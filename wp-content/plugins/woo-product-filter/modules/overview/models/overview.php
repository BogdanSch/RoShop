<?php
class OverviewModelWpf extends ModelWpf {
	private $_apiUrl = '';
	public function __construct() {
		$this->_initApiUrl();
		if (!$this->getFirstOverview()) {
			update_option('_overview_' . WPF_CODE, time());
		}
	}
	public function subscribe( $params ) {
		$email = empty($params['email']) ? '' : $params['email'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->pushError(esc_html__('Invalid email format', 'woo-product-filter'));
			return false;
		}
		$resData = $this->_req('subscribe', array(
			'url' => WPF_SITE_URL,
			'plugin_code' => 'woofilters',
			'email' => $email,
			'data' => $this->getPluginData()
		));
		if ($resData) {
			update_option('_subscribe_' . WPF_CODE, time());
			return true;
		}
		
		return false;
	}
	public function rating( $params ) {
		$rate = empty($params['rate']) ? 0 : $params['rate'];
		if (5 == $rate) {
			update_option('_rating_' . WPF_CODE, time());
			return true;
		}
		$email = empty($params['email']) ? '' : $params['email'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->pushError(esc_html__('Invalid email format', 'woo-product-filter'));
			return false;
		}
		$problem = empty($params['problem']) ? '' : $params['problem'];
		if (empty($problem) || strlen($problem) < 5) {
			$this->pushError(esc_html__('Describe ideas and problems, please', 'woo-product-filter'));
			return false;
		}

		$resData = $this->_req('rating', array(
			'url' => WPF_SITE_URL,
			'plugin_code' => 'woofilters',
			'email' => $email,
			'data' => array_merge(array(
				'rate' => $rate,
				'problem' => $problem
			), $this->getPluginData())
		));
		if ($resData) {
			update_option('_rating_' . WPF_CODE, time());
			return true;
		}
		
		return false;
	}
	
	public function getFirstOverview() {
		return (int) get_option('_overview_' . WPF_CODE);
	}
	public function isSubscribe() {
		return (int) get_option('_subscribe_' . WPF_CODE);
	}
	public function isRating() {
		return (int) get_option('_rating_' . WPF_CODE);
	}
	public function getPluginData() {
		return array(
			'license_type' => FrameWpf::_()->getModule('options')->get('license_type'),
			'license_email' => FrameWpf::_()->getModule('options')->get('license_email'),
			'license_key' => FrameWpf::_()->getModule('options')->get('license_key'),
			'license_name' => FrameWpf::_()->getModule('options')->get('license_name')
		);
	}
	
	public function overviewHttpRequestTimeout( $handle ) {
		curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt( $handle, CURLOPT_TIMEOUT, 30 );
	}
	
	private function _req( $action, $data = array() ) {
		add_filter('http_api_curl', array($this, 'overviewHttpRequestTimeout'), 100, 1);
		
		$data = array_merge($data, array(
			'mod' => 'feedback',
			'pl' => 'lms',
			'action' => $action,
		));

		$response = wp_remote_post($this->_apiUrl, array(
			'body' => $data,
			'timeout' => 30,
		));

		remove_filter('http_api_curl', array($this, 'overviewHttpRequestTimeout'));
		if (!is_wp_error($response)) {
			$resArr = UtilsWpf::jsonDecode($response['body']);
			if ( isset($response['body']) && !empty($response['body']) && $resArr ) {
				if (!$resArr['error']) {
					return $resArr;
				} else {
					$this->pushError($resArr['errors']);
				}
			} else {
				$this->pushError(esc_html__('There was a problem with sending request to our autentification server. Please try latter.', 'woo-product-filter'));
			}
		} else {
			$this->pushError( $response->get_error_message() );
		}
		return false;
	}
	private function _initApiUrl() {
		if (empty($this->_apiUrl)) {
			$this->_apiUrl = 'https://woobewoo.com/';
		}
	}
}
