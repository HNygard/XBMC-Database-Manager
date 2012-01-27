<?php  
	class cfg extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		public function getsettingslist()
		{
			if ($this->session->userdata('logged_in'))
			{
				$list = array();
				$list[0] = '<a href="" onclick="return viewsettings(this);" id="database">Database settings</a>';
				$list[1] = '<a href="" onclick="return viewsettings(this);" id="users">User settings</a>';
				return $list;
			}
			return NULL;
		}
		
		public function getdbsettings()
		{
			if ($this->session->userdata('logged_in'))
			{
				$info['col1'] = array();
				$info['col2'] = array();
				$col1 = array('dbcfg','Hostname','Username','Password','Database','Database driver','Database prefix');
				foreach ($col1 as $row)
				{
					array_push($info['col1'], $row);
				}
				$info['col2']['0'] = 'Database Settings';
				$query = $this->configdb->xbmcdb();
				foreach ($query as $row)
				{
					array_push($info['col2'], $row);
				}
				return $info;
			}
			return NULL;
		}
		
		public function getusersettings()
		{
			if ($this->session->userdata('logged_in'))
			{
				$info['col1'] = array();
				$info['col2'] = array();
				$info['col1']['0'] = 'usercfg';
				$info['col2']['0'] = 'User settings';
				
				$query = $this->configdb->user();
				array_push($info['col1'], 'Username');
				array_push($info['col1'], 'Password');
				foreach ($query as $row)
				{
					array_push($info['col2'], $row);
				}
				return $info;
			}
			return NULL;
		}
		
		public function updatedbcfg()
		{
			if ($this->session->userdata('logged_in'))
			{
				$post = $this->input->post();
				$this->configdb->setdbcfg($post);
			}
			return NULL;
		}
	}
/* End of file cfg.php */  
/* Location: ./application/models/cfg.php */  
