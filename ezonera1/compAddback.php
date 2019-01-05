<?php
// https://stackoverflow.com/questions/26180972/how-to-use-mysqli-query-using-a-separate-connection-php-file
// How to use mysqli query using a separate connection.php file?

if(isset($_POST['cmpWeb']))
{
	require 'dbconn.php';
	// https://www.w3schools.com/php/php_mysql_prepared_statements.asp
	// prepared statments
	$stmt=$mysqli->prepare("INSERT INTO compname (CompName, CompSite) VALUES (?, ?)");
	$stmt->bind_param("ss", $com_Name, $com_Site);
	$com_Name=$_POST['cmp_Name'];
	$com_Site=$_POST['cmp_Web'];
	$stmt->execute();
	$comp_Id=$stmt->insert_id;
	$stmt->close();
	$mysqli->close();
	header('Location: empAdd.php?compID='.$comp_Id);
}
?>