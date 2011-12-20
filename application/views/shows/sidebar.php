				<div id="showlistmenu">
					<table border="0">
						<tr>
							<td>
								<select name="sortby" SIZE="1" class="sortby">
									<option value="c00" id="title">Title</option>
									<option value="c05" id="year">First aired</option>
									<option value="idShow" id="year">Added</option>
								</select>
							</td>
							<td>
								<select name="sortdir" SIZE="1" class="sortdir">
									<option value="ASC" id="asc">Ascending</option>
									<option value="DESC" id="desc">Descending</option>
								</select>
							</td>
							<td>
								<input type="button" onclick="sortshows()" value="Refresh"/>
							</td>
						</tr>
					</table>
				</div>
				<div id="showlist" class="list">
					<!-- Placeholder for movie/show/music list -->
					<script>
						$(document).ready(function()
						{
							$('#showlist').load("shows/getlist");
						});
					</script>
				</div>
				<div id="episodelistmenu">
				</div>
				<div id="episodelist" class="list">
				</div>
			</div>
