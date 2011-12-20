<?php
	Class User extends CI_Model
	{
		function login($username, $password)
		{
			$connection = NULL;
			try
			{
				$connection = new PDO('sqlite:../data/xbmcdm.db');
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
			// Build query
			$sql = 'SELECT username FROM members WHERE username = \'' . $username . '\' AND password = \'' . MD5($password) . '\'';
			$numrows = NULL;
			$dbuser = NULL;
			$result = $connection->query("$sql");
			// Loop through the results
			foreach ($result as $row)
			{
				$dbuser = $row['username'];
				$numrows++;
			}
			if ($numrows == 1)
			{
				return $dbuser;
			}
			else
			{
				return false;
			}
			return false;
		}
	}
?>
