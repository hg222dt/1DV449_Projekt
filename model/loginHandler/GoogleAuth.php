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
			$this->client->setRedirectUri('http://www.bigmachine.se/test_med_oauth/index.php');
			$this->client->setScopes('email');
		}

	}

}









