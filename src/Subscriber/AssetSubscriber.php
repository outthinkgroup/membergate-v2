<?php

namespace Membergate\Subscriber;

use Membergate\Assets\Vite;
use Membergate\EventManagement\SubscriberInterface;

class AssetSubscriber implements SubscriberInterface {


	public static function get_subscribed_events():array{
		return [
			'admin_enqueue_scripts'=>'enqueue_admin_assets',
			'script_loader_tag' => ['use_esm_modules',10,3],
			'wp_enqueue_scripts' => 'enqueue_form_syles',
		];
	}

	public function enqueue_admin_assets($hook){
		//check get_current_screen
		if($hook == "toplevel_page_membergate-settings"){
			Vite::useVite("assets/main.ts");
		}
	}

	public function enqueue_form_syles(){
		Vite::useVite("assets/frontend.ts");	
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

