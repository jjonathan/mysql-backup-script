# mysql-backup-script
Php script to make a backup of all databases

## Updated from [backup-mysql-database-php](https://davidwalsh.name/backup-mysql-database-php)

## Instruction:

* Make a copy of [options.json.example](./options.json.example) and rename  to `options.json`;
* Put your configurations inside `options.json`;
* Options explanation:
	* (string)  host: 		Host of your database;
	* (string)  user: 		User of your database;
	* (string)  pass: 		Password of your database;
	* (integer) port: 		Port of your database;
	* (array)   ignore: 	Databases you want to ignore (by default already populated with the default mysql databases);
	* (integer) days_keep:	Number of days to keep the backup (Set null if you don't want to delete the backup files)
* In your terminal run: `php main.php`.