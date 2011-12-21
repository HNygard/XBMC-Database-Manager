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
			$this->load->model('cfg');													// Init the model
		}																				//
		// End __construct() -----------------------------------------------------------//

		// Index controller ------------------------------------------------------------//
		public function index()															//
		{																				//
			$data['title'] = 'Settings';												// Set page title
			$this->load->view('settings/header', $data);								// Load page header
			$this->load->view('settings/sidebar');										// List it
		}																				//
		// End function index() --------------------------------------------------------//

		public function getlist()
		{
			$data['list'] = $this->cfg->getsettingslist();								// Get the HTML formatted list of settings (left)
			$this->load->view('common/list', $data);									// List it
		}
				
		public function database()
		{
			$data['title'] = 'Database - Settings';										// Set page title
			$data['list'] = $this->cfg->getsettingslist();								// Get the HTML formatted list of settings (left)
			$this->load->view('settings/header', $data);								// Load page header
			$this->load->view('common/list', $data);									// List it
		}

		// Edit database values --------------------------------------------------------//
		public function edit()															//
		{																				//
			$editwhat = $this->input->post('what');										// What to edit
			$movieid = $this->input->post('id');										// Which Movie ID the value belongs to
			$towhat = $this->input->post('to');											// The new value
			if($this->session->userdata('logged_in'))									// Check to see that a user is logged in
			{																			//
				$this->movie->editmovie($movieid, $editwhat, $towhat);					// If user is logged in, call the edit function
			}																			//
		}																				//
		// End function edit() ---------------------------------------------------------//
		
		function __destruct()															//
		{																				//
		}																				//
	}
/* End of file settings.php */
/* Location: ./application/controllers/settings.php */
