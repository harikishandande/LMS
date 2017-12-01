<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['controller']))
	{	
		if(isset($_POST['update']))
		{
			$id = $_SESSION['id'];
			$duration = $_POST['duration'];
			$staff_no = $_POST['staff_no'];
			$password = $_POST['password'];
			$staff_status = $_POST['staff_status'];
			
			
			
			if(empty($id) && empty($duration) && empty($staff_no) && empty($password) && empty($staff_status))
			{
				$error = "";
			}
			else
			{
				$_SESSION['id'] = NULL;
				$sql = "UPDATE staff_names SET duration = ?, staff_no = ?, password = ?, staff_status = ? WHERE id = ?";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $duration);
					$query->bindValue("2", $staff_no);
					$query->bindValue("3", $password);
					$query->bindValue("4", $staff_status);
					$query->bindValue("5", $id);
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
                        <a href="c_viewebooks.php"><i class="glyphicon glyphicon-book "></i>View e Books</a>
                    </li>
					<li>
                        <a href="c_addstaff.php"><i class="glyphicon glyphicon-plus-sign "></i>Add Staff</a>
                    </li>
					<li>
                        <a class="active-menu" href="c_viewstaff.php"><i class="glyphicon glyphicon-user "></i>View Staff</a>
                    </li>
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12" style="margin-left:20px;">
                     <h2>View Staff</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<table class="table table-bordered ">
				<thead>
					<tr>
						<th>
						</th>
						<th>
							Duration
						</th>
						<th>
							Staff No
						</th>
						<th>
							Staff Name
						</th>
						<th>
							Password
						</th>
						<th>
							Staff Status
						</th>
						<th>
							No Of Books Taken
						</th>
						<th width="20%">
							Book No's
						</th>
						<th>
							Total Fine
						</th>
						
					</tr>
				</thead>
				<?php
		/*		if(isset($_GET['book_no']))
				{
					$d_book_no = $_GET['book_no'];
					$sql = "DELETE FROM book_details WHERE book_no = ? ";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $d_book_no);
					$result = $query->execute();
				}
		*/
				$staffname = new Article;
				$staffnames = $staffname->fetch_staff_names();

				foreach($staffnames as $staffname)
				{	
					$student_id = $staffname['id'];
					$duration = $staffname['duration'];
					$staff_no = $staffname['staff_no'];
					$staff_name = $staffname['staff_name'];
					$password = $staffname['password'];
					$staff_status = $staffname['staff_status'];
				?>
				<tbody>
				<?php
					if(isset($_GET['staff_no']))
					{
						if(($staff_no == $_GET['staff_no']))
						{
								$staffname = new Article;
								$staffnames = $staffname->fetch_staff_name($staff_no);
								$id = $staffnames['id'];
								$_SESSION['id'] = $id;
				?>				<tr>
								<form role="form" action="c_viewstaff.php" method="post">
									<td>
										<button type="submit" class="btn btn-success btn-sm" name="update" id="update">
											<i class="glyphicon glyphicon-update"></i> Update
										</button>
									</td>
									<td>
										<input type="text" class="form-control" name="duration" value="<?php echo $duration; ?>" />
									</td>
									<td>
										<input type="text" class="form-control" name="staff_no" value="<?php echo $staff_no; ?>" />
									</td>
									<td>
										<input type="text" class="form-control" name="staff_no" value="<?php echo $staff_name; ?>" disabled/>
									</td>
									<td>
										<input type="text" class="form-control" name="password" value="<?php echo $password; ?>" />
									</td>
									<td>
									<center>	<span style="color:green;"><b>1 - <?php echo "Active"; ?></b></span>	<br/>		<span style="color:red;"><b>0 - <?php echo "Inactive"; ?></b></span></center>
										<input type="text" class="form-control" name="staff_status" value="<?php echo $staff_status;?>" />
									</td>
								</form>
						<?php		$staff_no_detail = new Article;
									$staff_no_details = $staff_no_detail->fetch_issue_details( $staff_no );
									
									?>
									<td>
										<?php echo count($staff_no_details) . " Books";?>
									</td>	
									<td>
						<?php
									$total_fine=0;
									foreach($staff_no_details as $staff_no_detail)
									{	
										$return_date = $staff_no_detail['return_date'];
										$issue_status = $staff_no_detail['issue_status'];
										$current_date = date('y-m-d');
										
										$diff = strtotime($current_date) - strtotime($return_date);
										$days = floor($diff / (24 * 60 * 60 ));
										
										
										if($days > 0 && $days <= 10)
										{
											$status = 2;
										}
										else if($days > 10)
										{
											$status = 3;
										}
										else
										{
											$status = 0;
										}
										
										if($issue_status == 0)
										{
											if($status == 2)
											{
									?>			<span style="color:orange;"><?php echo $staff_no_detail['book_no']; ?></span>
									<?php	}
											else if($status == 3)
											{
									?>			<span style="color:red;"><?php echo $staff_no_detail['book_no']; ?></span>
									<?php	}
											else
											{
									?>			<span style="color:;"><?php echo $staff_no_detail['book_no']; ?></span>
									<?php	}
										}
										else
										{
									?>		<span style="color:green;"><?php echo $staff_no_detail['book_no']; ?></span>
						<?php			}
										echo " - ";
										$total_fine = $total_fine + $staff_no_detail['fine'];
										
									}
						?>			</td>			
									<td>
										<?php echo $total_fine . " Rs"; ?>
									</td>
								</tr>
				<?php	}
					}
					else
					{
				?>
						<tr> 
							<td>
								<a class="btn btn-primary btn-xs" name="edit" id="edit" href="c_viewstaff.php?staff_no=<?php echo $staff_no;?>">
									<i class="glyphicon glyphicon-edit"></i> Edit
								</a>
							</td>
							<td>
								<?php echo $duration; ?>
							</td>
							<td>
								<?php echo $staff_no; ?>
							</td>
							<td>
								<?php echo $staff_name; ?>
							</td>
							<td>
								<?php echo $password; ?>
							</td>
							<td>
								<?php	if($staff_status == 1){
								?>			<span style="color:green;"><b><?php echo "Active"; ?></b></span>
								<?php	}else{
								?>			<span style="color:red;"><b><?php echo "Inactive"; }?></b></span>
							</td>
				
				<?php		$staff_no_detail = new Article;
							$staff_no_details = $staff_no_detail->fetch_issue_details( $staff_no );
				?>
							<td>
								<?php echo count($staff_no_details) . " Books"; ?>
							</td>
							<td>
						<?php
									$total_fine=0;
									foreach($staff_no_details as $staff_no_detail)
									{	
										$return_date = $staff_no_detail['return_date'];
										$issue_status = $staff_no_detail['issue_status'];
										$current_date = date('y-m-d');
										
										$diff = strtotime($current_date) - strtotime($return_date);
										$days = floor($diff / (24 * 60 * 60 ));
										
										
										if($days > 0 && $days <= 10)
										{
											$status = 2;
										}
										else if($days > 10)
										{
											$status = 3;
										}
										else
										{
											$status = 0;
										}
										
										if($issue_status == 0)
										{
											if($status == 2)
											{
									?>			<span style="color:orange;"><?php echo $staff_no_detail['book_no']; ?></span>
									<?php	}
											else if($status == 3)
											{
									?>			<span style="color:red;"><?php echo $staff_no_detail['book_no']; ?></span>
									<?php	}
											else
											{
									?>			<span style="color:;"><?php echo $staff_no_detail['book_no']; ?></span>
									<?php	}
										}
										else
										{
									?>		<span style="color:green;"><?php echo $staff_no_detail['book_no']; ?></span>
						<?php			}
										echo " - ";
										$total_fine = $total_fine + $staff_no_detail['fine'];
										
									}
						?>			</td>		
							<td>
								<?php echo $total_fine . " Rs"; ?>
							</td>
						</tr>
					
			<?php 	} 	
				}	
			?>
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