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
		
		//Gets proper input format
		function formatdata($input){
			return htmlspecialchars(stripslashes(trim($input)));
		}
		
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
		
		//Get username-pw 
		$records = array(array("user"=> null, "pass"=> null,)); //init array
		$recordsDB = mysqli_query($sqlconnect, "select * from admin"); //fetching data from bookrepo db
		$count = 0;
		
		
		//Get books
		$booksDB = mysqli_query($sqlconnect, "select * from books order by dateposted desc");
		$bookCount = 0;
		
		//Get books 
		/*
		$bookRecords = array("title"=> null, "isbn"=> null, "abstract"=> null, "series"=> null, "pubhouse"=> null, 
		*/
		
		//session init
		session_start();
		
		/*
		//Putting users in array
		while($arr = mysqli_fetch_array($recordsDB)){
			//$records[$count]["user"] = $arr['UserName'];
			$_SESSION['user'][$count] = $arr['UserName'];
			//$records[$count]["pass"] = $arr['Password'];
			$_SESSION['pass'][$count] = $arr['Password'];
			$count++;
		}
		
		
		//init variables
		$username = $password = "";
		$userErr = $passErr = "";
		
		//Verifs
		$error = 0;
		$userVer = 0;
		$passVer = 0;
		
		//Error check and catch
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			//Input Check
			if(empty($_POST["username"])){
				$userErr = "Please input your Username!";
				$error = 1;
			}	
			else {
				//Check in admin 
				$username = formatdata($_POST["username"]);
				for($userid = 0; $userid < $count; $userid++){
					if($username == $_SESSION['user'][$userid]){
						$userVer = 1;
						break;
					}
				}
			}
			
			//Error message for UserName not found.
			if($userVer == 0 && !empty($_POST["username"])){
				$userErr = "Username does not exist!";
			}
			
			//PW Check
			if(empty($_POST["password"])){
				$passErr = "Please input a Password!";
			} 
			else {
				$password = formatdata($_POST["password"]);
				if($userVer == 1){
					//If Found
					if($password == $_SESSION['pass'][$userid]){
						$passVer = 1;
					}
					else {
						$passErr = "Password does not match!";
						echo "<script>alert('Password does not match!')</script>";
					}
				}
			}
		}
		*/
		
		//Putting book details into array
		while($arrB = mysqli_fetch_array($booksDB)){
			$_SESSION['bookid'][$bookCount] = $arrB['bookID'];
			//echo $_SESSION['bookid'][$bookCount] . " ";
			$_SESSION['title'][$bookCount] = $arrB['Title'];
			$_SESSION['isbn'][$bookCount] = $arrB['ISBN'];
			$_SESSION['author'][$bookCount] = $arrB['Author'];
			$_SESSION['cover'][$bookCount] = $arrB['Cover'];
			$_SESSION['abstract'][$bookCount] = $arrB['Abstract'];
			$_SESSION['series'][$bookCount] = $arrB['Series'];
			$_SESSION['pubhouse'][$bookCount] = $arrB['PubHouse'];
			$_SESSION['pubdate'][$bookCount] = $arrB['PubDate'];
			$_SESSION['country'][$bookCount] = $arrB['Country'];
			$_SESSION['date'][$bookCount] = $arrB['DatePosted'];
			$bookCount++;
		}
		
		//init of bookCount to pass
		$_SESSION['bookcount'] = $bookCount;
		
		//Storing page values into local array
		//$pageIndex = $_GET['page'];
		//echo $pageIndex;
		$pageTotal = ceil($_SESSION['bookcount'] / 2);
		//echo $pageTotal;
		$pageCont = 0;
		for($i = 0; $i < $pageTotal; $i++){
			for($y = 0; $y < 2; $y++){
				$pages[$i][$y] = $pageCont;
				//echo $pages[$i][$y] . "+";
				$pageCont++;
				//echo "=" . $i;
				//echo $pageCont ."-";
			}
			echo " ";
			//$pageCont++;
		}
	?>

		<!-- Content -->
			<div id="content">
				<div class="inner">

					<!-- Post -->
						<article class="box post post-excerpt">
							<header>
								<h2>RepoHub: About Us</h2>
							</header>
							<p>
								<b>RepoHub</b> is a student-driven initiative to bring a book repository online and available to anyone and everyone. The academic community is very diverse as well as it's fiction, digests and fun reads.

								The purpose of Repohub is to give each member of the academic community a quick stop to acquaint themselves with a particular piece of reading material. Currently, the website doesn't support acquiring the feedback of each user. However, it'll soon boast reviews and ratings for each uploaded piece.

								

								
							</p>
							
							<h1>Created by: Jan Luis Antoc & Martin Adrian Enghoy </h1>
							
							<br>
							
							<em> "Education is the most powerful weapon which you can use to change the world."
								- Nelson Mandela
							</em>
							
							
				</div>
			</div>

		<!-- Sidebar -->
			<div id="sidebar">

				<!-- Logo -->
					<h1 id="logo"><a href="#">RepoHub</a></h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="inLib-Home.php?page=1">Latest Post</a></li>
							<li><a href="inLib-AddBook.php">Add Book</a></li>
							<li class="current"><a href="#">About RepoHub</a></li>
						</ul>
					</nav>

				<!-- Login -->
				<section class ="box text-style1">
				<br>
					<div class ="inner">
						<p>Welcome to RepoHub, </p>
						<h2><?php echo $_SESSION['id'] . "!";?></h2>
					</div>
					<h2><a href="lib-home.php?page=1">Logout</a></h2>
				</section>
				
				<!-- Search -->
					<section class="box search">
						<form method="get" action="inLib-SearchBook.php">
							<select id="Category" name="Category" class="form-control">
								<option value="Title">Title</option>
								<option value="ISBN">ISBN</option>
								<option value="Author">Author</option>
								<option value="Series">Series</option>
								<option value="PubHouse">PubHouse</option>
								<option value="Country">Country</option>
							</select>
							<br>
							<input type="text" class="text" name="search" placeholder="Search" />
							<br>
							<input type="submit" id="Submit" value="Search Book"/>
						</form>
					</section>
				
				
				<!-- Recent Posts -->
					<section class="box recent-posts">
						<header>
							<h2>Recent Posts</h2>
						</header>
						<ul>
							<li><a href="inLib-ViewBook.php?bookID=0"><?php echo $_SESSION['title'][0];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=1"><?php echo $_SESSION['title'][1];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=2"><?php echo $_SESSION['title'][2];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=3"><?php echo $_SESSION['title'][3];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=4"><?php echo $_SESSION['title'][4];?></a></li>
						</ul>
					</section>
										
				<!-- Copyright -->
					<ul id="copyright">
						<li>&copy; LBYCPG2</li><li>Design: Antoc, Jan Luis and Enghoy, Martin Adrian</a></li>
					</ul>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>