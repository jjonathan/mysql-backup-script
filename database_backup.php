<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

function backup($options){

	$mysqli = new mysqli($options->host, $options->user, $options->pass, null, $options->port);

	if ($mysqli->connect_errno) {
	    echo_log("Conection error: $mysqli->connect_error\n");
	    exit;
	}

	if (!$mysqli->ping()) {
		echo_log("Error: $mysqli->error");
		exit;
	}

	$databases = [];
	$ignore = $options->ignore;

	$result = $mysqli->query('SHOW DATABASES');
	while($row = $result->fetch_row())
	{
		if (!in_array($row[0], $ignore)) {
			$databases[] = $row[0];
		}
	}

	foreach ($databases as $key => $db_name) {
		make_backup($mysqli, $db_name);
	}

	$mysqli->close();
}

/* backup the db*/
function make_backup($mysqli,$name,$tables = '*')
{
	
	echo_log("Starting 	: $name");
	$mysqli->select_db($name);
	
	//get all of the tables
	$tables = array();
	$result = $mysqli->query('SHOW TABLES');
	while($row = $result->fetch_row())
	{
		$tables[] = $row[0];
	}

	//Var where will be the backup string
	$return = '';
	
	//cycle through
	foreach($tables as $table)
	{
		$result = $mysqli->query('SELECT * FROM '.$table);
		$num_fields = $mysqli->field_count;
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = $mysqli->query('SHOW CREATE TABLE '.$table)->fetch_row();
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = $result->fetch_row())
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	if (!is_dir('backups')) {
		mkdir('backups');
	}
	if (!is_dir("backups/$name")) {
		mkdir("backups/$name");
	}
	$handle = fopen("backups/$name/" . date('Y-m-d_H_i_s') . "_-_{$name}_" . uniqid() .'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
	echo_log("Finished 	: $name");
}

?>