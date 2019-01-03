<?php
$comp_ID=$_GET['compID'];
function row_creator($arr)
{
$table_row="<tr><td data-toggle='tooltip' title='". $arr[4] ."' class='". $arr[4] ."'> <input type='checkbox' name='empArray[]' value='". $arr[2] ."'> ". $arr[3] ."</td><td>". $arr[5] ."</td><td data-toggle='tooltip' title='". $arr[8] ."' class='". $arr[8] ."'> <input type='checkbox' name='emailArray[]' value='". $arr[6] ."'> ". $arr[7] ."</td></tr>";
//return $table_row;
echo $table_row;
}
require 'dbconn.php';
$select_query="SELECT compname.CompName, compname.CompSite, empname.EmpID, `empname`.`EmpName`, empname.EmpStatus, `empname`.`EmpDesig`, empemail.EmpEmailID, `empemail`.`EmpEmail`, empemail.EmpEmailStatus FROM `empname`, `empemail`, compname WHERE empname.EmpID=empemail.EmpID and compname.CompID=".$comp_ID;
$result=$mysqli->query($select_query);
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
		function compNameDisplay(cname)
		{
			document.getElementById("compNameHeading").innerText=cname;
		}
		function compSiteDisplay(csite)
		{
			document.getElementById("compSiteHeading").innerText=csite;
		}
		// Create script where I have to just click the employee checkbox to enable the relevant email addresses only then will the user be able to proceed with adding the company to the profiling list.
	</script>
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
	<div class="container" style="margin-top: 20px;">
		<div class="row">
			<div class="col-sm-12" style="background-color:lavender;">
				<h1 style="text-align: center;">Add Employee and Email addresses for</h1>
				<h3 style="text-align: center;" id="compNameHeading">
				</h3>
				<h4 style="text-align: center;" id="compSiteHeading">
					
				</h4>
				<!-- company name so the user knows the company to which he is adding the employee to -->
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<!-- list the existing employees here -->
				<form method="post" action="3roughwork.php?comp=<?php echo $comp_ID; ?>">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Employee Name</th>
								<th>Employee Designation</th>
								<th>Employee email address</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3">
							<?php
							if($result->num_rows==0)
							{
								echo "No Records Found";
							}
							else
							{
							?>
							</td>
							</tr>
							<?php
							$counter=1;
							while ($row=$result->fetch_array()) {
								if($counter==1)
								{
									echo "<script type='text/javascript'>compNameDisplay('". $row[0] ."');</script>";
									echo "<script type='text/javascript'>compSiteDisplay('". $row[1] ."');</script>";
									echo row_creator($row);
								}
								else
								{
									echo row_creator($row);
								}
								$counter++;
							}
						}
							?>
						</tbody>
					</table>
					<button type="submit" class="btn btn-default center-block">Proceed to profiling these details</button>
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
						<input type="email" class="form-control" id="empEmail1" placeholder="Enter Employee Email Address" name="emp_Email1" maxlength="300" required="true">
					</div>
					<div class="form-group">
						<label for="empEmail2">Employee email Address 2: </label>
						<input type="email" class="form-control" id="empEmail2" placeholder="Enter Employee Email Address" name="emp_Email2" maxlength="300">
					</div>
					<div class="form-group">
						<label for="empEmail3">Employee email Address 3: </label>
						<input type="email" class="form-control" id="empEmail3" placeholder="Enter Employee Email Address" name="emp_Email3" maxlength="300">
					</div>
					<button type="submit" class="btn btn-default center-block">Add and Proceed for another Employee addition</button>
				</form>
			</div>
		</div>
	</div>

</body>
</html>