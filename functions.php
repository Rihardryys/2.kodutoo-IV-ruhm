<?php

require("config.php");
session_start();
	
	
	
	$database = "php1"; 
	function signup($email, $password, $signupEesnimi, $signupPerenimi){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_table (email, enimi, pnimi, password) VALUES (?, ?, ?, ?)");
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
			FROM user_table
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
	
	
	
	
	
	
	
	

?>