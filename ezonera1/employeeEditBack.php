<?php 
class dbclass
{			
	private $mysqli;
	private $row_count;
	function __construct()
	{
		$this->dbconnect();
	}
	private function dbconnect()
	{
		$this->mysqli=new mysqli("localhost","root","","ezonera1");
		if(mysqli_connect_error()){
			die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_errno());
		}
	}
	public function Update_details($emp_ID, $Name, $designation, $Status, $phone)
	{
		$up_query="UPDATE `empname` SET `EmpName`='". $Name ."',`EmpDesig`='". $designation ."',`EmpStatus`='". $Status ."',`EmpPhone`='". $phone ."' WHERE `EmpID`=". $emp_ID;
		if(mysqli_query($this->mysqli, $up_query))
			return TRUE;
		else
			return FALSE;
	}
	public function update_email_details($email_id, $email_address, $email_status)
	{
		$update_email_query="UPDATE `empemail` SET `EmpEmail`='". $email_address ."',`EmpEmailStatus`='". $email_status ."' WHERE `EmpEmailID`=". $email_id;
		if(mysqli_query($this->mysqli, $update_email_query))
			return TRUE;
		else
			return FALSE;
	}
}
if(isset($_POST['update_empl']))
{
	//print_r($_POST);
	$obj=new dbclass();
	if($obj->Update_details($_GET['empID'], $_POST['empl_name'], $_POST['empl_desig'], $_POST['emp_stat'], $_POST['empl_phone']))
		header("location:AdminEmpEdit.php?comID=".$_GET['comID']);
	else
	{
		echo "there was an error redirecting back";
		header("Refresh: 5; URL=AdminEmpEdit.php?comID=".$_GET['comID']);
	}

}
if(isset($_POST['update_email']))
{
	//print_r($_POST);
	$obj=new dbclass();
	if($obj->Update_details($_GET['empEmailID'], $_POST['Employee_email'], $_POST['email_stat']))
		header("location:AdminEmpEdit.php?comID=".$_GET['comID']);
	else
	{
			echo "there was an error";
			header("Refresh: 5; URL=AdminEmpEdit.php?comID=".$_GET['comID']);
	}
}
?>