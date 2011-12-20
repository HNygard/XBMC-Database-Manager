<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	session_start();
	
	class Movies extends CI_Controller
	{
		function __construct()
		{
			// Call the Model constructor
			parent::__construct();
			$this->load->model('movie');										// Init the model
		}
		
		public function index()
		{
			$this->load->helper(array('form', 'url'));							// Load the url helper
			$data['title'] = 'Movies';											// Set page title
			$this->load->view('header', $data);									// Load page header
			$this->load->view('movies/navigation');								// Load page navigation
			$this->load->view('movies/sidebar');								// Load page navigation
			$this->load->view('content');										// Load page content, send $data along
			$this->load->view('footer');										// Load page footer
		}

		public function edit()
		{
			$editwhat = $this->input->post('what');
			$movieid = $this->input->post('id');
			$towhat = $this->input->post('to');
			if($this->session->userdata('logged_in'))
			{
				$this->movie->editmovie($movieid, $editwhat, $towhat);
			}
		}
		
		// Function to render the html formatted movie list
		public function getlist()
		{
			if ($this->input->get('sortby') != "")
			{
				$sortby = $this->input->get('sortby');							// Get info about movie
				$sortdir = $this->input->get('sortdir');						// Get info about movie
				$filter = $this->input->get('filter');							// Get info about movie
				$data['list'] = $this->movie->getmovielinks($sortby, $sortdir, $filter);						// Puts all movietitles in an array as "<a href="idMovie">Title</a>"
			}
			else
			{
				$data['list'] = $this->movie->getmovielinks();					// Puts all movietitles in an array as "<a href="idMovie">Title</a>"
			}
			$this->load->view('list', $data);							// Load page navigation
		}
		
		// Function to render the html formatted content
		public function viewmovie()
		{
			if ($this->input->get('view'))
			{
				$this->session->set_userdata('view', $this->input->get('view'));
			}
			switch($this->session->userdata('view'))
			{
				case 'info':
					$movieinfo = $this->movie->getmovieinfo($this->input->get('id'));		// Get info about movie
					$this->load->view('info.php', $movieinfo);					// Load page footer
					break;
				case 'edit':
					if($this->session->userdata('logged_in'))
					{
						$movieedit = $this->movie->getmovieedit($this->input->get('id'));	// Get edit page for the movie
						$this->load->view('movies/movieedit.php', $movieedit);				// Load page footer
					}
					else
					{
						$movieinfo = $this->movie->getmovieinfo($this->input->get('id'));	// Get info about movie
						$this->load->view('info.php', $movieinfo);				// Load page footer
					}
					break;
				default:
					$movieinfo = $this->movie->getmovieinfo($this->input->get('id'));		// Get info about movie
					$this->load->view('info.php', $movieinfo);					// Load page footer
					break;
			}
		}
		
		// Function to render the html formatted content navigation
		public function viewcontentnav()
		{
			$data = array();
			if(!$this->session->userdata('view'))
			{
				$this->session->set_userdata('view', 'info');
			}
			if ($this->input->get('view'))
			{
				$this->session->set_userdata('view', $this->input->get('view'));
			}
			$id = $this->input->get('id');
			$data['menulist'] = $this->movie->getmoviemenu($id, $this->session->userdata('view'));
			$data['selected'] = $this->session->userdata('view');
			$this->load->view('contentnav.php', $data);
		}
	}
/* End of file movies.php */
/* Location: ./application/controllers/movies.php */
