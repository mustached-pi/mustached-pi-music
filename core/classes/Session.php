<?php

/*
 *
 * This is MOKA, a simple and modern PHP framework
 * Copyright 2013, the authors:
 * - Alfio Emanuele Fresta 	<alfio.emanuele.f@gmail.com>
 * - Angelo Lupo			<angelolupo94@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

/**
 * A simple class to manage user sessions on the database
 * Uses the User class to store user data 
 */
class Session extends BindableCollection {

	public static function expiredSessions() {
		return static::find([
			'expire'	=>
				[
					'$lte'	=>	time()
				]
		]);
	}
	
	public function onPostCreate() {
		$expire = (new DateTime)->modify("+24 hour");
		$this->expire = $expire->getTimestamp();
	}

	public function onPostLoad() {
		$now = (new DateTime)->getTimestamp();
		if ( $now > $this->expire ) {
			$this->logout();
		}
		$this->onPostCreate();
	}

	public function login(User $user) {
		$this->user = (string) $user;
	}

	public function logout() {
		$this->user = null;
	}

	public function user() {
		if ( $u = $this->user ) {
			return new User($u);
		} else {
			return false;
		}
	}

}