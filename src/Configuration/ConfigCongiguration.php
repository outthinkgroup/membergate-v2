<?php
namespace Membergate\Configuration;

class ConfigConfiguration  {

    public function get($file){
        return [
            'plugin_basename' => plugin_basename($file,),
            'plugin_domain' => $domain,
            'plugin_path' => plugin_dir_path($file),
            'plugin_relative_path' => basename(plugin_dir_path($file)),
            'plugin_url' => plugin_dir_url($file),
            'plugin_version' => self::VERSION,

        ];
    }
}
