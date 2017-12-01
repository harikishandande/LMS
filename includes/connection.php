<?php
try
{
  $pdo = new PDO('mysql:host=localhost;dbname=library_management','root','123');

	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '123');
	define('DB_DATABASE', 'library_management');
	$connection = @mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


}
catch(PDOException $e)
{
  exit('Database error.');
}