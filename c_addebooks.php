<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['controller']))
	{	
		if(isset($_POST['addebook']) != "")
		{	
			$ename = $_POST['ename'];
					
			$count=mysqli_query($connection, "SELECT * FROM ebook WHERE ename = '$ename'");

			if(mysqli_num_rows($count) < 1)
			{
					if ($_FILES["efile"]["error"] > 0)
					{
						echo "<script> alert(' Feilmelding:" . $_FILES['efile']['error'] . "');</script>";
					}
					else
					{
						$randstr = ""; 
						  for($i=0; $i<7; $i++){ 
							 $randnum = mt_rand(0,61); 
							 if($randnum < 10){ 
								$randstr .= chr($randnum+48); 
							 }else if($randnum < 36){ 
								$randstr .= chr($randnum+55); 
							 }else{ 
								$randstr .= chr($randnum+61); 
							 } 
						  } 
						$efile = $randstr.$_FILES['efile']['name'];
						$temp=$_FILES['efile']['tmp_name'];
						move_uploaded_file($temp,"UPLOAD_DIR/".$efile);
						$insert=mysqli_query($connection,"insert into ebook(ename, efile)values('$ename','$efile')");
						if($insert)
						{
							echo "<script> alert('Book Uploaded Successfully !');</script>";
						}
					}
			}
			else
			{
				echo "<script> alert('Your Book Already Exist ! Change Book name !');</script>";
			}
		}
		if(isset($_POST['addjournal']) != "")
		{	
			$jname = $_POST['jname'];
					
			$count=mysqli_query($connection, "SELECT * FROM journals WHERE jname = '$jname'");

			if(mysqli_num_rows($count) < 1)
			{
					if ($_FILES["jfile"]["error"] > 0)
					{
						echo "<script> alert(' Failure :" . $_FILES['jfile']['error'] . "');</script>";
					}
					else
					{
						$randstr = ""; 
						  for($i=0; $i<7; $i++){ 
							 $randnum = mt_rand(0,61); 
							 if($randnum < 10){ 
								$randstr .= chr($randnum+48); 
							 }else if($randnum < 36){ 
								$randstr .= chr($randnum+55); 
							 }else{ 
								$randstr .= chr($randnum+61); 
							 } 
						  } 
						$jfile = $randstr.$_FILES['jfile']['name'];
						$temp=$_FILES['jfile']['tmp_name'];
						move_uploaded_file($temp,"UPLOAD_JOR/".$jfile);
						$insert=mysqli_query($connection,"insert into journals(jname, jfile)values('$jname','$jfile')");
						if($insert)
						{
							echo "<script> alert('Journal Uploaded Successfully !');</script>";
						}
					}
			}
			else
			{
				echo "<script> alert('Your Journal Already Exist ! Change Book name !');</script>";
			}
		}
		if(isset($_POST['addmagazine']) != "")
		{	
			$mname = $_POST['mname'];
					
			$count=mysqli_query($connection, "SELECT * FROM magazines WHERE mname = '$mname'");

			if(mysqli_num_rows($count) < 1)
			{
					if ($_FILES["mfile"]["error"] > 0)
					{
						echo "<script> alert(' Failure :" . $_FILES['mfile']['error'] . "');</script>";
					}
					else
					{
						$randstr = ""; 
						  for($i=0; $i<7; $i++){ 
							 $randnum = mt_rand(0,61); 
							 if($randnum < 10){ 
								$randstr .= chr($randnum+48); 
							 }else if($randnum < 36){ 
								$randstr .= chr($randnum+55); 
							 }else{ 
								$randstr .= chr($randnum+61); 
							 } 
						  } 
						$mfile = $randstr.$_FILES['mfile']['name'];
						$temp=$_FILES['mfile']['tmp_name'];
						move_uploaded_file($temp,"UPLOAD_MAG/".$mfile);
						$insert=mysqli_query($connection,"insert into magazines(mname, mfile)values('$mname','$mfile')");
						if($insert)
						{
							echo "<script> alert('Magazine Uploaded Successfully !');</script>";
						}
					}
			}
			else
			{
				echo "<script> alert('Your Book Already Exist ! Change Book name !');</script>";
			}
		}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $_SESSION['username']; ?> - Library management System - Controller Panel</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
	
	<link href="assets/css/jquery-ui.css" rel="stylesheet"> 

	<script src="assets/js/jquery.min.js"></script>

     <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	   
		<style>
			tr.clickableRow { cursor: pointer; }
		</style>
		
   <!-- JQUERY SCRIPTS -->
	
	
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0px;margin-top:-20px;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://www.vidyanikethan.edu">Vidyanikethan</a> 
            </div>
			<div style=" font-size: 25px;color: #f00;padding: 10px 50px 5px 15px;float: left;">Library Management System - Controller Panel</div>
            <form role="form" action="login.php" method="POST" enctype="multipart/form-data">
				<div style="color: white;margin: 15px 15px 5px 0px;float: right;font-size: 16px;"><?php echo "<i class='glyphicon glyphicon-user'></i>" . " " . $_SESSION['username']; ?>&nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust" >LogOut</a> </div>      
			</form>
		</nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
					<li class="text-center">
						<img src="assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
					<li>
                        <a href="c_index.php"><i class="glyphicon glyphicon-stats "></i>Statistics</a>
                    </li>
					<li>
                        <a href="#"><i class="glyphicon glyphicon-bookmark"></i> Book Clearance<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="c_bookissue.php">Book Issue</a>
                            </li>
                            <li>
                                <a href="c_bookreturn.php">Book Return</a>
                            </li>
                            <li>
                                <a href="c_finedetails.php">Fine Details</a>
                            </li>
                        </ul>
                    </li>  
                    <li>
                        <a href="c_addbooks.php"><i class="glyphicon glyphicon-plus-sign "></i>Add Books</a>
                    </li>
					<li>
                        <a href="c_viewbooks.php"><i class="glyphicon glyphicon-book "></i>View Books</a>
                    </li>
					<li>
                        <a class="active-menu" href="c_addebooks.php"><i class="glyphicon glyphicon-plus-sign "></i>Add e Books</a>
                    </li>
					<li>
                        <a href="c_viewebooks.php"><i class="glyphicon glyphicon-book "></i>View e Books</a>
                    </li>
					<li>
                        <a href="c_addstaff.php"><i class="glyphicon glyphicon-plus-sign "></i>Add Staff</a>
                    </li>
					<li>
                        <a href="c_viewstaff.php"><i class="glyphicon glyphicon-user "></i>View Staff</a>
                    </li>
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12" style="margin-left:20px;">
                     <h2>Statistics</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				
				<div class="col-md-12">
					<div class="col-md-4">
						<form role="form" action="c_addebooks.php" enctype="multipart/form-data" method="POST">
							<div class="form-group">
								<label>File Name</label>
								<input type="text" style="text-transform:uppercase;" class="form-control" name="ename" placeholder="E book name" />
							</div>
							<div class="form-group">
								<label>Attach Efile</label>
								<input type="file" name="efile" id="efile" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info" name="addebook" >Add E Book</button>
							</div>
						</form>
					</div>
					<div class="col-md-4 center">
						<form role="form" action="c_addebooks.php" enctype="multipart/form-data" method="POST">
							<div class="form-group">
								<label>File Name</label>
								<input type="text" style="text-transform:uppercase;" class="form-control" name="jname" placeholder="Journal name" />
							</div>							<div class="form-group">
								<label>Attach Efile</label>
								<input type="file" name="jfile" id="efile" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info" name="addjournal" >Add Journal</button>
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<form role="form" action="c_addebooks.php" enctype="multipart/form-data" method="POST">
							<div class="form-group">
								<label>File Name</label>
								<input type="text" style="text-transform:uppercase;" class="form-control" name="mname" placeholder="Magazine name" />
							</div>
							<div class="form-group">
								<label>Attach Efile</label>
								<input type="file" name="mfile" id="efile" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info" name="addmagazine" >Add Magazine</button>
							</div>
						</form>
					</div>
				</div>
				
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
	<script src="assets/js/jquery-ui.js"></script>
	
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php 
	}
?>