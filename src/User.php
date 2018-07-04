<?php

namespace rdx\bookr;

class User extends Model {

	static public $_table = 'users';

	static public function fromAuth( $username, $password ) {
		$user = self::first(['username' => $username]);
		if ( $user && password_verify($password, $user->password) ) {
			return $user;
		}
	}

	protected function getSetting( $setting, $default = null ) {
		$settings = $this->settings_array;
		return $settings[$setting] ?? $default;
	}

	protected function get_settings_array() {
		return json_decode($this->settings, true) ?: [];
	}

	protected function get_setting_summary() {
		return (bool) $this->getSetting('summary', true);
	}

	protected function get_setting_notes() {
		return (bool) $this->getSetting('notes', true);
	}

	protected function get_setting_rating() {
		return (bool) $this->getSetting('rating', false);
	}

}
