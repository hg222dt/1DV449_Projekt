<?php


class DB
{
	protected $sqLiteDb;

	public function __construct() {
		try {
			$this->sqLiteDb = new PDO("sqlite:database.db");
			$this->sqLiteDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}
	}

	public function query($sql)
	{
		$result;
		$stm;
		try {
			$stm = $this->sqLiteDb->prepare($sql);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query: " .$e->getMessage());
			return false;
		}

		return $result;

	}

}