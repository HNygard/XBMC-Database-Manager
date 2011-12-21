<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	Class ConfigDB
	{
		protected $connection = NULL;
		
		public function __construct()
		{
			try
			{
				$this->connection = new PDO('sqlite:../data/xbmcdm.db');
			}
			catch(PDOException $e)
			{
				$this->connection = NULL;
				echo $e->getMessage();
			}
		}
		
		public function query($sql)
		{
			return $this->connection->query($sql);
		}
		
		public function xbmcdb()
		{
			$result = array();
			$st = 'SELECT hostname,username,password,database,dbdriver,dbprefix FROM dbconnection';
			$query = $this->connection->query($st);
			foreach ($query as $row)
			{
				$result = $row;
			}
			return $result;
			
/*$config['hostname'] = "localhost";
$config['username'] = "myusername";
$config['password'] = "mypassword";
$config['database'] = "mydatabase";
$config['dbdriver'] = "mysql";
$config['dbprefix'] = "";
$config['pconnect'] = FALSE;
$config['db_debug'] = TRUE;
$config['cache_on'] = FALSE;
$config['cachedir'] = "";
$config['char_set'] = "utf8";
$config['dbcollat'] = "utf8_general_ci";*/
		}
		
		public function __destruct()
		{
			$this->connection = NULL;
		}
	}
