<?php

namespace Membergate\Subscriber;

use Membergate\Assets\Vite;
use Membergate\EventManagement\SubscriberInterface;

class AssetSubscriber implements SubscriberInterface {


	public static function get_subscribed_events():array{
		return [
			'admin_enqueue_scripts'=>'enqueue_assets',
			'script_loader_tag' => ['use_esm_modules',10,3],
		];
	}

	public function enqueue_assets($hook){
		//TODO: 👇
		//load on admin pages only 
		//check get_current_screen
		Vite::useVite("assets/main.ts");
	}

	public function use_esm_modules($tag, $handle, $src){
		if (false !== stripos($handle, 'sage')) {
			$str = "type='module'";
			$str .= IS_DEVELOPMENT ? ' crossorigin' : '';
			$tag = str_replace("type='text/javascript'", $str, $tag);

			return "<script type='module' src='$src' id='$handle' crossorigin></script>";
		} else {
			return $tag;
		}
	}

}

