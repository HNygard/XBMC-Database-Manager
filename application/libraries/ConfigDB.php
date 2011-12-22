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
			$sth = $this->connection->prepare('SELECT hostname,username,password,database,dbdriver,dbprefix FROM dbconnection');
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function setdbcfg($data)
		{
			$sth = $this->connection->prepare('UPDATE dbconnection SET hostname=?, username=?, password=?, database=?, dbdriver=?, dbprefix=?');
			$host = $data['hostname'];
			$user = $data['username'];
			$pass = $data['password'];
			$db = $data['database'];
			$driver = $data['dbdriver'];
			$prefix = $data['dbprefix'];
			$sth->execute(array($host,$user,$pass,$db,$driver,$prefix)) or die(print_r($sth->errorInfo(), true));
		}
		
		public function __destruct()
		{
			$this->connection = NULL;
		}
	}
