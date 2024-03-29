# CSCE-315-Project-1

Due to not being able to install PHP packages and not able to get .env files working on TAMU server there are three places to change data to run on your server. They are commented with `# USER SPECIFIC DATA` in the project.

* `CommonMethods.php`
	* $dbname
	* $user
	* $pass
* `Logger.php`
	* $logDirectory (may need to chmod 777 this file once it is created the frist time)
* `Constants.py`
	* SERVER_API this is the endpoint in this case on the server)

## Dependencies

Make sure to have the following items installed

* [Python 3.6.4](https://www.python.org/downloads/release/python-364/)
* [pip 9.0.2](https://pypi.python.org/pypi/pip)
* Be able to run makefiles (bash or cygwin?)
### Makefile Commands
Not sure which of these will work on Windows but you can open the makefile and find the
appropriate command and run the Windows equivalent.

```bash
make all # create venv and install packages
make init_venv # create venv
make deps # install dependencies in requirements.txt
make freeze # freeze dependencies to requirements.txt
make clean_venv # remove venv
make run # run python arduino code
make test_python # run python unit tests
make deploy # Deploy server code to TAMU server
```

## Webserver
### SQL To Create Table

```sql
USE DB_NAME;
CREATE TABLE IF NOT EXISTS `PeopleCounts` (
  `id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `entering` enum('false','true') NOT NULL DEFAULT 'true'
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

ALTER TABLE `PeopleCounts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `PeopleCounts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

-- ALTER TABLE `PeopleCounts`
  ADD PRIMARY KEY (`id`);
```

### View
Main page `web_project/p1/index.php` is a table of all data.

### Increment

Increment count table by 1 (Entering)
```bash
curl -X POST \
  http://projects.cse.tamu.edu/NETID/p1/api/Increment.php \
  -d 'secret=69&entering=%22true%22'
```

Exeting
```bash
curl -X POST \
  http://projects.cse.tamu.edu/NETID/p1/api/Increment.php \
  -d 'secret=69&entering=%22false%22'
```

### Reset Table

This will clear all data in table and set increment back to 1.

```bash
curl -X DELETE http://projects.cse.tamu.edu/NETID/p1/api/Reset.php
```

## Arduino Setup

Once you have installed the dependencies listed below, you will need to load the Arduino Firmware.

If you are not able to install with the makefile, do the following
```
certifi==2018.1.18
chardet==3.0.4
future==0.16.0
idna==2.6
iso8601==0.1.12
numpy==1.14.2
PyMata==2.17
pymata-aio==2.19
pyserial==2.7
PyYAML==3.12
requests==2.18.4
urllib3==1.22
websockets==4.0.1
```

If you are not able to install with the makefile, do the following
```
cd arduino
pip install -r requirements.txt
```

Firmware is FirmataPlus. How to install the 3rd party package can be found https://github.com/MrYsLab/pymata-aio/wiki/Uploading-FirmataPlus-to-Arduino

Once loaded, run the program!
```
python3 arduino/main.py
```