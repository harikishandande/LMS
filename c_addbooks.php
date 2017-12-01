<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
if(isset($_SESSION['controller']))
{	
		$booktitle = new Article;
		$booktitles = $booktitle->fetch_booknames();
		$book_names = array();
		$i=0;
		foreach($booktitles as $booktitle)
		{
			$book_names[$i] = $booktitle['book_name'];
			$i++;
		}
		$authorname = new Article;
		$authornames = $authorname->fetch_authornames();
		$author_names = array();
		$i=0;
		foreach($authornames as $authorname)
		{
			$author_names[$i] = $authorname['author_name'];
			$i++;
		}
	if(isset($_POST['submit']))
	{	
		$_SESSION['book_name'] = NULL;
		$_SESSION['author_name'] = NULL;
		$_SESSION['book_edition'] = NULL;
		$book_name = $_POST['book_name'];
		$author_name = $_POST['author_name'];
		$book_edition = $_POST['book_edition'];
		$book_noofcopies = $_POST['book_noofcopies'];
		if(empty($book_name) or empty($author_name) or empty($book_edition) or empty($book_noofcopies))
		{
			$error="All fields are required !";
		}
		else
		{
			$bookid = new Article;
			$bookids = $bookid->fetch_booknameid( $book_name );
			$book_id = $bookids['book_id'];
			$authorid = new Article;
			$authorids = $authorid->fetch_authornameid( $author_name );
			$author_id = $authorids['author_id'];
			$existededition = new Article;
			$unexistededition = $existededition->fetch_editioncheck($book_id,$author_id,$book_edition);
			$generated_no = array();
			if(empty($unexistededition['value']))
			{	
				for($i=1;$i<=$book_noofcopies;$i++)
				{
					$book_no = $book_id.".".$author_id.".".$book_edition.".".$i;
					$generated_no[$i] = $book_no;
					global $pdo; 
					$query = $pdo -> prepare('INSERT INTO book_details (book_id,author_id,book_edition,book_no,book_timestamp) VALUES (?,?,?,?,?)');
					$query -> bindValue(1,$book_id);
					$query -> bindValue(2,$author_id);
					$query -> bindValue(3,$book_edition);
					$query -> bindValue(4,$book_no);
					$query -> bindValue(5,date('Y-m-d H:i:s'));
					$query->execute();
				}
			}
			else
			{
				$value = $unexistededition['value'];
				$j=1;
				for($i=$value+1;$i<=($book_noofcopies+$value);$i++)
				{
					$book_no = $book_id.".".$author_id.".".$book_edition.".".$i;
					$generated_no[$j] = $book_no;
					global $pdo; 
					$query = $pdo -> prepare('INSERT INTO book_details (book_id,author_id,book_edition,book_no,book_timestamp) VALUES (?,?,?,?,?)');
					$query -> bindValue(1,$book_id);
					$query -> bindValue(2,$author_id);
					$query -> bindValue(3,$book_edition);
					$query -> bindValue(4,$book_no);
					$query -> bindValue(5,date('Y-m-d H:i:s'));
					$query->execute();
					$j++;
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
	/*
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
	*/
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
                        <a  class="active-menu" href="c_addbooks.php"><i class="glyphicon glyphicon-plus-sign "></i>Add Books</a>
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
                     <h2>Add Books</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
				<?php 	if(isset($book_name) and isset($author_name) and isset($book_edition) and isset($book_noofcopies) and isset($generated_no))
						{	?>	
							<div class="col-md-12">
								<div class="col-md-6">
									<h4>
										Book Name : <?php echo $book_name;?>
									</h4>
									<h4>
										Author Name : <?php echo $author_name;?>
									</h4>
									<h4>
										Book Edition : <?php echo $book_edition;?>
									</h4>
									<h4>
										No of Copies : <?php echo $book_noofcopies;?>
									</h4>
									<h4>
										Book No : <?php for($i = 1; $i<=$book_noofcopies; $i++) { if($i != 1){echo " , ";}echo $generated_no[$i];}?>
									</h4>
									<p>
									</p>
								</div>
								<div class="col-md-6">
										<div class="course-thumb">
											<?php 	if(isset($_SESSION['b_cover']))
													{	
														$b_cover = $_SESSION['b_cover'];
														$bookcover = new Article;
														$bookcovers = $bookcover->fetch_bookcover( $b_cover );
														$edition_image = $bookcovers['edition_image'];
													?>	<img class="img-thumbnail" src="book_covers/<?php echo $edition_image; ?>"/>
											<?php	}   $_SESSION['b_cover'] = NULL; ?>
										</div>
								</div>
							</div>
				<?php	}
					else{
				?>
			<div class="col-md-12">
				<div class="col-md-6">
				<center>
				<h5>Enter Books Details</h5>
				</center>
					<form role="form" action="c_addbooks.php" method="POST" enctype="multipart/form-data">
							<div class="form-group">							
								<label for="">Book Name</label>
								<div class="input-group">
									<input type="text" class="form-control book_name" id="book_name" name="book_name" placeholder="Book Name" value="<?php if(isset($_SESSION['book_name'])){echo $_SESSION['book_name'];}?>"/> <?php if(isset($error)) { ?><h4 style="color:red;text-align:center"><?php echo $error; ?></h4><?php } ?>
									<span class="input-group-btn">
										<button class="btn btn-warning" type="submit" name="book_submit" id="book_submit" onclick=" var data=$('#book_name').val();
																																	var dataString = 'book_name='+ data;
																																	$.ajax
																																	({
																																			type: 'POST',
																																			url: 'ajax_city.php',
																																			data: dataString,
																																			cache: false,
																																			complete: function()
																																			{
																																				alert('Book check successful');
																																			} 
																																	});	">
											<i class="glyphicon glyphicon-thumbs-up"></i>
										</button>
									</span>
								</div>
							</div>
						<div class="form-group">
							 <label class="control-label" for="">Author Name</label>
								<div class="input-group">
									<input type="text" class="form-control author_name" id="author_name" name="author_name" placeholder="Author Name" value="<?php if(isset($_SESSION['author_name'])){echo $_SESSION['author_name'];}?>" /> <?php if(isset($error)) { ?><h4 style="color:red;text-align:center"><?php echo $error; ?></h4><?php } ?>
									<span class="input-group-btn">
										<button class="btn btn-warning" type="submit" name="author_submit" id="author_submit" onclick=" var data=$('#author_name').val();
																																	var dataString = 'author_name='+ data;
																																	$.ajax
																																	({
																																			type: 'POST',
																																			url: 'ajax_city.php',
																																			data: dataString,
																																			cache: false,
																																			complete: function()
																																			{
																																				alert('author check successful');
																																			} 
																																	});	">
											<i class="glyphicon glyphicon-thumbs-up"></i>
										</button>
									</span>
								</div>
						</div>
						<div class="form-group">
							 <label class="control-label" for="">Book Edition</label>
								<div class="input-group">
									<input type="number" class="form-control book_edition" id="book_edition" name="book_edition" placeholder="Book Edition" value="<?php if(isset($_SESSION['book_edition'])){echo $_SESSION['book_edition'];}?>" /> <?php if(isset($error)) { ?><h4 style="color:red;text-align:center"><?php echo $error; ?></h4><?php } ?>
									<span class="input-group-btn">
										<button class="btn btn-warning" type="submit" name="edition_submit" id="edition_submit" onclick="   var data1=$('#book_name').val();
																																			var data2=$('#author_name').val();
																																			var data3=$('#book_edition').val();
																																			var dataString = 'book_name='+ data1 + '&author_name='+ data2 + '&book_edition='+ data3;
																																			$.ajax
																																			({
																																					type: 'POST',
																																					url: 'ajax_city.php',
																																					data: dataString,
																																					cache: false,
																																					success: function()
																																					{
																																						alert('edition check successful');
																																					} 
																																			});	">
											<i class="glyphicon glyphicon-thumbs-up"></i>
										</button>
									</span>
								</div>
						</div>
						<div class="form-group">
							 <label class="control-label" for="">No Of Copies</label>
								<input type="number" class="form-control " id="book_noofcopies" name="book_noofcopies"  placeholder="Book No Of Copies" />
						</div>
						<div class="form-group">
								<button class="btn btn-success" type="submit" name="submit">Add Books</button>
						</div>
					</form>
				</div>
				<div class="col-md-6">
				<center>
				<h5>Select Book Cover</h5>
					<?php $_SESSION['addbooks'] = 1;?>
					<a href="upload/upload.php?b_cover=<?php if(isset($_SESSION['b_cover'])) { $b_cover = $_SESSION['b_cover']; echo $b_cover; } ?>">
							<?php 	if(isset($_SESSION['b_cover']) && isset($_SESSION['cover_status']))
									{	
										$_SESSION['cover_status'] = NULL;
										$b_cover = $_SESSION['b_cover'];
										$bookcover = new Article;
										$bookcovers = $bookcover->fetch_bookcover( $b_cover );
										$edition_image = $bookcovers['edition_image'];
									?>	<img class="img-thumbnail" src="book_covers/<?php echo $edition_image; ?>"/>
							<?php	}
									else
									{	?>
										<img class="img-thumbnail" src="book_covers/book.jpg"/>
							<?php	}	?>
					</a>
				</center>
				</div>
			</div>
			<?php } ?>
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
