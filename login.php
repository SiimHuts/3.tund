<?php
//mvp idee - 

	require("../../config.php");
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	
	//MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$loginEmailError = "";
	$loginPasswordError = "";
	$signupEmail = "";
	$gender = "female";
	
	// kas e-post oli olemas
	
	if ( isset ( $_POST["signupEmail"] ) ) {
		
		if ( empty ( $_POST["signupEmail"] ) ) {
		
			// oli email, kuid see oli tühi
			$signupEmailError = "Insert correct e-mail!";
		
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}
		
	
		if ( isset ( $_POST["signupPassword"] ) ) {
		
			if ( empty ( $_POST["signupPassword"] ) ) {
		
				// oli email, kuid see oli tühi
				$signupPasswordError = "Insert correct password!";
			
			} else {
				
				if ( strlen($_POST["signupPassword"]) < 8 ) {
					
					$signupPasswordError="Password must be atleast 8 character long!";
					
				}
			}
		}
		
	if ( isset ( $_POST["loginEmail"] ) ) {
			
		if ( empty ( $_POST["loginEmail"] ) ) {
				
			$loginEmailError = "Insert your e-mail!";
				
		}
			
	}

	if ( isset ( $_POST["loginPassword"] ) ) {
		
		if ( empty ($_POST["loginPassword"] ) ) {
			
			$loginPasswordError = "Insert your password!";
			
		}
		
	}
	
	
	// Kus tean et yhtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword"])  &&
		 isset($_POST["signupEmail"])  &&
		 empty($signupEmailError) &&
		 empty($signupPasswordError) 
		) {
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash ("sha512", $_POST["signupPassword"]);
		
		echo"parool ".$_POST["signupPassword"]."<br>";
		echo"r2si ".$password."<br>";
		
		//echo $serverUsername;
		//echo $serverPassword;
		
		$database = "if16_siim_1";
		
		$mysqli = new mysqli($serverHost,$serverUsername,$serverPassword,$database);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email,password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		//s - string
		//i - integer
		//d - double/float
		$stmt->bind_param("ss", $signupEmail, $password); 
		
		if ($stmt->execute()) {
			
			echo "salvestamine 6nnestus";
		} else {
			echo "ERROR" .$stmt->error;
			
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Log in or Sign up</title>
	</head>
	<body>

	<h1>Log in</h1>
		<form method = "POST">
			<fieldset>
				<legend>Existing users.</legend>
				<lable>E-mail</lable><br> 
				<input name = "loginEmail" type = "email" placeholder = "E-mail"> <?php echo $loginEmailError; ?>
				
				<br><br>
				<lable>Password</lable><br>
				<input name = "loginPassword" type = "password" placeholder = "Password"> <?php echo $loginPasswordError?>
				
				<br><br>
				
				<input  type = "submit" value="Log in">
			</fieldset>	
		</form>
		
	<h1>Sign up</h1>
		<form method = "POST">
			<fieldset>
				<legend>Create a new user.</legend>
				<lable>E-mail</lable><br> 
				<input name = "signupEmail" type = "email" placeholder = "E-mail" value = "<?= $signupEmail;?>"> <?php  echo $signupEmailError; ?>
				
				<br><br>
				<lable>Password</lable><br>
				<input name = "signupPassword" type = "password" placeholder = "Password"> <?php  echo $signupPasswordError; ?>
				
				<br><br>
				<lable>Gender</lable><br>
				<?php if ($gender == "female") { ?>
					<input type="radio" name="gender" value="female" checked>Female
				<?php } else { ?>
					<input type="radio" name="gender" value="female" > Female<br>
				<?php } ?>
				
				<?php if ($gender == "male") { ?>
					<input type="radio" name="gender" value="male" checked> Male<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="male" > Male<br>
				<?php } ?>
				<br><br>
				<lable>Date of Birth</lable><br>
				<input type="date" name="bday">
				<br><br>
				<input  type = "submit" value="Sign up">
			</fieldset>
		</form>
	</body>
</html>

