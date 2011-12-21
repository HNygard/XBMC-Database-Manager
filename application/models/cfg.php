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
			$list[0] = '<a href="settings/database">Database settings</a>';
			return $list;
		}
	}
/* End of file cfg.php */  
/* Location: ./application/models/cfg.php */  
