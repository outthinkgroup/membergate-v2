<?php
// TODO: 
namespace Membergate\ListProviders;

use Membergate\Cache\ListProviderCache;
use Membergate\Common\PossibleError;
use Membergate\ListProviders\EMSClients\MailChimpClient;

class MailchimpProvider implements ListProvidersInterface
{
	private $api_key;
	private MailChimpClient $client;
	private $cache;
	const provider_name = "mailchimp";

	public function __construct($api_key)
	{
		$this->api_key = $api_key;
		$this->client = new MailChimpClient($this->api_key);
		$this->cache = new ListProviderCache(self::provider_name);
	}

	public static function capabilities(): array
	{
		return [
			"has_groups",
			"has_lists",
			"has_tags",
			"has_merge_fields",
		];
	}

	public function get_lists()
	{
		return $this->cache->get_lists($this->api_key, function () {
			$resp = $this->fetch_lists();
			if ($resp->has_error()) {
				return "";
			}
			return $resp->value;
		});
	}

	public function get_groups($list_id)
	{
		return $this->cache->get_groups($list_id, function ($list_id) {
			$resp = $this->fetch_all_groups($list_id);

			if ($resp->has_error()) {
				return null;
			}
			return $resp->value;
		});
	}

	public function fetch_lists(): PossibleError
	{
		$resp = new PossibleError();
		$lists = $this->client->get('lists', [], 200);
		if (!$this->client->success()) {
			//TODO: handle error better
			error_log(print_r([$this->client->getLastResponse(), $this->client->getLastRequest()], true));
			$resp->error = $this->client->getLastError();
			return $resp;
		}
		$resp->value = $lists;
		return $resp;
	}

	/**
	 * Fetches groups with parent group as well
	 */
	public function fetch_all_groups($list_id): PossibleError
	{
		$resp = new PossibleError();
		$interest_cats_resp = $this->fetch_group_categories($list_id);
		if ($interest_cats_resp->has_error()) {
			return $interest_cats_resp;
		}
		$interest_cats = $interest_cats_resp->value;
		$groups = [];
		foreach ($interest_cats as $cat) {
			$children_resp = $this->fetch_groups($list_id, $cat['id']);
			if ($children_resp->has_error()) {
				if ($resp->has_error()) {
					$resp->error[] = $children_resp->error;
				}
			}

			$children = $children_resp->value;
			foreach ($children as $group) {
				$groups[] = [
					'parentGroupName' => $cat['name'],
					'name'	=> $group['name'],
					'id'	=> $group['id'],
				];
			}
		}

		$resp->value = $groups;
		return $resp;
	}

	public function fetch_group_categories($list_id): PossibleError
	{
		$resp = new PossibleError();
		$categories = [];
		$group_categories = $this->client->get("/lists/$list_id/interest-categories/");
		if (!is_array($group_categories) || !array_key_exists('categories', $group_categories) || !is_array($group_categories['categories'])) {
			$resp->error = $this->client->getLastError();
			return $resp;
		}

		foreach ($group_categories['categories'] as $category) {
			$categories[] = [
				'id' => $category['id'],
				'name' => $category['title'],
			];
		}
		$resp->value = $categories;
		return $resp;
	}

	public function fetch_groups($list_id, $cat_group_id): PossibleError
	{
		$resp = new PossibleError();
		$interests = $this->client->get("/lists/$list_id/interest-categories/$cat_group_id/interests");
		$groups = [];
		
		if (!is_array($interests) || !array_key_exists('interests', $interests) || !is_array($interests['interests'])) {
			$resp->error = $this->client->getLastError();
			return $resp;
		}

		foreach ($interests['interests'] as $group) {
			$groups[] = [
				'id' => $group['id'],
				'name' => $group['name'],
			];
		}
		$resp->value = $groups;
		return $resp;
	}

	public function add_subscriber($email_address, $settings, $submission=null): PossibleError
	{
		$list_id = $settings['list_id'];
		$hash = $this->client->subscriberHash($email_address);
		$groups = [$settings['group_id'] => true];

		$res = $this->client->put("/lists/$list_id/members/$hash",[
			'status_if_new'=>'subscribed',
			'email_address'=>$email_address,
			'interests' => $groups,
		]);
		if (!$this->client->success() ) {
			debug($this->client->getLastError());
			return new PossibleError(null, $this->client->getLastError());
		}
		return new PossibleError($res);
	}

	public function get_user($list_id, $email_address): PossibleError
	{
		$hash = $this->client->subscriberHash($email_address);
		$res = $this->client->get("lists/$list_id/members/$hash");
		if (!$this->client->success() ) {
			$response = $this->client->getLastResponse();
			if ( $response['headers']['http_code'] == 404 ){
				return new PossibleError(false);
			}

			return new PossibleError(null, $this->client->getLastError());
		}
		return new PossibleError($res);
	}

	public function is_user_subscribed($list_id, $email_address): PossibleError
	{
		$possible_error = $this->get_user($list_id, $email_address);
		if ($possible_error->has_error()) {
			return $possible_error;
		}
		$resp = $possible_error->value;
		if ($resp == false) {
			return new PossibleError(false);	
		}
		if($resp['status'] == 'subscribed'){
			return new PossibleError(true);
		}
		return new PossibleError(false);	
	}
}
