<?php
  
   class Article
   {	
		public function fetch_book_lib_no($book_no)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_lib_no FROM book_details WHERE book_no = ? ;");
			$query -> bindValue(1,$book_no);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_remain_book_details($book_id,$author_id,$book_edition)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_no,book_status, book_lib_no FROM book_details WHERE book_id = ? && author_id = ? && book_edition = ? && book_status = 1 ;");
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query -> bindValue(3,$book_edition);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_ebooks()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM ebook order by ename ASC;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_journals()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM journals order by jname ASC;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_magazines()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM magazines order by mname ASC;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_booknames()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM book_names order by book_id ASC;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_authornames()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM author_names order by author_id ASC;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_booknameid($book_name)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_id FROM book_names WHERE book_name = ? ;");
			$query -> bindValue(1,$book_name);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_authornameid($author_name)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT author_id FROM author_names WHERE author_name = ? ;");
			$query -> bindValue(1,$author_name);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_editioncheck($book_id,$author_id,$book_edition)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT COUNT(*) as value FROM book_details WHERE ( book_id = ? && author_id = ? && book_edition = ? ) ;");
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query -> bindValue(3,$book_edition);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_bookcover($b_cover)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT edition_image FROM edition_details WHERE b_cover = ? ;");
			$query -> bindValue(1,$b_cover);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_edition_details()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_only_edition_details($book_id, $author_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE book_id = ? and author_id = ? order by book_edition ASC;");
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_edition_details_by_bookid($book_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE book_id = ? ;");
			$query -> bindValue(1,$book_id);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_edition_details_by_authorid($author_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE author_id = ? ;");
			$query -> bindValue(1,$author_id);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_edition_details_by_bothids($book_id, $author_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE (book_id = ? && author_id = ?) ;");
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_edition_details_by_all($book_id, $author_id, $book_edition)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE (book_id = ? && author_id = ? && book_edition = ?) ;");
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query -> bindValue(3,$book_edition);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_bookname($book_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_name FROM book_names WHERE book_id = ? ;");
			$query -> bindValue(1,$book_id);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_authorname($author_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT author_name FROM author_names WHERE author_id = ? ;");
			$query -> bindValue(1,$author_id);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_book_details($book_id,$author_id,$book_edition)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_no,book_status,book_lib_no FROM book_details WHERE book_id = ? && author_id = ? && book_edition = ? ;");
			$query -> bindValue(1,$book_id);
			$query -> bindValue(2,$author_id);
			$query -> bindValue(3,$book_edition);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_allbook_details()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM book_details  ;");
			$query->execute();
			return $query ->fetchAll();
		}
		
		public function fetch_booknameidsearch($book_name)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_id FROM book_names WHERE book_name LIKE '%$book_name%' ;");
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_authornameidsearch($author_name)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT author_id FROM author_names WHERE author_name LIKE '%$author_name%' ;");
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_search_bookname($search)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM book_details WHERE book_id LIKE '%$search%';");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_search_authorname($search)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM book_details WHERE author_id LIKE '%$search%';");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_search_both($book_id , $author_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM book_details WHERE book_id LIKE '$book_id' and author_id LIKE '$author_id';");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_authorids($book_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE book_id = ? ;");
			$query -> bindValue(1,$book_id);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_bookids($author_id)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM edition_details WHERE author_id = ? ;");
			$query -> bindValue(1,$author_id);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_book_status($book_no)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT book_status FROM book_details WHERE book_no = ? ;");
			$query -> bindValue(1,$book_no);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_staff_status($staff_no, $password)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT staff_status FROM staff_names WHERE staff_no = ? and password = ? ;");
			$query -> bindValue(1,$staff_no);
			$query -> bindValue(2,$password);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_staff_state($staff_no)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT staff_status FROM staff_names WHERE staff_no = ?;");
			$query -> bindValue(1,$staff_no);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_issued_returndate($book_no)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT return_date FROM issue_details WHERE book_no = ? and issue_status = ? ;");
			$query -> bindValue(1,$book_no);
			$query -> bindValue(2,0);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_issue_details($username)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM issue_details WHERE staff_no = ? ;");
			$query -> bindValue(1,$username);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_issue_detail()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM issue_details WHERE issue_status = ? ;");
			$query -> bindValue(1,2);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_issue_waiting()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM issue_details WHERE issue_status = ? ;");
			$query -> bindValue(1,2);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_issue_return()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM issue_details WHERE issue_status = ? ;");
			$query -> bindValue(1,0);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_issue_return_fine()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM issue_details WHERE issue_status = ? ;");
			$query -> bindValue(1,1);
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_staff_names()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM staff_names;");
			$query->execute();
			return $query ->fetchAll();
		}
		public function fetch_staff_name($staff_no)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM staff_names WHERE staff_no = ? ;");
			$query -> bindValue(1,$staff_no);
			$query->execute();
			return $query ->fetch();
		}
		public function fetch_book_report()
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT * FROM report_books;");
			$query->execute();
			return $query ->fetchAll();
		}
		
		public function fetch_check_report($day, $edition_detail)
		{
			global $pdo;
			
			$query= $pdo->prepare("SELECT id,count FROM report_books WHERE ( remind_timestamp = ? && edition_detail = ? );");
			$query -> bindValue(1,$day);
			$query -> bindValue(2,$edition_detail);
			$query->execute();
			return $query ->fetch();
		}
    }
 ?>