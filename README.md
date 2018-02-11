# CSCE-315-Project-1

Currently located at [here](http://projects.cse.tamu.edu/josephmart/p1/)

## Arduino
### Setup

Create virtual enviroment and acivate it.

```bash
cd arduino
python3 -m venv venv
source venv/bin/activate
```

Install dependencies
```bash
pip3 install -r requirements.txt
```

### Tests

## Api
```bash
cd arduino
source venv/bin/activate
python3 tests/test_api_unittest.py
```

## Webserver
### SQL To Create Table

```sql
CREATE TABLE `NET_ID`.`PeopleCounts` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;
```

### View
Main page `index.php` is a table of all data.

### Increment

Increment count table by 1
```bash
curl -d "secret=69" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://projects.cse.tamu.edu/josephmart/p1/api/increment.php
```

### Reset Table

This will clear all data in table and set increment back to 1.

```bash
curl -X DELETE http://projects.cse.tamu.edu/josephmart/p1/api/reset.php
```