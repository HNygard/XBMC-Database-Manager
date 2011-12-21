<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class VerifyLogin extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('user');
			$this->load->library('ConfigDB');
		}
		
		function index()
		{
			//This method will have the credentials validation
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
			$redir = $this->input->post('redirect');
			//$this->form_validation->run();
			if($this->form_validation->run() == FALSE)
			{
				$test = strip_tags(validation_errors());
				?>
					<script language='JavaScript' type='text/javascript'>
						var err = <?php echo json_encode($test); ?>;
						alert(err);
					</script>
				<?php
			}
			redirect($redir, 'refresh');
		}

		function check_database($password)
		{
			//Field validation succeeded.  Validate against database
			$username = $this->input->post('username');
			//query the database
			$result = $this->user->login($username, $password);
			if($result)
			{
				$user = $result;
				$this->session->set_userdata('logged_in', $user);
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('check_database', 'Invalid username or password');
				return false;
			}
		}
	}
