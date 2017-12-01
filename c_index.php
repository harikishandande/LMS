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
                        <a  class="active-menu" href="c_index.php"><i class="glyphicon glyphicon-stats "></i>Statistics</a>
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
                     <h2>Statistics</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<?php
			
				$editiondetail = new Article;
				$editiondetails = $editiondetail->fetch_edition_details();
				
				$available_books = 0;
				
				foreach($editiondetails as $editiondetail)
				{	
					
					$book_id = $editiondetail['book_id'];
					$author_id = $editiondetail['author_id'];
					$book_edition = $editiondetail['book_edition'];
					$edition_image = $editiondetail['edition_image'];
					$bookname = new Article;
					$booknames = $bookname->fetch_bookname( $book_id );
					$book_name = $booknames['book_name'];
					$authorname = new Article;
					$authornames = $authorname->fetch_authorname( $author_id );
					$author_name = $authornames['author_name'];
					$bookdetail = new Article;
					$bookdetails = $bookdetail->fetch_remain_book_details($book_id,$author_id,$book_edition);
				
					foreach($bookdetails as $bookdetail)
					{	
						if($bookdetail['book_status'] == 1)
						{	
							$available_books++;
						}	
					}	
				}	
			?>
			<dl class="dl-horizontal">
				<dt style="width:300px;">
					Total No Of Books&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;
				</dt>
				<dd style="width:300px;">
					<?php
						$avl = new Article;
						$available = $avl -> fetch_allbook_details();
						$total_books = 0;
						foreach($available as $avl)
						{
							$total_books++;
						}
						echo $total_books . " are total books.";
					?>
				</dd>
				<dt style="width:300px;">
					Available Books&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;
				</dt>
				<dd style="width:300px;">
					<?php echo $available_books . " Book available."; ?>
				</dd>
				<dt style="width:300px;">
					Total No Of Staff&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;
				</dt>
				<dd style="width:300px;">
					<?php
						$avls = new Article;
						$availablestaff = $avls -> fetch_staff_names();
						$total_staff = 0;
						foreach($availablestaff as $avls)
						{
							$total_staff++;
						}
						echo $total_staff . " Members.";
					?>
				</dd>
				</dl>
			<table class="table table-bordered ">
				<thead>
					<tr>
						
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
							Book Lib No
						</th>
						<th width="10%">
							Book No's
						</th>
					</tr>
				</thead>
				<?php
			
				$editiondetail = new Article;
				$editiondetails = $editiondetail->fetch_edition_details();
				
				$available_books = 0;
				
				foreach($editiondetails as $editiondetail)
				{	
					
					$book_id = $editiondetail['book_id'];
					$author_id = $editiondetail['author_id'];
					$book_edition = $editiondetail['book_edition'];
					$edition_image = $editiondetail['edition_image'];
					$bookname = new Article;
					$booknames = $bookname->fetch_bookname( $book_id );
					$book_name = $booknames['book_name'];
					$authorname = new Article;
					$authornames = $authorname->fetch_authorname( $author_id );
					$author_name = $authornames['author_name'];
					$bookdetail = new Article;
					$bookdetails = $bookdetail->fetch_remain_book_details($book_id,$author_id,$book_edition);
				?>
				<tbody>
					<tr> 
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
								<?php	
									foreach($bookdetails as $bookdetail)
									{	
							?>			<div style="text-align:center;margin-top:10px;"><?php echo $bookdetail['book_lib_no']; ?></div>
							<?php	}	
							?>
							</td>
							<td>
								<?php 	foreach($bookdetails as $bookdetail)
										{	
											if($bookdetail['book_status'] == 1)
											{	
												$available_books++;
								?>				<div style="color:blue;text-align:center;margin-top:10px;"><?php echo $bookdetail['book_no']; ?></div>
								<?php		}	
											else if($bookdetail['book_status'] == 2)
											{	
								?>				<div style="color:orange;text-align:center;margin-top:10px;"><?php echo $bookdetail['book_no']; ?></div>
								<?php		}	
											else
											{
								?>				<div style="color:red;text-align:center;margin-top:10px;"><?php echo $bookdetail['book_no']; ?></div>
								<?php		}	
										}	
								?>
							</td>
						</tr>
					
			<?php 	 	
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