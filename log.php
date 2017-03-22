<?php  

	function log_define(){
		$log_file = "logs/" . date('Y-m-d') . ".log";
		ini_set("log_errors", 1);
		ini_set("error_log", $log_file);
	}
	
	function echo_log($string){
		echo "$string\n";

		$log_name = date('Y-m-d') . ".log";
		$log_row = "[" . date('d-M-Y H:i:s') . " " . date_default_timezone_get() . "] PHP Message:  $string\n";

		error_log($log_row, 3, "logs/$log_name");
	}

?>