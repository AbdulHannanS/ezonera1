<?php
session_start();
if(!isset($_SESSION['RAID']))
{
	header("location:Login.php");
}
$comp_ID=$_GET['compID'];
function row_creator($arr)
{
$table_row="<tr>
<td data-toggle='tooltip' title='". $arr['EmpStatus'] ."' class='". $arr['EmpStatus'] ."'> <input type='checkbox' name='empArray[]' value='". $arr['EmpID'] ."' onclick='handleClick(this)'> ". $arr['EmpName'] ."</td><td>". $arr['EmpDesig'] ."</td>
<td data-toggle='tooltip' title='". $arr['EmpEmailStatus'] ."' class='". $arr['EmpEmailStatus'] ."'> <input type='checkbox' name='emailArray[]' value='". $arr['EmpEmailID'] ."'> ". $arr['EmpEmail'] ."</td>
</tr>";
//return $table_row;
echo $table_row;
}
require 'dbconn.php';
$select_query="SELECT compname.CompName, compname.CompRemarks, compname.CompSite, empname.EmpID, `empname`.`EmpName`, empname.EmpStatus, `empname`.`EmpDesig`, empemail.EmpEmailID, `empemail`.`EmpEmail`, empemail.EmpEmailStatus FROM `empname`, `empemail`, compname WHERE empname.EmpID=empemail.EmpID AND compname.CompID=empname.CompID AND compname.CompID=". $_GET['compID'];
$result=$mysqli->query($select_query);
//$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add employee and Email Addresses</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		// Create script where I have to just click the employee checkbox to enable the relevant email addresses only then will the user be able to proceed with adding the company to the profiling list.
		// $(document).ready(function(){$('input[type="checkbox"]').click(function(){alert("you clicked a check box");})});
		function handleClick(el) {
			checkStat=el.checked;
			var rowChildArr=el.parentElement.parentElement.childNodes;
			rowChildArr[4].childNodes[1].checked=checkStat;
		}
		<?php
			$comp_Name_query="SELECT * FROM `compname` WHERE `CompID`=". $comp_ID;
			$rez=$mysqli->query($comp_Name_query);
			if($rez->num_rows==1)
			{
				$row1=$rez->fetch_assoc();
				?>
				$(document).ready(function(){$("#compNameHeading").text(<?php echo "'". $row1['CompName']. "'"; ?>);
					$("#compNameHeading").attr("class", <?php echo "'" . $row1['CompStatus']. "'"; ?>);
					$("#compSiteHeading").text(<?php echo "'". $row1['CompSite'] ."'"; ?>);
					$("#compRemarks").text(<?php echo "'". $row1['CompRemarks'] ."'" ?>);
				});

				<?php
			}
			$mysqli->close();
		?>
		$(document).ready(function(){
			$('.mailbx').keyup(function() {
  				$(this).val(this.value.toLowerCase().replace(/\s/g, ''));
			});
		});
	</script>
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
	<div class="container" style="margin-top: 20px;">
		<div class="row">
			<div class="col-sm-12" style="background-color:lavender;">
				<h1 style="text-align: center;">Add Employee and Email addresses for</h1>
				<h3 style="text-align: center;" id="compNameHeading">
				</h3>
				<h4 style="text-align: center;" id="compSiteHeading">					
				</h4>
				<h6 style="text-align: center;" id="compRemarks">					
				</h6>
				<!-- company name so the user knows the company to which he is adding the employee to -->
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<!-- list the existing employees here -->
				<form method="post" action="LogInsertBack.php?comp=<?php echo $comp_ID; ?>">
					<div class="form-group">
						<label for="jobTitle">Job Title:</label>
						<input type="text" class="form-control" id="jobTitle" placeholder="Enter job title" name="job_title">
					</div>
					<div class="form-group">
						<label for="jobLoc">Job Location:</label>
						<input type="text" class="form-control" id="jobLoc" placeholder="Enter job Location" name="job_loc">
					</div>
					<div class="form-group">
						<label for="JDLink">Job Description Link (required):</label>
						<input type="text" class="form-control" id="JDLink" placeholder="Enter job Description link" name="JD_link" maxlength="2000" required>
					</div>
					<table class="table table-bordered" id="empDetailsTable">
						<thead>
							<tr>
								<th>Employee Name</th>
								<th>Employee Designation</th>
								<th>Employee email address</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($result->num_rows==0)
							{
								echo "<tr><td colspan='3'><h3 style='text-align:center;'>No Records Found</h3></td></tr>";
							}
							else
							{
							while ($row=$result->fetch_assoc()) {
								echo row_creator($row);
							}
						}
							?>
						</tbody>
					</table>
					<button type="submit" class="btn btn-default center-block" <?php if($result->num_rows==0){echo "disabled";} ?>>Proceed to profiling these details</button>
			</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<!-- in action redirect to this page, so along with the comp ID I can add the employee name and email address -->
				<form method="post" action="empAddBack.php?comp=<?php echo $comp_ID; ?>">
						<div class="form-group">
						<label for="empName">Employee Name (required): </label>
						<input type="text" class="form-control" id="empName" placeholder="Enter Employee Name" name="emp_Name" maxlength="100" required>
					</div>
					<div class="form-group">
						<label for="empDesignation">Employee Designation: </label>
						<input type="text" class="form-control" id="empDesignation" placeholder="Enter Employee Designation" name="emp_desig" maxlength="100">
					</div>
					<!-- FOR STORING EMAIL ADDRESSES, JUST SAVE THE EMPLOYEE DETAILS AND THEN GET THE EMP ID
					Then save the email addresses with proper emp id with prepared statment -->
					<hr size="20">
					<div class="form-group">
						<label for="empEmail1">Employee email Address 1 (required): </label>
						<input type="email" class="form-control mailbx" id="empEmail1" placeholder="Enter Employee Email Address" name="emp_Email1" maxlength="300" required="true">
					</div>
					<div class="form-group">
						<label for="empEmail2">Employee email Address 2: </label>
						<input type="email" class="form-control mailbx" id="empEmail2" placeholder="Enter Employee Email Address" name="emp_Email2" maxlength="300">
					</div>
					<div class="form-group">
						<label for="empEmail3">Employee email Address 3: </label>
						<input type="email" class="form-control mailbx" id="empEmail3" placeholder="Enter Employee Email Address" name="emp_Email3" maxlength="300">
					</div>
					<button type="submit" class="btn btn-default center-block">Add and Proceed for another Employee addition</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>