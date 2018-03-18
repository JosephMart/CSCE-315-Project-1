import requests

from Constants import SERVER_API, ENDPOINTS

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

if __name__ == '__main__':
	test()