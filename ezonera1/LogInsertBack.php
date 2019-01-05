<?php
$company_id=$_GET['comp'];
$job_Position=$_POST['job_title'];
$job_location=$_POST['job_loc'];
$job_description_link=$_POST['JD_link'];
$employee_array=$_POST['empArray'];
$emails_aray=$_POST['emailArray'];
//replace raid value with the one fetched from session variable
$RAid=1;
require 'dbconn.php';
//also add date to this query fetched from session variable
$stmt=$mysqli->prepare("INSERT INTO `profilelog`(`RAID`, `CompID`, `JobTitle`, `JobLocation`, `JDLink`, `EmpID`, `EmpEmailID`) VALUES (?,?,?,?,?,?,?)");
	$stmt->bind_param("iisssii", $RAid, $company_id, $job_Position, $job_location, $job_description_link, $emp, $emailz);
for ($i = 0; $i < count($employee_array); $i++)
{
    $emp=$employee_array[$i];
    $emailz=$emails_aray[$i];
//    $stmt->execute();
    if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
}
$stmt->close();
$mysqli->close();
//insert a header redirecting to profilelog
?>