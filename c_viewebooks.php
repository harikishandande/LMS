<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['controller']))
	{	
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
                        <a href="c_addebooks.php"><i class="glyphicon glyphicon-plus-sign "></i>Add e Books</a>
                    </li>
					<li>
                        <a class="active-menu" href="c_viewebooks.php"><i class="glyphicon glyphicon-book "></i>View e Books</a>
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
				
						<br/>
						<table class="table table-bordered ">
							<thead>
								<tr>
									<th style="background-color:orange;">
										E-BOOKS
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
									$book = new Article;
									$ebook = $book->fetch_ebooks();
									foreach($ebook as $book)
									{
							?>		
									<tr>
										<td>
											<a href="c_viewebooks.php?efile=<?php echo $book['efile'];?>"><?php echo $book['ename']; ?></a>
										</td>
									</tr>
							<?php	}
									?>
							</tbody>
						</table>
				
							<?php
								if(isset($_GET['efile']))
								{
						?>			<label style="margin:10px 10px 10px 0px;">Loaded E-Book</label><a href="c_viewebooks.php" style="color:white;float:right;" class="btn btn-info"><b>x</b></a>
									<iframe src="UPLOAD_DIR/<?php echo $_GET['efile'];?>" style="width:100%; height:800px;" frameborder="0"></iframe>
						<?php	}	?>
		
						<br/><br/><br/>
						<table class="table table-bordered ">
							<thead>
								<tr>
									<th style="background-color:orange;">
										JOURNALS
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
									$journal = new Article;
									$journals = $journal->fetch_journals();
									foreach($journals as $journal)
									{
							?>		
									<tr>
										<td>
											<a href="c_viewebooks.php?jfile=<?php echo $journal['jfile'];?>"><?php echo $journal['jname']; ?></a>
										</td>
									</tr>
							<?php	}
									?>
							</tbody>
						</table>
				
							<?php
								if(isset($_GET['jfile']))
								{
						?>			<label style="margin:10px 10px 10px 0px;">Loaded Journal</label><a href="c_viewebooks.php" style="color:white;float:right;" class="btn btn-info"><b>x</b></a>
									<iframe src="UPLOAD_JOR/<?php echo $_GET['jfile'];?>" style="width:100%; height:800px;" frameborder="0"></iframe>
						<?php	}	?>
						<br/><br/><br/>
						<table class="table table-bordered ">
							<thead>
								<tr>
									<th style="background-color:orange;">
										MAGAZINES
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
									$magazine = new Article;
									$magazines = $magazine->fetch_magazines();
									foreach($magazines as $magazine)
									{
							?>		
									<tr>
										<td>
											<a href="c_viewebooks.php?mfile=<?php echo $magazine['mfile'];?>"><?php echo $magazine['mname']; ?></a>
										</td>
									</tr>
							<?php	}
									?>
							</tbody>
						</table>
				
							<?php
								if(isset($_GET['mfile']))
								{
						?>			<label style="margin:10px 10px 10px 0px;">Loaded Magazine</label><a href="c_viewebooks.php" style="color:white;float:right;" class="btn btn-info"><b>x</b></a>
									<iframe src="UPLOAD_MAG/<?php echo $_GET['mfile'];?>" style="width:100%; height:800px;" frameborder="0"></iframe>
						<?php	}	?>
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