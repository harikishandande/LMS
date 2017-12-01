<?php
session_start();
include('includes/article.php');
include('includes/connection.php');
if(isset($_POST['login']))
{ 
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(empty($username) || empty($password))
	{
		$error = 'All fields are required !!';
	}
	else
	{
		$query = $pdo -> prepare("SELECT * FROM staff_names WHERE staff_no = ? AND password= ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->execute();
		$num = $query->rowCount();
		if($num==1)
		{	
			$_SESSION['username'] = $username;
			$_SESSION['staff'] = true;
			header('Location: s_index.php');
			exit();
		}
		$query = $pdo -> prepare("SELECT * FROM controller_names WHERE username = ? AND password= ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->execute();
		$num = $query->rowCount();
		if($num==1)
		{	
			$_SESSION['username'] = $username;
			$_SESSION['controller'] = true;
			header('Location: c_index.php');
			exit();
		}
		$query = $pdo -> prepare("SELECT * FROM admin_names WHERE username = ? AND password= ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->execute();
		$num = $query->rowCount();
		if($num==1)
		{	
			$_SESSION['username'] = $username;
			$_SESSION['admin'] = true;
			header('Location: a_index.php');
			exit();
		}
		if(!isset($_SESSION['username']))
		{
			$error = 'Incorrect login details !!';
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
            <form role="form" action="aboutus.php" method="POST" enctype="multipart/form-data">
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
                        <a href="books.php"><i class="glyphicon glyphicon-folder-open "></i>All Book Records</a>
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
                        <a class="active-menu" href="aboutus.php"><i class="glyphicon glyphicon-map-marker "></i>About Us</a>
                    </li>
                </ul>
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
				<?php 
					if(isset($error))
					{ ?>
						<h4 style ="color:#ff0000;text-align:center"><?php echo $error; ?> </h4>
			  <?php } ?>
                    <div class="col-md-12" style="margin-left:20px;">
                     <h2>About Us</h2>   
                        <h5>Search any requisite book through Book Name and Author Name .</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                <hr />
									<table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                      <tr>
                                        <td align="left"><p class="news"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Computer Science and Systems Engineering </strong></p></td>
                                      </tr>
                                      <tr>
                                        <td><table border="0" cellspacing="12">
                                            <tr rowspan=2>
                                              <td width="164"><div align="center" class="standard_taxt"><img src="Senguttuvan.jpg" width="130" height="165" /><br />
                                                      <strong>Dr. A. Senguttuvan,</strong> <br />
                                                Dean (CSE, IT, CSSE & MCA)</div></td>
                                              <td ><p align=justify class="standard_taxt">The Department of computer Science & Systems Engineering was established in the year 1999 with annual intake of 40. In the year 2002 intake has been increased to 60. In the year 2012-13 intake has been increased to 120. The curriculum is designed to train the students in developing computing systems (Hardware). <br />
                                                      <br />
                                                The Department is headed by Mr. B. Narendra Kumar Rao who has 10 years of academic experience and 04 years of Industrial Experience with the specialization in Software Testing and Embedded Systems. He obtained B.Tech (CSE) from University of Madras, M.Tech (CS) from JNTU, Anantapur. Currently he is pursuing Ph.D at JNTUH, Hyderabad.</p></td>
                                              <td width="164"><div align="center" class="standard_taxt"><img src="B-Narendra-Kumar.jpg" width="138" height="168" /><br />
                                                      <strong>Mr. B.Narendra Kumar Rao Associate Professor</strong> HOD, CSSE</div></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                      <tr>
                                        <td align="center"><table width="">
                                            <tr>
                                              <td width="" class="text_eng" colspan="10"><p align="justify" class="standard_taxt">The Department is supported by 01 Assistant Professors (SL) and 14 Assistant Professors. All faculty members are having M. Tech qualification.<br />
                                                      <br />
                                                The Department is well equipped with 246 Computer Systems with latest configuration and also has a separate Department library with latest Titles, Editions, NPTEL Course wave, Journals and also connected with internet facility.<br />
                                                <br />
                                                The department strives to inculcate conceptual and technical skills in students through a scientific teaching methodology based on lectures, case studies, seminars, group discussions, project works, assignments, quiz programs etc. These are well supported by modern teaching aids. <br />
                                                <br />
                                                The systematic approach to problem solving is emphasized in the classrooms and laboratories as well as through the course projects and additional computer training beyond the scope of the syllabus. The laboratory exercises are designed to implement the latest software and tools of the industry. <br />
                                                <br />
                                                Seminars and Guest Lectures are organized periodically for the benefit of students. Students are also encouraged to participate in Technical Symposiums / paper contests conducted by various other organizations. Eminent personalities from various other academic institutions, Research Organizations and Industries, are being invited to deliver expert lectures in certain advanced subjects.<br />
                                                <br />
                                                About 15 students are attached to a teacher to guide, motivate and counsel them in academic and other related matters.<br />
                                                <br />
                                                Extra classes will be conducted for students who are academically weak. Parents will be intimated about the poor performance of their wards so that counseling will be done from both the sides which may lead to better performance of the student.<br />
                                                <br />
                                                Systems Engineers Association (SEA) organizes regularly Co-Curricular and Extra-Curricular activities for all round development of students.<br />
                                                <br />
                                                Students of the Department have been excelling in competitive exams. 80% of eligible students have been placed in reputed companies.<br />
                                                <br />
                                                The Alumni of CSSE, who have imbibed ethics, human values and professionalism, have made their mark in reputed organizations in India and abroad. </p>
                                                  <p align="justify" class="standard_taxt">&nbsp;</p></td>
                                            </tr>
                                        </table></td>
                                      </tr>
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
