$(document).ready(function() {

	// This is your default javascript file
	$("#thePlayer").bind("ended", function() {
		console.log("A track has ended.");
	});

	$("#theSearchButton").click ( function() {
		startSearch(
			$("#theSearchInput").val()
		);
		return false;
	});

	startSearch("");
});

function playTrack(trackID) {
	$("#thePlayer").attr('src', '/open.php?id=' + trackID);
	$("#thePlayer").trigger("play");
	loadMeta(trackID);
}

function loadMeta(trackID) {
	api('info', {id: trackID}, function(info) {
		$("#theTrackName").html (info.title);
		$("#theArtistName").html (info.artist);
		$("#theTrackDuration").html (info.playtime);
		$("#theAlbumName").html (info.album);
	});
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

function startSearch(query) {
	searchTrack(query);
	searchAlbum(query);
	searchArtist(query);
	$("#theSearchInput").val(query).focus().select();
}

function searchTrack( query ) {
	if ( query.length < 1 ) { return; }
	api('searchTrack', { query: query }, function (results) {
		paintTracksTable(results);
	});
}

function searchAlbum ( query ) {
	api('searchAlbum', { query: query }, function (results) {
		paintAlbumTable(results);
	});
}

function searchArtist (query) {
	api('searchArtist', { query: query }, function (results) {
		paintArtistTable(results);
	});
}

function filterArtist ( artist ) {
	searchAlbum(artist);
	searchTrack(artist);
	$("#theSearchInput").val(artist).focus().select();
}

function hideSearchResults() {
	$("#theContent").show();
	$("#theTableContainer").hide();
}

function paintTracksTable ( results ) {
	var string = '';
	for ( var i in results ) {
		string += "<tr>\n";
		string += " <td><a onclick='playTrack(\"" + results[i].id + "\");'><i class='icon-play-sign'></i> Play</a></td>\n";
		string += " <td>" + results[i].title + "</td>\n";
		string += " <td><a onclick='startSearch(\"" + results[i].album + "\");'>" + results[i].album + "</a></td>\n";
		string += " <td><a onclick='startSearch(\"" + results[i].artist + "\");'>" + results[i].artist + "</a></td>\n";
		string += " <td><a onclick='searchTrack(\"" + results[i].year + "\");'>" + results[i].year + "</a></td>\n";
		string += " <td><a onclick='searchTrack(\"" + results[i].genre + "\");'>" + results[i].genre + "</a></td>\n";
		string += " <td>" + results[i].playtime + "</td>\n";
		string += "</tr>\n";
	}
	$("#theTable tbody").html(string);
}

function paintAlbumTable ( results ) {
	var string = '';
	for ( var i in results ) {
		string += "<tr>\n";
		string += " <td><a onclick='startSearch(\"" + results[i] + "\");'>" + results[i] + "</a></td>\n";
		string += "</tr>\n";
	}
	$("#theAlbums tbody").html(string);
}

function paintArtistTable ( results ) {
	var string = '';
	for ( var i in results ) {
		string += "<tr>\n";
		string += " <td><a onclick='filterArtist(\"" + results[i] + "\");'>" + results[i] + "</a></td>\n";
		string += "</tr>\n";
	}
	$("#theArtists tbody").html(string);
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