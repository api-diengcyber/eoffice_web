<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Curl_waapi
{

	public $ci;
	public $apiurl = 'https://waapi.aipos.id/';
	public $socketurl = 'https://waapi.aipos.id/whatsapp/socket/chat';

	public function __construct($local = false)
	{
		$this->ci = &get_instance();
		if ($local) {
			$this->apiurl = 'http://192.168.80.54:3500/';
			$this->socketurl = 'http://192.168.80.54:3500/whatsapp/socket/chat';
		}
		$this->ci->load->helper('file');
	}

	public function unAuthorizedResponse($resp)
	{
		$is_unauthorized = false;
		if (!empty($resp)) {
			$decode = (array) json_decode($resp);
			if (!empty($decode['statusCode'])) {
				if ($decode['statusCode'] == '401') {
					$is_unauthorized = true;
					if (file_exists('./assets/waapi_at.txt')) {
						unlink('./assets/waapi_at.txt');
					}
				}
			}
		}
		return $is_unauthorized;
	}

	public function genAccessToken()
	{
		$is_exists = false;
		if (file_exists('./assets/waapi_at.txt')) {
			$bearer = file_get_contents('./assets/waapi_at.txt');
			if (!empty($bearer)) {
				$is_exists = true;
				return trim($bearer);
			}
		}
		if (!$is_exists) {
			$response = $this->post('auth/login', [
				'username' => 'aryo',
				'password' => '12341234',
			], false);
			if ($response) {
				$decode = (array) json_decode($response);
				if (!empty($decode['access_token'])) {
					write_file('./assets/waapi_at.txt', $decode['access_token']);
					return $decode['access_token'];
				} else {
					return null;
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function gen_curl_file($file)
	{
		return curl_file_create($file['tmp_name'], $file['type'], $file['name']);
	}

	public function post($url, $post = [], $is_at = true)
	{
		$setopt = [
			CURLOPT_HTTPHEADER => ['Content-type: application/json'],
			CURLOPT_URL => $this->apiurl . $url,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => json_encode($post),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
		];
		$bearer = '';
		if ($is_at) {
			$bearer = $this->genAccessToken();
			if (!empty($bearer)) {
				$setopt[CURLOPT_HTTPHEADER] = [
					'Authorization: Bearer ' . $bearer,
					'Content-type: application/json',
				];
			}
		}
		$curl = curl_init();
		curl_setopt_array($curl, $setopt);
		$resp = curl_exec($curl);
		curl_close($curl);

		$is_unauthorized = $this->unAuthorizedResponse($resp);
		if (!$is_unauthorized) {
			return $resp;
		} else {
			return $this->post($url, $post, $is_at);
		}
	}

	public function get($url, $is_at = true)
	{
		$setopt = [
			CURLOPT_URL => $this->apiurl . $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		];
		$bearer = '';
		if ($is_at) {
			$bearer = $this->genAccessToken();
			if (!empty($bearer)) {
				$setopt[CURLOPT_HTTPHEADER] = [
					'Authorization: Bearer ' . $bearer,
					'Content-type: application/json',
				];
			}
		}
		$curl = curl_init();
		curl_setopt_array($curl, $setopt);
		$resp = curl_exec($curl);
		curl_close($curl);

		$is_unauthorized = $this->unAuthorizedResponse($resp);
		if (!$is_unauthorized) {
			return $resp;
		} else {
			return $this->get($url, $is_at);
		}
	}
}

/* End of file Curl_model.php */
/* Location: ./application/models/Curl_model.php */
