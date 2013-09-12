<?php

class API {

	protected
		$params;

	public function __construct() {
		$this->params = array_merge(
			$_POST, $_GET
		);
	}

	public function execute($function) {
		if (!method_exists($this, "api_{$function}"))
			throw new Exception("Function not defined");
		return json_encode([
				'request'	=>	$this->params,
				'response' 	=>  call_user_func([$this, "api_{$function}"])
			],
			JSON_PRETTY_PRINT
		);
	}

	public function api_info() {
		if ( !Track::hasId($this->params['id']))
			throw new Exception('Track does not exist');
		$x = Track::object($this->params['id']);
		return [
			'title'		=>	$x->title,	
			'artist'	=>	$x->artist,	
			'album'		=>	$x->album,	
			'playtime'	=>	$x->playtime(),	
			'id'		=>	(string) $x,	
		];
	}

	public function api_searchTrack() {
		$regex = new MongoRegex("/{$this->params['query']}/i");
		$query = [
			'$or' => [
				['title'  	=> $regex ],
				['artist' 	=> $regex ],
				['album' 	=> $regex ],
				['year' 	=> $regex ],
				['genre' 	=> $regex ]
			]
		];
		$y = Track::find($query)->sort(['track' => 1]);
		$r = [];
		foreach ( $y as $x ) {
			$x = Track::object($x);
			$r[] = [
				'title'		=>	$x->title,	
				'artist'	=>	$x->artist,	
				'album'		=>	$x->album,	
				'year'		=>	$x->year,	
				'genre'		=>	$x->genre,	
				'playtime'	=>	$x->playtime(),	
				'id'		=>	(string) $x,	
			];
		}
		return $r;
	}

	public function api_searchArtist() {
		$regex = new MongoRegex("/{$this->params['query']}/i");
		$query = [
			'$or' => [
				['artist' 	=> $regex ],
				['album' 	=> $regex ],
			]
		];
		$y = Track::distinct("artist", $query);
		sort($y);
		return $y;
	}

	public function api_searchAlbum() {
		$regex = new MongoRegex("/{$this->params['query']}/i");
		$query = [
			'$or' => [
				['artist' 	=> $regex ],
				['album' 	=> $regex ],
			]
		];
		$y = Track::distinct("album", $query);
		sort($y);
		return $y;
	}

}