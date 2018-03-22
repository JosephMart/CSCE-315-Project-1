import logging
from functools import wraps
from typing import Callable, Dict, List

from datetime import datetime, timedelta

import pytz as pytz
from pymata_aio.pymata3 import PyMata3

from Constants import LOG_CONFIG, TRIG_PIN_INDEX, DISTANCE_INDEX

logging.basicConfig(**LOG_CONFIG)
log = logging.getLogger(__name__)


# default ping callback function
def default_sonic_cb(data: List[int]):
    if len(data) == 2:
        log.debug(f"Sensor Trig Pin: {data[TRIG_PIN_INDEX]: <2}\tDistance: {data[DISTANCE_INDEX]: <3} cm")


class Board:
    PRINT_ALL = False

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

    def __aggregate_timestamps(self) -> List[List[datetime]]:
        """
        Aggregate the timestamps stored in the sensors
        """
        # Get pin numbers with the lower the pin number the farther to the left the sensor is located
        trig_pins = list(self.__ultrasonics.keys())
        trig_pins.sort()
        times = list()

        for tp in trig_pins:
            times.append(self.__ultrasonics[tp].timestamps)
        return times

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
            if self.__collect_values:
                self.__setup_values.append(data[DISTANCE_INDEX])

            if self.__setup and data[DISTANCE_INDEX] in self.__acceptable_range:
                self.__direction_logic(data[TRIG_PIN_INDEX])
                return cb(data) if cb is not None else None

        return decorated

    def __direction_logic(self, trig_pin: int):
        # Update appropriate sensor timestamp list
        self.__ultrasonics[trig_pin].detected()

        # Determine if someone has moved to the left
        timestamps: List[List[datetime]] = self.__aggregate_timestamps()

        times = list()
        # Determine has moved from left to right (currently ignoring two people)
        for sensor_times in timestamps:
            if len(sensor_times) == 0:
                return
            times.append(sensor_times[-1])

        check_left_to_right = times[:]
        check_right_to_left = times[::-1]
        times.sort()

        if check_left_to_right == times:
            log.debug("Someone went Right to Left")
            for _, sensor in self.__ultrasonics.items():
                sensor.timestamps = list()

        if check_right_to_left == times:
            log.debug("Someone went Left to Right")
            for _, sensor in self.__ultrasonics.items():
                sensor.timestamps = list()

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
    MAX_TIMESTAMPS: int = 10
    ACCEPTABLE_TIME_DELTA: timedelta = timedelta(seconds=1.5)

    def __init__(self, board, trig: int, echo: int, cb: Callable[[List[int]], None]):
        self.trig = trig
        self.echo = echo
        self.cb = cb

        # Timestamp detection with the most recent stamps being at the end of the list
        self.timestamps: List[datetime] = list()
        board.sonar_config(self.trig, self.echo, self.cb)

    def detected(self):
        self.timestamps.append(datetime.now(pytz.utc))

        # Only keep MAX_TIMESTAMPS in scope
        now = datetime.now(pytz.utc)
        while len(self.timestamps) > self.MAX_TIMESTAMPS or (now - self.timestamps[0]) > self.ACCEPTABLE_TIME_DELTA:
            self.timestamps.pop(0)
