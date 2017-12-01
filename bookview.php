<?php
session_start();
session_destroy();
include('includes/article.php');
include('includes/connection.php');

if(isset($_GET['remind']))
{
	$day = date('y-m-d');
	$remind = $_GET['remind'];
	$array = explode('.',$remind);
	$edition_detail = $array[0] . "." . $array[1] . "." . $array[2];
	
		$check = new Article;
		$checking = $check->fetch_check_report($day, $edition_detail);
		
		if($checking == NULL)
		{	
			$count = 1;
			$sql = "INSERT INTO report_books (edition_detail, count, remind_timestamp) VALUES (?,?,?)";
				$query = $pdo->prepare($sql);
				$query->bindValue("1", $edition_detail);
				$query->bindValue("2", $count);
				$query->bindValue("3", date('Y-m-d'));
				$query->execute();
				
				header('Location: books.php');
		}
		else
		{
			$id = $checking['id'];
			$count = $checking['count'];
			$count = $count+1;
				$sql = "UPDATE report_books SET count = ? WHERE id = ? ";
				$query = $pdo->prepare($sql);
				$query->bindValue("1", $count);
				$query->bindValue("2", $id);
				$result = $query->execute();	
				
				header('Location: books.php');
		}
}

if(isset($_GET['book_id']) && isset($_GET['author_id']) && isset($_GET['book_edition']))
{
	$book_id = $_GET['book_id'];
	$author_id = $_GET['author_id'];
	$book_edition = $_GET['book_edition'];
	$onlyeditiondetail = new Article;
	$onlyeditiondetails = $onlyeditiondetail->fetch_only_edition_details($book_id, $author_id);	
	
	$edition_nos = array();
	$i=0;
	foreach($onlyeditiondetails as $onlyeditiondetail)
	{
		$edition_nos[$i] = $onlyeditiondetail['book_edition'];
		$i++;
	}
	$editiondetail = new Article;
	$editiondetails = $editiondetail->fetch_edition_details_by_all($book_id, $author_id, $book_edition);	
	$edition_image = $editiondetails['edition_image'];
	$bookname = new Article;
	$booknames = $bookname->fetch_bookname( $book_id );
	$book_name = $booknames['book_name'];
	$authorname = new Article;
	$authornames = $authorname->fetch_authorname( $author_id );
	$author_name = $authornames['author_name'];
	$bookdetail = new Article;
	$bookdetails = $bookdetail->fetch_book_details($book_id,$author_id,$book_edition);
}

if(isset($_POST['enroll']))
{
	$book_no = $_POST['book_no'];
	$staff_no = $_POST['staff_no'];
	$password = $_POST['password'];
	if(empty($book_no) && empty($staff_no) && empty($password))
	{
		$error = "All fields are required in issuing book!";
	}
	else
	{
		$bookstatus = new Article;
		$bookstatuses = $bookstatus->fetch_book_status($book_no);
		$book_status = $bookstatuses['book_status'];
		
		$staffno = new Article;
		$staffnos = $staffno->fetch_staff_status($staff_no, $password);
		$staff_status = $staffnos['staff_status'];
		if($book_status == 0 && $staff_status == 0)
		{
			$error = "Book is already issued and also check your status !";
		}
		else if($book_status == 1 && $staff_status == 0)
		{
			$error = "Check your status !";
		}
		else if($book_status == 0 && $staff_status == 1)
		{
			$error = "Book is already issued !";
		}
		else if($book_status == 2)
		{
			$error = "Book is under issuing process !";
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
				$issue_status = 2;
				$issue_date = date('y-m-d');
				$return_date = date('y-m-d', strtotime($issue_date . '+15 day'));
				$sql = "INSERT INTO issue_details (book_no,staff_no,issue_date,return_date,issue_status,issue_timestamp) VALUES (?,?,?,?,?,?)";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $book_no);
					$query->bindValue("2", $staff_no);
					$query->bindValue("3", $issue_date);
					$query->bindValue("4", $return_date);
					$query->bindValue("5", $issue_status);
					$query->bindValue("6", date('Y-m-d H:i:s'));
					$result = $query->execute();
				
				$sql = "UPDATE book_details SET book_status = ? WHERE book_no = ? ";
				$query = $pdo->prepare($sql);
				$query->bindValue("1", 2);
				$query->bindValue("2", $book_no);
				$result = $query->execute();	
				if($count == 1)
				{
					$sql = "UPDATE staff_names SET staff_status = ? WHERE staff_no = ? ";
						$query = $pdo->prepare($sql);
						$query->bindValue("1", 0);
						$query->bindValue("2", $staff_no);
						$result = $query->execute();
				}
				header('Location: index.php');
				
			}
			else
			{
				header('Location: index.php');
				$error = "You need to return books before issuing !";
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
			tr.clickableRow { cursor: pointer; }
		</style>
		
   <!-- JQUERY SCRIPTS -->
	<script type="text/javascript" >
	jQuery(document).ready(function($) 
	{
		$(".clickableRow").click(function() 
		{
			window.document.location = $(this).attr("href");
		});
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
                <a class="navbar-brand" href="index.php">Vidyanikethan</a> 
            </div>
			<div style=" font-size: 25px;color: #f00;padding: 10px 50px 5px 15px;float: left;">Library Management System</div>
            <form role="form" action="books.php" method="POST" enctype="multipart/form-data">
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
                        <a class="active-menu" href="books.php"><i class="glyphicon glyphicon-folder-open "></i>All Book Records</a>
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
                        <a href="nptel.php"><i class="glyphicon glyphicon-facetime-video "></i>NPTEL</a>
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
						<h2>Book View</h2>   
							<h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
		<?php	if(!empty($_GET['book_id']) && !empty($_GET['author_id']) && !empty($_GET['book_edition']))
				{
		?>
				<div class="row versions versions-large versions-centered">
				<ul class="row ">
					<li class="disabled">
						<a style="color:#0099cc;">Editions</a>
					</li>
				<?php
					for($i=0;$i<sizeof($edition_nos);$i++)
					{
						if($edition_nos[$i] == $book_edition)
						{
				?>			<li class="active">
								<a href="#"><?php echo $edition_nos[$i];?></a>
							</li>
				<?php	}
						else
						{
				?>			<li>
								<a href="bookview.php?book_id=<?php echo $book_id;?>&author_id=<?php echo $author_id;?>&book_edition=<?php echo $edition_nos[$i];?>"><?php echo $edition_nos[$i];?></a>
							</li>
				<?php	}
					}
				?>
				</ul>
				<div class="row" style="margin-top:20px;">
					<div class="col-md-1"></div>
					<div class="col-md-3">
						<h5>Book Cover</h5>
						<img class="course-thumb img-thumbnail" src="book_covers/<?php echo $edition_image; ?>"/>
					</div>
					<div class="col-md-7">
					<h5>Book Details</h5>
					<dl class="dl-horizontal">
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
							No of Copies
						</dt>
						<dd>
							<?php echo count($bookdetails) . " Copies";?>
						</dd>
						<dt>
							Status
						</dt>
						<dd>
							<?php 	$count = 0;$i = 0;
									foreach($bookdetails as $bookdetail)
									{	
										if($bookdetail['book_status'] == 1)
										{	
											$count++;
										}
										else
										{
											$book_no = $bookdetail['book_no'];
											$issuedetail = new Article;
											$issuedetails = $issuedetail->fetch_issued_returndate($book_no);
											$return_dates[$i] = $issuedetails['return_date'];
										}										$i++;
									}	
									if($count == 0)
									{
										echo "Not Available";
									}
									else
									{
										echo $count . " Books Available";
									}
							?>
						</dd>
						<dt>
							Availablity
						</dt>
						<dd>
							<?php	if($count == 0)
									{
										$current_date = date('y-m-d');
										$return_date = min($return_dates);
										$diff = strtotime($return_date) - strtotime($current_date);
										$days = floor($diff / (24 * 60 * 60 ));
										if($days > 0)
											echo "In " . $days ." Days";
										else	
											echo abs($days) . "Days Lagging";
									}
									else
									{
										echo "---";
									}
							?>
						</dd>
					</dl>
					<div class="col-md-12 column">
							 <a id="modal-964786" href="#modal-container-964786" role="button" class="btn btn-info btn-large col-md-6" data-toggle="modal" style="margin-left:50px;">Add to MyStore</a>
							
							<div class="modal fade" id="modal-container-964786" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> x </button>
											<h4 class="modal-title" id="myModalLabel">
												Use your credentials
											</h4>
										</div>
										<div class="modal-body">
							<?php 	$rem = count($bookdetails);
									$start = 0;
									foreach($bookdetails as $bookdetail)
									{	
										if($bookdetail['book_status'] == 1)
										{	
							?>				<?php echo " - " . $bookdetail['book_lib_no'] . "<span style='color:blue;text-align:center;margin-top:10px;'> [ " . $bookdetail['book_no'] ." ] - "; ?></span>
							<?php		}	
										else if($bookdetail['book_status'] == 2)
										{	
							?>				<?php echo " - " . $bookdetail['book_lib_no'] . "<span style='color:orange;text-align:center;margin-top:10px;'> [ " . $bookdetail['book_no'] ." ] - "; ?></span>
							<?php		}	
										else
										{	$start++;$temp = $bookdetail['book_no'];
							?>				<?php echo " - " . $bookdetail['book_lib_no'] . "<span style='color:red;text-align:center;margin-top:10px;'> [ " . $bookdetail['book_no'] ." ] - "; ?></span>
							<?php		}	
									}	
									
									if($rem == $start)
									{
							?>			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="bookview.php?remind=<?php echo $temp; ?>" class="btn btn-warning span5">Remind Us</a>
						<?php		}
							?>
							<hr/>
							<form class="form-horizontal" action="bookview.php" method="POST" enctype="multipart/form-data">
									<div class="form-group">
										<label for="">Book No</label>
										<input type="text" id="book_no" class="form-control book_no" name="book_no" placeholder="Book No" />
									</div>
									<div class="form-group">
										<label for="inputRollnumber">Staff Number</label>
										<input type="text" style="text-transform:uppercase;" id="staff_no" class="form-control staff_no" name="staff_no" placeholder="Staff No"/>
									</div>
									<div class="form-group">
										<label for="inputPassword">Password</label>
										<input type="password" id="password" class="form-control password" name="password" placeholder="Password"/>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-success span5" name="enroll">Confirm</button>
									</div>
								</form>
										</div>
										<div class="modal-footer">
										</div>
									</div>
									
								</div>
								
							</div>
							
						</div>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
		<?php	}
				else
				{
		?>
					<div class="col-md-12">
					<div class="col-md-3"></div>
					<div class="col-md-6 center">
						<?php 
					if(isset($error))
					{ ?>
						<h4 style ="color:#ff0000;text-align:center"><?php echo $error; ?> </h4>
			  <?php } ?>
			  <?php 
					if(isset($success))
					{ ?>
						<h4 style ="color:green;text-align:center"><?php echo $success; ?> </h4>
			  <?php } ?>
					</div>
					<div class="col-md-3"></div>
				</div>
		<?php
				}	
		?>
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