<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
	if(isset($_SESSION['controller']))
	{	
		if(isset($_POST['update']))
		{
			$book_no = $_SESSION['book_no'];
			$id = $_GET['id'];
			$staff_no = $_SESSION['staff_no'];
			$book_status = $_POST['book_status'];
			$current_issue_status = $_POST['issue_status'];
			
			if(isset($_POST['fine'])){	$fine = $_POST['fine'];	}
			
			if(empty($staff_no) && empty($book_no) && empty($id) && empty($book_status) && empty($current_issue_status))
			{
				$error = "";
			}
			else
			{	
				$staffvalidate = new Article;
				$staffvalidation = $staffvalidate -> fetch_issue_details($staff_no);
				$count = 0;
				foreach($staffvalidation as $staffvalidate)
				{
					$issue_status = $staffvalidate['issue_status']; 
					if($issue_status == 0)
					{
						$count++;
					}
				}
				if($count < 2)
				{
						$sql = "UPDATE staff_names SET staff_status = ? WHERE staff_no = ? ";
							$query = $pdo->prepare($sql);
							$query->bindValue("1", 1);
							$query->bindValue("2", $staff_no);
							$result = $query->execute();
				}
				
				$_SESSION['book_no'] = NULL;
				$sql = "UPDATE issue_details SET issue_status = ? , received_date = ? WHERE id = ?";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $current_issue_status);
					$query->bindValue("2", date('Y-m-d H:i:s'));
					$query->bindValue("3", $id);
					$query->execute();
				
				if(isset($_POST['fine']))
				{
					$sql = "UPDATE issue_details SET fine = ? WHERE id = ?";
						$query = $pdo->prepare($sql);
						$query->bindValue("1", $fine);
						$query->bindValue("2", $id);
						$query->execute();
				}
				else
				{
					$fine = 0;
					
					$sql = "UPDATE issue_details SET fine = ? WHERE id = ?";
						$query = $pdo->prepare($sql);
						$query->bindValue("1", $fine);
						$query->bindValue("2", $id);
						$query->execute();
				}
				$sql = "UPDATE book_details SET book_status = ? WHERE book_no = ?";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $book_status);
					$query->bindValue("2", $book_no);
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

     <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<style>
	 .dl-horizontal dt {
    float: left;
    width: 50px;
    overflow: hidden;
    clear: left;
    text-align: right;
    text-overflow: ellipsis;
    white-space: nowrap;
	font-size:13px;
  }
  .dl-horizontal dd {
    margin-left: 90px;
	font-size:12px;
  }
  </style>
	
   <!-- JQUERY SCRIPTS -->
	<script type="text/javascript" >
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
	</script>
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
                        <a  class="active-menu" href="#"><i class="glyphicon glyphicon-bookmark"></i> Book CLearance<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="c_bookissue.php">Book Issue</a>
                            </li>
                            <li>
                                <a  class="active-menu" href="c_bookreturn.php">Book Return</a>
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
                        <a href="c_viewstaff.php"><i class="glyphicon glyphicon-user "></i>View Staff</a>
                    </li>
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12" style="margin-left:20px;" >
                     <h2>Book Return</h2>
					   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
		
                 <!-- /. ROW  -->
                <hr />
				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>
						</th>
						<th>
							Book No <br/>[Book Lib No]
						</th>
						<th>
							Book No Status
						</th>
						<th>
							Roll No
						</th>
						<th>
							Roll No Status
						</th>
						<th>
							Fine
						</th>
						<th>
							Issue Status
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
						$issuewait = new Article;
						$issuewaiting = $issuewait -> fetch_issue_return();
						foreach($issuewaiting as $issuewait)
						{
							$book_no = $issuewait['book_no'];
							$libno = new Article;
							$libnos = $libno->fetch_book_lib_no($book_no);
							$book_lib_no = $libnos['book_lib_no'];
							$_SESSION['book_no'] = $book_no;
							$staff_no = $issuewait['staff_no'];
							$_SESSION['staff_no'] = $staff_no;
							$id = $issuewait['id'];
							$issue_date = $issuewait['issue_date'];
							$return_date = $issuewait['return_date'];
							$issue_status = $issuewait['issue_status'];
							$bookstatus = new Article;
							$bookstatuses = $bookstatus->fetch_book_status($book_no);
							$book_status =  $bookstatuses['book_status'];
							$staffstatus = new Article;
							$staffstatuses = $staffstatus->fetch_staff_state($staff_no);
							$staff_status =  $staffstatuses['staff_status'];
				?>
						<tr>
							<form role="form" action="c_bookreturn.php?id=<?php echo $id;?>" method="post">
								<td>
									<button type="submit" class="btn btn-success btn-sm" name="update" id="update">
									 Update
									</button>
								</td>
								<td>
									<?php echo $book_no;?><br/><?php echo "[ ".$book_lib_no." ]";?>
								</td>
								<td><center>	<span style="color:green;"><b>1 - <?php echo "To Return"; ?></b></span></center>
								
									<input type="text" class="form-control" name="book_status" value="<?php echo $book_status;?>" />
								</td>
								<td>
									<?php echo $staff_no;?>
								</td>
								<td>
									<?php echo $staff_status;?>
								</td>
								<?php 
									
									$fine = 0;
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
											$fine = $days *0.5;
											$status = 2;
										}
										else if($days > 10)
										{
											$fine = $days *1;
											$status = 3;
										}
										else
										{
											$fine = 0;
										}
									?>
								<td width="20%">
							<?php	if($fine > 0)
									{	$random = rand(0,10000);
							?>			<div class="input-group" style="margin-top:20px;">
											<input type="text" class="form-control" name="fine" value="<?php echo $fine;?>" />
											<span class="input-group-addon">Rs</span>
										</div>
										<center><a class="btn btn-info btn-xs" style="margin-top:5px;" onclick="printDiv('printableArea-<?php echo $random; ?>')" >Generate Bill</a></center>

										<div class="modal fade" id="modal-container-<?php echo $random; ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog" >
											<div class="modal-content" id="printableArea-<?php echo $random; ?>">
												<div class="modal-header" >
													Sree Vidyanikethan Engineering College - Bill generation<strong style="margin-left:150px;"><?php echo date('Y-m-d H:i:s');?></strong>
												</div>
												<div class="modal-body">
											<?php	$array = explode('.', $book_no);
													$book_id = $array[0];
													$bookname = new Article;
													$booknames = $bookname->fetch_bookname( $book_id );
													$book_name = $booknames['book_name'];
													$author_id = $array[1];
													$authorname = new Article;
													$authornames = $authorname->fetch_authorname( $author_id );
													$author_name = $authornames['author_name'];
													$book_edition = $array[2];
													$edition_image = $book_id.".".$author_id.".".$book_edition.".jpg";
											?>		<div class="row" >
													<div class="col-md-4">
														<center><b><?php echo "Book No : ".$book_no; ?></b></br></br>
															<img class="course-thumb img-thumbnail" src="book_covers/<?php echo $edition_image; ?>"/></center>
														<br/>
													</div>
													<div class="col-md-8">
														<dl class="dl-horizontal">
															<dt>
																Staff No
															</dt>
															<dd>
																<?php echo $staff_no; ?>
															</dd>
															<dt>
																Title
															</dt>
															<dd>
																<?php echo $book_name; ?>
															</dd>
															<dt>
																Author
															</dt>
															<dd>
																<?php echo $author_name; ?>
															</dd>
															<dt>
																Edition
															</dt>
															<dd>
																<?php echo $book_edition;?>
															</dd>
															<dt>
																Fine
															</dt>
															<dd>
																<?php echo "Rs " . $fine . "/-";?>
															</dd>
														</dl>
														</br></br>
														<strong style="text-align:left;margin-left:30px;">Status</strong>
														<strong style="margin-left:370px;">Signature Of Controller</strong>
													</div>
													</div>
												</div>
										</div>
										</div>
									</div>
							<?php	}
									else
									{
										echo $fine . " Rs"; 
									}
							?>
								</td>
								<td><center>	<span style="color:green;"><b>1 - <?php echo "To Return"; ?></b></span></center>
									<input type="text" class="form-control" name="issue_status" value="<?php echo $issue_status;?>" />
								</td>
							</form>
							<?php	if($fine > 0)
							{
							?>	
					<?php	}
							else
							{
					?>			<td>
									<center>---</center>
								</td>
					<?php	}?>
								
							</tr>
				<?php	}
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
	
    <script src="assets/js/jquery.js"></script>
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