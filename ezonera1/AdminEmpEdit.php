<?php
//authorisation lines
session_start();
if(!$_SESSION['RAType']=="Admin" or !(strlen($_GET['comID'])>0))
{
	header("location:compStatSearch.php");
}
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
	public function company_details($term)
	{
		// if the company is in the database but not in the profilelog then it will not show with this query
		$search_query="SELECT `compname`.`CompName`, `compname`.`CompSite`, `compname`.`CompStatus`, `compname`.`CompRemarks` FROM `compname` LEFT JOIN `empname` ON `compname`.`CompID` = `empname`.`CompID` LEFT JOIN `empemail` ON `empname`.`EmpID` = `empemail`.`EmpID` WHERE compname.CompID=". $term ." LIMIT 1";
		$res=mysqli_query($this->mysqli, $search_query);
		$res_arr=$res->fetch_assoc();
		return $res_arr;
	}
	public function emp_list($comp_ID)
	{
		$emp_list_query="SELECT `empname`.`EmpID`, `empname`.`CompID`, `empname`.`EmpName`, `empname`.`EmpDesig`, `empname`.`EmpStatus`, `empname`.`EmpPhone`, `empemail`.`EmpEmailID`, `empemail`.`EmpID`, `empemail`.`EmpEmail`, `empemail`.`EmpEmailStatus` FROM `empname` LEFT JOIN `empemail` ON `empname`.`EmpID` = `empemail`.`EmpID` WHERE `empname`.`CompID`=". $comp_ID;
		$emp_set=mysqli_query($this->mysqli, $emp_list_query);
		return $emp_set;
	}
	public function Employee_details($emp_ID)
	{
		$emp_details_query="SELECT `EmpName`, `EmpDesig`, `EmpStatus`, `EmpPhone` FROM `empname` WHERE EmpID=". $emp_ID;
		$res_set=mysqli_query($this->mysqli, $emp_details_query);
		$emp_Arr=$res_set->fetch_assoc();
		return  $emp_Arr;
	}
	public function Email_details($email_ID)
	{
		$email_details_query="SELECT `EmpEmail`, `EmpEmailStatus` FROM `empemail` WHERE `EmpEmailID`=". $email_ID;
		$res_set=mysqli_query($this->mysqli, $email_details_query);
		$email_Arr=$res_set->fetch_assoc();
		return  $email_Arr;
	}
	public function get_row_count()
	{
		return $this->row_count;
	}
}
$dbObj=new dbClass();
$comp_Details_arr=$dbObj->company_details($_GET['comID']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit or Add Employees</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<style type="text/css">
		.DNC, .incorrect{
			background-color: red;
		}
		.point-of-Contact
		{
			background-color: green;
		}
		.Qualified{
			background-color: cyan;
		}
		.contact-later
		{
			background-color: yellow;
		}
	</style>
</head>
<body>
	<?php include 'nav_bar.php'; ?>
	<div class="container" style="margin-top: 20px;">
		<div class="row">
			<div class="col-sm-12" style="background-color:lavender;">

				<h1 style="text-align: center;">Add Employee and Email addresses for</h1>
				<h3 style="text-align: center;" data-toggle="tooltip" title="<?php echo $comp_Details_arr['CompStatus']; ?>" class="<?php echo $comp_Details_arr['CompStatus']; ?>"><?php echo $comp_Details_arr['CompName']; ?></h3>
				<h4 style="text-align: center;"><?php echo $comp_Details_arr['CompSite']; ?></h4>
				<h6 style="text-align: center;"><?php echo $comp_Details_arr['CompRemarks']; ?></h6>
			</div>
		</div>
		<!-- below this div add a php if statment that ends with the below div if(isset($_GET['emplID'])) -->
		<?php
		if(isset($_GET['emplID']))
		{
			$empDetArr=$dbObj->Employee_details($_GET['emplID']);?>
		<div class="row">
			<div class="col-sm-12">
				<form action="employeeEditBack.php?comID=<?php echo $_GET['comID']; ?>&empID=<?php echo $_GET['emplID']; ?>" method="post">
					<div class="form-group">
						<label for="empNameBox">Employee Name</label>
						<input type="text" name="empl_name" id="empNameBox" class="form-control" value="<?php echo $empDetArr['EmpName']; ?>">
					</div>
					<div class="form-group">
						<label for="emplDesignation">Employee Designation</label>
						<input type="text" name="empl_desig" id="emplDesignation" class="form-control" value="<?php echo $empDetArr['EmpDesig']; ?>">
					</div>
					<div class="form-group">
						<label for="emplPhone">Employee Phone Number</label>
						<input type="text" name="empl_phone" id="emplPhone" class="form-control" value="<?php echo $empDetArr['EmpPhone']; ?>">
					</div>
					<div class="form-group">
				      <label for="empStatSel">Employee Status:</label>
					      <select class="form-control" id="EmpStatSel" name="emp_stat">
					        <option value="">Select</option>
					        <option value="DNC" <?php if($empDetArr['EmpStatus']=="DNC") echo "selected"; ?>>DO NOT CONTACT</option>
					        <option value="point-of-Contact" <?php if($empDetArr['EmpStatus']=="point-of-Contact") echo "selected"; ?>>Point Of Contact</option>
					      </select>
				    </div>
				    <button type="submit" class="btn btn-default center-block" name="update_empl">Submit Changes</button>
				</form>
			</div>
		</div>
		<?php
		}
		?>
		<!-- email status edit bootstrap row -->
		<?php
		if(isset($_GET['empEmailID']))
		{
			$email_details_arr=$dbObj->Email_details($_GET['empEmailID']); ?>
		<div class="row">
			<div class="col-sm-12">
				<form action="employeeEditBack.php?comID=<?php echo $_GET['comID']; ?>&empEmailID=<?php echo $_GET['empEmailID']; ?>" method="post">
					<div class="form-group">
						<label for="emailBox">Employee Phone Number</label>
						<input type="text" name="Employee_email" id="emailBox" class="form-control" value="<?php echo $email_details_arr['EmpEmail']; ?>">
					</div>
					<div class="form-group">
				      <label for="EmailStatSel">Employee Status:</label>
					      <select class="form-control" id="EmailStatSel" name="email_stat">
					        <option value="">Select</option>
					        <option value="incorrect" <?php if($email_details_arr['EmpEmailStatus']=="incorrect") echo "selected"; ?>>Incorrect</option>
					        <option value="rejected" <?php if($email_details_arr['EmpEmailStatus']=="rejected") echo "selected"; ?>>Rejected incoming emails</option>
					      </select>
					      <button type="submit" class="btn btn-default center-block" name="update_email">Submit Changes</button>
				    </div>
				</form>				
			</div>			
		</div>
		<?php
		}
		?>
		<br>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Employee Name</th>
							<th>Employee Designation</th>
							<th>Employee Phone</th>
							<th>Employee Email</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$emp_result_set=$dbObj->emp_list($_GET['comID']);
						if(!$emp_result_set->num_rows==0)
						{
							while ($emp_row=$emp_result_set->fetch_assoc())
							{
								?>
								<tr>
									<td class="<?php echo $emp_row['EmpStatus']; ?>" data-toggle="tooltip" title="<?php echo $emp_row['EmpStatus']; ?>"><a href="AdminEmpEdit.php?comID=<?php echo $_GET['comID']; ?>&emplID=<?php echo $emp_row['EmpID'] ?>"><?php echo $emp_row['EmpName']; ?></a></td>
									<td><?php echo $emp_row['EmpDesig']; ?></td>
									<td><?php echo $emp_row['EmpPhone']; ?></td>
									<td data-toggle="tooltip" title="<?php echo $emp_row['EmpEmailStatus']; ?>" class="<?php echo $emp_row['EmpEmailStatus']; ?>"><a href="AdminEmpEdit.php?comID=<?php echo $_GET['comID']; ?>&empEmailID=<?php echo $emp_row['EmpEmailID']; ?>"><?php echo $emp_row['EmpEmail']; ?></a></td>
								</tr>

								<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>