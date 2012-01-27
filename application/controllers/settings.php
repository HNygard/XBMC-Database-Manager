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
			$this->load->helper('form');												// Load the form helper
			$this->load->model('cfg');													// Init the model
		}																				//
		// End __construct() -----------------------------------------------------------//

		// Index controller ------------------------------------------------------------//
		public function index()															//
		{																				//
			if ($this->session->userdata('logged_in'))									// Check to see if the user is logged in
			{																			//
				$data['title'] = 'Settings';											// Set page title
				$this->load->view('common/header', $data);								// Load page header
				$this->load->view('settings/navigation', $data);						// Load navigation bar
				$this->load->view('settings/sidebar');									// Load sidebar
				$this->load->view('common/content');									// Load content
				$this->load->view('common/footer');										// Load footer
			}																			//
			else																		// If user isn't logged in
			{																			//
				redirect('main', 'refresh');											// Redirect to main page
			}																			//
		}																				//
		// End function index() --------------------------------------------------------//

		// Render the html formatted list over settings pages --------------------------//
		public function getlist()														//
		{																				//
			if ($this->session->userdata('logged_in'))									// Check to see if the user is logged in
			{																			//
				$data['list'] = $this->cfg->getsettingslist();							// Get the HTML formatted list of settings (left)
				$this->load->view('common/list', $data);								// List it
			}																			//
			else																		// If user isn't logged in
			{																			//
				redirect('main', 'refresh');											// Redirect to main page
			}																			//
		}																				//
		// End function getlist() ------------------------------------------------------//

		// Function to get view the html formatted settings content page ---------------//
		public function getsettings()													//
		{																				//
			if ($this->session->userdata('logged_in'))									// Check to see if the user is logged in
			{																			//
				$data = array();														// Data is empty array
				$what = $this->input->get('what');										// Set what to $_GET variable what
				switch ($what)															//
				{																		//
					case 'database':													// If the database settings page is requested
						$data = $this->cfg->getdbsettings();							// Set data to return value from dbsettings()
						//$attributes = array('id' => 'database');						// 
						$this->load->view('settings/dbedit', $data);						// Show the edit view
						break;															//
					case 'users':														// If the user settings page is requested
						$data = $this->cfg->getusersettings();							// do something
						$this->load->view('settings/useredit', $data);						// Show the edit view
						break;															//
				}																		//
			}																			//
			else																		// If user isn't logged in
			{																			//
				redirect('main', 'refresh');											// Redirect to main page
			}																			//
		}																				//
		// End function getsettings() --------------------------------------------------//

		// Edit database values --------------------------------------------------------//
		public function edit()															//
		{																				//
			if ($this->session->userdata('logged_in'))									// Check to see if the user is logged in
			{																			//
				$this->cfg->updatedbcfg();												// Call update db cfg function
			}																			//
			else																		// If user isn't logged in
			{																			//
				redirect('main', 'refresh');											// Redirect to main page
			}																			//
		}																				//
		// End function edit() ---------------------------------------------------------//
		
		// Class destructor ------------------------------------------------------------//
		function __destruct()															//
		{																				//
		}																				//
		// End __destruct() ------------------------------------------------------------//
	}
/* End of file settings.php */
/* Location: ./application/controllers/settings.php */
