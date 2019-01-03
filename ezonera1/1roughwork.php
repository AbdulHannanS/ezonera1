<?php
/*$host="localhost";
$user="root";
$password="";
$db="test";
$mysqli=new mysqli($host,$user,$password,$db);
if($mysqli->connect_error)
	die('Connect Error');
$stmt=$mysqli->prepare("INSERT INTO empname (EmpName, EmpDesig) VALUES (?, ?)");
	$stmt->bind_param("ss", $emp_Name, $emp_designation);
	$emp_Name=$_POST['emp_Name'];
	$emp_designation=$_POST['emp_desig'];
	$stmt->execute();
	$emp_Id=$stmt->insert_id;
	$stmt->close();
	$stmt2=$mysqli->prepare("INSERT INTO empcontact (EmpID, empEmail) VALUES (?, ?)");
	$stmt2->bind_param("is", $empid, $empmail);
	$empid=$emp_Id;
	$empmail=$_POST['emp_Email1'];
	$stmt2->execute();
	$stmt2->close();
	if(strlen($_POST['emp_Email2'])>=1)
	{
		$stmt3=$mysqli->prepare("INSERT INTO empcontact (EmpID, empEmail) VALUES (?, ?)");
		$stmt3->bind_param("is", $empid, $empmail);
		$empid=$emp_Id;
		$empmail=$_POST['emp_Email2'];
		$stmt3->execute();
	}
	if(strlen($_POST['emp_Email3'])>=1)
	{
		$stmt3=$mysqli->prepare("INSERT INTO empcontact (EmpID, empEmail) VALUES (?, ?)");
		$stmt3->bind_param("is", $empid, $empmail);
		$empid=$emp_Id;
		$empmail=$_POST['emp_Email3'];
		$stmt3->execute();
	}
	$mysqli->close();*/
	if (isset($_POST['vehicle'])) {
		print_r($_POST);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>test the checkbox</title>
</head>
<body>
	<?php
	$counter=11;
	?>
<form method="post" action="" class="abc<?php echo $counter; ?>">
	<input type="checkbox" name="vehicle[]" value="Bike"> I have a bike<br>
	<input type="checkbox" name="vehicle[]" value="Car"> I have a car<br>
	<input type="checkbox" name="vehicle[]" value="cycle"> I have a cycle<br>
	<input type="checkbox" name="vehicle[]" value="truck"> I have a truck<br>
	<input type="submit" value="Submit">
</form>
</body>
</html>