					<table border="0">
						<tr>
							<td>
								<select SIZE="1" class="season">
									<?php
										foreach ($seasons as $select)
										{
											echo $select;
										}
									?>
								</select>
							</td>
							<td>
								<select name="filter" SIZE="1" class="filter">
									<option value="all" id="all">All</option>
									<option value="watched" id="watched">Watched</option>
									<option value="notwatched" id="notwatched">Not Watched</option>
								</select>
							</td>
							<td>
								<input type="button" onclick="sortepisodes()" value="Refresh"/>
							</td>
						</tr>
					</table>
