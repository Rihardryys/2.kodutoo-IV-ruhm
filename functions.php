<?php
require("../config.php");
session_start();
	
	
	
	$database = "if16_rihard_4"; 
	function signup($email, $password, $signupEesnimi, $signupPerenimi){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, enimi, pnimi, password) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		//asendan küsimärgid
		//iga märgi kohta tuleb lisada üks täht - mis muutuja on
		// s-string
		// i- int
		// d - double
		$stmt->bind_param("ssss", $email, $signupEesnimi, $signupPerenimi, $password);
		if($stmt->execute() ) {
			echo "õnnestus";
		}else{"ERROR".$stmt->error;
			
			
		}
	
	}
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, email, password
			FROM user_sample
			WHERE email = ?
		");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//rea kohta tulba väärtus
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		
		$stmt->execute();
		
		//ainult SELECT'i puhul
		if($stmt->fetch()) {
			// oli olemas, rida käes
			//kasutaja sisestas sisselogimiseks
			$hash = hash("sha512", $password);
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja $id logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				//echo "ERROR";
				
				header("Location: leht2.php");
				
			} else {
				$notice = "parool vale";
			}
			
			
		} else {
			
			//ei olnud ühtegi rida
			$notice = "Sellise emailiga ".$email." kasutajat ei ole olemas";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		return $notice;
		
		
		
		
		
	}
	
	function saveEvent($age, $color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO whistle (age, color) VALUE (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("is", $age, $color);
		
		if ( $stmt->execute() ) {
			echo "õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllPeople() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, age, color
			FROM whistle
		");
		$stmt->bind_result($id, $age, $color);
		$stmt->execute();
		
		$results = array();
		
		// tsükli sisu tehakse nii mitu korda, mitu rida
		// SQL lausega tuleb
		while ($stmt->fetch()) {
			
			$human = new StdClass();
			$human->id = $id;
			$human->age = $age;
			$human->lightColor = $color;
			
			
			//echo $color."<br>";
			array_push($results, $human);
			
		}
		
		return $results;
		
	}
	
	
	function cleanInput($input) {
		
		
		$input = trim($input);
		
		
		// võtab välja \
		$input = stripslashes($input);
		
		// html asendab, nt "<" saab "&lt;"
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
	
	
	
	
	
	
	
?>
