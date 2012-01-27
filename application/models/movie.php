<?php  
	class Movie extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		public function deletemovie($id)
		{
			if($this->session->userdata('logged_in'))
			{
				$st = 'DELETE m.*,f.*,p.* FROM movie AS m LEFT JOIN files as f ON f.idFile = m.idFile LEFT JOIN path as p ON p.idPath = f.idPath WHERE m.idMovie = ';
				return $this->db->query($st . $id);
			}
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
					array_push($menu,'<a href="" class="current" id="'.$id.'" onclick="return viewmovie(this.id, \'info\');">Info</a>');
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'cast\');">Cast</a>');
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'fanart\');">Fan Art</a>');
					if($this->session->userdata('logged_in'))
					{
						array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'edit\');">Edit</a>');
					}
					break;
				case 'cast':
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'info\');">Info</a>');
					array_push($menu,'<a href="" class="current" id="'.$id.'" onclick="return viewmovie(this.id, \'cast\');">Cast</a>');
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'fanart\');">Fan Art</a>');
					if($this->session->userdata('logged_in'))
					{
						array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'edit\');">Edit</a>');
					}
					break;
				case 'fanart':
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'info\');">Info</a>');
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'cast\');">Cast</a>');
					array_push($menu,'<a href="" class="current" id="'.$id.'" onclick="return viewmovie(this.id, \'fanart\');">Fan Art</a>');
					if($this->session->userdata('logged_in'))
					{
						array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'edit\');">Edit</a>');
					}
					break;
				case 'edit':
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'info\');">Info</a>');
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'cast\');">Cast</a>');
					array_push($menu,'<a href="" id="'.$id.'" onclick="return viewmovie(this.id, \'fanart\');">Fan Art</a>');
					array_push($menu,'<a href="" class="current" id="'.$id.'" onclick="return viewmovie(this.id, \'edit\');">Edit</a>');
					break;
			}				
			return $menu;
		}

		public function getmovieinfo($id = '1')
		{
			// Sets initial variables
			$info['col1'] = array();
			$info['col2'] = array();
			$info['thumb'] = '';
			
			// Defines what to extract from database
			$select = 'c00,c15,c06,c18,c14,c07,c11,c05,c04,c03,c02,strPath,strFileName,c09,c01,playCount';
			// Defines the corresponding items
			$col1 = array('Title:','Director:','Writer:','Studio:','Genre:','Year:','Runtime:','Rating:','Tagline:','Plot Outline:<br/>','Path:<br/>','File:<br/>','External Info:','Plot:<br/>','Watched:');
			
			$this->db->where('idMovie', $id);							// Prepare WHERE clause
			$this->db->select($select);									// Prepare SELECT clause
			$query = $this->db->get('movieview', $info);				// Execute query
			$col2 = $query->row_array();								// Put the resulting array into col2 
			// Loop through the col1 array and put each value in info['col1'] indexed (0-n)
			foreach ($col1 as $row)
			{
				array_push($info['col1'], $row);
			}
			// Loop through the col2 array and put each value in info['col2'] indexed (0-n)
			foreach ($col2 as $row)
			{
				array_push($info['col2'], $row);
			}
			$info['col2'][6] .= " minutes";				// Add "minutes" after number of minutes
			$info['col2'][7] = number_format($info['col2'][7], 1).' / '.$info['col2'][8].' votes';	// Set rating to 1 decimal
			unset($info['col2'][8]);				// Removes duplicate of votes entry
			$info['col2'] = array_values($info['col2']);		// Re-index thee array

			// Format the IMDB link:
			$info['col2']['12'] = "<a href=\"http://www.imdb.com/title/" . $info['col2']['12'] . "\">IMDB</a>";
			$info['col2']['14'] = $info['col2']['14'] ? "Yes" : "No";

			$info['thumb'] = $this->configdb->hashit($info['col2'][10].$info['col2'][11]);

			//Prevent the path and filename to be shown if user not logged in
			if(!$this->session->userdata('logged_in'))
			{
				unset($info['col1'][10]);
				unset($info['col2'][10]);
				unset($info['col1'][11]);
				unset($info['col2'][11]);
				//Re-index the arrays
				$info['col1'] = array_values($info['col1']);
				$info['col2'] = array_values($info['col2']);
			}

			return $info;												// Return a array with links to the movies.
		}

		public function getmoviecast($id = '1')
		{
			$cast['actor'] = array();
			$cast['role'] = array();
			$cast['thumb'] = array();
			// Defines what to extract from database
			$select = 'idActor,strRole';
			$this->db->where('idMovie', $id);							// Prepare WHERE clause
			$query = $this->db->get('actorlinkmovie');
			foreach ($query->result() as $row)
			{
				array_push($cast['role'], $row->strRole);
				$select = 'strActor';
				$this->db->where('idActor', $row->idActor);						// Prepare WHERE clause
				$query2 = $this->db->get('actors');
				foreach ($query2->result() as $row2)
				{
					array_push($cast['actor'], $row2->strActor);
				}
			}
			foreach ($cast['actor'] as $actor)
			{
				array_push($cast['thumb'], $this->configdb->hashit('actor'.$actor));
			}
			return $cast;
		}

		public function getmoviehash($id = '1')
		{
			$hash = '';
			// Defines what to extract from database
			$select = 'strPath,strFileName';
			$this->db->where('idMovie', $id);							// Prepare WHERE clause
			$query = $this->db->get('movieview');
			foreach ($query->result() as $row)
			{
				$hash = $this->configdb->hashit($row->strPath.$row->strFileName);
			}
			return $hash;
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
			array_push($edit['col1'], 'Delete');
			array_push($edit['col2'], 'Removes the movie from the database');
			array_push($edit['col3'], '<button id="'.$id.'" name="Delete" onclick="return editmovie(this);">Delete</button>');
			return $edit;
		}			

		public function getmovielinks($sortby = 'c00', $sortdir = 'ASC', $filter = 'all')
		{
			$link = array();
			$this->db->select('c00,idMovie');
			$this->db->order_by($sortby, $sortdir);
			
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
