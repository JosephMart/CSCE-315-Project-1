import unittest
import sys
sys.path.append(sys.path[0] + "/..")
from Api import reset, increment

class TestApi(unittest.TestCase):
    '''Test Api Module'''

    def setUp(self):
        pass

    def testRest(self):
        '''
        Test Reset Endpoint from Arduino Python Code
        '''
        self.assertEqual(reset(), '{"status":"success"}')
    
    def testIncrement(self):
        '''
        Test Increment Endpoint from Arduino Python Code
        '''
        self.assertEqual(increment(), '{"status":"success"}')

if __name__ == '__main__':
    unittest.main(verbosity=2)

