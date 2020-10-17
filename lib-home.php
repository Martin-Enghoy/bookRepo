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
		
		//init variables
		$username = $password = "";
		$userErr = $passErr = "";
		
		//Page variables
		$pageBookIndex = 0;
		
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
				header("Location: inLib-Home.php");
			}	
		}
		
	?>

		<!-- Content -->
			<div id="content">
				<div class="inner">

					<!-- Post -->
						<article class="box post post-excerpt">
							<header>
								<h2><a href="#"><?php echo $_SESSION['title'][$pageBookIndex];?></a></h2>
								
								<p><?php echo $_SESSION['author'][$pageBookIndex];?> | <?php echo $_SESSION['pubdate'][$pageBookIndex];?></p>
							</header>
							<div class="info">
								<!--
									Note: The date should be formatted exactly as it's shown below. In particular, the
									"least significant" characters of the month should be encapsulated in a <span>
									element to denote what gets dropped in 1200px mode (eg. the "uary" in "January").
									Oh, and if you don't need a date for a particular page or post you can simply delete
									the entire "date" element.
								-->
								<span class="date"><span class="month">Jul<span>y</span></span> <span class="day">14</span><span class="year">, 2014</span></span>
								<!--
									Note: You can change the number of list items in "stats" to whatever you want.
								-->
								<ul class="stats">
									<li><a href="#" class="icon fa-comment">16</a></li>
									<li><a href="#" class="icon fa-heart">32</a></li>
									<li><a href="#" class="icon brands fa-twitter">64</a></li>
									<li><a href="#" class="icon brands fa-facebook-f">128</a></li>
								</ul>
							</div>
							<div class="box">
							<a href="#" class="image centered"><img src="<?php echo "images/" . $_SESSION['cover'][$pageBookIndex]?>"  alt="" /></a>
							</div>
							<p>
								<?php echo $_SESSION['abstract'][$pageBookIndex];?>
							</p>
							
							<?php $pageBookIndex++;?>
							<!-- <p><?php //echo $pageBookIndex;?></p> -->
						</article>

					<!-- Post -->
						<article class="box post post-excerpt">
							<header>
								<h2><a href="#"><?php echo $_SESSION['title'][$pageBookIndex];?></a></h2>
								<p><?php echo $_SESSION['author'][$pageBookIndex];?> | <?php echo $_SESSION['pubdate'][$pageBookIndex];?></p>
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
							<a href="#" class="image centered"><img class="image centered" src="<?php echo "images/" . $_SESSION['cover'][$pageBookIndex]?>" alt="" /></a>
							<p>
								<?php echo $_SESSION['abstract'][$pageBookIndex];?>
							</p>
						</article>

					<!-- Pagination -->
						<div class="pagination">
							<!--<a href="#" class="button previous">Previous Page</a>-->
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

				</div>
			</div>

		<!-- Sidebar -->
			<div id="sidebar">

				<!-- Logo -->
					<h1 id="logo"><a href="#">RepoHub</a></h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li class="current"><a href="#">Latest Post</a></li>
							<li><a href="#">Book Repo</a></li>
							<li><a href="#">Add Book</a></li>
							<li><a href="#">About RepoHub</a></li>
						</ul>
					</nav>

				<!-- Login -->
				<section class ="box text-style1">
					<div class ="inner">
						<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
							<p class="error"><?php echo $userErr; ?></p>
							<input type="text" class="text" name="username" placeholder="Username"/>
							<p class="error"><?php echo $passErr; ?></p>
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
				
				<!-- Search -->
					<section class="box search">
						<form method="post" action="#">
							<input type="text" class="text" name="search" placeholder="Search" />
						</form>
					</section>

				<!-- Text -->
					<section class="box text-style1">
						<div class="inner">
							<p>
								<strong>Striped:</strong> A free and fully responsive HTML5 site
								template designed by <a href="http://twitter.com/ajlkn">AJ</a> for <a href="http://html5up.net/">HTML5 UP</a>
							</p>
						</div>
					</section>

				<!-- Recent Posts -->
					<section class="box recent-posts">
						<header>
							<h2>Recent Posts</h2>
						</header>
						<ul>
							<li><a href="#">Lorem ipsum dolor</a></li>
							<li><a href="#">Feugiat nisl aliquam</a></li>
							<li><a href="#">Sed dolore magna</a></li>
							<li><a href="#">Malesuada commodo</a></li>
							<li><a href="#">Ipsum metus nullam</a></li>
						</ul>
					</section>

				<!-- Recent Comments -->
					<section class="box recent-comments">
						<header>
							<h2>Recent Comments</h2>
						</header>
						<ul>
							<li>case on <a href="#">Lorem ipsum dolor</a></li>
							<li>molly on <a href="#">Sed dolore magna</a></li>
							<li>case on <a href="#">Sed dolore magna</a></li>
						</ul>
					</section>

				<!-- Calendar -->
					<section class="box calendar">
						<div class="inner">
							<table>
								<caption>July 2014</caption>
								<thead>
									<tr>
										<th scope="col" title="Monday">M</th>
										<th scope="col" title="Tuesday">T</th>
										<th scope="col" title="Wednesday">W</th>
										<th scope="col" title="Thursday">T</th>
										<th scope="col" title="Friday">F</th>
										<th scope="col" title="Saturday">S</th>
										<th scope="col" title="Sunday">S</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="4" class="pad"><span>&nbsp;</span></td>
										<td><span>1</span></td>
										<td><span>2</span></td>
										<td><span>3</span></td>
									</tr>
									<tr>
										<td><span>4</span></td>
										<td><span>5</span></td>
										<td><a href="#">6</a></td>
										<td><span>7</span></td>
										<td><span>8</span></td>
										<td><span>9</span></td>
										<td><a href="#">10</a></td>
									</tr>
									<tr>
										<td><span>11</span></td>
										<td><span>12</span></td>
										<td><span>13</span></td>
										<td class="today"><a href="#">14</a></td>
										<td><span>15</span></td>
										<td><span>16</span></td>
										<td><span>17</span></td>
									</tr>
									<tr>
										<td><span>18</span></td>
										<td><span>19</span></td>
										<td><span>20</span></td>
										<td><span>21</span></td>
										<td><span>22</span></td>
										<td><a href="#">23</a></td>
										<td><span>24</span></td>
									</tr>
									<tr>
										<td><a href="#">25</a></td>
										<td><span>26</span></td>
										<td><span>27</span></td>
										<td><span>28</span></td>
										<td class="pad" colspan="3"><span>&nbsp;</span></td>
									</tr>
								</tbody>
							</table>
						</div>
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