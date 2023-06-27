<?php

namespace Membergate\Cache;

if (!defined('ABSPATH')) {
    exit;
}

use Membergate\Common\Time;

class ListProviderCache {
    private string $provider;

    private string $list_prefix;

    private string $group_prefix;

    public Time $list_expr;

    public Time $group_expr;

    public function __construct(string $provider) {
        $this->provider = $provider;
        $this->list_prefix = "{$this->provider}_lists_of";
        $this->group_prefix = "{$this->provider}_groups_of";
        $this->list_expr = Time::Day();
        $this->group_expr = Time::Hour();
    }

    public function get_lists($api_key, $update_fn) {
        return Cache::get(
            $api_key,
            $update_fn,
            [$api_key],
            $this->list_expr,
            $this->list_prefix
        );
    }

    public function get_groups($list_id, $update_fn) {
        return Cache::get(
            $list_id,
            $update_fn,
            [$list_id],
            $this->group_expr,
            $this->group_prefix
        );
    }
}
