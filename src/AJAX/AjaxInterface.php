<?php

namespace Membergate\AJAX;

interface AjaxInterface {
	public function get_action(): string;
	public function get_name(): string;

	public function handle();
}

