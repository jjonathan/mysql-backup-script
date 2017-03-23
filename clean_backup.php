<?php 

function clean($days){
	$mask = date('Y-m-d', strtotime("-$days days"))."*";

	$files = getFiles($mask);

	foreach ($files as $key => $file) {
		echo_log("Deleted 	: $file");
		unlink($file);
	}
}

function getFiles($mask){
	$directories = directories('backups');
	$files = [];
	foreach ($directories as $key => $value) {
		$file = glob("$value/$mask");
		if ($file) {
			$files = array_merge($files, $file);
		}
	}
	return $files;
}

function directories($directory)
{
    $glob = glob($directory . '/*');

    if($glob === false)
    {
        return array();
    }

    return array_filter($glob, function($dir) {
        return is_dir($dir);
    });
}

?>