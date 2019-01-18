<?php

if(isset($_POST['Delete_line']))
{
	if(!isset($_POST['profiled_ID']))
	{
		header("location:ProfileLog.php");
	}
	else
	{
		require 'dbconn.php';
		//print_r($_POST);
		$row_ID=$_POST['profiled_ID'];
		print_r($row_ID);
		foreach ($row_ID as $value) {
			if($mysqli->query("DELETE FROM `profilelog` WHERE ProfiledID=".$value))
			{
				echo "record deleted from Profile log";
			}
			else
			{
				echo "record could not be deleted from Profile log";
			}
		}
		header("Refresh:5; url=ProfileLog.php");
	}
}
?>