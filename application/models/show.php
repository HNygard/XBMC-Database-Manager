<?php  
	class Show extends CI_Model
	{
		var $view = NULL;
		
		public function editshow($id, $what, $tovalue)
		{
			$editdata = array();
			if($this->session->userdata('logged_in'))
			{
				$this->db->where('idShow', $id);
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
				$this->db->update('showview', $editdata);
			}
		}
		
		public function getshowmenu($idshow = '1', $idepisode = '0', $view = 'info')
		{
			$menu = array();
			switch ($view)
			{
				case 'info':
					array_push($menu,'<li id="current"><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'info\');" name="'.$idepisode.'" class="showlink">Info</a></li>');
					if($this->session->userdata('logged_in'))
					{
						array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'edit\');" name="'.$idepisode.'" class="showlink">Edit</a></li>');
					}
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" name="'.$idepisode.'" class="episodelink">Episode Info</a></li>');
					break;
				case 'edit':
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'info\');" name="'.$idepisode.'" class="showlink">Info</a></li>');
					array_push($menu,'<li id="current"><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'edit\');" name="'.$idepisode.'" class="showlink">Edit</a></li>');
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" name="'.$idepisode.'" class="episodelink">Episode Info</a></li>');
					break;
				case 'epinfo':
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'info\');" name="'.$idepisode.'" class="showlink">Info</a></li>');
					if($this->session->userdata('logged_in'))
					{
						array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'edit\');" name="'.$idepisode.'" class="showlink">Edit</a></li>');
					}
					array_push($menu,'<li id="current"><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" name="'.$idepisode.'" class="episodelink">Episode Info</a></li>');
					break;
			}				
			return $menu;
		}

		public function getshowinfo($id = '1')
		{
			// Sets initial variables
			$info['col1'] = array();
			$info['col2'] = array();
			
			// If user is logged in, select this from database:
			if($this->session->userdata('logged_in'))
			{
				// Defines what to extract from database
				$select = 's.c00,COUNT(e.idEpisode),s.c05,s.c08,s.c04,s.c14,p.strPath,s.c01';
				// Defines the corresponding items
				$col1 = array('Title','Episodes','First Aired','Genre','Rating','Network','Path','Plot');
			}
			else
			{
				// Defines what to extract from database
				$select = 's.c00,COUNT(e.idEpisode),s.c05,s.c08,s.c04,s.c14,s.c01';
				// Defines the corresponding items
				$col1 = array('Title','Episodes','First Aired','Genre','Rating','Network','Plot');
			}
			
			$this->db->select($select);														// Prepare SELECT clause
			$this->db->from('tvshow AS s');
			$this->db->join('tvshowlinkepisode AS e', 'e.idShow = s.idShow', 'left');
			$this->db->join('tvshowlinkpath AS tslp', 'tslp.idShow = s.idShow', 'left');
			$this->db->join('path AS p', 'p.idPath = tslp.idPath', 'left');
			$this->db->where('s.idShow', $id);												// Prepare WHERE clause
			$query = $this->db->get();														// Execute query
			$col2 = $query->row_array();													// Put the resulting array into col2 
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
			//$info['col2']['6'] .= " minutes";												// Add "minutes" after number of minutes
			$info['col2']['4'] = number_format($info['col2']['4'], 1);						// Set rating to 1 decimal
			// Format the IMDB link:
			if($this->session->userdata('logged_in'))
			{
				//$info['col2']['12'] = "<a href=\"http://www.imdb.com/title/" . $info['col2']['12'] . "\">IMDB</a>";
				//$info['col2']['14'] = $info['col2']['14'] ? "Yes" : "No";
			}
			else
			{
				//$info['col2']['10'] = "<a href=\"http://www.imdb.com/title/" . $info['col2']['10'] . "\">IMDB</a>";
				//$info['col2']['12'] = $info['col2']['12'] ? "Yes" : "No";
			}
			return $info;												// Return a array with links to the movies.
		}

		public function getepisodeinfo($id = '0')
		{
			// Sets initial variables
			$info['col1'] = array();
			$info['col2'] = array();
			
			// If user is logged in, select this from database:
			if($this->session->userdata('logged_in'))
			{
				// Defines what to extract from database if logged in
				$select = 'CONCAT(strTitle,\' - \',c00),CONCAT(\'S\',c12,\' E\',c13),c05,strStudio,c03,c09,strPath,strFileName,c01,playCount,lastPlayed';
				// Defines the corresponding items
				$col1 = array('Title','Season/Episode','First Aired','Studio','Rating','Length','Path','Filename','Plot','Playcount','Last played');
			}
			else
			{
				// Defines what to extract from database if not logged in
				$select = 'CONCAT(strTitle,\' - \',c00),CONCAT(\'S\',c12,\' E\',c13),c05,strStudio,c03,c06,c01,playCount,lastPlayed';
				// Defines the corresponding items
				$col1 = array('Title','Season/Episode','First Aired','Studio','Rating','Thumb','Plot','Playcount','Last played');
			}
			if($id == '0' || $id == '')
			{
				array_push($info['col2'], 'Select episode');
				return $info;
			}
			$this->db->select($select, FALSE);														// Prepare SELECT clause
			$this->db->from('episodeview');
			$this->db->where('idEpisode', $id);												// Prepare WHERE clause
			$query = $this->db->get();														// Execute query
			$col2 = $query->row_array();													// Put the resulting array into col2 
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
			$info['col2']['4'] = number_format($info['col2']['4'], 1);
			//$info['col2']['5'] = '<img src="'. $info['col2']['5'].'" />';
			$info['col2']['5'] = str_replace('<thumb>','<a target="_blank" href="',$info['col2']['5']);
			$info['col2']['5'] = str_replace('</thumb>','">The TVDB</a>',$info['col2']['5']);
			if($this->session->userdata('logged_in'))
			{
				$info['col2']['9'] = $info['col2']['9'] ? $info['col2']['9'] : '0';
				$info['col2']['10'] = $info['col2']['10'] ? $info['col2']['10'] : 'Never';
			}
			else
			{
				$info['col2']['7'] = $info['col2']['7'] ? $info['col2']['7'] : '0';
				$info['col2']['8'] = $info['col2']['8'] ? $info['col2']['8'] : 'Never';
			}
			
			return $info;																	// Return a array with links to the movies.
		}

		public function getshowedit($id = '0', $view = 'edit')
		{
			$edit['col1'] = array();
			$edit['col2'] = array();
			$edit['col3'] = array();

			$select = 'c00';
			$col1 = array('Title');
			
			$this->db->where('idShow', $id);							// Prepare WHERE clause
			$this->db->select($select);									// Prepare SELECT clause
			$query = $this->db->get('tvshow');						// Execute query
			$col2 = $query->row_array();								// Put the resulting array into col2 
			foreach ($col1 as $row)
			{
				array_push($edit['col1'], $row);
				array_push($edit['col3'], '<button id="'.$id.'" name="'.$row.'" onclick="return editshow(this);">Edit</button>');
			}
			foreach ($col2 as $row)
			{
				array_push($edit['col2'], $row);
			}
			return $edit;
		}			

		public function getshowlinks($sortby = 'c00', $sortdir = 'ASC', $filter = 'all')
		{
			$link = array();
			$this->db->select('c00,idShow');
			$this->db->order_by("$sortby " . "$sortdir");
			$query = $this->db->get('tvshow');

			foreach ($query->result() as $row)
			{
				array_push($link,'<a href="" id="'.$row->idShow.'" onclick="return viewtv(this,\'info\');" class="showlink">'.$row->c00.'</a>');
			}

			return $link;
		}

		public function getepisodelinks($idshow, $season = 'all', $filter = 'all')
		{
			$link = array();
			if ($season == 'all' || $season == '')
			{
				$this->db->select('c12');
				$this->db->where('idShow', $idshow);
				$this->db->group_by('c12');
				$queryseasons = $this->db->get('episodeview');
				foreach ($queryseasons->result() as $row)
				{
					array_push($link,'<b><h4>Season '.$row->c12.'</h4></b>');
					$this->db->select('c13,c00,idEpisode');
					$this->db->where('idShow', $idshow);
					if ($filter == 'watched')
					{
						$this->db->where('playCount !=', 'NULL');
					}
					elseif ($filter == 'notwatched')
					{
						$this->db->where('playCount IS NULL', NULL, FALSE);
					}
					$this->db->where('c12', $row->c12);
					$this->db->order_by('c13 + 0');
					$queryepisodes = $this->db->get('episodeview');
					foreach ($queryepisodes->result() as $row2)
					{
						array_push($link,'<a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" class="episodelink" name="'.$row2->idEpisode.'">'.$row2->c13.' - '.$row2->c00.'</a>');
					}
				}
			}
			else
			{
				$this->db->select('c13,c00,idEpisode');
				$this->db->where('idShow', $idshow);
				$this->db->where('c12', $season);
				if ($filter == 'watched')
				{
					$this->db->where('playCount !=', 'NULL');
				}
				elseif ($filter == 'notwatched')
				{
					$this->db->where('playCount IS NULL', NULL, FALSE);
				}
				$this->db->order_by('c13 + 0');
				$queryepisodes = $this->db->get('episodeview');
				foreach ($queryepisodes->result() as $row2)
				{
					array_push($link,'<a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" class="episodelink" name="'.$row2->idEpisode.'">'.$row2->c13.' - '.$row2->c00 . '</a>');
				}
			}
			return $link;
		}
		
		// Function to return a option list of the seasons in chosen TV-show (to episode list menu)
		public function getseasons($id)
		{
			$seasons = array();
			array_push($seasons,'<option value="all" id="'.$id.'">All</option>');
			$this->db->select('c12');
			$this->db->where('idShow', $id);
			$this->db->group_by('c12');
			$query = $this->db->get('episodeview');
			foreach ($query->result() as $row)
			{
				array_push($seasons,'<option value="'.$row->c12.'" id="'.$id.'">Season '.$row->c12.'</option>');
			}
			return $seasons;
		}
	}
/* End of file movie.php */  
/* Location: ./application/models/movie.php */  
