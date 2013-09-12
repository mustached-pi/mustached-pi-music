$(document).ready(function() {

	// This is your default javascript file
	$("#thePlayer").bind("ended", function() {
		console.log("A track has ended.");
	});

	$("#theSearchButton").click ( function() {
		searchTrack(
			$("#theSearchInput").val()
		);
		return false;
	});

});

function playTrack(trackID) {
	$("#thePlayer").attr('src', '/open.php?id=' + trackID);
	$("#thePlayer").trigger("play");
}

function api( functionName, data, callback ) {
	$.post('/api.php?a=' + functionName,
		data,
		function(x) {
			callback(x.response)
		},
		'json'
	);
}

function searchTrack( query ) {
	$("#theSearchInput").addClass('disabled');
	api('search', { query: query }, function (results) {
		$("#theSearchInput").removeClass('disabled');
		paintTable(results);
	});
	$("#theSearchInput").val(query).focus().select();
}

function paintTable ( results ) {

	$("#theContent").hide();
	$("#theTable").hide();
	var string = '';
	for ( var i in results ) {
		string += "<tr>\n";
		string += " <td>" + results[i].title + "</td>\n";
		string += " <td><a onclick='searchTrack(\"" + results[i].album + "\");'>" + results[i].album + "</a></td>\n";
		string += " <td><a onclick='searchTrack(\"" + results[i].artist + "\");'>" + results[i].artist + "</a></td>\n";
		string += " <td>" + results[i].year + "</td>\n";
		string += " <td>" + results[i].genre + "</td>\n";
		string += " <td>" + results[i].playtime + "</td>\n";
		string += " <td><a onclick='playTrack(\"" + results[i].id + "\");'><i class='icon-play'></i> Play</a></td>\n";
		string += "</tr>\n";
	}
	$("#theTable tbody").html(string);
	$("#theTable").show();
	$("#theTableDescription").html("<i class='icon-search'></i> Found " + results.length + " tracks");
}

/*
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
            */