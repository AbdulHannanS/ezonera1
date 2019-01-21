<?php
print_r($_POST);
echo "<br>";
print_r($_GET);
echo "<br>";
session_start();
$company_id=$_GET['comp'];
$job_Position=$_POST['job_title'];
$job_location=$_POST['job_loc'];
$job_description_link=$_POST['JD_link'];
$employee_array=$_POST['empArray'];
$emails_aray=$_POST['emailArray'];
//replace raid value with the one fetched from session variable
$RAid=$_SESSION['RAID'];
$pdate=$_SESSION['prof_dt'];
require 'dbconn.php';
//also add date to this query fetched from session variable
if(!$stmt=$mysqli->prepare("INSERT INTO `profilelog`(`ProfiledDate`, `RAID`, `CompID`, `JobTitle`, `JobLocation`, `JDLink`, `EmpID`, `EmpEmailID`) VALUES (?,?,?,?,?,?,?,?)"))
	echo "Execute failed at prepare: (" . $stmt->errno . ") " . $stmt->error . " ". gettype($stmt) ;
	if(!$stmt->bind_param("siisssii", $pdate, $RAid, $company_id, $job_Position, $job_location, $job_description_link, $emp, $emailz))
		echo "Execute failed at param: (" . $stmt->errno . ") " . $stmt->error;
for ($i = 0; $i < count($employee_array); $i++)
{
    $emp=$employee_array[$i];
    $emailz=$emails_aray[$i];
//    $stmt->execute();
    if (!$stmt->execute()) {
    echo "Execute failed at execute: (" . $stmt->errno . ") " . $stmt->error;
}
}
$stmt->close();
$mysqli->close();
//insert a header redirecting to profilelog
header('Location:ProfileLog.php);
?>