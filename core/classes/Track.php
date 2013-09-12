<?php

class Track extends Collection {
	
	public function playtime() {
		return gmdate("i:s", $this->playtime);
	}

}