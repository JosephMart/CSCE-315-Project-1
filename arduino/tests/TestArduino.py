import unittest
import sys
import asyncio

from pymata_aio.pymata3 import PyMata3


class TestArduino(unittest.TestCase):
    '''Test Arduino Module'''

    def setUp(self):
        pass

    def testConnection(self):
        '''
        Test connection to the board as well as Firmware is loaded
        https://github.com/MrYsLab/pymata-aio/issues/63#issuecomment-377400310
        '''
        try:
            board = PyMata3()
        # Board not plugged in - correct Firmware/sketch or not
        except TypeError:
            assert False
        # incorrect Firmware/sketch loaded
        except asyncio.futures.CancelledError:
            assert False

if __name__ == '__main__':
    unittest.main(verbosity=2)

