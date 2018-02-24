import requests
import unittest
from constants import SERVER_API, ENDPOINTS

def test() -> None:
	"""Run Test cases on reset and increment"""

	print('----------------------------------------')
	print('\tTESTING RESETTING')
	print('----------------------------------------')
	reset(True)

	print('----------------------------------------')
	print('\tTESTING INCREMENTING BY 10')
	print('----------------------------------------')
	for x in range(10):
		increment(True)

def reset(printResponse: bool = False) -> None:
	"""
	Hit reset endpoint on the server which will clear the table
	and set autoincrement count back to
	
	Keyword Arguments:
		printResponse {bool} -- print server response if True (default: {False})
	"""
	response = requests.delete(SERVER_API + ENDPOINTS['RESET'])
	if printResponse: print(response.text)
	return response.text

def increment(printResponse: bool = False) -> None:
	"""
	Hit increment endpoint on the server which will increment the table
	
	Keyword Arguments:
		printResponse {bool} -- print server response if True (default: {False})
	"""
	params = {u'secret': 69}
	headers = {'content-type': 'application/x-www-form-urlencoded'}
	response = requests.post(SERVER_API + ENDPOINTS['INCREMENT'], data=params)
	if printResponse: print(response.text)
	return response.text



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
	test()
	unittest.main(verbosity=2)