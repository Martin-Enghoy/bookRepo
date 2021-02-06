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
			$bookCount = 0;
			
			if($_SERVER["REQUEST_METHOD"] == "GET") {	
				
				//Gets proper input format
				function formatdata($input){
					return htmlspecialchars(stripslashes(trim($input)));
				}
				
				
				
				// Details to be supplemented for each book to be added
				$detailsList = array('bookID','Title', 'Author', 'Cover', 'PubDate','DatePosted', 'ISBN', 'Abstract','Series','PubHouse','Country');
				
				// Check if the user already pressed "Search book" submit button
				if (isset($_GET['Category']) & isset($_GET['search'])) {
					$category = $_GET['Category'];
					$keywords = $_GET['search'];
					
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
					
					
					$searchQuery = "SELECT * FROM books WHERE $category LIKE '%$keywords%';";
					$results = mysqli_query($sqlconnect, $searchQuery);
					
					$bookCount = 0;
					while($arrSearch = mysqli_fetch_array($results)){
						//echo "++".$bookCount;
						$_SESSION['sbookid'][$bookCount] = $arrSearch[$detailsList[0]];
						//echo "++".$_SESSION['sbookid'][$bookCount];
						
						$_SESSION['stitle'][$bookCount] = $arrSearch[$detailsList[1]];
						//echo "++".$_SESSION['stitle'][$bookCount];	
						
						$_SESSION['sauthor'][$bookCount] = $arrSearch[$detailsList[2]];
						//echo "++".$_SESSION['sauthor'][$bookCount];	
						
						$_SESSION['scover'][$bookCount] = $arrSearch[$detailsList[3]];
						//echo "++".$_SESSION['scover'][$bookCount];
						
						$_SESSION['spubdate'][$bookCount] = $arrSearch[$detailsList[4]];
						//echo "++".$_SESSION['spubdate'][$bookCount];
						
						$_SESSION['sdate'][$bookCount] = $arrSearch[$detailsList[5]];
						//echo "++".$_SESSION['sdate'][$bookCount];	
						
						$_SESSION['sisbn'][$bookCount] = $arrSearch[$detailsList[6]];
						$_SESSION['sabstract'][$bookCount] = $arrSearch[$detailsList[7]];
						$_SESSION['sseries'][$bookCount] = $arrSearch[$detailsList[8]];
						$_SESSION['spubhouse'][$bookCount] = $arrSearch[$detailsList[9]];
						$_SESSION['scountry'][$bookCount] = $arrSearch[$detailsList[10]];
						
						$bookCount++;
					} 
					
					/*
					// Testing of the search output
					while ($arr = mysqli_fetch_array($results)) {
						for ($i = 0; $i < 10; $i++) {
							echo $arr[$detailsList[$i]];
							echo "<br>";
						}
						echo "-----------------------------------------------";
						echo "<br>";
					}
					*/
				}
			}
				
		
	?>

		<!-- Content -->
			<div id="content">
					<div class="inner">
						<header>
							<h1>Search Results: <?php echo $bookCount; ?> </h1>
						</header>
					</div>
					<?php
					
					
					$counter = 0;
					echo "<div class=\"inner\">";
					$i=0;
					while($counter<$bookCount){
					//for($i=0; $i<$bookCount; $i++){
						//echo "--".$i;
						echo "<article class=\"box post post-excerpt\">";
						//echo "<a href=\"inLib-SearchViewBook.php?bookID=".$i."\" class=\"image left\"><img src=\"images/".$_SESSION['scover'][$counter]."\" class=\"search\"/></a>";
						echo "<h2><a href=\"inLib-SearchViewBook.php?bookID=".$counter."\">".$_SESSION['stitle'][$counter]."</a></h2>";
						echo "<p>".$_SESSION['sauthor'][$counter]." | ".$_SESSION['spubdate'][$counter]." | Posted on: ".$_SESSION['sdate'][$counter]."</p>";
						echo "</article>";					
						$counter++;
					}
					echo "</div>";
					
					?>
			</div>
			

		<!-- Sidebar -->
			<div id="sidebar">

				<!-- Logo -->
					<h1 id="logo"><a href="lib-home.php?page=1">RepoHub</a></h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="lib-home.php?page=1">Latest Post</a></li>
							<li><a href="lib-About.php">About RepoHub</a></li>
						</ul>
					</nav>

				<!-- Login -->
				<section class ="box text-style1">
					<div class ="inner">
						<form method="post" action="lib-home.php?page=1">
						<?php //echo htmlspecialchars($_SERVER['PHP_SELF']);?>
							<input type="text" class="text" name="username" placeholder="Username"/>
							<p class="error"><?php echo $userErr; ?></p>
							<input type="password" class="text" name="password" placeholder="Password"/>
							<p class="error"><?php echo $passErr; ?></p>
							<input type="submit" value="Login"/>
						</form> 
						<?php 
							//if($userVer == 1 && $passVer == 1){
							//	header("Location: inLib-Home.php");
							//}
						?>
					</div>
				</section>
				<br><br>				
				<a href="lib-reg.php">Not yet Registered?</a>
				
				<br><br>
				
				<!-- Search -->
					<section class="box search">
						<form method="get" action="lib-SearchBook.php">
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
					<br><br><br><br><br>
					

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