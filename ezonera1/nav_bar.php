<?php
// $_SESSION['RAID'];
// $_SESSION['RAname'];
// $_SESSION['RAType'];
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="ProfileLog.php"><?php echo $_SESSION['RAname']; ?></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="ProfileLog.php">Home</a></li>
      <li><a href="CompSearch.php">Search and Profile Company</a></li>
      <?php
      if($_SESSION['RAType']=='Admin')
      {?>
      <li><a href="compStatSearch.php">Edit Company Status</a></li>
      <?php }
      ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><p class="navbar-text">
      	<?php
      	if(!isset($_SESSION['prof_dt']))
      		echo "Date Not SET";
      	else
      		echo $_SESSION['prof_dt'];
      	?>
      </p></li>
      <li><a href="Log_Out.php">Log Out</a></li>
    </ul>
  </div>
</nav>
