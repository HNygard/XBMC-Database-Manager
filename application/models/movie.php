<?php  
	class Movie extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		public function editmovie($id, $what, $tovalue)
		{
			$editdata = array();
			if($this->session->userdata('logged_in'))
			{
				$this->db->where('idMovie', $id);
				switch($what)
				{
					case 'Watched':
						$editdata['playCount'] = ($tovalue == '1') ? '1' : NULL;
						break;
					case 'Title':
						$editdata['c00'] = $tovalue;
						break;
					case 'Path':
						$editdata['strPath'] = $tovalue;
						break;
					case 'File':
						$editdata['strFileName'] = $tovalue;
						break;
				}
				$this->db->update('movieview', $editdata);
			}
		}
		
		public function getmoviemenu($id = '1', $view = 'info')
		{
			$menu = array();
			switch ($view)
			{
				case 'info':
					array_push($menu,'<li id="current"><a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'info\');">Info</a></li>');
					if($this->session->userdata('logged_in'))
					{
						array_push($menu,'<li><a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'edit\');">Edit</a></li>');
					}
					break;
				case 'edit':
					array_push($menu,'<li><a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'info\');">Info</a></li>');
					array_push($menu,'<li id="current"><a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'edit\');">Edit</a></li>');
					break;
			}				
			return $menu;
		}

		public function getmovieinfo($id = '1')
		{
			// Sets initial variables
			$info['col1'] = array();
			$info['col2'] = array();
			
			// If user is logged in, select this from database:
			if($this->session->userdata('logged_in'))
			{
				// Defines what to extract from database
				$select = 'c00,c15,c06,c18,c14,c07,c11,c05,c03,c02,strPath,strFileName,c09,c01,playCount';
				// Defines the corresponding items
				$col1 = array('Title','Director','Writer','Studio','Genre','Year','Runtime','Rating','Tagline','Plot Outline','Path','File','External Info','Plot','Watched');
			}
			else
			{
				// Defines what to extract from database
				$select = "c00,c15,c06,c18,c14,c07,c11,c05,c03,c02,c09,c01,playCount";
				// Defines the corresponding items
				$col1 = array("Title","Director","Writer","Studio","Genre","Year","Runtime","Rating","Tagline","Plot Outline","External Info","Plot","Watched");
			}
			
			$this->db->where('idMovie', $id);							// Prepare WHERE clause
			$this->db->select($select);									// Prepare SELECT clause
			$query = $this->db->get('movieview', $info);				// Execute query
			$col2 = $query->row_array();								// Put the resulting array into col2 
			// Loop through the col1 array and put each value in info['col1'] standard indexed (0-n)
			foreach ($col1 as $row)
			{
				array_push($info['col1'], $row);
			}
			// Loop through the col2 array and put each value in info['col2'] standard indexed (0-n)
			foreach ($col2 as $row)
			{
				array_push($info['col2'], $row);
			}
			$info['col2']['6'] .= " minutes";							// Add "minutes" after number of minutes
			$info['col2']['7'] = number_format($info['col2']['7'], 1);	// Set rating to 1 decimal
			// Format the IMDB link:
			if($this->session->userdata('logged_in'))
			{
				$info['col2']['12'] = "<a href=\"http://www.imdb.com/title/" . $info['col2']['12'] . "\">IMDB</a>";
				$info['col2']['14'] = $info['col2']['14'] ? "Yes" : "No";
			}
			else
			{
				$info['col2']['10'] = "<a href=\"http://www.imdb.com/title/" . $info['col2']['10'] . "\">IMDB</a>";
				$info['col2']['12'] = $info['col2']['12'] ? "Yes" : "No";
			}
			return $info;												// Return a array with links to the movies.
		}

		public function getmovieedit($id = '0', $view = 'edit')
		{
			$edit['col1'] = array();
			$edit['col2'] = array();
			$edit['col3'] = array();

			$select = 'c00,strPath,strFileName,playCount';
			$col1 = array('Title','Path','File','Watched');
			
			$this->db->where('idMovie', $id);							// Prepare WHERE clause
			$this->db->select($select);									// Prepare SELECT clause
			$query = $this->db->get('movieview');						// Execute query
			$col2 = $query->row_array();								// Put the resulting array into col2 
			foreach ($col1 as $row)
			{
				array_push($edit['col1'], $row);
				array_push($edit['col3'], '<button id="'.$id.'" name="'.$row.'" onclick="return editmovie(this);">Edit</button>');
			}
			foreach ($col2 as $row)
			{
				array_push($edit['col2'], $row);
			}
			return $edit;
		}			

		public function getmovielinks($sortby = 'c00', $sortdir = 'ASC', $filter = 'all')
		{
			$link = array();
			$this->db->select('c00,idMovie');
			$this->db->order_by($sortby);

			if ($filter == 'watched')
			{
				$this->db->where('playCount !=', 'NULL');
			}
			elseif ($filter == 'notwatched')
			{
				$this->db->where('playCount IS NULL', NULL, FALSE);
			}

			$query = $this->db->get('movieview');

			foreach ($query->result() as $row)
			{
				array_push($link,'<a href="" id="'.$row->idMovie.'" onclick="return viewmovie(this.id);">'.$row->c00.'</a>');
			}

			return $link;						// Return a array with links to the movies.
		}
	}
/* End of file movie.php */  
/* Location: ./application/models/movie.php */  
