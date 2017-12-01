<?php
session_start();
include('includes/article.php');
include('includes/connection.php');

if(isset($_POST['login']))
{ 
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(empty($username) || empty($password))
	{
		$error = 'All fields are required !!';
	}
	else
	{
		$query = $pdo -> prepare("SELECT * FROM staff_names WHERE staff_no = ? AND password= ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->execute();
		$num = $query->rowCount();
		if($num==1)
		{	
			$_SESSION['username'] = $username;
			$_SESSION['staff'] = true;
			header('Location: s_index.php');
			exit();
		}
		$query = $pdo -> prepare("SELECT * FROM controller_names WHERE username = ? AND password= ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->execute();
		$num = $query->rowCount();
		if($num==1)
		{	
			$_SESSION['username'] = $username;
			$_SESSION['controller'] = true;
			header('Location: c_index.php');
			exit();
		}
		$query = $pdo -> prepare("SELECT * FROM admin_names WHERE username = ? AND password= ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->execute();
		$num = $query->rowCount();
		if($num==1)
		{	
			$_SESSION['username'] = $username;
			$_SESSION['admin'] = true;
			header('Location: a_index.php');
			exit();
		}
		if(!isset($_SESSION['username']))
		{
			$error = 'Incorrect login details !!';
		}
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library management System</title>
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
                <a class="navbar-brand" href="index.php">Vidyanikethan</a> 
            </div>
			<div style=" font-size: 25px;color: #f00;padding: 10px 50px 5px 15px;float: left;">Library Management System</div>
            <form role="form" action="contactus.php" method="POST" enctype="multipart/form-data">
				<div class="col-sm-4" style="margin: 15px -10px 0px 165px;">
					<div class="col-sm-6">
						<input type="text" class="form-control" style="color:white;background-color: transparent;" placeholder="Username" name="username" />
					</div>
					<div class="col-sm-6">
						<input type="password" class="form-control" style="color:white;background-color: transparent;" placeholder="Password" name="password" >
					</div>
				</div>
				<div style="color: white;margin: 15px 15px 5px 0px;float: right;font-size: 16px;">&nbsp; <button type="submit" class="btn btn-danger square-btn-adjust" name="login" >LogIn</button> </div>      
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
                        <a href="index.php"><i class="glyphicon glyphicon-search "></i>Search</a>
                    </li>
                     <li>
                        <a href="books.php"><i class="glyphicon glyphicon-folder-open "></i>All Book Records</a>
                    </li>
					<li>
                        <a href="ebooks.php"><i class="glyphicon glyphicon-book "></i>E-Book</a>
                    </li>
					<li>
                        <a href="journals.php"><i class="glyphicon glyphicon-list "></i>Journals</a>
                    </li>
					<li>
                        <a href="magazines.php"><i class="glyphicon glyphicon-globe "></i>Magazines</a>
                    </li>
					<li>
                        <a class="active-menu" href="nptel.php"><i class="glyphicon glyphicon-facetime-video "></i>NPTEL</a>
                    </li>
                    <li>
                        <a href="suggest.php"><i class="glyphicon glyphicon-book "></i>Suggest Books</a>
                    </li>
					<li>
                        <a href="contactus.php"><i class="glyphicon glyphicon-phone-alt "></i>Contact Us</a>
                    </li>	
                    <li>
                        <a href="aboutus.php"><i class="glyphicon glyphicon-map-marker "></i>About Us</a>
                    </li>
                </ul>
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
				<div class="row">
                    <div class="col-md-12" style="margin-left:20px;">
						<h2>NPTEL</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
				</div>
                 <!-- /. ROW  -->
					<table class="table table-bordered ">
					<tbody>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=1">Computer Architecture</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=2">NOC:Introduction to programming in C</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=3">NOC:Programming, Data Structures and Algorithms</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=4">Artificial Intelligence</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=5">Artificial Intelligence</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=6">Artificial Intelligence</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=7">Artificial Intelligence(Prof.P.Dasgupta)</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=8">Compiler Design</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=9">Compiler Design</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=10">Computer Algorithms - 2</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=11">Computer Architecture</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=12">Computer Graphics</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=13">Computer Graphics</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=14">Computer Networks</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=15">Computer Networks</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=16">Computer Networks</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=17">Computer Organisation and Architecture</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=18">Computer Organization</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=19">Computer Organization and Architecture</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=20">Data Structures And Algorithms</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=21">Design and Analysis of Algorithms</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=22">Design and Analysis of Algorithms</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=23">Discrete Mathematical Structures</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=24">Introduction to Computer Graphics</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=25">Introduction to Problem Solving and Programming</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=26">Introduction to Problem Solving and Programming</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=27">Numerical Optimization</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=28">Operating Systems</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=29">Software Engineering</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=30">Software Engineering</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=31">Theory of Automata and Formal Languages</a>
						</tr>
						<hr/>
						<tr>
							<a class="btn btn-warning" style="border-radius:8px;width:100%;" href="sub.php?id=32">Theory of Automata, Formal Languages and Computation</a>
						</tr>
						<hr/>
					</tbody>
					</table>
					
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