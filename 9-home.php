<!DOCTYPE html>
	<head>
		<title>
			Home Page
		</title>
	</head>
	
	<body>
	<h2 align="center"> Welcome to this Page! </h2>
	
	<?php
	//Open the connection
	$sqlconnect = mysqli_connect('localhost','root','');
	if(!$sqlconnect){
		die();
	}
	
	//Choose the database
	$selectDB = mysqli_select_db($sqlconnect,'DB1');
	if(!$selectDB){
		die("Database did not connect!".mysqli_error());
	}
	
	//Create array for values to be read from DB1
	$records = array(
			array(
					"id" => null,
					"last" => null,
					"first" => null,
					"user" => null,
					"email" => null,
			)
		);
		
	$recordsDB = mysqli_query($sqlconnect, "select * from records");
	$count = 0;
	
	while($arr = mysqli_fetch_array($recordsDB)){
		$records[$count]["id"] = $arr['IDNumber'];
		$records[$count]["last"] = $arr['LastName'];
		$records[$count]["first"] = $arr['FirstName'];
		$records[$count]["user"] = $arr['UserName'];
		$records[$count]["email"] = $arr['Email'];
		$count++;
	}
	
	echo "<table style='width:.5' border ='1 px'";
	echo "<tr>";
	echo "<th>ID Number</th>";
	echo "<th>Last Name</th>";
	echo "<th>First Name</th>";
	echo "<th>Username</th>";
	echo "<th>Email</th>";
	echo "</tr>";
	for($i=0; $i<$count;$i++){
		echo "<tr>";
		echo "<td>".$records[$i]["id"]."</td>";
		echo "<td>".$records[$i]["last"]."</td>";
		echo "<td>".$records[$i]["first"]."</td>";
		echo "<td>".$records[$i]["user"]."</td>";
		echo "<td>".$records[$i]["email"]."</td>";
		echo "</tr>";
	}
	?>
	
	<form action = "9-login.php" method = "logout">
	<input type = "submit" value = "Logout"/>
	</form>
	</body>
</html>
	
	
	
	
	