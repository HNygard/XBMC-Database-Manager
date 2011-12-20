<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	session_start();
	
	class Shows extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();														// Call the Model constructor
			$this->load->model('show');													// Init the model
		}
		
		public function index()
		{
			$this->load->helper(array('form', 'url'));									// Load the url helper
			$data['title'] = 'TV-Shows';												// Set page title
			$this->load->view('header', $data);											// Load page header
			$this->load->view('shows/navigation');										// Load page navigation
			$this->load->view('shows/sidebar');											// Load page navigation
			$this->load->view('content');												// Load page content, send $data along
			$this->load->view('footer');												// Load page footer
		}

		// Function to edit database values
		public function edit()
		{
			$editwhat = $this->input->post('what');										// Which value to edit	
			$showid = $this->input->post('idshow');										// Which show id the value belongs to
			$episodeid = $this->input->post('idepisode');								// Which show id the value belongs to
			$towhat = $this->input->post('to');											// The new value
			if($this->session->userdata('logged_in'))									// Check to see that a user is logged in
			{
				$this->show->editshow($showid, $episodeid, $editwhat, $towhat);			// If user is logged in, goto edit function
			}
		}
		
		// Function to render the html formatted list over TV-shows
		public function getlist()
		{
			if ($this->input->get('sortby') != '')										// Check to see if a sorting option is chosen
			{
				$sortby = $this->input->get('sortby');									// Get sort by value
				$sortdir = $this->input->get('sortdir');								// Get sorting direction (Ascending/descending)
				$filter = $this->input->get('filter');									// Get filter options
				$data['list'] = $this->show->getshowlinks($sortby, $sortdir, $filter);	// Puts all tv-show titles in an array (as a href)
			}
			else																		// If there is no sorting options:
			{
				$data['list'] = $this->show->getshowlinks();							// Put all tv-show titles in an array (as a href)
			}
			$this->load->view('list', $data);											// Load the list view with tv-show titles
		}
		
		// Function to render the html formatted episode list
		public function getepisodes()
		{
			$idshow = $this->input->get('idshow');
			$season = $this->input->get('season');
			$filter = $this->input->get('filter');
			
			$data['list'] = $this->show->getepisodelinks($idshow, $season, $filter);
			
			$this->load->view('list', $data);
		}

		// Function to render the html formatted episode list menu
		public function getepisodesmenu()
		{
			$idshow = $this->input->get('idshow');
			$data['seasons'] = $this->show->getseasons($idshow);
			$this->load->view('shows/episodelistmenu', $data);
		}
				
		// Function to render the html formatted tv-show/episode content
		public function view()
		{
			$idshow = $this->input->get('idshow');
			$idepisode = $this->input->get('idepisode');
			$view = $this->input->get('view');
			
			if ($view != '')														// If view isn't empty
			{
				$this->session->set_userdata('view', $this->input->get('view'));	// Set session view to view
			}
			if ($this->session->userdata('view') == '')								// If session view is empty
			{
				$this->session->set_userdata('view', 'info');		
			}
			
			switch($this->session->userdata('view'))
			{
				case 'info':
					$info = $this->show->getshowinfo($idshow);
					$this->load->view('info.php', $info);
					break;
				case 'edit':
					if($this->session->userdata('logged_in'))
					{
						$edit = $this->show->getshowedit($idshow);
						$this->load->view('shows/edit.php', $edit);
					}
					else
					{
						$info = $this->show->getshowinfo($idshow);
						$this->load->view('info.php', $info);
					}
					break;
				case 'epinfo':
					$info = $this->show->getepisodeinfo($idepisode);
					$this->load->view('info.php', $info);
					break;
				default:
					$info = $this->show->getshowinfo($idshow);
					$this->load->view('info.php', $info);
					break;
			}
		}

		// Function to render the html formatted content navigation
		public function viewcontentnav()
		{
			$data = array();
			if($this->input->get('view') != '')
			{
				$this->session->set_userdata('view', $this->input->get('view'));
			}
			if(!$this->session->userdata('view') || $this->session->userdata('view') == '')
			{
				$this->session->set_userdata('view', 'info');
			}
			$idshow = $this->input->get('idshow');
			$idepisode = $this->input->get('idepisode');
			$data['menulist'] = $this->show->getshowmenu($idshow, $idepisode, $this->session->userdata('view'));
			$data['selected'] = $this->session->userdata('view');
			$this->load->view('contentnav.php', $data);
		}
	}
/* End of file shows.php */
/* Location: ./application/controllers/shows.php */
