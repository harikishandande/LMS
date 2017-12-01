<?php
session_start();
include('includes/article.php');
include('includes/connection.php');

	/*$issuedetail = new Article;
	$issuedetails = $issuedetail->fetch_issue_detail();
	foreach($issuedetails as $issuedetail)
	{
		$current_date = date('y-m-d');
		$book_no = $issuedetail['book_no'];								
		$roll_no = $issuedetail['roll_no'];
		$issue_date = $issuedetail['issue_date'];
		
		$diff = strtotime($current_date) - strtotime($issue_date);
		$days = floor($diff / (24 * 60 * 60 ));
		
		if($days > 0)
		{
			$sql = "UPDATE book_details SET book_status = ? WHERE book_no = ? ";
				$query = $pdo->prepare($sql);
				$query->bindValue("1", 1);
				$query->bindValue("2", $book_no);
				$result = $query->execute();	
				
			$sql = "DELETE FROM issue_details WHERE book_no = ? and roll_no = ? ";
				$query = $pdo->prepare($sql);
				$query->bindValue("1", $book_no);
				$query->bindValue("2", $roll_no);
				$result = $query->execute();
		}
	}
	
	*/

?>