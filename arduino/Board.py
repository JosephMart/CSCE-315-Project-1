import logging
from functools import wraps
from typing import Callable, Dict, List

from pymata_aio.pymata3 import PyMata3

from Constants import LOG_CONFIG

logging.basicConfig(**LOG_CONFIG)
log = logging.getLogger(__name__)


# ping callback function
def default_sonic_cb(data: List[int]):
    if len(data) == 2:
        log.debug(f"Sensor Trig Pin: {data[0]: <2}\tDistance: {data[1]: <3} cm")


class Board:
    def __init__(self):
        """
        Instantiate a Board instance
        """
        # create a PyMata instance
        self.board: PyMata3 = PyMata3(2)

        # Used to keep track of ultrasonic sensors with the key being the trig pin
        self.__ultrasonics: Dict[int, UltraSonic] = {}

        # Setup flag that is switched to True once setup_enviroment has occurred has
        self.__setup: bool = False

        # Acceptable range for values to be read range to be valid, will get properly set during setup
        self.__max_distance: int = 200
        self.__min_distance: int = 0

        # Callback will collect values to __setup_values if __collect_values is set to True
        self.__collect_values: bool = False
        self.__setup_values: List = []

        log.info("Board Successfully Created")

    def __del__(self):
        """
        Clean up the board connection properly
        """
        self.board.shutdown()

    @property
    def __acceptable_range(self) -> range:
        """
        Property that returns a Python range from __min_distance to __max_distance
        """
        return range(self.__min_distance, self.__max_distance)

    def setup_environment(self):
        """
        This should be called after sensors have been attached to create a buffer range
        """
        # Ensure that setup has not been called before
        if self.__setup:
            raise Exception("Board setup has already occurred once")

        log.info("Setting up board environment")
        val = -1

        while val != "":
            val = input("Press (enter) to calculate max distance")

        # Setup
        # Collect values for 5 seconds
        self.__collect_values = True
        self.sleep(5)
        self.__collect_values = False

        # Min Value of collected values should be the distance from the sensor to the stationary background
        self.__max_distance = min(self.__setup_values)
        msg = "Max Calculated Distance: {0: <3} cm".format(self.__max_distance)
        log.info(msg)
        print(msg)

        # Anymore setup?
        # Mark setup as happened
        self.__setup = True

    def sleep(self, time: int = .1):
        """
        Perform an asyncio sleep for the time specified in seconds. T
        his method should be used in place of time.sleep()

        :param time: time in seconds
        :returns: No return value
        """
        self.board.sleep(time)

    def __ultrasonic_decorator(self, cb: Callable[[List[int]], None]) -> Callable[[List[int]], None]:
        """
        Don't allow sonic callback if setup has occurred and distance is within acceptable range
        :param cb:
        :return:
        """

        @wraps(cb)
        def decorated(data: List[int]) -> None:
            if self.__collect_values:
                self.__setup_values.append(data[1])

            if self.__setup and data[1] in self.__acceptable_range:
                return cb(data) if cb is not None else None

        return decorated

    def add_ultrasonic(self, trig: int, echo: int, cb: Callable[[List[int]], None] = default_sonic_cb):
        """
        Instantiate an ultrasonic sensor with the board
        :param trig: Trigger Pin Number
        :param echo: Echo Pin Number
        :param cb: Callback
        :return: None
        """
        # Ensure there is not a sensor with the provided trig pin already
        if trig in self.__ultrasonics:
            raise Exception("There is an ultrasonic with this Trig pin already")

        self.__ultrasonics = {
            trig: UltraSonic(self.board, trig, echo, self.__ultrasonic_decorator(cb))
        }


class UltraSonic:
    def __init__(self, board, trig: int, echo: int, cb: Callable[[List[int]], None]):
        self.trig = trig
        self.echo = echo
        self.cb = cb
        board.sonar_config(self.trig, self.echo, self.cb)
