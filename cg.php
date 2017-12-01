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
							<b class="btn btn-warning" style="font-size:20px;border-radius:8px;width:100%;">Computer Graphics </b>
						</tr>
						<hr/>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/fwzYuhduME4?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/0ZuSu44-WeE?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/myRKFWMNKO0?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/GzpaDTbXMiQ?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/CoBIpAZQYiA?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/DPcVMEBDpAY?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/VziP-jctzns?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/_eVRNdGsLWc?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/55JDox30_Fk?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/V6odJpgsHyU?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/ujT6nt_hHEc?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/0xVl2_qvj1I?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/0HeTPi82gZQ?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/E_sqVKiuCx8?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/frrBDwmkQ0E?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/_f_pHgRQPPE?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/FO5XLAMh9E0?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/TNbkX5bYrtE?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/PGfG-DPosCA?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/0plNDJj4UPY?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/662KrfbVSbg?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/kmt3l1L0Jzo?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/uDlsWxDA1TQ?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/ryKmxjqG_e0?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/LZEVG3raveE?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/c59E5b0pcyw?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/gmoC8xC4MGw?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/cro30gbbV-M?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/qhRq627zvow?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/6yE09ITmbKQ?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/WyC1oguV0M0?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/ZHSIDji5sjo?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/8I5rpAhYk4Y?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/bgHodJrPnAg?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/NJbq99IGnNg?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/7yc4Pf14FIw?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/ZixahDF62jw?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/1foc4sbmQb8?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/apxdcHwBcZY?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/lTN7bDyHrfE?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/S8qwzHUiRoE?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/SgXOXg6gYHw?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						<tr>
							<center><iframe width="640" height="360" src="//www.youtube.com/embed/hgr5O0du-sg?feature=player_embedded" frameborder="0" allowfullscreen></iframe></center>
						</tr>
						
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