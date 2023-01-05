<?php

namespace Membergate\ListProviders;

use Membergate\ListProviders\EMSClients\MailChimpClient;

class MailchimpProvider implements ListProvidersInterface
{
	private $api_key;
	private $client;

	public function __construct($api_key)
	{
		$this->api_key = $api_key;
		$this->client = new MailChimpClient($this->api_key);
	}

	public static function capabilities(): array
	{
		return [
			"has_groups",
			"has_lists",
			"has_tags",
		];
	}

	public function fetch_lists()
	{
		$lists = $this->client->get('/lists');
		if (!$this->client->success()) {
			//TODO: handle error better
			error_log(print_r($this->client->getLastResponse(), true));
			return $this->client->getLastError();
		}
		return $lists;
	}

	/**
	 * Fetches groups with parent group as well
	 */
	public function fetch_groups($list_id)
	{
		$interest_cats = $this->group_categories($list_id);
		$groups = [];
		foreach ($interest_cats as $cat) {
			$children = $this->groups($list_id, $cat['id']);
			foreach ($children as $group) {
				$groups[] = [
					'parentGroupName' => $cat['name'],
					'name'	=> $group['name'],
					'id'	=> $group['id'],
				];
			}
		}

		if (!$this->client->success()) {
			//TODO: handle error better
			error_log(print_r($this->client->getLastResponse(), true));
			return $this->client->getLastError();
		}
		return $groups;
	}

	public function group_categories($list_id)
	{
		$categories = [];
		$group_categories = $this->client->get("/lists/$list_id/interest-categories/");

		if (!array_key_exists('categories', $group_categories) || !is_array($group_categories['categories'])) {
			return false;
		}

		foreach ($group_categories['categories'] as $category) {
			$categories[] = [
				'id' => $category['id'],
				'name' => $category['title'],
			];
		}

		return $categories;
	}

	public function groups($list_id, $cat_group_id)
	{

		$interests = $this->client->get("/lists/$list_id/interest-categories/$cat_group_id/interests");
		$groups = [];
		if (!array_key_exists('interests', $interests) || !is_array($interests['interests'])) {
			return [];
		}
		foreach ($interests['interests'] as $group) {
			$groups[] = [
				'id' => $group['id'],
				'name' => $group['name'],
			];
		}

		return $groups;
	}

	public function add_subscriber($email_address, $info)
	{
		//TODO:	
	}

	public function get_user($email_address): array
	{
		return [];
	}
}
