import logging
from datetime import datetime, timedelta
from functools import wraps
from typing import Callable, Dict, List

import pytz as pytz
from pymata_aio.pymata3 import PyMata3

import Api
from Constants import DISTANCE_INDEX, LOG_CONFIG, NUM_SENSORS, TRIG_PIN_INDEX, ULTRASONIC_PINS

logging.basicConfig(**LOG_CONFIG)
log = logging.getLogger(__name__)


# default ping callback function
def default_sonic_cb(data: List[int]):
    if len(data) == 2:
        log.debug(f"Sensor Trig Pin: {data[TRIG_PIN_INDEX]: <2}\tDistance: {data[DISTANCE_INDEX]: <3} cm")


class Board:
    PRINT_ALL = False
    POST_DATA = True

    def __init__(self):
        """
        Instantiate a Board instance
        """
        # create a PyMata instance
        self.board: PyMata3 = PyMata3(2)

        # Used to keep track of ultrasonic sensors with the key being the trig pin
        self.__ultrasonics: Dict[int, UltraSonic] = {}

        # Setup flag that is switched to True once setup_environment has occurred has
        self.__setup: bool = False

        # Acceptable range for values (cm) to be read range to be valid, will get properly set during setup
        self.__max_distance: int = 200
        self.__min_distance: int = 0

        # Callback will collect values to __setup_values if __collect_values is set to True
        self.__collect_values: bool = False
        self.__setup_values: List = []

        self.lock = False
        self.last_sensor_read = None

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

    def __ultrasonic_decorator(self, cb: Callable[[List[int]], None]) -> Callable[[List[int]], None]:
        """
        Don't allow sonic callback if setup has occurred and distance is not within acceptable range
        Also try to determine if a user has passed going left or right

        :param cb:
        :return: None
        """
        @wraps(cb)
        def decorated(data: List[int]) -> None:
            if self.PRINT_ALL:
                log.info(
                    log.debug(f"Sensor Trig Pin: {data[TRIG_PIN_INDEX]: <2}\tDistance: {data[DISTANCE_INDEX]: <3} cm"))

            # If in collect mode collect values
            if self.__collect_values:
                self.__setup_values.append(data[DISTANCE_INDEX])

            # If already have setup and distance is acceptable, store distances
            if self.__setup and data[DISTANCE_INDEX] in self.__acceptable_range:
                sensor: datetime = self.__ultrasonics[data[TRIG_PIN_INDEX]]
                now: datetime = datetime.now()

                if (now - sensor.timestamp) < timedelta(seconds=2):
                    return

                sensor.detected()
                self.__direction_logic()
                
                self.last_sensor_read = sensor.trig
                return cb(data) if cb is not None else None

        return decorated

    def __direction_logic(self):
        # Determine if someone has moved to the left
        right_sensor: UltraSonic = self.__ultrasonics[min([x['trig_pin'] for x in ULTRASONIC_PINS])]
        left_sensor: UltraSonic = self.__ultrasonics[max([x['trig_pin'] for x in ULTRASONIC_PINS])]

        if right_sensor.timestamp is None or left_sensor.timestamp is None:
            return

        diff: timedelta = right_sensor.timestamp - left_sensor.timestamp

        log.debug(f'Time diff {diff}')

        if timedelta(seconds=-2) < diff < timedelta(seconds=2):
            if diff < timedelta(seconds=0):
                msg = 'Person walked from right to left'
                log.info(msg)
                print(msg)
                if Board.POST_DATA:
                    Api.increment(True)
            elif diff > timedelta(seconds=0):
                msg = 'Person walked from left to right'
                log.info(msg)
                print(msg)
                if Board.POST_DATA:
                    Api.increment(True)
            left_sensor.timestamp = right_sensor.timestamp = datetime.now()

    def add_ultrasonic(self, trig_pin: int, echo_pin: int, cb: Callable[[List[int]], None] = default_sonic_cb):
        """
        Instantiate an ultrasonic sensor with the board

        :param trig_pin: Trigger Pin Number
        :param echo_pin: Echo Pin Number
        :param cb: Callback
        :return: None
        """
        # Ensure there is not a sensor with the provided trig pin already
        if trig_pin in self.__ultrasonics:
            raise Exception(f"There is an ultrasonic with {trig_pin} Trig pin already")

        self.__ultrasonics[trig_pin] = UltraSonic(self.board, trig_pin, echo_pin, self.__ultrasonic_decorator(cb))
        log.info(f"Created an UltraSonic Sensor with Trig Pin {trig_pin} Echo Pin {echo_pin}")

    def setup_environment(self):
        """
        This should be called after sensors have been attached to create a buffer range
        """
        # Ensure that setup has not been called before
        if self.__setup:
            raise Exception("Board setup has already occurred once")

        log.info("Setting up board environment")
        val = -1

        # while val != "":
        #     val = input("Press (enter) to calculate max distance")

        # Setup
        # Collect values for 5 seconds
        self.__collect_values = True
        self.sleep(5)
        self.__collect_values = False

        # Min Value of collected values should be the distance from the sensor to the stationary background
        log.debug("Setup values: {}".format(self.__setup_values))
        self.__max_distance = min(self.__setup_values)
        msg = "Max Calculated Distance: {0: <3} cm".format(self.__max_distance)
        log.info(msg)
        print(msg)

        # Anymore setup?
        # Mark setup as happened
        self.__setup = True

    def sleep(self, time: float = .1):
        """
        Perform an asyncio sleep for the time specified in seconds. T
        his method should be used in place of time.sleep()

        :param time: time in seconds
        :returns: No return value
        """
        self.board.sleep(time)

    def run(self):
        """
        Run the sensor collection infinitely
        """
        log.info("Running the program forever")
        while True:
            self.sleep()

class UltraSonic:
    # MAX_timestamps_FIX: int = 10
    ACCEPTABLE_TIME_DELTA: timedelta = timedelta(seconds=1.5)

    def __init__(self, board, trig: int, echo: int, cb: Callable[[List[int]], None]):
        self.trig: int = trig
        self.echo: int = echo
        self.cb = cb

        # Timestamp detection with the most recent stamps being at the end of the list
        self.timestamp: datetime = datetime.now()
        board.sonar_config(self.trig, self.echo, self.cb, ping_interval=127)

    def detected(self):
        now = datetime.now()
        self.timestamp = now
        log.debug(f'UltraSonic ({self.trig}) detected at {now}')
