<?php
session_start();
include('includes/article.php');
include('includes/connection.php');

if($_POST['book_name'])
{ 
		$book_name = $_POST['book_name'] ;
		$_SESSION['book_name'] = $book_name;
		$booktitle = new Article;
		$booktitles = $booktitle->fetch_booknames();
		$i=0; $flag=0;
		foreach($booktitles as $booktitle)
		{
			if($booktitle['book_name'] == $book_name )
			{
				$flag = 1;
			}
		}
		if($flag == 0)
		{
			$booknumber = new Article;
			$booknumbers = $booknumber->fetch_booknames();
			if(!empty($booknumbers))
			{
				$booknumber = new Article;
				$booknumbers = $booknumber->fetch_booknames();
				$i=1;
				foreach($booknumbers as $booknumber)
				{
					if($booknumber['book_id'] != $i )
					{
						$book_id = $i;
						break;
					}
					$i++;
					$book_id = $i;

				}		
			}
			else
			{	
				$book_id = 1;
			}
			global $pdo; 
			$query = $pdo -> prepare('INSERT INTO book_names (book_name,book_id) VALUES (?,?)');
			$query -> bindValue(1,$book_name);
			$query -> bindValue(2,$book_id);
			$query -> execute();
		}
}
if($_POST['author_name'])
{
		$author_name = $_POST['author_name'] ;
		$_SESSION['author_name'] = $author_name;
		$authortitle = new Article;
		$authortitles = $authortitle->fetch_authornames();
		$i=0; $flag=0;
		foreach($authortitles as $authortitle)
		{
			if($authortitle['author_name'] == $author_name )
			{
				$flag = 1;
			}
		}
		if($flag == 0)
		{
			$authornumber = new Article;
			$authornumbers = $authornumber->fetch_authornames();
			if(!empty($authornumbers))
			{
				$authornumber = new Article;
				$authornumbers = $authornumber->fetch_authornames();
				$i=1;
				foreach($authornumbers as $authornumber)
				{
					if($authornumber['author_id'] != $i )
					{
						$author_id = $i;
						break;
					}
					$i++;
					$author_id = $i;
				}
			}
			else
			{	
				$author_id = 1;
			}
			global $pdo; 
			$query = $pdo -> prepare('INSERT INTO author_names (author_name,author_id) VALUES (?,?)');
			$query -> bindValue(1,$author_name);
			$query -> bindValue(2,$author_id);
			$query -> execute();
		}
}
if($_POST['book_name'] && $_POST['author_name'] && $_POST['book_edition'])
{
		$book_name = $_POST['book_name'] ;
		$author_name = $_POST['author_name'] ;
		$book_edition = $_POST['book_edition'] ;
		$_SESSION['book_edition'] = $book_edition;
		$bookid = new Article;
		$bookids = $bookid->fetch_booknameid( $book_name );
		$book_id = $bookids['book_id'];
		$authorid = new Article;
		$authorids = $authorid->fetch_authornameid( $author_name );
		$author_id = $authorids['author_id'];
		$existededition = new Article;
		$unexistededition = $existededition->fetch_editioncheck($book_id,$author_id,$book_edition);
		if(empty($unexistededition['value']))
		{	
			$b_cover = $book_id.".".$author_id.".".$book_edition;
			$_SESSION['b_cover'] = $b_cover;
			global $pdo; 
			$query = $pdo -> prepare('INSERT INTO edition_details (book_id,author_id,book_edition,b_cover,edition_timestamp) VALUES (?,?,?,?,?)');
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query -> bindValue(3,$book_edition);
			$query -> bindValue(4,$b_cover);
			$query -> bindValue(5,date('Y-m-d H:i:s'));
			$query->execute();
		}
		else
		{
			$b_cover = $book_id.".".$author_id.".".$book_edition;
			$_SESSION['b_cover'] = $b_cover;
		}
}
?>