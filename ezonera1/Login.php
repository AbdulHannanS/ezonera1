<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login to EZONE RA Tool</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  require 'dbconn.php';
  session_start();
  // If form submitted, insert values into the database.
  if(isset($_POST['RAemail']))
  {
        // removes backslashes
    $RAemail = stripslashes($_REQUEST['RAemail']);
          //escapes special characters in a string
    $RAemail = mysqli_real_escape_string($mysqli,$RAemail);
    $RApwd = stripslashes($_REQUEST['RApwd']);
    $RApwd = mysqli_real_escape_string($mysqli,$RApwd);
    //Checking is user existing in the database or not
          $query = "SELECT * FROM `radetails` WHERE RAemail='$RAemail' and RAPass='".$RApwd."'";
    $result = mysqli_query($mysqli,$query);
    $rows = mysqli_num_rows($result);
    if($rows==1)
    {
      $RAdet=mysqli_fetch_assoc($result);
      $_SESSION['RAID'] = $RAdet['RAID'];
      $_SESSION['RAname'] = $RAdet['RAName'];
      $_SESSION['RAType'] = $RAdet['RAuserType'];
          // Redirect user to the profile page
      //header("Location: index.php");
    }
    else
    {
      echo "<script type='text/javascript'>\$(document).ready(function(){\$('#myModal').modal('show');});</script>";
    }
  }
?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login Failed</h4>
        </div>
        <div class="modal-body">
          <p>Make sure your email and password is correct</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Try Again</button>
        </div>
      </div>
      
    </div>
  </div>
<div class="container" style="width: 80%;">
  <h2 style="text-align: center;">Log in to EZONE RA Profiling tool</h2>
  <form action="" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="RAemail">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="RApwd">
    </div>
    <button type="submit" class="btn btn-default">Log In</button>
  </form>
</div>

</body>
</html>
