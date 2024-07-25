<?php
namespace Membergate\Settings;

class PostSettings {
    public $id;
    private $settings = [
        "membergate_should_set_cookie" => false,
        "membergate_cookie_key" => "is_member",
        "membergate_cookie_value"=> "true",
    ];

    public function __construct($id = null){
        if(is_null($id)){
            $id = get_the_ID();
        }
        $this->id = $id;
    }

	public function __call($name, $args=null) {
        error_log("DEBUG: ".$name);
		if (in_array($name,$this->available_options())) {
            // if their is an arg passed we will set it.
            if(isset($args[0]) && !is_null($args[0])) {
               $result = update_post_meta($this->id, $name, $args[0]); 
               return $result;
            }
            // if null then we will return it
			$value = get_post_meta($this->id,$name, true);
            if(!$value){
                // set it to default
                $value = $this->settings[$name];
            }
            return $value;
        } else {

            throw new \Exception("Not a valid Setting $name");
        }
    }

    public function available_options(){
        return array_keys($this->settings);
    }
}

