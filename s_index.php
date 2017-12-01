<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['staff']))
	{	
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
                        <a class="active-menu" href="s_index.php"><i class="glyphicon glyphicon-search "></i>Issued Details</a>
                    </li>
                    <li>
                        <a href="s_profile.php"><i class="glyphicon glyphicon-folder-open "></i>Staff Profile</a>
                    </li>
                </ul>
            </div>
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12" style="margin-left:20px;">
                     <h2>Issued Details</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>
							Book No
						</th>
						<th>
							Book Title
						</th>
						<th>
							Book Author
						</th>
						<th>
							Book Edition
						</th>
						<th>
							Book Issued
						</th>
						<th>
							Book returned
						</th>
						<th>
							Book received
						</th>
						<th>
							Book Fine
						</th>
						<th>
							Book Status
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$username = $_SESSION['username'];
					$issuedetail = new Article;
					$issuedetails = $issuedetail -> fetch_issue_details($username);
					$count = 0;
					$count = count($issuedetails);
					if($count == 0)
					{
				?>			<tr>
								<td colspan="9">
									<center style="color:red;"><b>No Book Issued</b></center>
								</td>
 							</tr>
				<?php	}
					foreach($issuedetails as $issuedetail)
					{
						$book_no = $issuedetail['book_no'];
						$issue_date = $issuedetail['issue_date'];
						$return_date = $issuedetail['return_date'];
						$received_date = $issuedetail['received_date'];
						$fine = $issuedetail['fine'];
						$issue_status = $issuedetail['issue_status'];
						$array = explode('.', $book_no);
						$book_id = $array[0];
						$bookname = new Article;
						$booknames = $bookname->fetch_bookname( $book_id );
						$book_name = $booknames['book_name'];
						$author_id = $array[1];
						$authorname = new Article;
						$authornames = $authorname->fetch_authorname( $author_id );
						$author_name = $authornames['author_name'];
						$book_edition = $array[2];
						
						if($issue_status == 0)
						{
				?>			<tr>
								<td>
									<?php echo $book_no; ?>
								</td>
								<td>
									<?php echo $book_name; ?>
								</td>
								<td>
									<?php echo $author_name; ?>
								</td>
								<td>
									<?php echo $book_edition . " Edition"; ?>
								</td>
								<td>
									<?php echo $issue_date; ?>
								</td>
								<td>
									<?php echo $return_date; ?>
								</td>
								<?php 
										$current_date = date('y-m-d');
										
										$diff = strtotime($current_date) - strtotime($return_date);
										$days = floor($diff / (24 * 60 * 60 ));
										
										if($days < -5)
										{
											$status = 0;
										}
										else if($days <= 0 && $days >= -5)
										{
											$status = 1;
										}
										else if($days > 0 && $days <= 10)
										{
											$fine = $days *10;
											$status = 2;
										}
										else if($days > 10)
										{
											$fine = $days *10;
											$status = 3;
										}
										else
										{
											$fine = 0;
										}
									?>
								<td>
									<?php echo "--- Not Yet ---"; ?>
								</td>
								<td>
									<?php echo $fine . " Rs"; ?>
								</td>
						<?php	if($status == 0)
								{
						?>			<td>
										<a class="btn btn-default btn-xs"> Book Allotted</a>
									</td>
						<?php 	}
								else if($status == 1)
								{
						?>			<td>
										<a class="btn btn-primary btn-xs"> Less than 5 days to return</a>
									</td>
						<?php	}
								else if($status == 2)
								{
						?>			<td>
										<a class="btn btn-warning btn-xs"> Fine Started</a>
									</td>
						<?php	}
								else
								{
						?>			<td>
										<a class="btn btn-danger btn-xs"> Fine Crossed 100 /- </a>
									</td>
						<?php	}
						?>
							</tr>
			<?php		}
						else if($issue_status == 2)
						{
			?>				<tr>
								<td>
									<?php echo $book_no; ?>
								</td>
								<td>
									<?php echo $book_name; ?>
								</td>
								<td>
									<?php echo $author_name; ?>
								</td>
								<td>
									<?php echo $book_edition . " Edition"; ?>
								</td>
								<td colspan="5">
									<center style="color:red;"><b>Under issuing process</b></center>
								</td>
							</tr>
			<?php		}
						else
						{
			?>				<tr>
								<td>
									<?php echo $book_no; ?>
								</td>
								<td>
									<?php echo $book_name; ?>
								</td>
								<td>
									<?php echo $author_name; ?>
								</td>
								<td>
									<?php echo $book_edition . " Edition"; ?>
								</td>
								<td>
									<?php echo $issue_date; ?>
								</td>
								<td>
									<?php echo $return_date; ?>
								</td>
								<td>
									<?php echo $received_date; ?>
								</td>
								<td>
									<?php echo $fine. " Rs"; ?>
								</td>
								<td>
									<button class="btn btn-success btn-xs"> Book Received</button>
								</td>
							</tr>
			<?php		}
					} 	?>
				</tbody>
			</table>
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