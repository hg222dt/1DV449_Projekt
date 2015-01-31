<?php


class UserDAL {
	
	public function logUserIn($useremail) {

		//Se om användaren är registrerad på databasen.
		//Om inte - registrera.

		$db = null;
			
		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}


		$q = "SELECT * FROM User WHERE Email = '$useremail'";

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query5: " .$e->getMessage());
			return false;
		}

		if(isset($result[0])) {
			$result = $result[0];
			

		
		} else {

			//Om ingen användare fanns

			$this->createNewUser($useremail);

			return true;
		}


	}

	public function createNewUser($useremail) {

		$db = null;
			
		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}

		$q = "INSERT INTO User (Email) VALUES ('$useremail')";

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query6: " .$e->getMessage());
			return false;
		}

	}


	public function saveAsFavourite($userId, $geonameId) {

		$geonameId = (int) $geonameId;

		if(!$this->doesFavouriteExist($userId, $geonameId)) {

			$db = null;
				
			try {
				$db = new PDO("sqlite:database.db");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOEception $e) {
				die("Something went wrong -> " .$e->getMessage());
			}

			$q = "INSERT INTO Favourites (GeonameId, UserId) VALUES ($geonameId ,$userId)";

			$result;
			$stm;
			try {
				$stm = $db->prepare($q);
				$stm->execute();
				$result = $stm->fetchAll();
			}
			catch(PDOException $e) {
				echo("Error creating query6: " .$e->getMessage());
				return false;
			}

		}
	}


	public function doesFavouriteExist($userId, $geonameId) {

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}

		$q = "SELECT * FROM Favourites WHERE UserId = $userId AND GeonameId = $geonameId";

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query40: " .$e->getMessage());
			return false;
		}

		if(Count($result) == 0) {
			return false;
		}
		return true;
	}



	public function getUserFavouriteIds($userId) {

		$db = null;
			
		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}

		$q = "SELECT GeonameId FROM Favourites WHERE UserId = $userId";

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query40: " .$e->getMessage());
			return false;
		}

		$geonameIds = array();

		foreach ($result as $key => $value) {
			$geonameId = $value['GeonameId'];
			array_push($geonameIds, $geonameId);
		}

		//Om inga favoriter finns, returnera false
		return $geonameIds;
	
	}

}