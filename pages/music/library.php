<?php

$tracks = Track::find();

?>

<table class="table table-striped">

	<thead>
		<tr>
			<th>Title</th>
			<th>Album</th>
			<th>Artist</th>
			<th>Year</th>
			<th>Genre</th>
			<th>Lenght</th>
			<th>Play</th>
		</tr>
	</thead>

	<tbody>
		<?php
		foreach ($tracks as $track) {
			$track = Track::object($track);
			?>
			<tr>
				<td><?= $track->title; ?></td>
				<td><?= $track->album; ?></td>
				<td><?= $track->artist; ?></td>
				<td><?= $track->year; ?></td>
				<td><?= $track->genre; ?></td>
				<td><?= $track->playtime(); ?></td>
				<td>
					<a onclick="playTrack('<?= $track; ?>');">
						<i class="icon-play"></i>
						Play
					</a>
				</td>
			</tr>	
			<?php
		}
		?>
	</tbody>
</table>