<?php

	require("functions.php");
	
	
	$signupEmail = "";
	$signupEmailError = "";
	$signupPassword = "";
	$signupPasswordError = "";
	$signupEesnimi = "";
	$signupEesnimiError = "";
	$signupPerenimi = "";
	$signupPerenimiError = "";
	
	$loginEmail = "";
	$loginEmailError = "";
	$loginPassword = "";
	$loginPasswordError = "";
	
	$gender = "";
	$genderError = "";
	$password = "";
	
	
	if (isset ($_POST["signupEmail"])) {
		
		//on olemas
		// kas emaili v�li on t�hi
		if (empty ($_POST["signupEmail"])) {
			
			// kui on t�hi
			$signupEmailError = "*Väli on kohustuslik!";
			
		} else {
			// email on olemas ja �ige
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	if (isset ($_POST["signupPassword"])) {
		
		if (empty ($_POST["signupPassword"])) {
			
			$signupPasswordError = "*Väli on kohustuslik!";
			
		} else {
			
			// parool ei olnud t�hi
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
			
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk!";
				
			}
			
		}
		
	}
	
	if (isset ($_POST["signupEesnimi"])) {
		
		//on olemas
		// kas v�li on t�hi
		if (empty ($_POST["signupEesnimi"])) {
			
			// kui on t�hi
			$signupEesnimiError = "*Väli on kohustuslik!";
			
		} else {
			// on olemas ja �ige
			$signupEesnimi = $_POST["signupEesnimi"];
			
		}
		
	} 
	
	if (isset ($_POST["signupPerenimi"])) {
		
		//on olemas
		// kas v�li on t�hi
		if (empty ($_POST["signupPerenimi"])) {
			
			// kui on t�hi
			$signupPerenimiError = "*Väli on kohustuslik!";
			
		} else {
			// on olemas ja �ige
			$signupPerenimi = $_POST["signupPerenimi"];
			
		}
		
	} 
	
	if (isset ($_POST["gender"])) {
		if (empty ($_POST["gender"])) {
			$genderError = "Väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
		
	}
	
		
	
	
	if ( $signupEmailError == "" AND
		$signupPasswordError == ""		&&
		isset ($_POST["signupPerenimi"]) &&
		isset ($_POST["signupEesnimi"]) &&
		isset ($_POST["signupEmail"]) &&
		isset ($_POST["gender"])  &&
		isset($_POST["signupPassword"])
	//viga ei olnud, k�ik v�ljad on t�idetud (&&)
	
	){
		
		//vigu ei olnud, kõik on olemas	
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo $password."<br>";
		
		signup($signupEmail, $password, $signupEesnimi, $signupPerenimi);
		
		
	}
	
	$notice = "";
	//kas kasutaja tahab sisse logida
	if ( isset($_POST["loginEmail"]) && 
		 isset($_POST["loginPassword"]) && 
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		
		$notice = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
	


?>
<!DOCTYPE html>

<html>
	<head>
		<title>Sisselogimine</title>
	</head>
	
	<body background="https://s.yimg.com/ny/api/res/1.2/Cc0nt_iFgSCb8W_7D1HFpw--/YXBwaWQ9aGlnaGxhbmRlcjtzbT0xO3c9ODAw/http://media.zenfs.com/en/homerun/feed_manager_auto_publish_494/aa2fe58bee3bd79cb1475360afcf981e">
	
	<center>
	
	<h1>Logi sisse</h1>
		<p style="color:red;"></p>
		<form method="POST" >
			
			<label>E-post</label><br>
			<input name="loginEmail" type="email">
			
			<br><br>

			<input name="loginPassword" placeholder="Parool" type="password">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">	
			
			<h1>Loo kasutaja</h1
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<label>Eesnimi</label><br>
			<input name="signupEesnimi" type="eesnimi" value="<?=$signupEesnimi;?>"> <?php echo $signupEesnimiError; ?>
			
			<br><br>
			
			<label>Perekonnanimi</label><br>
			<input name="signupPerenimi" type="perenimi" value="<?=$signupPerenimi;?>"> <?php echo $signupPerenimiError; ?>
			
			<br><br>

			<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
					
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> female<br><?php } else { ?>
				<input type="radio" name="gender" value="female" > female<br><?php } ?>
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> male<br><?php } else { ?>
				<input type="radio" name="gender" value="male" > male<br><?php } ?>
			
			<input type="submit" value="Loo kasutaja">
		
		</form>
	
	
	
	
	</center>
	
	</body>
	
	