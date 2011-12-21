<?php  
	class Show extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		// Edits the database ----------------------------------------------------------//
		public function editshow($id, $what, $tovalue)									//
		{																				//
			$editdata = array();														// Set editdata to empty array
			if($this->session->userdata('logged_in'))									// Check to see that a user is logged in
			{																			//
				$this->db->where('idShow', $id);										// Sets DB Where clause to the correct TV-Show ID
				switch($what)															// Switch on which value to edit
				{																		//
					case 'Watched':														// If watched is what to edit
						$editdata['playCount'] = ($tovalue == '1') ? '1' : NULL;		// Set editdata
						break;															//
					case 'Title':														// If Title is what to edit
						$editdata['c00'] = $tovalue;									// Set editdata to tovalue
						break;															//
					case 'Path':														// If Path is what to edit
						$editdata['strPath'] = $tovalue;								// Set editdata to tovalue
						break;															//
					case 'File':														// If File is what to edit
						$editdata['strFileName'] = $tovalue;							// Set editdata to tovalue
						break;															//
				}																		//
				$this->db->update('tvshow', $editdata);									// Updata tvshow table with new values
			}																			//
		}																				//
		// End function editshow() -----------------------------------------------------//

		// Creates the HTML code for the tv-show list menu -----------------------------//
		public function getshowmenu($idshow = '1', $idepisode = '0', $view = 'info')	//
		{																				//
			$menu = array();															//
			switch ($view)																//
			{																			//
				case 'info':															//
					array_push($menu,'<li id="current"><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'info\');" name="'.$idepisode.'" class="showlink">Info</a></li>');													//
					if($this->session->userdata('logged_in'))							//
					{																	//
						array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'edit\');" name="'.$idepisode.'" class="showlink">Edit</a></li>');												//
					}																	//
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" name="'.$idepisode.'" class="episodelink">Episode Info</a></li>');													//
					break;																//
				case 'edit':															//
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'info\');" name="'.$idepisode.'" class="showlink">Info</a></li>');
					array_push($menu,'<li id="current"><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'edit\');" name="'.$idepisode.'" class="showlink">Edit</a></li>');
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" name="'.$idepisode.'" class="episodelink">Episode Info</a></li>');
					break;																//
				case 'epinfo':															//
					array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'info\');" name="'.$idepisode.'" class="showlink">Info</a></li>');
					if($this->session->userdata('logged_in'))							//
					{																	//
						array_push($menu,'<li><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'edit\');" name="'.$idepisode.'" class="showlink">Edit</a></li>');
					}																	//
					array_push($menu,'<li id="current"><a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" name="'.$idepisode.'" class="episodelink">Episode Info</a></li>');
					break;																//
			}																			//
			return $menu;																//
		}																				//
		// End function getshowmenu($idshow, $idepisode, $view) ------------------------// 

		// Creates the HTML TV-show info -----------------------------------------------//
		public function getshowinfo($id = '1')											// TV-Show ID is 1 if nothing is given
		{																				//
			$info['col1'] = array();													// Info col1 and col2 is empty arrays
			$info['col2'] = array();													//
																						//
			if($this->session->userdata('logged_in'))									// Checks if user is logged in
			{																			// Sets the select clause and the corresponding names
				$select = 's.c00,COUNT(e.idEpisode),s.c05,s.c08,s.c04,s.c14,p.strPath,s.c01';
				$col1 = array('Title','Episodes','First Aired','Genre','Rating','Network','Path','Plot');
			}																			//
			else																		// If user isn't logged in
			{																			// Select the following columns from DB
				$select = 's.c00,COUNT(e.idEpisode),s.c05,s.c08,s.c04,s.c14,s.c01';		//
				$col1 = array('Title','Episodes','First Aired','Genre','Rating','Network','Plot');
			}																			//
																						//
			$this->db->select($select);													// Prepare SELECT clause
			$this->db->from('tvshow AS s');												// Select from tvshow table as s
			$this->db->join('tvshowlinkepisode AS e', 'e.idShow = s.idShow', 'left');	// Also select from tvshowlinkepisode table as e
			$this->db->join('tvshowlinkpath AS tslp', 'tslp.idShow = s.idShow', 'left');// Also select from tvshowlinkpath table as tslp
			$this->db->join('path AS p', 'p.idPath = tslp.idPath', 'left');				// And select from path table as p
			$this->db->where('s.idShow', $id);											// Select rows WHERE idShow matches
			$query = $this->db->get();													// Execute query
			$col2 = $query->row_array();												// Put the resulting array into col2 
			foreach ($col1 as $row)														// Loop through the rows in $col1
			{																			//
				array_push($info['col1'], $row);										// Put the values in info, col1, standard indexed 0-n
			}																			//
			foreach ($col2 as $row)														// Loop through the rows in $col2
			{																			//
				array_push($info['col2'], $row);										// Put the values in info, col2, standard indexed 0-n
			}																			//
			$info['col2']['4'] = number_format($info['col2']['4'], 1);					// Set rating to 1 decimal
			return $info;																// Return the info array
		}																				//
		// End function getshowinfo($id) -----------------------------------------------//

		// Creates the HTML episode info -----------------------------------------------//
		public function getepisodeinfo($id = '0')										//
		{																				//
			$info['col1'] = array();													//
			$info['col2'] = array();													//
																						//
			if($this->session->userdata('logged_in'))									//
			{																			//
				$select = 'CONCAT(strTitle,\' - \',c00),CONCAT(\'S\',c12,\' E\',c13),c05,strStudio,c03,c09,strPath,strFileName,c01,playCount,lastPlayed';
				$col1 = array('Title','Season/Episode','First Aired','Studio','Rating','Length','Path','Filename','Plot','Playcount','Last played');
			}																			//
			else																		//
			{																			//
				$select = 'CONCAT(strTitle,\' - \',c00),CONCAT(\'S\',c12,\' E\',c13),c05,strStudio,c03,c06,c01,playCount,lastPlayed';
				$col1 = array('Title','Season/Episode','First Aired','Studio','Rating','Thumb','Plot','Playcount','Last played');
			}																			//
			if($id == '0' || $id == '')													// If episode id is 0
			{																			// Means no episode is chosen yet
				array_push($info['col2'], 'Select episode');							// Print this text
				return $info;															// exit function
			}																			//
			$this->db->select($select, FALSE);											// Prepare SELECT clause
			$this->db->from('episodeview');												//
			$this->db->where('idEpisode', $id);											// Prepare WHERE clause
			$query = $this->db->get();													// Execute query
			$col2 = $query->row_array();												// Put the resulting array into col2 
			foreach ($col1 as $row)														// Loop through the rows in $col1
			{																			//
				array_push($info['col1'], $row);										// Put the values in info, col1, standard indexed 0-n
			}																			//
			foreach ($col2 as $row)														// Loop through the rows in $col2
			{																			//
				array_push($info['col2'], $row);										// Put the values in info, col2, standard indexed 0-n
			}																			//
			$info['col2']['4'] = number_format($info['col2']['4'], 1);					// Set rating to only 1 decimal
			$info['col2']['5'] = str_replace('<thumb>','<a target="_blank" href="',$info['col2']['5']);	// Replace <thumb> tag in thumb column with a href to thetvdb
			$info['col2']['5'] = str_replace('</thumb>','">The TVDB</a>',$info['col2']['5']);
			if($this->session->userdata('logged_in'))									// Check if user is logged in
			{																			//
				$info['col2']['9'] = $info['col2']['9'] ? $info['col2']['9'] : '0';		// Set the playcount to actual playcount or 0 if it is NULL
				$info['col2']['10'] = $info['col2']['10'] ? $info['col2']['10'] : 'Never';	// Set the last watched to corresponding time or Never if value is NULL
			}																			//
			else																		// If user isn't logged in
			{																			//
				$info['col2']['7'] = $info['col2']['7'] ? $info['col2']['7'] : '0';		// Set the playcount to actual playcount or 0 if it is NULL
				$info['col2']['8'] = $info['col2']['8'] ? $info['col2']['8'] : 'Never';	// Set the last watched to corresponding time or Never if value is NULL
			}																			//			
			return $info;																// Return with the info array
		}																				//
		// End function getepisodeinfo($id) --------------------------------------------//

		// Renders the TV-Show edit page -----------------------------------------------//
		public function getshowedit($id = '0', $view = 'edit')							//
		{																				//
			$edit['col1'] = array();													// edit, col1 to col3 is empty arrays
			$edit['col2'] = array();													//
			$edit['col3'] = array();													//
																						//
			$select = 'c00';															// Prepares the SELECT statement
			$col1 = array('Title');														// Sets the corresponding items in col1
																						//
			$this->db->where('idShow', $id);											// Prepare WHERE clause
			$this->db->select($select);													// Prepare SELECT clause
			$query = $this->db->get('tvshow');											// Execute query
			$col2 = $query->row_array();												// Put the resulting array into col2 
			foreach ($col1 as $row)														//
			{																			//
				array_push($edit['col1'], $row);										//
				array_push($edit['col3'], '<button id="'.$id.'" name="'.$row.'" onclick="return editshow(this);">Edit</button>');
			}																			//
			foreach ($col2 as $row)														//
			{																			//
				array_push($edit['col2'], $row);										//
			}																			//
			return $edit;																//
		}																				//
		// End function getshowedit($id, $view) ----------------------------------------//

		// Renders the HTML TV-Show links ----------------------------------------------//
		public function getshowlinks($sortby = 'c00', $sortdir = 'ASC', $filter = 'all')//
		{																				//
			$link = array();															// Link is empty array
			$this->db->select('c00,idShow');											// Prepare select statement
			$this->db->order_by("$sortby " . "$sortdir");								// Prepare sorting
			$query = $this->db->get('tvshow');											// Execute query
																						//
			foreach ($query->result() as $row)											// Loop through the results
			{																			// Create a TV-show link with the values, put in array
				array_push($link,'<a href="" id="'.$row->idShow.'" onclick="return viewtv(this,\'\');" class="showlink">'.$row->c00.'</a>');
			}																			//
			return $link;																// Return with the link array
		}																				//
		// End function getshowlinks($sortby, $sortdir, $filter) -----------------------//

		// Renders the HTML Episode links ----------------------------------------------//
		public function getepisodelinks($idshow, $season = 'all', $filter = 'all')		//
		{																				//
			$link = array();															//
			if ($season == 'all' || $season == '')										//
			{																			//
				$this->db->select('c12');												//
				$this->db->where('idShow', $idshow);									//
				$this->db->group_by('c12');												//
				$queryseasons = $this->db->get('episodeview');							//
				foreach ($queryseasons->result() as $row)								//
				{																		//
					array_push($link,'<b><h4>Season '.$row->c12.'</h4></b>');			//
					$this->db->select('c13,c00,idEpisode');								//
					$this->db->where('idShow', $idshow);								//
					if ($filter == 'watched')											//
					{																	//
						$this->db->where('playCount !=', 'NULL');						//
					}																	//
					elseif ($filter == 'notwatched')									//
					{																	//
						$this->db->where('playCount IS NULL', NULL, FALSE);				//
					}																	//
					$this->db->where('c12', $row->c12);									//
					$this->db->order_by('c13 + 0');										// Orders by Episode number, +0 to get the correct ordering
					$queryepisodes = $this->db->get('episodeview');						//
					foreach ($queryepisodes->result() as $row2)							//
					{																	//
						array_push($link,'<a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" class="episodelink" name="'.$row2->idEpisode.'">'.$row2->c13.' - '.$row2->c00.'</a>');
					}																	//
				}																		//
			}																			//
			else																		//
			{																			//
				$this->db->select('c13,c00,idEpisode');									//
				$this->db->where('idShow', $idshow);									//
				$this->db->where('c12', $season);										//
				if ($filter == 'watched')												//
				{																		//
					$this->db->where('playCount !=', 'NULL');							//
				}																		//
				elseif ($filter == 'notwatched')										//
				{																		//
					$this->db->where('playCount IS NULL', NULL, FALSE);					//
				}																		//
				$this->db->order_by('c13 + 0');											//
				$queryepisodes = $this->db->get('episodeview');							//
				foreach ($queryepisodes->result() as $row2)								//
				{																		//
					array_push($link,'<a href="" id="'.$idshow.'" onclick="return viewtv(this, \'epinfo\');" class="episodelink" name="'.$row2->idEpisode.'">'.$row2->c13.' - '.$row2->c00 . '</a>');
				}																		//
			}																			//
			return $link;																//
		}																				//
		// End function getepisodelinks($idshow, $season, $filter) ---------------------//
		
		// Returns a option list of the seasons in chosen TV-show ----------------------//
		public function getseasons($idshow)												//
		{																				//
			$seasons = array();															// seasons is empty array
			array_push($seasons,'<option value="all" id="'.$idshow.'">All</option>');	// Set first option to all seasons
			$this->db->select('c12');													// Prepare select statement (season column)
			$this->db->where('idShow', $idshow);										// Prepare where statement (idshow must match)
			$this->db->group_by('c12');													// Only get one row for each season
			$query = $this->db->get('episodeview');										// Execute query
			foreach ($query->result() as $row)											// Loop through the results
			{																			// Put each returned row into the seasons array as an option
				array_push($seasons,'<option value="'.$row->c12.'" id="'.$idshow.'">Season '.$row->c12.'</option>');
			}																			//
			return $seasons;															// Return the seasons array
		}																				//
		// End function getseasons($idshow) --------------------------------------------//
	}
/* End of file movie.php */  
/* Location: ./application/models/movie.php */  
