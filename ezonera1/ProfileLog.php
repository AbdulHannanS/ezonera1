<?php
//Let the User select the date here, and show a profile log below for that date
session_start();
if(isset($_POST['Profile_dt']))
{
	$_SESSION['prof_dt']=$_POST['Profile_dt'];
}
function populate_Profile_log($pdate)
{
	$table_row="";
	$counter=1;
	require 'dbconn.php';
	$Select_profile_query="SELECT `profilelog`.`ProfiledID`, `profilelog`.`ProfiledDate`, `radetails`.`RAName`, `compname`.`CompName`, `compname`.`CompSite`, `compname`.`CompStatus`, `empname`.`EmpName`, `empname`.`EmpDesig`, `empname`.`EmpStatus`, `empemail`.`EmpEmail`, `empemail`.`EmpEmailStatus`, `profilelog`.`JobTitle`, `profilelog`.`JobLocation`, `profilelog`.`JDLink` FROM `profilelog` LEFT JOIN `radetails` ON `profilelog`.`RAID` = `radetails`.`RAID` LEFT JOIN `compname` ON `profilelog`.`CompID` = `compname`.`CompID` LEFT JOIN `empname` ON `profilelog`.`EmpID` = `empname`.`EmpID` LEFT JOIN `empemail` ON `profilelog`.`EmpEmailID` = `empemail`.`EmpEmailID` WHERE radetails.RAID= ? and profilelog.ProfiledDate= ?";
	$stmt=$mysqli->prepare($Select_profile_query);
	$stmt->bind_param("is", $_SESSION['RAID'], $pdate );
	$stmt->execute();
	$res=$stmt->get_result();
	if($res->num_rows>0)
	{
		while ($arr=$res->fetch_assoc()) {
			$table_row = $table_row."<tr><td><input type='checkbox' name='profiled_ID[]' value='". $arr['ProfiledID'] ."'> ". $counter ."</td><td>". $arr['RAName'] ."</td><td data-toggle='tooltip' title='". $arr['CompStatus'] ."' class='". $arr['CompStatus'] ."' data-placement='auto left' >". $arr['CompName'] ."</td><td>". $arr['CompSite'] ."</td><td>". $arr['JobTitle'] ."</td><td>". $arr['JobLocation'] ."</td><td>". $arr['JDLink'] ."</td><td data-toggle='tooltip' title='". $arr['EmpStatus'] ."' class='". $arr['EmpStatus'] ."' data-placement='auto left' >". $arr['EmpName'] ."</td><td>". $arr['EmpDesig'] ."</td><td data-toggle='tooltip' title='". $arr['EmpEmailStatus'] ."' class='". $arr['EmpEmailStatus'] ."' data-placement='auto left' >". $arr['EmpEmail'] ."</td></tr>";
			$counter++;
		}
		return $table_row;
	}
	else
	{
		return "<tr><td colspan='10' style='text-align:center;'>No Data Available for this date</td></tr>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile log</title>
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
		}
	</style>
</head>
<body>
 <!-- add a date field on the top with 2 buttons. 1st will enable the  date field if the use wants to change the date field. Second will submit the date and will set the session variable for date. -->
 	<div style="padding: 3px; text-align: center; margin-top: 8px;">
		<form action="" method="post" class="form-inline">
			<div class="form-group">
				<label for="dtField">Date to profile on (mm-dd-yyyy)</label>
				<input type="date" name="Profile_dt" <?php 
				if(isset($_SESSION['prof_dt']))
					echo "value='". $_SESSION['prof_dt'] ."'";
				?>>
			</div>
			<button type="submit" class="btn btn-default" name="dt_changer">Change/Set Date</button>
		</form>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<!-- https://www.formget.com/angularjs-crud/#crud_read
			show table using angular -->
			<form method="post" action="3roughwork.php">
				<table class="table table-bordered table-fixed">
					<thead>
						<tr><th>Sr. No.</th>
						<th>RA Name</th>
						<th>Company Name</th>
						<th>Company Website</th>
						<th>Job Position</th>
						<th>Job Location</th>
						<th>JD Link</th>
						<th>Lead Name</th>
						<th>Lead Designation</th>
						<th>Lead Email</th></tr>
					</thead>
					<tbody>
						<tr><td colspan="10" style="text-align: center;"><button type="submit" class="btn btn-default" name="Delete_line">Delete row</button>&nbsp;&nbsp;&nbsp;
							<!-- change may be needed while migrating to another server --><button class="btn btn-default" onclick="Location.href='3roughwork.php';">Add a Company</button></td></tr>
							<?php
							if(isset($_SESSION['prof_dt']))
							{
								echo populate_Profile_log($_SESSION['prof_dt']);
							}
							?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</body>
</html>