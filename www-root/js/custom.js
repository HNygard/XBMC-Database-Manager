/**********************
 * For the movie view *
 **********************/
// Function viewmovie, updates content navigation and content for movie info view --//
function viewmovie(id, view)														//
{																					//
	if (view)																		//
	{																				//
		$('#contentnav').load("movies/viewcontentnav?id=" + id + "&view=" + view);	//
		$('#content').load("movies/viewmovie?id=" + id + "&view=" + view);			//
		return false;																//
	}																				//
	else																			//
	{																				//
		$('#contentnav').load("movies/viewcontentnav?id=" + id);					//
		$('#content').load("movies/viewmovie?id=" + id);							//
	}																				//
	return false;																	//
}																					//
// End function viewmovie(id, view) ------------------------------------------------//

// Function editmovie, updates content navigation and content for movie edit view
function editmovie(object)
{
	var value = $("#" + object.name).find("#datacol").html();
	switch(object.name)
	{
		case 'Watched':
			value = (value == 'Yes') ? null : '1';
			break;
		case 'Title':
			var newtitle = prompt("Please enter the new title",value);
			if(newtitle != value && newtitle != null)
			{
				value = newtitle;
			}
			else if(newtitle == null ||  newtitle == value)
			{
				return false;
			}
			break;
		case 'Path':
			var newpath = prompt("Please enter the new path",value);
			if(newpath != value && newpath != null)
			{
				value = newpath;
			}
			else if(newpath == null ||  newpath == value)
			{
				return false;
			}
			break;
		case 'File':
			var newfile = prompt("Please enter the new filename",value);
			if(newfile != value && newfile != null)
			{
				value = newfile;
			}
			else if(newfile == null ||  newfile == value)
			{
				return false;
			}
			break;
		case 'Delete':
			var action = confirm("Are you sure you want to delete this item?");
			if (action==true)
			{
				$.post('/movies/delete',{ id: object.id });
				location.reload();
			}
			else
			{
				location.reload();
			}
			return false;
			break;
		default:
			return false;
			break;
	}
	$.ajax(
	{
		type: 'POST',
		url:  '/movies/edit',
		async: false,
		data: {
			id: object.id,
			what: object.name,
			to: value
		},
		success: function(data)
		{
			$('#contentnav').load("movies/viewcontentnav?id=" + object.id);
			$('#content').load("movies/viewmovie?id=" + object.id);
		},
		error: function(data)
		{
			alert("Error: " + data);
		}
	});
	return false;
}
// Function sortmovies, update movie list based on selected sorting options
function sortmovies()
{
	var sortby = $('select.sortby option:selected').val();
	var sortdir = $('select.sortdir option:selected').val();
	var filter = $('select.filterby option:selected').val();
	$('#listing').load("movies/getlist?sortby=" + sortby + "&sortdir=" + sortdir + "&filter=" + filter);
}

/************************
 * For the TV-Show view *
 ************************/
// Function viewtv, updates content navigation and content for tv-show/episode info view
function viewtv(object, view)
{
	var idshow = object.id;
	var idepisode = object.name ? object.name : '0';
	var what = $(object).attr('class');
	
	if (view)
	{
		switch (what)
		{
			case 'showlink':
				$('#contentnav').load("shows/viewcontentnav?idshow="+idshow+"&idepisode="+idepisode+"&view="+view);
				$('#content').load('shows/view?idshow='+idshow+"&idepisode="+idepisode+"&view="+view);
				$('#episodelistmenu').load('shows/getepisodesmenu?idshow='+idshow);
				$('#episodelist').load('shows/getepisodes?idshow='+idshow);
				break;
			case 'episodelink':
				$('#contentnav').load("shows/viewcontentnav?idshow=" + idshow + "&idepisode=" + idepisode+"&view="+view);
				$('#content').load('shows/view?idshow=' + idshow + "&idepisode=" + idepisode + "&view=" + view);
				break;
		}
	}
	else
	{
		switch (what)
		{
			case 'showlink':
				$('#contentnav').load("shows/viewcontentnav?idshow="+idshow+"&idepisode="+idepisode);
				$('#content').load('shows/view?idshow='+idshow+"&idepisode="+idepisode);
				$('#episodelistmenu').load('shows/getepisodesmenu?idshow='+idshow);
				$('#episodelist').load('shows/getepisodes?idshow='+idshow);
				break;
			case 'episodelink':
				$('#contentnav').load("shows/viewcontentnav?idshow=" + idshow + "&idepisode=" + idepisode);
				alert("Show ID: " + idshow + " Episode ID: " + idepisode + " View: NO! What: " + what);
				$('#content').load('shows/view?idshow=' + idshow + "&idepisode=" + idepisode);
				break;
		}
	}
	return false;
}
// Function sortshows, updates tv-show list based on sorting options
function sortshows()
{
	var sortby = $('select.sortby option:selected').val();
	var sortdir = $('select.sortdir option:selected').val();
	$('#showlist').load("shows/getlist?sortby=" + sortby + "&sortdir=" + sortdir + "&filter=" + filter);
}
// Function sortepisodes, updates episode list based on sorting options
function sortepisodes()
{
	var idshow = $('select.season option:selected').attr("id");
	var season = $('select.season option:selected').val();
	var filter = $('select.filter option:selected').val();
	//var filter = $('select.filter option:selected').val();
	$('#episodelist').load('shows/getepisodes?idshow=' + idshow + '&season='+season+'&filter='+filter);
}

/*************************
 * For the settings view *
 *************************/
function viewsettings(object)
{
	what = object.id;
	$('#content').load('settings/getsettings?what=' + what);
	return false;
}
// Function to save edited settings
function editcfg(object)
{
	var type = object.id;
	switch (type)
	{
		case 'dbcfg':
			var data = {};
			$('.'+type).each(function(index)
			{
				data['hostname'] = ($(this).attr('name') == 'Hostname') ? $(this).attr('value') : data['hostname'];
				data['username'] = ($(this).attr('name') == 'Username') ? $(this).attr('value') : data['username'];
				data['password'] = ($(this).attr('name') == 'Password') ? $(this).attr('value') : data['password'];
				data['database'] = ($(this).attr('name') == 'Database') ? $(this).attr('value') : data['database'];
				data['dbdriver'] = ($(this).attr('name') == 'Database driver') ? $(this + 'option:selected').attr('value') : data['dbdriver'];
				data['dbprefix'] = ($(this).attr('name') == 'Database prefix') ? $(this).attr('value') : data['dbprefix'];
			});
			$.ajax(
			{
				type: 'POST',
				url:  '/settings/edit',
				async: false,
				data: data,
				success: function(data)
				{
					alert("SAVED!" + data);
					$('#content').load('settings/getsettings?what=database');
				},
				error: function(data)
				{
					alert("Error: " + data);
				}
			});
			break;
		case 'usercfg':
			alert('Type: ' +type);
			break;
	}
}
