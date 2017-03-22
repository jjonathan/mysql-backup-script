# mysql-backup-script
Php script to make a backup of all databases

## Updated from [backup-mysql-database-php](https://davidwalsh.name/backup-mysql-database-php)

## Instruction:

* Make a copy of [options.json.example](./options.json.example) and rename  to `options.json`;
* Put your configurations inside options.json;
* Add (or not) the databases you don't wanna make backup in `ignore` options inside your `options.json`;
* In your terminal run: `php main.php`.