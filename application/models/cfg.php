<?php  
	class cfg extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		public function getsettingslist()
		{
			$list = array();
			$list[0] = '<a href="" onclick="return viewsettings(this);" id="database">Database settings</a>';
			return $list;
		}
		
		public function getdbsettings()
		{
			$info['col1'] = array();
			$info['col2'] = array();
			if($this->session->userdata('logged_in'))
			{
				$col1 = array('Title','Hostname','Username','Password','Database','Database driver','Database prefix');
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
			}
			return $info;
		}
	}
/* End of file cfg.php */  
/* Location: ./application/models/cfg.php */  
