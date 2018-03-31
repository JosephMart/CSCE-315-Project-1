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
