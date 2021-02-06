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
		$booksDB = mysqli_query($sqlconnect, "select * from books order by dateposted desc limit 1");
		$bookCount = 0;
		
		
		//Get books 
		/*
		$bookRecords = array("title"=> null, "isbn"=> null, "abstract"=> null, "series"=> null, "pubhouse"=> null, 
		*/
		
		//session init
		session_start();
		
		//Putting users in array
		while($arr = mysqli_fetch_array($recordsDB)){
			//$records[$count]["user"] = $arr['UserName'];
			$_SESSION['user'][$count] = $arr['UserName'];
			//$records[$count]["pass"] = $arr['Password'];
			$_SESSION['pass'][$count] = $arr['Password'];
			$count++;
		}
		
		
		//Putting book details into array
		/*
		while($arrB = mysqli_fetch_array($booksDB)){
			$_SESSION['bookid'][$bookCount] = $arrB['bookID'];
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
		*/
		
		
		//Getting the $_SESSION values 
		$bookIndex = $_GET['bookID'];
		
		
		//init variables
		$username = $password = "";
		$userErr = $passErr = "";
		
		//Page variables
		//$pageBookIndex = 0;
		
		//Verifs
		$error = 0;
		$userVer = 0;
		$passVer = 0;
		
		//Error check and catch
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			/*
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
						$_SESSION['userLog'] = $_SESSION['user'][$userid];
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
						$_SESSION['userPass'] = $_SESSION['pass'][$userid];
					}
					else {
						$passErr = "Password does not match!";
						echo "<script>alert('Password does not match!')</script>";
					}
				}
			}
			if($userVer == 1 && $passVer == 1){
				header("Location: inLib-ViewBook.php");
			}
			*/			
		}
		
		
	?>

		<!-- Content -->
			<div id="content">
				<div class="inner">

					<!-- Post -->
					<section>
							<article class="box post post-excerpt">
								<header>
									<h2><a href="#"><?php echo $_SESSION['title'][$bookIndex];?></a></h2>
									
									<p><?php echo $_SESSION['author'][$bookIndex];?> | <?php echo $_SESSION['pubdate'][$bookIndex];?></p>
								</header>
								<!--
								<div class="info">
									<!--
										Note: The date should be formatted exactly as it's shown below. In particular, the
										"least significant" characters of the month should be encapsulated in a <span>
										element to denote what gets dropped in 1200px mode (eg. the "uary" in "January").
										Oh, and if you don't need a date for a particular page or post you can simply delete
										the entire "date" element.
									
									<span class="date"><span class="month">Jul<span>y</span></span> <span class="day">14</span><span class="year">, 2014</span></span>
									<!--
										Note: You can change the number of list items in "stats" to whatever you want.
									
									<ul class="stats">
										<li><a href="#" class="icon fa-comment">16</a></li>
										<li><a href="#" class="icon fa-heart">32</a></li>
										<li><a href="#" class="icon brands fa-twitter">64</a></li>
										<li><a href="#" class="icon brands fa-facebook-f">128</a></li>
									</ul>
								</div>
								-->
								<h3>
									<b>ISBN: </b><?php echo $_SESSION['isbn'][$bookIndex];?>
								</h3>
								<div class="box">
								<a href="#" class="image centered"><img src="<?php echo "images/" . $_SESSION['cover'][$bookIndex]?>"  alt="" /></a>
								</div>
								<p>
									<?php echo $_SESSION['abstract'][$bookIndex];?>
								</p>
								<p>
									<b>Series: </b><?php echo $_SESSION['series'][$bookIndex];?>
								</p>
								<p>
									<b>Publishing House: </b><?php echo $_SESSION['pubhouse'][$bookIndex];?>
								</p>
								<p>
									<b>Publishing Date: </b><?php echo $_SESSION['pubdate'][$bookIndex];?>
								</p>
								<p>
									<b>Country: </b><?php echo $_SESSION['country'][$bookIndex];?>
								</p>
								<p>
									<b>Date Posted: </b><?php echo $_SESSION['date'][$bookIndex];?>
								</p>
								
								<?php //$pageBookIndex++;?>
								<!-- <p><?php //echo $pageBookIndex;?></p> -->
							</article>
						</section>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
						<!-- Edit Button -->
						<section>
							<a href="inLib-EditBook.php?bookID=<?php echo $bookIndex;?>">
								<input type="submit" id="Submit" name="submit" value="Edit Book"/>
							</a>
							<?php if($_SESSION['access'] == "Admin"){
							echo "<form method=\"post\" action=\"inLib-DeleteBook.php?bookID=" . $bookIndex . "\" onsubmit=\"return confirm('Are you sure you want to delete " . $_SESSION['title'][$bookIndex] . "');\">
							<br>
								<input type=\"submit\" id=\"Submit\" name=\"delete\" value=\"Delete Book\"/>
							</form>";
							}
							?>
						</section>

					<!-- Post 
						<article class="box post post-excerpt">
							<header>
								<h2><a href="#"><?php //echo $_SESSION['title'][$pageBookIndex];?></a></h2>
								<p><?php //echo $_SESSION['author'][$pageBookIndex];?> | <?php //echo $_SESSION['pubdate'][$pageBookIndex];?></p>
							</header>
							<div class="info">
								<span class="date"><span class="month">Jul<span>y</span></span> <span class="day">9</span><span class="year">, 2014</span></span>
								<ul class="stats">
									<li><a href="#" class="icon fa-comment">16</a></li>
									<li><a href="#" class="icon fa-heart">32</a></li>
									<li><a href="#" class="icon brands fa-twitter">64</a></li>
									<li><a href="#" class="icon brands fa-facebook-f">128</a></li>
								</ul>
							</div>
							<a href="#" class="image centered"><img class="image centered" src="<?php //echo "images/" . $_SESSION['cover'][$pageBookIndex]?>" alt="" /></a>
							<p>
								<?php //echo $_SESSION['abstract'][$pageBookIndex];?>
							</p>	
						</article>
					-->
					<!-- Pagination 
						<div class="pagination">
							<!--<a href="#" class="button previous">Previous Page</a>
							<div class="pages">
								<a href="#" class="active">1</a>
								<a href="#">2</a>
								<a href="#">3</a>
								<a href="#">4</a>
								<span>&hellip;</span>
								<a href="#">20</a>
							</div>
							<a href="#" class="button next">Next Page</a>
						</div>
						-->

				</div>
			</div>

		<!-- Sidebar -->
			<div id="sidebar">

				<!-- Logo -->
					<h1 id="logo"><a href="inLib-Home.php?page=1">RepoHub</a></h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="inLib-Home.php?page=1">Latest Post</a></li>
							<li><a href="inLib-AddBook.php">Add Book</a></li>
							<li><a href="inLib-About.php">About RepoHub</a></li>
						</ul>
					</nav>

				<!-- Login -->
					<section class ="box text-style1">
						<div class ="inner">
							<p>Welcome to RepoHub, </p>
							<h2><?php echo $_SESSION['id'] . "!";?></h2>
						</div>
						<h2><a href="lib-home.php?page=1">Logout</a></h2>
						<?php 
							//if($userVer == 1 && $passVer == 1){
							//	header("Location: inLib-Home.php");
							//}
						?>	
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