import logging

from Board import Board
from Constants import ULTRASONIC_PINS, LOG_CONFIG

SETUP_TIME: int = 1
CHANGE_TRIGGER: int = 20

logging.basicConfig(**LOG_CONFIG)
log: logging = logging.getLogger(__name__)


def main():
    log.info('Main Program Starting')
    board = Board()

    # Setup Ultrasonic sensors
    for sensor in ULTRASONIC_PINS:
        board.add_ultrasonic(**sensor)

    # Setup Environment
    board.setup_environment()

    # Run the program
    board.run()


if __name__ == '__main__':
    main()
