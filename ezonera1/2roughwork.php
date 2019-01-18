<?php
if(isset($_POST['testtable']))
{
	print_r($_POST);
	//header("refresh:3, URL=1roughwork.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>table as a form</title>
</head>
<body>
<form method="post" action="">
	<table>
		<tr>
			<th>heading1</th>
			<th>heading2</th>
			<th>heading3</th>
		</tr>
		<tr>
			<td><input type="text" name="cell10"></td>
			<td>cell1,2</td>
			<td>cell1,3</td>
		</tr>
		<tr>
			<td><input type="text" name="cell12"></td>
			<td>cell1,2</td>
			<td>cell1,3</td>
		</tr>
		<tr>
			<td name="cell3">cell1,1</td>
			<td>cell1,2</td>
			<td name="cell33">cell1,3</td>
		</tr>
	</table>
	<input type="submit" name="testtable">
</form>
</body>
</html>