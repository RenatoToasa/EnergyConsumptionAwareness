<?php
include ("config_mysql.php");
function openConection(){
	$con=mysqli_connect(HOST,USER,PASS,DB);
	// Check connection
	mysqli_set_charset($con,'utf8');
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  } else {
		return $con;
		}
}

?>
