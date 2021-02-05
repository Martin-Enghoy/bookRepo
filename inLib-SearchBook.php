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
				$detailsList = array('bookID','Title', 'Author', 'Cover', 'PubDate','DatePosted');
				
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
						echo "++".$bookCount;
						$_SESSION['sbookid'][$bookCount] = $arrSearch[$detailsList[0]];
						echo "++".$_SESSION['sbookid'][$bookCount];
						
						$_SESSION['stitle'][$bookCount] = $arrSearch[$detailsList[1]];
						echo "++".$_SESSION['stitle'][$bookCount];	
						
						$_SESSION['sauthor'][$bookCount] = $arrSearch[$detailsList[2]];
						echo "++".$_SESSION['sauthor'][$bookCount];	
						
						$_SESSION['scover'][$bookCount] = $arrSearch[$detailsList[3]];
						echo "++".$_SESSION['scover'][$bookCount];
						
						$_SESSION['spubdate'][$bookCount] = $arrSearch[$detailsList[4]];
						echo "++".$_SESSION['spubdate'][$bookCount];
						
						$_SESSION['sdate'][$bookCount] = $arrSearch[$detailsList[5]];
						echo "++".$_SESSION['sdate'][$bookCount];	
						
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
					for($i=0; $i<$bookCount; $i++){
						//echo "--".$i;
						echo "<a href=\"inLib-ViewBook.php?bookId=".$_SESSION['sbookid'][$counter]."\" class=\"image\"><img src=\"images/".$_SESSION['scover'][$counter]."\" class=\"search\"/></a>";
						echo "<h2 class=\"search\"><a href=\"inLib-ViewBook.php?bookID=".$_SESSION['sbookid'][$counter]."\">".$_SESSION['stitle'][$counter]."</a></h2>";
						echo "<p class=\"search\">".$_SESSION['sauthor'][$counter]." | ".$_SESSION['spubdate'][$counter]." | Posted on: ".$_SESSION['sdate'][$counter]."</p>";
						
						
						$counter++;
					}
						
					
					?>
			</div>
			

		<!-- Sidebar -->
			<div id="sidebar">

				<!-- Logo -->
					<h1 id="logo"><a href="#">RepoHub</a></h1>

				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="inLib-Home.php?page=1">Latest Post</a></li>
							<li><a href="inLib-Search.php">Book Repo</a></li>
							<li class="current"><a href="inLib-AddBook.php">Add Book</a></li>
							<li><a href="lib-AboutUs.php">About RepoHub</a></li>
						</ul>
					</nav>

				<!-- Login -->
				<section class ="box text-style1">
					<div class ="inner">
						<p>Welcome to RepoHub, </p>
						<h2><?php echo $_SESSION['id'] . "!";?></h2>
					</div>
					<h2><a href="lib-home.php?page=1">Logout</a></h2>
				</section>
				
				<!-- Search -->
					<section class="box search">
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