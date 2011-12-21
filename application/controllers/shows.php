<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	session_start();
	
	class Shows extends CI_Controller
	{
		// Class constructor -----------------------------------------------------------//
		function __construct()															//
		{																				//
			parent::__construct();														// Calls the parent class constructor
			$this->load->model('show');													// Init the model
			$this->load->library('ConfigDB');											// Load the database config class
			$dbconn = $this->configdb->xbmcdb();										// Gets the XBMC Database connection config
			$this->load->database($dbconn);												// Loads the XBMC Database
		}																				//
		// End __construct() -----------------------------------------------------------//
		
		// Index controller ------------------------------------------------------------//
		public function index()															//
		{																				//
			$this->load->helper(array('form', 'url'));									// Load the url helper
			$data['title'] = 'TV-Shows';												// Set page title
			$this->load->view('common/header', $data);									// Load page header
			$this->load->view('shows/navigation');										// Load page navigation
			$this->load->view('shows/sidebar');											// Load page navigation
			$this->load->view('common/content');										// Load page content, send $data along
			$this->load->view('common/footer');											// Load page footer
		}																				//
		// End function index() --------------------------------------------------------//

		// Edit database values --------------------------------------------------------//
		public function edit()															//
		{																				//
			$editwhat = $this->input->post('what');										// What to edit	
			$showid = $this->input->post('idshow');										// Which show id the value belongs to
			$episodeid = $this->input->post('idepisode');								// Which episode id the value belongs to
			$towhat = $this->input->post('to');											// The new value
			if($this->session->userdata('logged_in'))									// Check to see that a user is logged in
			{																			//
				$this->show->editshow($showid, $episodeid, $editwhat, $towhat);			// If user is logged in, call edit function in model
			}																			//
		}																				//
		// End function edit()----------------------------------------------------------//

		// Renders the html formatted list over TV-shows -------------------------------//
		public function getlist()														//
		{																				//
			if ($this->input->get('sortby') != '')										// Check to see if a sorting option is chosen
			{																			//
				$sortby = $this->input->get('sortby');									// Get sortby value
				$sortdir = $this->input->get('sortdir');								// Get sorting direction (Ascending/descending)
				$filter = $this->input->get('filter');									// Get filter options
				$data['list'] = $this->show->getshowlinks($sortby, $sortdir, $filter);	// Puts all tv-show titles in an array (as a href)
			}																			//
			else																		// If there is no sorting options:
			{																			//
				$data['list'] = $this->show->getshowlinks();							// Put all tv-show titles in an array (as a href)
			}																			//
			$this->load->view('common/list', $data);									// Load the list view with tv-show titles
		}																				//
		// End function getlist()-------------------------------------------------------//
		
		// Renders the html formatted episode list -------------------------------------//
		public function getepisodes()													//
		{																				//
			$idshow = $this->input->get('idshow');										// TV-Show ID
			$season = $this->input->get('season');										// Which season
			$filter = $this->input->get('filter');										// Get filter option (watched/not watched)
			$data['list'] = $this->show->getepisodelinks($idshow, $season, $filter);	// Put all the episode titles in an array
			$this->load->view('common/list', $data);									// Load the list view with episode titles
		}																				//
		// End function getepisodes()---------------------------------------------------//

		// Renders the html formatted episode list menu --------------------------------//
		public function getepisodesmenu()												//
		{																				//
			$idshow = $this->input->get('idshow');										// TV-Show ID
			$data['seasons'] = $this->show->getseasons($idshow);						// Get the seasons for the TV-Show
			$this->load->view('shows/episodelistmenu', $data);							// Load the list menu
		}																				//
		// End function getepisodesmenu() ----------------------------------------------//
				
		// Renders the html formatted tv-show/episode content --------------------------//
		public function view()															//
		{																				//
			$idshow = $this->input->get('idshow');										// TV-Show ID
			$idepisode = $this->input->get('idepisode');								// Episode ID
			$view = $this->input->get('view');											// Which view (episode info etc)
																						//
			if ($view != '')															// If view is set
			{																			//
				$this->session->set_userdata('view', $this->input->get('view'));		// Set session view to view
			}																			//
			if ($this->session->userdata('view') == '')									// If session view is empty
			{																			//
				$this->session->set_userdata('view', 'info');							// Set session view to info
			}																			//
																						//
			switch($this->session->userdata('view'))									//
			{																			//
				case 'info':															// If view is info
					$info = $this->show->getshowinfo($idshow);							// Get the showinfo
					$this->load->view('common/info.php', $info);						// Load the info view
					break;																//
				case 'edit':															// If view is edit
					if($this->session->userdata('logged_in'))							// Check to see that a user is logged in
					{																	//
						$edit = $this->show->getshowedit($idshow);						// Get edit items
						$this->load->view('shows/edit.php', $edit);						// Load the edit view
					}																	//
					else																// IF user isn't logged in
					{																	//
						$info = $this->show->getshowinfo($idshow);						// Get the show info
						$this->load->view('common/info.php', $info);					// And load the info view instead
					}																	//
					break;																//
				case 'epinfo':															// If view is episode info
					$info = $this->show->getepisodeinfo($idepisode);					// Get episode info
					$this->load->view('common/info.php', $info);						// Load the info view
					break;																//
				default:																// If a view isn't matched
					$info = $this->show->getshowinfo($idshow);							// Get show info
					$this->load->view('common/info.php', $info);						// Load info view
					break;																//
			}																			//
		}																				//
		// End function view() ---------------------------------------------------------//

		// Renders the html formatted content navigation -------------------------------//
		public function viewcontentnav()												//
		{																				//
			$data = array();															// Set data to empty array
			if($this->input->get('view') != '')											// If view isn't empty
			{																			//
				$this->session->set_userdata('view', $this->input->get('view'));		// set session view to view
			}																			//
			if(!$this->session->userdata('view') || $this->session->userdata('view') == '')	// If session view isn't set or session view is empty
			{																			//
				$this->session->set_userdata('view', 'info');							// Set session view to info
			}																			//
			$idshow = $this->input->get('idshow');										// TV-Show ID
			$idepisode = $this->input->get('idepisode');								// Episode ID
			$view = $this->session->userdata('view');									// View
			$data['menulist'] = $this->show->getshowmenu($idshow, $idepisode, $view);	// Get the content navigation menu items
			$data['selected'] = $this->session->userdata('view');						// The selected menu item is same as view
			$this->load->view('common/contentnav.php', $data);							// Load the content navigation menu
		}																				//
		// End function viewcontentnav() -----------------------------------------------//

		// Destructor ------------------------------------------------------------------//
		function __destruct()															//
		{																				//
			$this->db->close;															// Closes the database connection
		}																				//
		// End of __destruct() ---------------------------------------------------------//
	}
/* End of file shows.php */
/* Location: ./application/controllers/shows.php */
