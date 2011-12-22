<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	session_start();
	
	class Settings extends CI_Controller
	{
		// Class constructor -----------------------------------------------------------//
		function __construct()															//
		{																				//
			parent::__construct();														// Calls the parent class constructor
			$this->load->library('ConfigDB');											// Load the database config class
			$this->load->helper('form');
			$this->load->model('cfg');													// Init the model
		}																				//
		// End __construct() -----------------------------------------------------------//

		// Index controller ------------------------------------------------------------//
		public function index()															//
		{																				//
			$data['title'] = 'Settings';												// Set page title
			$this->load->view('common/header', $data);									// Load page header
			$this->load->view('settings/navigation', $data);							// Load navigation bar
			$this->load->view('settings/sidebar');										// Load sidebar
			$this->load->view('common/content');										// Load content
			$this->load->view('common/footer');											// Load footer
		}																				//
		// End function index() --------------------------------------------------------//

		// -----------------------------------------------------------------------------//
		public function getlist()														//
		{																				//
			$data['list'] = $this->cfg->getsettingslist();								// Get the HTML formatted list of settings (left)
			$this->load->view('common/list', $data);									// List it
		}																				//
		// -----------------------------------------------------------------------------//

		// -----------------------------------------------------------------------------//
		public function getsettings()													//
		{
			$data = array();
			$what = $this->input->get('what');
			switch ($what)
			{			
				case 'database':
					$data = $this->cfg->getdbsettings();
					$attributes = array('id' => 'database');
					break;
				case 'users':
					something;
					break;
			}
			$this->load->view('settings/edit', $data);
		}																				//
		// -----------------------------------------------------------------------------//

		// Edit database values --------------------------------------------------------//
		public function edit()															//
		{																				//
			$this->cfg->updatedbcfg();
		}																				//
		// End function edit() ---------------------------------------------------------//
		
		function __destruct()															//
		{																				//
		}																				//
	}
/* End of file settings.php */
/* Location: ./application/controllers/settings.php */
