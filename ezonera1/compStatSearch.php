<?php
/*For Admin:
1. Edit company status
2. Edit Employee status select emailaddress to not contact or contact
3. Incorrect email address selection*/
session_start();
if(!$_SESSION['RAType']=="Admin")
{
	header("location:Login.php");
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
	public function Search_result($term)
	{
		// if the company is in the database but not in the profilelog then it will not show with this query
		$search_query="SELECT `profilelog`.`ProfiledDate`, `radetails`.`RAName`, `compname`.`CompID`, `compname`.`CompName`, `compname`.`CompSite`, `compname`.`CompStatus`, `empname`.`EmpName`, `empname`.`EmpDesig`, `empname`.`EmpStatus`, `profilelog`.`JobTitle`, `profilelog`.`JobLocation`, `profilelog`.`JDLink`, `empemail`.`EmpEmail`, `empemail`.`EmpEmailStatus` FROM `profilelog` LEFT JOIN `radetails` ON `profilelog`.`RAID` = `radetails`.`RAID` LEFT JOIN `compname` ON `profilelog`.`CompID` = `compname`.`CompID` LEFT JOIN `empname` ON `profilelog`.`EmpID` = `empname`.`EmpID` LEFT JOIN `empemail` ON `profilelog`.`EmpEmailID` = `empemail`.`EmpEmailID` WHERE `compname`.`CompSite` LIKE '%". $term ."%' OR `empemail`.`EmpEmail` LIKE '%". $term ."%'";
		$res=mysqli_query($this->mysqli, $search_query);
		$this->row_count=$res->num_rows;
		return $res;
	}
	public function get_row_count()
	{
		return $this->row_count;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search and Edit Company</title>
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
	</style>
</head>
<body>
	<?php include 'nav_bar.php'; ?>
<div class="container-fluid">
	<div class="row">
		<!-- row for a search box -->
		<div class="col-sm-12">
			<form class="form-inlne" method="post" action="#">
				<div class="input-group">
					<input type="text" class="form-control" name="comp_search" placeholder="search a company with website name or email domain">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>			
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Company Name</th>
						<th>Company Site</th>
						<th>Employee Name</th>
						<th>Employee Designation</th>
						<th>Employee Phone</th>
						<th>Employee Email</th>
					</tr>
				</thead>
				<tbody>
					<?php
					
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>