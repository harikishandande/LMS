<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['staff']))
	{	
		if(isset($_POST['update_profile']))
		{
			$username = $_SESSION['username'];
			$staff_name = $_POST['staff_name'];
			$password = $_POST['password'];
			if(empty($password) || empty($staff_name))
			{
				$error = "";
			}
			else
			{
				$sql = "UPDATE staff_names SET staff_name = ?, password = ? WHERE staff_no = ?";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $staff_name);
					$query->bindValue("2", $password);
					$query->bindValue("3", $username);
					$query->execute();
				$success = "";
			}
		}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $_SESSION['username']; ?> - Library management System</title>
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
                <a class="navbar-brand" href="index.html">Vidyanikethan</a> 
            </div>
			<div style=" font-size: 25px;color: #f00;padding: 10px 50px 5px 15px;float: left;">Library Management System</div>
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
                        <a href="s_index.php"><i class="glyphicon glyphicon-search "></i>Issued Details</a>
                    </li>
                    <li>
                        <a class="active-menu" href="s_profile.php"><i class="glyphicon glyphicon-folder-open "></i>staff Profile</a>
                    </li>
                </ul>
            </div>
        </nav>    
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12" style="margin-left:20px;">
                     <h2>staff Profile</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<?php
					$staff_no = $_SESSION['username'];
					$staffname = new Article;
					$staffnames = $staffname->fetch_staff_name($staff_no);
				?>
				<div class="col-md-12">
					<div class="col-md-3"></div>
					<div class="col-md-6 center">
						<form role="form" action="s_profile.php" method="post">
							<div class="form-group">
								<label></label>
								<?php
										if($staffnames['staff_status'] == 0)
										{
								?>			<div class="form-group has-warning has-feedback">
												<label class="control-label" for="">staff Status</label>
												<input type="text" class="form-control" name="staff_status" value="<?php echo " Inactive [ Contact administrator ]";?>" disabled/>
												<span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
											</div>
								<?php	}
										else if($staffnames['staff_status'] == 1)
										{
								?>			<div class="form-group has-success has-feedback">
												<label class="control-label" for="">staff Status</label>
											<input type="text" class="form-control " name="staff_status" value="<?php echo " Active";?>" disabled/>
												<span class="glyphicon glyphicon-ok form-control-feedback"></span>
											</div>
								<?php	}
								?>
							</div>
							<div class="form-group">
								<label>Username</label>
								<input type="text" class="form-control" name="username" value="<?php echo $staffnames['staff_no'];?>" disabled/>
							</div>
							<div class="form-group">
								<label>Staff Name</label>
								<input type="text" class="form-control" name="staff_name" value="<?php echo $staffnames['staff_name'];?>" />
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="text" class="form-control" name="password" value="<?php echo $staffnames['password'];?>" />
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-info" name="update_profile" >Update Profile</button>
							</div>
						</form>
					</div>
					<div class="col-md-3"></div>
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
