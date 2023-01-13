<?php

namespace Membergate\Settings\EMSSettings;

use Membergate\Common\PossibleError;

interface EMSSettingsInterface {
	public function __construct();

	public function update_settings(array $post_arr): PossibleError;
	public function update_setting(string $key, mixed $value): PossibleError;
	public function get_settings(): PossibleError;
	public function get_setting(string $key): PossibleError;
}
