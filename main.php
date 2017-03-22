<?php 
	include 'database_backup.php';
	include 'clean_backup.php';
	include 'log.php';

	date_default_timezone_set('America/Sao_Paulo');

	$options = file_get_contents('options.json');
	$options = json_decode($options);

	echo_log("Starting");

	log_define();
	backup($options);
	clean();

	echo_log("Finished");
?>