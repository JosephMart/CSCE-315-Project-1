# CSCE-315-Project-1

Currently located at [here](http://projects.cse.tamu.edu/josephmart/p1/)

Due to not being able to install PHP packages on TAMU server there are
three places to change data to run on your server. They are commented
with `# USER SPECIFIC DATA`.

* `CommonMethods.php`
	* $dbname
	* $user
	* $pass
* `logger.php`
	* $logDirectory (may need to chmod 777 this file once it is created the frist time)
* `Constants.py`
	* SERVER_API

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
CREATE TABLE IF NOT EXISTS `PeopleCounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `entering` enum('false','true') NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `PeopleCounts`
  ADD PRIMARY KEY (`id`);
```

### View
Main page `web_project/p1/index.php` is a table of all data.

### Increment

Increment count table by 1 (Entering)
```bash
curl -X POST \
  http://projects.cse.tamu.edu/NETID/p1/api/increment.php \
  -d 'secret=69&entering=%22true%22'
```

Exeting
```bash
curl -X POST \
  http://projects.cse.tamu.edu/NETID/p1/api/increment.php \
  -d 'secret=69&entering=%22false%22'
```

### Reset Table

This will clear all data in table and set increment back to 1.

```bash
curl -X DELETE http://projects.cse.tamu.edu/NETID/p1/api/reset.php
```