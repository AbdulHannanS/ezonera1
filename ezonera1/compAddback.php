<?php
// https://stackoverflow.com/questions/26180972/how-to-use-mysqli-query-using-a-separate-connection-php-file
// How to use mysqli query using a separate connection.php file?

if(isset($_POST['cmp_Web']))
{
	require 'dbconn.php';
	// https://www.w3schools.com/php/php_mysql_prepared_statements.asp
	// prepared statments
	$com_Name=$_POST['cmp_Name'];
	$com_Site=$_POST['cmp_Web'];
	if(!$stmt=$mysqli->prepare("INSERT INTO compname (CompName, CompSite) VALUES (?, ?)"))
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	if(!$stmt->bind_param("ss", $com_Name, $com_Site))
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	if(!$stmt->execute())
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	$comp_Id=$stmt->insert_id;
	$stmt->close();
	$mysqli->close();
	header('Location:empAdd.php?compID='.$comp_Id);
}
?>