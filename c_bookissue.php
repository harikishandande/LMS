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
			
			$book_status = $_POST['book_status'];
			$issue_status = $_POST['issue_status'];
			
			if(empty($book_no) && empty($id) && empty($book_status) && empty($issue_status))
			{
				$error = "";
			}
			else
			{
				$_SESSION['book_no'] = NULL;
				$sql = "UPDATE book_details SET book_status = ? WHERE book_no = ?";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $book_status);
					$query->bindValue("2", $book_no);
					$query->execute();
				$sql = "UPDATE issue_details SET issue_status = ? WHERE id = ?";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $issue_status);
					$query->bindValue("2", $id);
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

     <!-- GOOGLE FONTS-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	   
		<style>
			tr.clickableRow { cursor: pointer; }
		</style>
		
   <!-- JQUERY SCRIPTS -->
	<script type="text/javascript" >
	var book_titles = <?php echo json_encode($book_names); ?>;
	$(function()
	{
    	$("#book_name").autocomplete({
    	    source: book_titles,
    	    minLength: 1
 	   });
	});	
	</script>
	<script type="text/javascript" >

	var author_titles = <?php echo json_encode($author_names); ?>;
	$(function()
	{
    	$("#author_name").autocomplete({
    	    source: author_titles,
    	    minLength: 1
 	   });
	});	
	</script>
	<script type="text/javascript" >
	$('tr').click(function() {
    location.href = 'url';
	});
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
                                <a  class="active-menu" href="c_bookissue.php">Book Issue</a>
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
                     <h2>Book Issue</h2>   
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
							Staff No
						</th>
						<th>
							Staff No Status
						</th>
						<th>
							Issue Date
						</th>
						<th>
							Issue Status
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
						$issuewait = new Article;
						$issuewaiting = $issuewait -> fetch_issue_waiting();
						foreach($issuewaiting as $issuewait)
						{
							$book_no = $issuewait['book_no'];
							$libno = new Article;
							$libnos = $libno->fetch_book_lib_no($book_no);
							$book_lib_no = $libnos['book_lib_no'];
							$_SESSION['book_no'] = $book_no;
							$staff_no = $issuewait['staff_no'];
							$id = $issuewait['id'];
							$issue_date = $issuewait['issue_date'];
							$issue_status = $issuewait['issue_status'];
							$bookstatus = new Article;
							$bookstatuses = $bookstatus->fetch_book_status($book_no);
							$book_status =  $bookstatuses['book_status'];
							$staffstatus = new Article;
							$staffstatuses = $staffstatus->fetch_staff_state($staff_no);
							$staff_status =  $staffstatuses['staff_status'];
				?>
						<tr>
							<form role="form" action="c_bookissue.php?id=<?php echo $id;?>" method="post">
								<td>
									<button type="submit" class="btn btn-success btn-sm" name="update" id="update">
										<i class="glyphicon glyphicon-update"></i> Update
									</button>
								</td>
								<td>
									<?php echo $book_no;?><br/><?php echo "[ ".$book_lib_no." ]";?>
								</td>
								<td><center>	<span style="color:orange;"><b>2 - <?php echo "Need confirmation"; ?></b></span>	<br/>		<span style="color:green;"><b>0 - <?php echo "To Issue"; ?></b></span><br/>		<span style="color:red;"><b>1 - <?php echo "No issue"; ?></b></span></center>
									<input type="text" class="form-control" name="book_status" value="<?php echo $book_status;?>" />
								</td>
								<td>
									<?php echo $staff_no;?>
								</td>
								<td>
								<?php	if($staff_status == 1){
								?>			<span style="color:green;"><b><?php echo "Active"; ?></b></span>
								<?php	}else{
								?>			<span style="color:red;"><b><?php echo "Inactive"; }?></b></span>
								</td>
								<td>
									<?php echo $issue_date;?>
								</td>
								<td><center>	<span style="color:orange;"><b>2 - <?php echo "Need confirmation"; ?></b></span>	<br/>		<span style="color:green;"><b>0 - <?php echo "To Issue"; ?></b></span><br/>		<span style="color:red;"><b>2 - <?php echo "Leave calm to delete"; ?></b></span></center>
								
									<input type="text" class="form-control" name="issue_status" value="<?php echo $issue_status;?>" />
								</td>
							</form>
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
