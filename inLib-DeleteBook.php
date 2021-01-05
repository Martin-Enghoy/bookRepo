<!DOCTYPE HTML>
<!--
	Striped by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>RepoHub</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">
	
	<!-- Back End
		1. Load bookRepo database
		2. Get user and pw from Admin
		3. Get BookDetails
		4. Check if details exist
		5. Redirect to book pages when clicked.
	-->
	
	<?php
			//Get username-pw 
			/*
			$records = array(array("user"=> null, "pass"=> null,)); //init array
			$recordsDB = mysqli_query($sqlconnect, "select * from admin"); //fetching data from bookrepo db
			$count = 0;
			*/
			
			//Get books 
			/*
			$bookRecords = array("title"=> null, "isbn"=> null, "abstract"=> null, "series"=> null, "pubhouse"=> null, 
			*/
			
			//session init
			session_start();
			
			//Flags
			$error = 0;
			$titleErr = $isbnErr = $authErr = $covErr = $absErr = $serErr = $pubhErr = $pubdErr = $counErr = "";
			
			$bookIndex = $_SESSION['bookid'][$_GET['bookID']];

			//Connection to SQL
			$sqlconnect = mysqli_connect('localhost','root','');
			if(!$sqlconnect){
				die();
			}

			//Database init
			$selectDB = mysqli_select_db($sqlconnect,'bookrepo');
			if(!$selectDB){
				die("Database not connected." . mysqli_error());
			}

			$deleteQuery = "DELETE FROM books WHERE bookID = $bookIndex";
			mysqli_query($sqlconnect, $deleteQuery);
			
			header('Location: inLib-Home.php?page=1');
		
	?>

		

	</body>
</html>