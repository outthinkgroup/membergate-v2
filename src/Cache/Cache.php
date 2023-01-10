<?php
namespace Membergate\Cache;

use Membergate\Common\Time;

/**
 * A wrapper around wp transient
 * 
**/
class Cache {

	/**
	 * Sets the transient
	 * @param string $transient key of the transient
	 * @param array $value  value to be stored
	 * @param Time $expiration time in seconds of how long it will be stored
	 * @param string $prefix A label to namespace the transient
	 * 
	**/
	public static function set(string $transient, array $value, Time $expiration = null, string $prefix = "" ){

		if(is_null($expiration)){
			$expiration = Time::Day();
		}
		set_transient("{$prefix}_{$transient}", $value, $expiration->getValue());
		# TODO: add a do action so we can invalidate other caches that depend on the new cache
	}

	/**
	 * Gets the transient value and updates it if it is invalid
	 * @param string $transient key of the transient
	 * @param callable $update function that is called to update the transient value
	 * @param array $params array of parameters to be passed to $update function
	 * @param Time $expiration time in seconds of how long it will be stored
	 * @param string $prefix A label to namespace the transient
	 *
	 * @return array
	**/
	public static function get( string $transient, callable $update, array $params = [], Time $expiration = null, string $prefix = ""){
		if(is_null($expiration)){
			$expiration = Time::Day();
		}

		$value = null;
		if( false === ( $value = get_transient("{$prefix}_{$transient}") ) ){
			
			$value = call_user_func_array($update, $params);
			if($value){
				self::set($transient, $value, $expiration,$prefix);
			}
		}
		if(!$value){
			return [];
		}
		return $value;
	}

	/**
	 * Deletes the transient
	 *
	 * @param string $transient key of the transient
	 * @param string $prefix A label to namespace the transient
	 * 
	**/
	public static function delete($transient, string $prefix = ""){
		delete_transient("{$prefix}_{$transient}");
	}

}

