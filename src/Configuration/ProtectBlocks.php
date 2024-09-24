<?php

namespace Membergate\Configuration;

use WP_Post;

class ProtectBlocks implements ModifierInterface{
    protected string $event;
    public function __construct(){
        $this->event = "PAGE_LOAD";
    }

    public function checkPost(WP_Post $post): bool { 
        // if we add more blocks make this a config array and loop through it
        $this->event = "CLICK_PROTECT_LINK";
        return has_block("membergate/protectedlink", $post);
    }

    public function onEvent():string {
       return $this->event; 
    }
    
}
