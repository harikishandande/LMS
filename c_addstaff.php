<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['controller']))
	{	
		if(isset($_POST['submitstaff']))
	{	
		$array=$_POST['staff'];
		$duration = $_POST['duration'];
		if(empty($array) or empty($duration))
		{
			$error="All fields are required !";
		}
		else
		{
			foreach($array as $staff_no)
			{	
				$password = rand(10000,99999);
				if(strlen($staff_no)>0)
				{
					$query = $pdo->prepare('INSERT into staff_names(duration,staff_no,password)values(?,?,?)');
						$query->bindValue(1, $duration);
						$query->bindValue(2, $staff_no);
						$query->bindValue(3, $password);
						$query->execute();
						header('Location: c_addstaff.php');
				}
			}
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

     <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

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
                        <a href="#"><i class="glyphicon glyphicon-bookmark"></i> Book CLearance<span class="fa arrow"></span></a>
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
                        <a href="c_addebooks.php"><i class="glyphicon glyphicon-plus-sign "></i>Add e Books</a>
                    </li>
					<li>
                        <a href="c_viewebooks.php"><i class="glyphicon glyphicon-book "></i>View e Books</a>
                    </li>
					<li>
                        <a class="active-menu" href="c_addstaff.php"><i class="glyphicon glyphicon-plus-sign "></i>Add Staff</a>
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
                     <h2>Add Staff</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<center><h4>Add Staff</h4>
				<div class="row">
					<div class="col-md-3"></div>
					<form role="form" class=" col-md-6" action="c_addstaff.php" method="post">
					<div class="form-group ">
						<select name="duration" class="form-control">
							<option>[ Choose duration ]</option>
							<option>2011 - 2012</option>
							<option>2012 - 2013</option>
							<option>2013 - 2014</option>
							<option>2014 - 2015</option>
							<option>2015 - 2016</option>
							<option>2016 - 2017</option>
							<option>2017 - 2018</option>
							<option>2018 - 2019</option>
							<option>2019 - 2020</option>
							<option>2020 - 2021</option>
						</select>
					</div>				
					<div class="clone"> 
						<input class="form-control" style="text-transform:uppercase;" type="text" name="staff[]" placeholder="New Staff Number"/>
						<a href="#" class="add btn btn-info btn-xs" rel=".clone">Add More</a>	
					</div>
				<div class="form-group" style="margin-top:25px;">
					<button class="btn btn-success" name="submitstaff" type="submit" >Add Staff</button>
				</div>
			</form>
				<div class="col-md-3"></div>
			</div>
			</center>
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
	<script src="assets/js/jquery-ui.js"></script>
	
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>

	<script type="text/javascript" src="reCopy.js"></script>
		<script type="text/javascript">
			$(function()
			{
				var removeLink = ' <a class="btn btn-danger btn-xs" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">remove</a>';
				$('a.add').relCopy({ append: removeLink});	
			});
		</script>
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
