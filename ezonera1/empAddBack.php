<?php

print_r($_GET);
echo "<br>";
print_r($_POST);
echo strlen($_POST['emp_Email2']);
if(isset($_POST['emp_Name']))
{
	require 'dbconn.php';
	//check before inserting if the email address has already been insrted in the Employee column
	$stmt=$mysqli->prepare("INSERT INTO empname (CompID, EmpName, EmpDesig) VALUES (?, ?, ?)");
	$stmt->bind_param("iss",$comID, $emp_Name, $emp_designation);
	$comID=$_GET['comp'];
	$emp_Name=$_POST['emp_Name'];
	$emp_designation=$_POST['emp_desig'];
	$stmt->execute();
	$emp_Id=$stmt->insert_id;
	$stmt->close();
	$stmt2=$mysqli->prepare("INSERT INTO empemail (EmpID, EmpEmail) VALUES (?, ?)");
	$stmt2->bind_param("is", $empid, $empmail);
	$empid=$emp_Id;
	$empmail=$_POST['emp_Email1'];
	$stmt2->execute();
	$stmt2->close();
	if(strlen($_POST['emp_Email2'])>1)
	{
		$stmt3=$mysqli->prepare("INSERT INTO empemail (EmpID, EmpEmail) VALUES (?, ?)");
		$stmt3->bind_param("is", $empid, $empmail);
		$empid=$emp_Id;
		$empmail=$_POST['emp_Email2'];
		$stmt3->execute();
		$stmt3->close();
	}
	if(strlen($_POST['emp_Email3'])>1)
	{
		$stmt4=$mysqli->prepare("INSERT INTO empemail (EmpID, EmpEmail) VALUES (?, ?)");
		$stmt4->bind_param("is", $empid, $empmail);
		$empid=$emp_Id;
		$empmail=$_POST['emp_Email3'];
		$stmt4->execute();
		$stmt4->close();
	}
	$mysqli->close();
	
}
header('Location:empAdd.php?compID='.$comID);
//header("refresh:5, URL=empAdd.php?compID=".$comID);
?>