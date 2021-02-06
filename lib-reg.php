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
		<link type="text/css" rel="stylesheet" href="assets/css/main.css"/>
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
		
		//init of bookCount to pass
		//$_SESSION['bookcount'] = $bookCount;
		//echo $bookCount;
		
		//init variables
		$username = $password = "";
		$userErr = $passErr = $firstErr = $lastErr = $emailErr = $institErr = $conErr = $simiErr = $occErr = "";
		$firstLenErr = $lastLenErr = $emailLenErr = $institLenErr = $userLenErr = $passLenErr = "";
		$addIndex = 0;
		$pageBookIndex = 0;
		//$addIndex = $_GET['page'];
		
		//Page variables
		//$pageBookIndex = $addIndex + 0;
		
		//Storing page values into local array
		//$pageIndex = $_GET['page'];
		//echo $pageIndex;
		//$pageTotal = ceil($bookCount / 2);
		//echo $pageTotal;
		//$pageCont = 0;
		/*
		for($i = 0; $i < $pageTotal; $i++){
			for($y = 0; $y < 2; $y++){
				$pages[$i][$y] = $pageCont;
				echo $pages[$i][$y] . "+";
				$pageCont++;
				//echo "=" . $i;
				//echo $pageCont ."-";
			}
			echo " ";
			//$pageCont++;
		}
		*/
		//echo $pageCont;
		
		
		//Verifs
		$error = 0;
		$firstVer = 0;
		$lastVer = 0;
		$emailVer = 0;
		$institVer = 0;
		$userVer = 0;
		$passVer = 0;
		$conVer = 0;
		
		
		//Error check and catch
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			//Input Check
			if(empty($_POST["userName"])){
				$userErr = "Please input your Username!";
				$error = 1;
			}	
			else {
				//Check in admin 
				$username = formatdata($_POST["userName"]);
				for($userid = 0; $userid < $count; $userid++){
					if($username == $_SESSION['user'][$userid]){
						$error = 1;
						$_SESSION['userLog'] = $_SESSION['user'][$userid];
						$userErr = "Username already exists!";
						break;
					}
				}
			}
			
			
			
			
			//Error message for UserName not found.
			/*
			if($userVer == 0 && !empty($_POST["userName"])){
				$userErr = "Username does not exist!";
			}
			*/
			
			//PW Check
			/*
			if(empty($_POST["passWord"])){
				$passErr = "Please input a Password!";
			} 
			else {
				$password = formatdata($_POST["passWord"]);
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
			*/
			
			//
			
			
			//Placeholder is Empty Checks
			if(empty($_POST["firstName"])){
				$firstErr = "Please input your First Name!";
				$error = 1;
			}
			if(empty($_POST["lastName"])){
				$lastErr = "Please input your Last Name!";
				$error = 1;
			}
			if(empty($_POST["emailAdd"])){
				$emailErr = "Please input your Email Address!";
				$error = 1;
			}
			if(empty($_POST["Institution"])){
				$institErr = "Please input your Institution!";
				$error = 1;
			}
			if(empty($_POST["passWord"])){
				$passErr = "Please input your Password!";
				$error = 1;
			}
			if(empty($_POST["conPass"])){
				$conErr = "Please confirm your Password!";
				$error = 1;	
			}
			if(empty($_POST["class"])){
				$occErr = "Please select an Occupation!";
				$error = 1;	
			}
			
			//Password Check for similarity
			if($_POST["passWord"] != $_POST["conPass"]){
				$simiErr = "Password does not match!";
				$error = 1;
			}
			
			//Check for exceeding length
			if(strlen($_POST["firstName"]) > 100){
				$firstLenErr = "First Name should not exceed 100 characters!";
			}
			if(strlen($_POST["lastName"]) > 100){
				$lastLenErr = "Last Name should not exceed 100 characters!";
			}
			if(strlen($_POST["emailAdd"]) > 100){
				$emailLenErr = "Email Address should not exceed 100 characters!";
			}
			if(strlen($_POST["Institution"]) > 100){
				$institLenErr = "Institution should not exceed 100 characters!";
			}
			if(strlen($_POST["passWord"]) > 30){
				$passLenErr = "Password should not exceed 30 characters!";
			}
			if(strlen($_POST["userName"]) > 30){	
				$userLenErr = "Username should not exceed 30 characters!";
			}
			

			if($error != 1){
				$firstn = $_POST["firstName"];
				$lastn = $_POST["lastName"];
				$emailAddress = $_POST["emailAdd"];
				$institution = $_POST["Institution"];
				$userName = $_POST["userName"];
				$passWord = $_POST["passWord"];
				$occupation = $_POST["class"];
				mysqli_query($sqlconnect, "INSERT INTO
				admin(UserName, Password, FirstName, LastName, EmailAdd, Instit, Class)
									VALUES('$userName','$passWord','$firstn','$lastn','$emailAddress','$institution','$occupation');");
				$error = 2;
				header("Location: lib-home.php?page=1");
			}
		}
		
	?>

		<!-- Content -->
			<div id="content">
				<div class="inner">
					<header><h2>RepoHub: Registration Form</h2></header>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<h4>First Name: </h4>
						<input type="text" class="text" name="firstName" placeholder="Your First Name"/><p class="error"><?php echo $firstErr . $firstLenErr; ?></p>
						<h4>Last Name: </h4>
						<input type="text" class="text" name="lastName" placeholder="Your Last Name"/><p class="error"><?php echo $lastErr . $lastLenErr; ?></p>
						<h4>Email Address: </h4>
						<input type="text" class="text" name="emailAdd" placeholder="Your Email Address"/><p class="error"><?php echo $emailErr . $emailLenErr; ?></p>
						<h4>Institution: </h4>
						<input type="text" class="text" name="Institution" placeholder="Your School / Institution"/><p class="error"><?php echo $institErr . $institLenErr; ?></p>
						<h4>Occupation: </h4>
						<select name="class"> 
							<option value="">--Select Occupation--</option>
							<option value="Admin">Admin</option>
							<option value="Student">Student</option>
						</select><?php echo $occErr; ?></p>
						<h4>Username: </h4>
						<input type="text" class="text" name="userName" placeholder="Your Username"/><p class="error"><?php echo $userErr . $userLenErr; ?></p>
						<h4>Password: </h4>
						<input type="password" class="text" name="passWord" placeholder="Password"/><p class="error"><?php echo $passErr . $passLenErr; ?></p>
						<h4>Confirm Password: </h4>
						<input type="password" class="text" name="conPass" placeholder="Confirm"/><p class="error"><?php echo $conErr; ?></p>
						<p class="error"><?php echo $simiErr; ?></p>
						<br>
						<input type="submit" value="Register"/>
					</form>
				</div>
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

				<!-- Login 
				<section class ="box text-style1">
					<div class ="inner">
						<form method="post" action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
							<p class="error"><?php //echo $userErr; ?></p>
							<input type="text" class="text" name="username" placeholder="Username"/>
							<p class="error"><?php //echo $passErr; ?></p>
							<input type="password" class="text" name="password" placeholder="Password"/>
							<br>
							<input type="submit" value="Login"/>
						</form> 
						<?php 
							//if($userVer == 1 && $passVer == 1){
							//	header("Location: inLib-Home.php");
							//}
						?>
					</div>
				</section>
				-->
				
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
							<h2>Recent Uploads</h2>
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

		
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>