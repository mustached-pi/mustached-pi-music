<?php

$tracks = track::find();

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
			<th>Size</th>
			<th>Path</th>
		</tr>
	</thead>

	<tbody>
		<?php
		foreach ($tracks as $track)
		{
			?>
			<tr>
				<td><?= $track['title']?></td>
				<td><?= $track['album']?></td>
				<td><?= $track['artist']?></td>
				<td><?= $track['year']?></td>
				<td><?= $track['genre']?></td>
				<td><?= $track['playtime_string']?></td>
				<td><?= $track['size']?></td>
				<td><audio controls src="/open.php?file=<?= $track['_id']; ?>"></audio></td>
			</tr>	
			<?php
		}
		?>
	</tbody>
</table>