# Constants used in the Arduino App

# Location of server api base url
# USER SPECIFIC DATA
import logging
from typing import Tuple, List, Dict

SERVER_API: str = 'http://projects.cse.tamu.edu/josephmart/p1/api'

# Endpoints on server
ENDPOINTS: Dict[str, str] = {
    'INCREMENT': '/increment.php',
    'RESET': '/reset.php'
}

# From standing behind the sensors Index 0 represents the farthest to the left sensor
# Tuples in the form of (Trig Pin, Echo Pin)
ULTRASONIC_PINS: List[Tuple[int, int]] = [
    (2, 3),
    (4, 5),
    (6, 7),
    (8, 9)
]

# Logging data
LOG_DEFAULT_FILENAME = 'main.log'
LOG_FORMAT = '%(levelname)s | %(asctime)-15s | %(message)s'
LOG_CONFIG = {
    'format': LOG_FORMAT,
    'level': logging.DEBUG,
    'filename': LOG_DEFAULT_FILENAME
}