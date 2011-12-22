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
		
		public function __destruct()
		{
			$this->connection = NULL;
		}
	}
