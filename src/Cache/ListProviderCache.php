<?php
namespace Membergate\Cache;

use Membergate\Common\Time;
use Membergate\Settings\ListProviderSettings;

class ListProviderCache {
	private string $provider;
	private string $list_prefix;
	private string $group_prefix;

	public Time $list_expr; 
	public Time $group_expr;
	public function __construct(string $provider){
		$this->provider = $provider;
		$this->list_prefix = "{$this->provider}_lists_of";
		$this->group_prefix = "{$this->provider}_groups_of";
		$this->list_expr = Time::Day();
		$this->group_expr = Time::Hour();
	}

	public function store_lists(array $lists, $api_key = null){
		if(!$api_key){
			$config = get_option(ListProviderSettings::KEY,true);
			if(isset($config['api_key'])){
				$api_key = $config['api_key'];
			} else{
				error_log('couldnt get api_key id from config');
				return;
			}
		}
		
		Cache::set($api_key, $lists, $this->list_expr, $this->list_prefix);
	}

	public function get_lists($api_key, $update_fn){
		return Cache::get(
			$api_key,
			$update_fn,
			[$api_key],
			$this->list_expr,
			$this->list_prefix 
		);
	}

	public function store_groups(array $groups, $list_id = null){
		if(!$list_id){
			$config = get_option(ListProviderSettings::KEY,true);
			if(isset($config['list_config']) && isset($config['list_config']['list_id'])){
				$list_id = $config['list_config']['list_id'];
			} else{
				error_log('couldnt get list id from config');
			}
		}
		
		Cache::set($list_id, $groups, $this->group_expr, $this->group_prefix);
	}

	public function get_groups($list_id, $update_fn){
		return Cache::get(
			$list_id,
			$update_fn,
			[$list_id],
			$this->group_expr,
			$this->group_prefix 
		);
	}

}