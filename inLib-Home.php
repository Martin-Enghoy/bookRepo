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
		$pageIndex = $_GET['page'];
		//echo $pageIndex;
		$pageTotal = ceil($_SESSION['bookcount'] / 2);
		//echo $pageTotal;
		$pageCont = 0;
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
	?>

		<!-- Content -->
			<div id="content">
				<div class="inner">

					<!-- Post -->
						<article class="box post post-excerpt">
							<header>
								<h2><a href="inLib-ViewBook.php?bookID=<?php echo $pages[$pageIndex-1][0];?>"><?php echo $_SESSION['title'][$pages[$pageIndex-1][0]];?></a></h2>
								<!-- <p><?php //echo $pageBookIndex;?></p>  -->
								
								<p><?php echo $_SESSION['author'][$pages[$pageIndex-1][0]];?> | <?php echo $_SESSION['pubdate'][$pages[$pageIndex-1][0]];?></p>
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
							<a href="inLib-ViewBook.php?bookID=<?php echo $pages[$pageIndex-1][0];?>" class="image centered"><img src="<?php echo "images/" . $_SESSION['cover'][$pages[$pageIndex-1][0]]?>"  alt="" /></a>
							<p>
								<?php echo $_SESSION['abstract'][$pages[$pageIndex-1][0]];?>
							</p>
							
							<?php $pageBookIndex;?>
							<!-- <p><?php //echo $pageBookIndex;?></p> -->
						</article>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<!-- Post -->
						<article class="box post post-excerpt">
							<header>
								<h2><a href="inLib-ViewBook.php?bookID=<?php echo $pages[$pageIndex-1][1];?>"><?php echo $_SESSION['title'][$pages[$pageIndex-1][1]];?></a></h2>
								<p><?php echo $_SESSION['author'][$pages[$pageIndex-1][1]];?> | <?php echo $_SESSION['pubdate'][$pages[$pageIndex-1][1]];?></p>
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
							<a href="inLib-ViewBook.php?bookID=<?php echo $pages[$pageIndex-1][1];?>" class="image centered"><img class="image centered" src="<?php echo "images/" . $_SESSION['cover'][$pages[$pageIndex-1][1]]?>" alt="" /></a>
							<p>
								<?php echo $_SESSION['abstract'][$pages[$pageIndex-1][1]];?>
							</p>
						</article>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

					<!-- Pagination -->
						<div class="pagination">
							<!--<a href="#" class="button previous">Previous Page</a>-->
							<div class="pages">
								<?php 
									for($i = 1; $i <= $pageTotal; $i++){
										if($pageTotal <= 6){
											if($i == $pageIndex){
												echo "<a href=\"inLib-home.php?page=$i\" class=\"active\">$i</a>";
											} 
											else {
												echo "<a href=\"inLib-home.php?page=$i\">$i</a>";
											}
										}
										if($pageTotal > 6){
											if($pageIndex >= $pageTotal-3){
												if($i == 1){
													echo "<a href=\"inLib-home.php?page=1\">1</a>";
													echo "<span>&hellip;</span>";
												}
												else if($i = $pageIndex){
													echo "<a href=\"inLib-home.php?page=$i\" class=\"active\">$i</a>";
												}
												else {
													echo "<a href=\"inLib-home.php?page=$i\">$i</a>";
												}
											}
											else if($pageIndex >= 4){
												if(($i = $pageIndex-2) || ($i = $pageIndex-1)){
													echo "<a href=\"inLib-home.php?page=$i\">$i</a>";
												}
												else if($i = $pageIndex){
													echo "<a href=\"inLib-home.php?page=$i\" class=\"active\">$i</a>";
												}
												else if($i = $pageIndex+1){
													echo "<span>&hellip;</span>";
												}
												else if($i = $pageIndex+2){
													echo "<a href=\"inLib-home.php?page=$pageTotal\">$pageTotal</a>";
												}
											}
											else if($pageIndex < 4){
												if($i = $pageIndex){
													echo "<a href=\"inLib-home.php?page=$i\" class=\"active\">$i</a>";
												}
												else if($i < 4){
													echo "<a href=\"inLib-home.php?page=$i\">$i</a>";
												} 
												else if($i = 4){
													echo "<span>&hellip;</span>";
												}
												else if($i > 4){
													echo "<a href=\"inLib-home.php?page=$pageTotal\">$pageTotal</a>";
												}
											}
										}
									}
								?>
							</div>
							<a href="inLib-home.php?page=<?php echo $pageIndex+1;?>" class="button next">Next Page</a>
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
							<li><a href="inLib-Search.php">Book Repo</a></li>
							<li><a href="inLib-AddBook.php">Add Book</a></li>
							<li><a href="lib-AboutUs.php">About RepoHub</a></li>
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
					<br><br>
						<form method="post" action="#">
							<input type="text" class="text" name="search" placeholder="Search" />
						</form>
					</section>
				
				
				<!-- Recent Posts -->
					<section class="box recent-posts">
						<header>
							<h2>Recent Posts</h2>
						</header>
						<ul>
							<li><a href="inLib-ViewBook.php?bookID=<?php echo $_SESSION['bookcount']-1;?>"><?php echo $_SESSION['title'][$_SESSION['bookcount']-1];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=<?php echo $_SESSION['bookcount']-2;?>"><?php echo $_SESSION['title'][$_SESSION['bookcount']-2];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=<?php echo $_SESSION['bookcount']-3;?>"><?php echo $_SESSION['title'][$_SESSION['bookcount']-3];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=<?php echo $_SESSION['bookcount']-4;?>"><?php echo $_SESSION['title'][$_SESSION['bookcount']-4];?></a></li>
							<li><a href="inLib-ViewBook.php?bookID=<?php echo $_SESSION['bookcount']-5;?>"><?php echo $_SESSION['title'][$_SESSION['bookcount']-5];?></a></li>
						</ul>
					</section>
					<br><br><br><br><br><br><br><br><br><br>
					

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