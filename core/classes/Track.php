<?php

class Track extends Collection
{
	
	public function playtime()
	{
		return gmdate("i:s", $this->playtime);
	}

	public function findLyrics()
	{
		$url 	= 'http://api.chartlyrics.com/apiv1.asmx/SearchLyricDirect?';

		$search = 'artist='.urlencode($this->artist).'&song='.urlencode($this->title);
		echo "Searching for {$track['title']} by {$track['artist']}... \n";
		$p1 	= file_get_contents("$url{$search}");
		$song   = new SimpleXMLElement($p1);
		if (!$song->Lyric)
		{
			return false;
		}
		return $song->Lyric;
	}

}