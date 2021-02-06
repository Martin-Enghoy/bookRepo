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
			
			$country_list = array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina",
				"Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium",
				"Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso",
				"Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad", "Chile", "China", "Colombia",
				"Comoros", "Congo (Brazzaville)", "Congo", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic",
				"Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor (Timor Timur)", "Ecuador", "Egypt", "El Salvador",
				"Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia, The", "Georgia",
				"Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary",
				"Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan",
				"Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho",
				"Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives",
				"Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Morocco",
				"Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria",
				"Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal",
				"Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent", "Samoa", "San Marino",
				"Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone", "Singapore",
				"Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname",
				"Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tonga",
				"Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates",
				"United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam",
				"Yemen", "Zambia", "Zimbabwe"
			);
						
			
			//Flags
			$error = 0;
			$titleErr = $isbnErr = $authErr = $covErr = $absErr = $serErr = $pubhErr = $pubdErr = $counErr = "";
			
			$bookIndex = $_GET['bookID'];
			$bookID = $_SESSION['bookid'][$bookIndex];
			$title = $_SESSION['title'][$bookIndex];
			$ISBN = $_SESSION['isbn'][$bookIndex];
			$author = $_SESSION['author'][$bookIndex];
			$cover = $_SESSION['cover'][$bookIndex];
			$abstract = $_SESSION['abstract'][$bookIndex];
			$series = $_SESSION['series'][$bookIndex];
			$pubHouse = $_SESSION['pubhouse'][$bookIndex];
			$pubDate = $_SESSION['pubdate'][$bookIndex];
			$country = $_SESSION['country'][$bookIndex];
			
			$countriesNum = sizeof($country_list);
			
			//echo $bookID;
			
			if($_SERVER["REQUEST_METHOD"] == "POST") {	
				
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
				
				$currDetails = array($title, $ISBN, $author, $cover, $abstract, $series, $pubHouse, $pubDate, $country);
				
				// Details to be supplemented for each book to be added
				$detailsList = array('Title', 'ISBN', 'Author', 'Cover', 'Abstract', 'Series', 'PubHouse', 'PubDate', 'Country',
					'DatePosted');
				$editBook = array();
				
				/*
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
				*/
				
				
				
				if($error != 1){
					 // Get the new input for each detail of the book
					// If there is no inputted data for a detail that is not required to be supplemented, input "None"
					for ($i = 0; $i < 9; $i++) {
						$category = $detailsList[$i];
						$detail = $_POST[$category];
						$detail = formatdata($detail);

						// Only edit the detail that has been changed compared to the current value of the detail
						if ($detail != $currDetails[$i]) {
							if (is_null($detail)) {
								$editBook[$category] = "None";
							} else {
								$editBook[$category] = $detail;
							}
						}
					}

					// Get the current date while adding the book
					$datePosted = date("Y-m-d");
					$editBook['DatePosted'] = $datePosted;

					 
					// Accommodate input with special characters, such as single quotation
					$editSize = sizeof($editBook);
					$editQuery = "UPDATE books SET ";

					// Making sure that the value of each category is a valid statement for mySQL
					// Concatenated too on the edit statement
					foreach ($editBook as $category => $value) {
						$value = mysqli_real_escape_string($sqlconnect, $value);
						if ($category != array_key_last($editBook)) {
							$editQuery = $editQuery . $category . " = " . "'$value', ";
						} else {
							$editQuery = $editQuery . $category . " = " . "'$value' ";
						}
					}
					
					
					$editQuery = $editQuery . "WHERE bookID = $bookID";
					
					mysqli_query($sqlconnect, $editQuery);
					/* Commented out. For testing if the mysqli_query() is working
					if (mysqli_query($sqlconnect, $insertQuery)) {
						echo "Successfully added!";
					} else {
						echo "Failure!";
					}
					*/
					
				}
				header("Location: inLib-ViewBook.php?bookID=$bookIndex");
				//echo $bookIndex;
				mysqli_close($sqlconnect);
				//echo  $editQuery;
				//echo $bookID;
			}
		
	?>

		<!-- Content -->
			<div id="content">
				<div class="inner">
					<header><h2>Editing: <?php echo $title?></h2></header>
					<form action="inLib-EditBook.php?bookID=<?php echo $bookIndex;//htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
						<label for="Title">Title</label>
						<input type="text" id="Title" name="Title" size="50" required value="<?php echo $title?>"> <br><br>
						<label for="ISBN">ISBN</label>
						<input type="text" id="ISBN" name="ISBN" required value="<?php echo $ISBN?>"> <br><br>
						<label for="Author">Author</label>
						<input type="text" id="Author" name="Author" required value="<?php echo $author;?>"> <br><br>
						<label for="Cover">Cover</label>
						<input type="file" id="Cover" name="Cover" accept="image/*" value="<?php echo $cover;?>"> <br><br>
						<label for="Abstract">Abstract</label>
						<input type="text" id="Abstract" name="Abstract" size="50" value="<?php echo $abstract;?>"> <br><br>
						<label for="Series">Series</label>
						<input type="text" id="Series" name="Series" size="50" value="<?php echo $series;?>"> <br><br>
						<label for="PubHouse">Publisher</label>
						<input type="text" id="PubHouse" name="PubHouse" size="50" required value="<?php echo $pubHouse;?>"> <br><br>
						<label for="PubDate">Publishing Date</label>
						<input type="date" id="PubDate" name="PubDate" required value="<?php echo $pubDate;?>"> <br><br>
						<!-- Drop down for countries, Retrieved from: https://gist.github.com/danrovito/977bcb97c9c2dfd3398a-->
						<label for="Country">Country</label><span style="color: red !important; display: inline; float: none;">*</span>
						<select id="Country" name="Country" class="form-control">
							<?php
								for ($i = 0; $i < $countriesNum; $i++) {
									$currCountry = $country_list[$i];
									$option = "<option value = '$currCountry' ";
									if ($country == $currCountry) {
										//echo "True";
										$option = $option . "selected";
									}
									$option = $option . ">$currCountry</option>";
									echo $option;
								}
							?>
						</select> <br><br>
						<input type="submit" id="Submit" name="Submit" value="Save Changes">
				</form>
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