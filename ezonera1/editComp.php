<?php
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
	public function update_comp_status($company_ID, $name, $site, $stat, $remark)
	{
		$update_query="UPDATE `compname` SET `CompName`='". $name ."',`CompSite`='". $site ."',`CompStatus`='". $stat ."',`CompRemarks`='". $remark ."' WHERE CompID=". $company_ID;
		$ret_val=mysqli_query($this->mysqli, $update_query);
	}
	public function get_row_count()
	{
		return $this->row_count;
	}
}
if(isset($_GET['comID']))
{
	$newObj=new dbclass();
	$comp_details=$newObj->company_details($_GET['comID']);
}
if(isset($_POST['Update_btn']))
{
	$updateObj= new dbclass();
	$updateObj->update_comp_status($_GET['comID'], $_POST['Company_name'], $_POST['company_site'], $_POST['Comp_Status'], $_POST['Comp_Remarks']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Company Status</title>
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
	<script type="text/javascript">
		function enabler(el)
		{
			if(confirm("Are you sure you want to edit this field"))
				el.disabled=false;
			else
				el.disabled=true;
		}
	</script>
</head>
<body>
	<?php include 'nav_bar.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<form method="post" action="#">
					<div class="form-group">
						<label for="company">Company Name:</label>
						<input type="text" class="form-control" id="company" placeholder="Company Name" name="Company_name" value="<?php echo $comp_details['CompName']; ?>" onclick="enabler(this)">
					</div>
					<div class="form-group">
						<label for="Website">Password:</label>
						<input type="text" class="form-control" id="Website" placeholder="Company Site" name="company_site" value="<?php echo $comp_details['CompSite']; ?>" onclick="enabler(this)">
					</div>
					<div class="form-group">
						<label for="sel1">Select list:</label>
						<select class="form-control" id="sel1" name="Comp_Status">
							<option value="">Select</option>
							<option value="DNC" <?php if($comp_details['CompStatus']=="DNC"){echo "selected";} ?>>Do Not Contact</option>
							<option value="Qualified" <?php if($comp_details['CompStatus']=="Qualified"){echo "selected";} ?>>Qualified</option>
							<option value="contact-later" <?php if($comp_details['CompStatus']=="contact-later"){echo "selected";} ?>>Contact Later</option>
						</select>
					</div>
					 <div class="form-group">
					 	<label for="comment">Company Remarks:</label>
					 	<textarea class="form-control" rows="2" id="comment" name="Comp_Remarks"><?php echo $comp_details['CompRemarks']; ?></textarea>
					 </div> 
					<button type="submit" class="btn btn-default" name="Update_btn">Update Company Details</button>
					<a href="AdminEmpEdit.php?comID=<?php echo $_GET['comID']?>">Add/Edit Employees</a>
				</form>
			</div>
		</div>
	</div>
</body>
</html>