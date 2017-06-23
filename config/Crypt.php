<?php
class Crypt{
	public static function encrypt($value){
		return password_hash($value, PASSWORD_BCRYPT);
	}
}