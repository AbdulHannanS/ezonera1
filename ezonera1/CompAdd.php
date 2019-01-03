<!DOCTYPE html>
<html>
<head>
	<title>Add Companies</title>
	<!-- https://stackoverflow.com/questions/34613551/get-last-inserted-id-after-setting-commit-to-false
	Get last inserted id after setting commit to false -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container" style="margin-top:20px;">
		<div class="row">
			<div class="col-sm-12" style="background-color:lavender;"><h1 style="text-align: center;">Add a Company</h1>
			</div>
		</div>
		<div class="row" style="padding-top: 5px;">
			<div class="col-sm-12">
				<form action="compAddback.php" method="post">
					<div class="form-group">
						<label for="cmpName">Company Name (required): </label>
						<input type="text" class="form-control" id="cmpName" placeholder="Enter Company Name" name="cmp_Name" maxlength="70" required>
					</div>
					<div class="form-group">
						<label for="cmpWeb">Company Website (required):</label>
						<input type="text" class="form-control" id="cmpWeb" placeholder="Enter Company Website" name="cmp_Web" maxlength="1000" required>
					</div>
					<button type="submit" class="btn btn-default center-block">Add and Proceed for Employee addition</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>