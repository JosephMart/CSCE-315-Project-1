import logging
import time
import Api
import numpy

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
        board.add_ultrasonic(sensor[0], sensor[1])

    log.info("Sleep for 20")
    for i in range(20):
        board.sleep()

    board.setup_environment()

    log.info("Sleep forever")
    while True:
        board.sleep()


#
#
#     acceptable = setup(monitor)
#     old_distance = monitor.readNum()
#     while (True):
#         distance = monitor.readNum()
#         if int(distance) in acceptable:
#             change = get_change(distance, old_distance)
#             old_distance = distance
#             if change > CHANGE_TRIGGER:
#                 Api.increment()
#
#
# def setup(m: SerialMonitor) -> range:
#     Api.reset()
#     t0 = time.clock()
#     vals = []
#
#     while (time.clock() - t0) <= SETUP_TIME:
#         val = m.readNum()
#         if val > -1:
#             vals.append(val)
#
#     vals = reject_outliers(vals)
#     return range(min(vals), max(vals) + 1)
#
#
# def reject_outliers(arr, m=2):
#     elements = numpy.array(arr)
#
#     mean = numpy.mean(elements, axis=0)
#     sd = numpy.std(elements, axis=0)
#
#     final_list = [x for x in arr if (x > mean - 2 * sd)]
#     final_list = [int(x) for x in final_list if (x < mean + 2 * sd)]
#     # return range(min(final_list), max(final_list) + 1)
#     return range(2, 7)
#
#
# def get_change(current, previous):
#     try:
#         return ((current - previous) / previous) * 100.0
#     except ZeroDivisionError:
#         return 0


if __name__ == '__main__':
    main()
