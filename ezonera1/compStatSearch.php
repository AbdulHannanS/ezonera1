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
		$search_query="SELECT `compname`.`CompID`, `compname`.`CompName`, `compname`.`CompSite`, `compname`.`CompStatus`, `compname`.`CompRemarks`, `empname`.`EmpID`, `empname`.`EmpName`, `empname`.`EmpDesig`, `empname`.`EmpStatus`, `empname`.`EmpPhone`, `empemail`.`EmpEmailID`, `empemail`.`EmpEmail`, `empemail`.`EmpEmailStatus` FROM `compname` LEFT JOIN `empname` ON `compname`.`CompID` = `empname`.`CompID` LEFT JOIN `empemail` ON `empname`.`EmpID` = `empemail`.`EmpID` WHERE `compname`.`CompSite` LIKE '%". $term ."%' OR `empemail`.`EmpEmail` LIKE '%". $term ."%'";
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
		<!-- row for a search box -->
		<div class="col-sm-12">
			<form class="form-inlne" method="post" action="#">
				<div class="input-group">
					<input type="text" class="form-control" name="comp_search" placeholder="search a company with website name or email domain" value="<?php if(isset($_POST['comp_search'])){ echo $_POST['comp_search']; } ?>">
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
					if(isset($_POST['comp_search']))
					{
						$counter=1;
						$dbObj=new dbclass();
						$res=$dbObj->Search_result($_POST['comp_search']);
						if(!($dbObj->get_row_count()==0))
						{
							while ($result_arr=$res->fetch_assoc())
							{
								?>
								<tr>
									<!-- first cell of the company -->
									<td class="<?php echo $result_arr['CompStatus']; ?>" data-toggle="tooltip" title="<?php echo $result_arr['CompStatus']; ?>"><a href="editComp.php?comID=<?php echo $result_arr['CompID']; ?>"><?php echo $result_arr['CompName']; ?></a>
										<?php
										if(strlen($result_arr['CompRemarks'])>0)
										{
											?>
											<div class="panel">
												<div class="panel-heading">
													<a data-toggle="collapse" href="#collapse<?php echo $counter; ?>">View Remarks</a>
												</div>
												<div id="collapse<?php echo $counter; ?>" class="panel-collapse collapse">
													<div class="panel-body"><?php echo $result_arr['CompRemarks']; ?></div>
												</div>
											</div>
											<?php
											$counter++;
										}
										?>
									</td>
									<!-- second cell -->
									<td><?php echo $result_arr['CompSite'] ?></td>
									<!-- third cell -->
									<td data-toggle="tooltip" title="<?php echo $result_arr['EmpStatus']; ?>" class="<?php echo $result_arr['EmpStatus']; ?>"><a href="editEmployee.php?emplID=<?php echo $result_arr['EmpID']; ?>"><?php echo $result_arr['EmpName'] ?></a></td>
									<!-- fourth cell -->
									<td><?php echo $result_arr['EmpDesig']; ?></td>
									<!-- fifth cell -->
									<td><?php echo $result_arr['EmpPhone']; ?></td>
									<!-- sixth cell -->
									<td class="<?php echo $result_arr['EmpEmailStatus']; ?>" data-toggle="tooltip" title="<?php echo $result_arr['EmpEmailStatus']; ?>"><?php echo $result_arr['EmpEmail']; ?></td>
								</tr>
								<?php
							}
						}
						else
						{
							?>
							<tr><td colspan='6' style='text-align:center;'><p>NO MATCHES WERE FOUND</p><p><a href='CompAdd.php'>Add The Company</a></p></td></tr>
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