<?php

namespace Membergate\Shortcode;

interface ShortcodeInterface {
	public function __construct(string $path, string $template_dirname);
	public function get_template_path():string;
	public function get_default_args():array;
}
