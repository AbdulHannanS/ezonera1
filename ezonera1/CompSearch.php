<?php
// add a search bar, below it create a table with the search result.
// put a check box in front of the company name.
// pass the company ID directly to the empAdd.php page along with the query string "compID" with the anchor tag.
// this way the user can select and add the company employess only, thus restraining the user from deleting the previously profiled data.
session_start();
if(!isset($_SESSION['RAID']))
{
	header("location:Login.php");
}
/**
		 * 
		 */
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
	<title>Search and Profile Company</title>
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
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<form method="post" action="#" class="form-inline">
				<div class="form-group">
					<div class="form-group">
						<label for="SrchBx">Email address:</label>
						<input type="text" class="form-control" id="SrchBx" name="Srch_term">
					</div>
					<button type="submit" class="btn btn-default">Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-bordered">
				<thead>
					<th>Profiled Date</th>
					<th>RA Name</th>
					<th>Company Name</th>
					<th>Company Website</th>
					<th>Job Title</th>
					<th>Job Location</th>
					<th>JD Link</th>
					<th>Employee Name</th>
					<th>Employee Designation</th>
					<th>Employee Email</th>
				</thead>
				<tbody>
					<?php
					if(isset($_POST['Srch_term']))
					{
						//print_r($_POST);
						$obj=new dbclass();
						$result_set=$obj->Search_result($_POST['Srch_term']);
						if(!($obj->get_row_count()==0))
						{
							while ($result_arr=$result_set->fetch_assoc())
							{
								?>
								<tr>
									<td><?php echo $result_arr["ProfiledDate"]; ?></td>
									<td><?php echo $result_arr["RAName"]; ?></td>
									<td data-toggle='tooltip' title='<?php echo $result_arr['CompStatus']; ?>' class='<?php echo $result_arr['CompStatus']; ?>'><a href='empAdd.php?compID=<?php echo $result_arr['CompID']; ?>'><?php echo $result_arr["CompName"]; ?></a></td>
									<td><?php echo $result_arr["CompSite"]; ?></td>
									<td><?php echo $result_arr["JobTitle"]; ?></td>
									<td><?php echo $result_arr["JobLocation"]; ?></td>
									<td><?php echo $result_arr["JDLink"]; ?></td>
									<td data-toggle='tooltip' title='<?php echo $result_arr['EmpStatus']; ?>' class='<?php echo $result_arr['EmpStatus']; ?>'><?php echo $result_arr["EmpName"]; ?></td>
									<td><?php echo $result_arr["EmpDesig"]; ?></td>
									<td data-toggle='tooltip' title='<?php echo $result_arr['EmpEmailStatus']; ?>' class='<?php echo $result_arr['EmpEmailStatus']; ?>'><?php echo $result_arr["EmpEmail"]; ?></td>
								</tr>
								<?php
							}
						}
						else
						{
							?>
							<tr><td colspan='10' style='text-align:center;'><p>NO MATCHES WERE FOUND</p><p><a href='CompAdd.php'>Add The Company</a></p></td></tr>
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