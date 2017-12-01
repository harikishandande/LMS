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
	
			$(document).ready(function()
			{
				$("#book_submit").click(function()
				{
					var data=$("#book_name").val();
					var dataString = 'book_name='+ data;
					$.ajax
					({
							type: "POST",
							url: "ajax_city.php",
							data: dataString,
							cache: false,
							complete: function()
							{
								alert("Book check successful");
							} 
					});	
				});
				
				$("#author_submit").click(function()
				{
					var data=$("#author_name").val();
					var dataString = 'author_name='+ data;
					$.ajax
					({
							type: "POST",
							url: "ajax_city.php",
							data: dataString,
							cache: false,
							complete: function()
							{
								alert("Author check successful");
							} 
					});	
				});
				
				$("#edition_submit").click(function()
				{
					var data1=$("#book_name").val();
					var data2=$("#author_name").val();
					var data3=$("#book_edition").val();
					var dataString = 'book_name='+ data1 + '&author_name='+ data2 + '&book_edition='+ data3;
					$.ajax
					({
							type: "POST",
							url: "ajax_city.php",
							data: dataString,
							cache: false,
							success: function()
							{
								alert("edition check successful");
							} 
					});	
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
                        <a href="#"><i class="glyphicon glyphicon-bookmark"></i> Book CLearance<span class="fa arrow"></span></a>
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
                        <a  class="active-menu" href="c_viewbooks.php"><i class="glyphicon glyphicon-book "></i>View Books</a>
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
                     <h2>View Books</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<table class="table table-bordered " width="80%">
				<thead>
					<tr>
						<th width="10px">
							
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
							Book No Of Copies
						</th>
						<th>
							Book No's
						</th>
						<th>
							Book Cover Image
						</th>
					</tr>
				</thead>
				<?php
				if(isset($_GET['book_no']))
				{
					$d_book_no = $_GET['book_no'];
					$sql = "DELETE FROM book_details WHERE book_no = ? ";
					$query = $pdo->prepare($sql);
					$query->bindValue("1", $d_book_no);
					$result = $query->execute();
				}
				$editiondetail = new Article;
				$editiondetails = $editiondetail->fetch_edition_details();

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
					$bookdetails = $bookdetail->fetch_book_details($book_id,$author_id,$book_edition);
				?>
				<tbody>
				<?php
					if(isset($_GET['book_id']))
					{
						if(($book_id == $_GET['book_id']) && ($author_id == $_GET['author_id']) && ($book_edition == $_GET['book_edition']))
						{
							?>	<tr> 
									<td>
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
										<?php 	foreach($bookdetails as $bookdetail)
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
										?>				<div style="color:blue;text-align:center;margin-top:10px;"><a style="color:red;" href="c_viewbooks.php?book_id=<?php echo $book_id;?>&author_id=<?php echo $author_id;?>&book_edition=<?php echo $book_edition;?>&book_no=<?php echo $bookdetail['book_no'];?>"><i class="glyphicon glyphicon-trash"></i></a> <?php echo $bookdetail['book_no']; ?></div>
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
									
							<?php 	$b_cover = $book_id.".".$author_id.".".$book_edition;?>
								
									<td>
										<?php $_SESSION['viewbooks'] = 1;?>
										<a href="upload/upload.php?b_cover=<?php echo $b_cover; ?>">
										<center><h5 style="">Change Book Cover</h5></center>
							<?php 	
										$bookcover = new Article;
										$bookcovers = $bookcover->fetch_bookcover( $b_cover );
										$edition_image = $bookcovers['edition_image'];
							?>			<img class="" style="padding:10px;" width="200px" src="book_covers/<?php echo $edition_image; ?>"/>
							<?php		$_SESSION['b_cover'] = NULL;	?>
					</a>
									</td>
								</tr>
				<?php	}
					}
					else
					{
				?>		<tr> 
							<td>
								<a class="btn btn-primary btn-xs" name="edit" id="edit" href="c_viewbooks.php?book_id=<?php echo $book_id;?>&author_id=<?php echo $author_id;?>&book_edition=<?php echo $book_edition;?>">
									<i class="glyphicon glyphicon-edit"></i> Edit
								</a>							
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
								<?php 	foreach($bookdetails as $bookdetail)
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
							<td>
								<img class="course-thumb " style="padding:10px;" width="200px" src="book_covers/<?php echo $edition_image; ?>"/>
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