				<div id="menulist">
					<table border="0">
						<tr>
							<td>
								<select name="sortby" SIZE="1" class="sortby">
									<option value="c00" id="title">Title</option>
									<option value="c07" id="year">Year</option>
									<option value="idMovie" id="year">Added</option>
								</select>
							</td>
							<td>
								<select name="sortdir" SIZE="1" class="sortdir">
									<option value="ASC" id="asc">Ascending</option>
									<option value="DESC" id="desc">Descending</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<select name="filterby" size="1" class="filterby">
									<option value="all" id="all">All</option>
									<option value="watched" id="watched">Watched</option>
									<option value="notwatched" id="notwatched">Not watched</option>
								</select>
							</td>
							<td>
								<input type="button" onclick="sortmovies()" value="Refresh"/>
							</td>
						</tr>
					</table>
				</div>
				<div id="listing" class="list">
					<!-- Placeholder for movie/show/music list -->
					<script>
						$(document).ready(function()
						{
							$('#listing').load("movies/getlist");
						});
					</script>
				</div>
			</div>
