<!DOCTYPE html>
	<head>
		<title>
			Login Page
		</title>
	</head>
	<body>
	
	<!--
		Back-end of Login HTML
		1. Load Database
		2. Get Records
		3. Check user-pw pair's existance in DB1.
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
		$selectDB = mysqli_select_db($sqlconnect,'db1');
		if(!$selectDB){
			die("Database not connected." . mysqli_error());
		}
		
		// Get username-pw 
		$records = array( array("user"=> null, "pass"=> null,));	
		$recordsDB = mysqli_query($sqlconnect,"select * from Records");
		$count = 0;
		while($arr = mysqli_fetch_array($recordsDB)){
			$records[$count]["user"] = $arr['UserName'];
			$records[$count]["pass"] = $arr['Password'];
			$count++;
		}
		
		//Initializing Variables
		$username = $password = "";
		$userErr = $passErr = "";
		//Verifs
		$userVer = 0;
		$passVer = 0;
		$idNum = 0;
		
		//Error check and catch
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			//UserName Check
			if(empty($_POST["username"])){
				$userErr = "Please input a Username!";
			} else {
				//Check if username is in DB1
				$username = formatdata($_POST["username"]);
				for($idNum; $idNum < $count; $idNum++){
					if($username == $records[$idNum]["user"]){
						$userVer = 1; //Found in Database
						break;
					}
				}
			}
			
			//Error message for UserName not found.
			if($userVer == 0 && !empty($_POST["username"])){
				$userErr = "Username does not exist!";
			}
			
			//PW check
			if(empty($_POST["password"])){
				$passErr = "Please input a Password!";
			} else {
				$password = formatdata($_POST["password"]);
				if($userVer == 1){
					//If Found
					if($password == $records[$idNum]["pass"]){
						$passVer = 1;
					} else {
						$passErr = "Password does not match!";
						echo "<script>alert('Password does not match!')</script>";
					}
				}
			}
		}
		
	?>
	
	<!-- Front-End -->
	<p>
		Student Login
	</p>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
		<table>
			<tr>
				<td>Username: </td>
				<td><input type="text" name="username"/><span class="error"><?php echo $userErr;?></span></td>
			</tr>
			<tr>
				<td>Password: </td>
				<td><input type="password" name="password"/><span class="error"><?php echo $passErr;?></span></td>
			</tr>
		</table>
		<input type="submit" value="Login" />
	</form>
	<br>
	Not yet registered?
	<form action="9-reg.php" method="post">
	<input type="submit" value="Create Account" />
	</form>
	
	<!-- If right creds -->
	<?php
		if($userVer == 1 && $passVer == 1){
			header("Location: 9-home.php");
		}
	?>
</body>
</html>
