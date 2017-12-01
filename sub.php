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
				<?php
					$ch = $_GET['id'];
					switch($ch)
					{
						case 1:
								$sub_name = "Computer Architecture";
								$sub_link = "http://nptel.ac.in/courses/106104122/";
								break;
						case 2:
								$sub_name = "NOC:Introduction to programming in C";
								$sub_link = "http://nptel.ac.in/courses/106104128/";
								break;
						case 3:
								$sub_name = "NOC:Programming, Data Structures and Algorithms";
								$sub_link = "http://nptel.ac.in/courses/106106127/";
								break;
						case 4:
								$sub_name = "Artificial Intelligence";
								$sub_link = "http://nptel.ac.in/courses/1061050778";
								break;
						case 5:
								$sub_name = "Artificial Intelligence";
								$sub_link = "http://nptel.ac.in/courses/106106126/";
								break;
						case 6:
								$sub_name = "Artificial Intelligence";
								$sub_link = "http://nptel.ac.in/courses/106105077/";
								break;
						case 7:
								$sub_name = "Artificial Intelligence(Prof.P.Dasgupta)";
								$sub_link = "http://nptel.ac.in/courses/106105079/";
								break;
						case 8:
								$sub_name = "Compiler Design";
								$sub_link = "http://nptel.ac.in/courses/106104072/";
								break;
						case 9:
								$sub_name = "Compiler Design";
								$sub_link = "http://nptel.ac.in/courses/106108052/";
								break;
						case 10:
								$sub_name = "Computer Algorithms - 2";
								$sub_link = "http://nptel.ac.in/courses/106104019/";
								break;
						case 11:
								$sub_name = "Computer Architecture";
								$sub_link = "http://nptel.ac.in/courses/106102062";
								break;
						case 12:
								$sub_name = "Computer Graphics";
								$sub_link = "http://nptel.ac.in/courses/106102063/";
								break;
						case 13:
								$sub_name = "Computer Graphics";
								$sub_link = "http://nptel.ac.in/courses/106106090/";
								break;
						case 14:
								$sub_name = "Computer Networks";
								$sub_link = "http://nptel.ac.in/courses/106106090/";
								break;
						case 15:
								$sub_name = "Computer Networks";
								$sub_link = "http://nptel.ac.in/courses/106105080/";
								break;
						case 16:
								$sub_name = "Computer Networks";
								$sub_link = "http://nptel.ac.in/courses/106105081/";
								break;
						case 17:
								$sub_name = "Computer Organisation and Architecture";
								$sub_link = "http://www.nptel.ac.in/courses/106104073/";
								break;
						case 18:
								$sub_name = "Computer Organization";
								$sub_link = "http://www.nptel.ac.in/courses/106106092/";
								break;
						case 19:
								$sub_name = "Computer Organization and Architecture";
								$sub_link = "http://www.nptel.ac.in/courses/106103068/";
								break;
						case 20:
								$sub_name = "Data Structures And Algorithms";
								$sub_link = "http://www.nptel.ac.in/courses/106102064/";
								break;
						case 21:
								$sub_name = "Design and Analysis of Algorithms";
								$sub_link = "http://www.nptel.ac.in/courses/106101059/";
								break;
						case 22:
								$sub_name = "Design and Analysis of Algorithms";
								$sub_link = "http://www.nptel.ac.in/courses/106101060/";
								break;
						case 23:
								$sub_name = "Discrete Mathematical Structures";
								$sub_link = "http://www.nptel.ac.in/courses/106106094/";
								break;
						case 24:
								$sub_name = "Introduction to Computer Graphics";
								$sub_link = "http://www.nptel.ac.in/courses/106102065/";
								break;
						case 25:
								$sub_name = "Introduction to Problem Solving and Programming";
								$sub_link = "http://www.nptel.ac.in/courses/106102066/";
								break;
						case 26:
								$sub_name = "Introduction to Problem Solving and Programming";
								$sub_link = "http://www.nptel.ac.in/courses/106104074/";
								break;
						case 27:
								$sub_name = "Numerical Optimization";
								$sub_link = "http://www.nptel.ac.in/courses/106108056/";
								break;
						case 28:
								$sub_name = "Operating Systems";
								$sub_link = "http://www.nptel.ac.in/courses/106108101/";
								break;
						case 29:
								$sub_name = "Software Engineering";
								$sub_link = "http://www.nptel.ac.in/courses/106101061/";
								break;
						case 30:
								$sub_name = "Software Engineering";
								$sub_link = "http://www.nptel.ac.in/courses/106105087/";
								break;
						case 31:
								$sub_name = "Theory of Automata and Formal Languages";
								$sub_link = "http://www.nptel.ac.in/courses/106103070/";
								break;
						case 32:
								$sub_name = "Theory of Automata, Formal Languages and Computation";
								$sub_link = "http://www.nptel.ac.in/courses/106106049/";
						
					}
				 ?>
				<div class="row">
                    <div class="col-md-12" style="margin-left:20px;">
						<h2><?php echo $sub_name; ?></h2>   
                       
                    </div>
				</div>
                 <!-- /. ROW  -->
				 
					<iframe src="<?php echo $sub_link; ?>" width="100%" height="900px"> </iframe>
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