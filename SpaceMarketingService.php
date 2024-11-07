<?php

class SpaceMarketingService
{
	private string $token = 'ba67df6a-a17c-476f-8e95-bcdb75ed3958';
	public function getUsersStatuses($dateFrom = null, $dateTo = null, $page = 0, $limit = 100)
	{
		$request = [
			'date_from' => $dateFrom, // default -30days, max -60days
	       'date_to' => $dateTo,   // default now
	       'page' => $page,                          // default 0
	       'limit' => $limit
		];

		$curlOptions = [
			CURLOPT_URL => 'https://crm.belmar.pro/api/v1/getstatuses',
			CURLOPT_POST => true,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $request,
		];

		$ch = curl_init();

		$headers = [
			'token: ' . $this->token,
			'Content-Type: application/json'
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt_array($ch, $curlOptions);

		return curl_exec($ch);
	}

	public function addLead(array $data = [])
	{
		$url = 'https://crm.belmar.pro/api/v1/addlead';
		unset($data['submit']);
		$data['box_id'] = 28;
		$data['offer_id'] = 5;
		$data['landingUrl'] = $_SERVER['HTTP_HOST'];
		$data['countryCode'] = 'GB';
		$data['language'] = 'en';
		$data['password'] = 'qwerty12';
		$data['ip'] = $this->getClientIp();

		$postdata = json_encode($data);

		$ch = curl_init($url);
		$headers = [
			'token: ' . $this->token,
			'Content-Type: application/json'
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		return curl_exec($ch);
	}

	private function getClientIp($trusted_proxies=[])
	{
		// In cli mode, there is no remote address
		if (empty($_SERVER['REMOTE_ADDR'])) {
			return null;
		}

		$client_ip = $_SERVER['REMOTE_ADDR'];
		// If the remote address is not a trusted proxy, we shouldn't trust
		// any headers that malicious clients may send
		if (!in_array($client_ip, $trusted_proxies)) {
			return $client_ip;
		}

		// The request is coming from a trusted proxy, so we can trust the
		// "forwarded for" headers
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		// No forwarded client IP header provided; this might be some kind
		// of health check request. Just return the trusted proxy IP.
		return $client_ip;
	}
}