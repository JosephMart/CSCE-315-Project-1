# Constants used in the Arduino App

# Location of server api base url
# USER SPECIFIC DATA
import logging
from typing import List, Dict

SERVER_API: str = 'http://projects.cse.tamu.edu/josephmart/p1/api'

# Endpoints on server
ENDPOINTS: Dict[str, str] = {
    'INCREMENT': '/Increment.php',
    'RESET': '/Reset.php'
}

# From standing behind the sensors Index 0 represents the farthest to the left sensor
# Tuples in the form of (Trig Pin, Echo Pin)
# Lower the pin, the farther to the right the pin is
ULTRASONIC_PINS: List[Dict[str, int]] = [
    {"trig_pin": 2, "echo_pin": 3},
    {"trig_pin": 8, "echo_pin": 9}
]

NUM_SENSORS = len(ULTRASONIC_PINS)

# Constant Names for index locations for data detected from sensor
TRIG_PIN_INDEX: int = 0
DISTANCE_INDEX: int = 1

# Logging data
LOG_DEFAULT_FILENAME = 'main.log'
LOG_FORMAT = '%(levelname)s | %(asctime)-15s | %(message)s'
LOG_CONFIG = {
    'format': LOG_FORMAT,
    'level': logging.DEBUG,
    'filename': LOG_DEFAULT_FILENAME
}
