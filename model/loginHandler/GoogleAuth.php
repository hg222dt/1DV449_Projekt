<?php

class GoogleAuth 
{
	protected $db;
	protected $client;

	public function __construct(Google_Client $googleClient = null) 
	{
		$this->client = $googleClient;
		
		if($this->client) 
		{

			$this->client->setClientId('1007777563828-qf7sfjkv028b4ir0e3sk6slc1kji3m9q.apps.googleusercontent.com');
			$this->client->setClientSecret('BaiOu6BXppwJqRPv3lBl7zrq');
			//$this->client->setRedirectUri('http://localhost:80/test_med_oauth/index.php');
			$this->client->setRedirectUri('http://localhost:80/1DV449_Projekt/index.php');
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
/*
			$this->storeUser($this->getPayload());
*/
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
		//unset($_SESSION['logged_in_user_google_id']);
	}

}









