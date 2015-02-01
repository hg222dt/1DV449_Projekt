<?php

class GoogleAuth 
{
	protected $db;
	protected $client;

	public function __construct(DB $db = null, Google_Client $googleClient = null) 
	{
		$this->db = $db;
		$this->client = $googleClient;
		
		if($this->client) 
		{

			$this->client->setClientId('1007777563828-qf7sfjkv028b4ir0e3sk6slc1kji3m9q.apps.googleusercontent.com');
			$this->client->setClientSecret('BaiOu6BXppwJqRPv3lBl7zrq');
			//$this->client->setRedirectUri('http://localhost:80/test_med_oauth/index.php');
			
			$this->client->setRedirectUri('http://localhost:80/1DV449_Projekt/index.php');
//			$this->client->setRedirectUri('http://localhost:80/1DV449_Projekt/signinPage.php');

			//$this->client->setRedirectUri('http://www.bigmachine.se/test_med_oauth/index.php');
			$this->client->setScopes('email');
		}

	}

	public function isLoggedIn() 
	{
		return isset($_SESSION['access_token']);
	}

	public function getAuthUrl() 
	{
		return $this->client->createAuthUrl();
	}

	public function checkRedirectCode() 
	{
		if(isset($_GET['code']))
		{
			$this->client->authenticate($_GET['code']);

			$this->setToken($this->client->getAccessToken());

			$this->storeUser($this->getPayload());

			return true;
		}

		return false;
	}

	public function setToken($token) 
	{
		$_SESSION['access_token'] = $token;
		$this->client->setAccessToken($token);
	}

	public function logout() 
	{
		unset($_SESSION['access_token']);
		unset($_SESSION['logged_in_user_google_id']);
	}

	protected function getPayload() 
	{
		$payload = $this->client->verifyIdToken()->getAttributes()['payload'];

		return $payload;
	}

	protected function storeUser($payload) 
	{
/*
		var_dump(gettype($payload['id']));
		var_dump($payload['id']);
		$_SESSION['logged_in_user_google_id'] = $payload['id'];
		var_dump($_SESSION['logged_in_user_google_id']);
*/
		//die();

		$sql = "SELECT * FROM google_users WHERE google_id = {$payload['id']}";

		$userCandidateData = $this->db->query($sql);


		if(Count($userCandidateData) == 0)
		{
			$sql = "INSERT INTO google_users (google_id, email)
			VALUES({$payload['id']}, '{$payload['email']}')
			";

			$this->db->query($sql);
		}
		
		$_SESSION['logged_in_user_google_id'] = $payload['id'];
	
	}

	public function getUserGoogleId() 
	{
		if(isset($_SESSION['logged_in_user_google_id'])) 
		{
			return $_SESSION['logged_in_user_google_id'];
		}
	}

	public function getUserIdFromGoogleId($user_google_id) {
		return $this->db->getUserIdFromGoogleId($user_google_id);
	}

}









