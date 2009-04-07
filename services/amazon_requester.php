<?php
	require_once RASP_SERVICES_PATH . 'abstract_service.php';

	class RaspAmazonRequester extends RaspAbstractService {

		public function send($request_params, $connection_params){
			$headers = "GET /onca/xml?" . join('&', self::to_get_variables($request_params)) . " HTTP/1.0\r\n";
			$headers .= "Connection: close\r\n\r\n";
			return Socket::request($connection_params['url'], $connection_params, $headers);
		}

		public static function to_get_variables($variables){
			$data = array();
			foreach($variables as $name => $value) $data[] = join(self::variables_joiner(), array($name, $value));
			return $data;
		}

		public static function request_items_by_seller($seller_id, $options){
			$default_options = array(
					'Service' => 'AWSECommerceService',
					'AWSAccessKeyId' => '1R01RXJ88EWPHG5RBTR2',
					'Operation' => 'SellerListingSearch',
					'ResponseGroup' => 'SellerListing',
					'SearchIndex' => 'Books',
					'ListingPage' => 1
			);
			$request_params = array_merge($default_options, $options);
			$request_params['SellerId'] = $seller_id;

			$response = RaspAmazonRequester::send($request_params, array('url' => 'ecs.amazonaws.com', 'port' => 80, 'timeout' => 60));
			preg_match('/(\<\?xml(?:.*))/', $response, $data);
			return $data[1];
		}

		private static function variables_joiner(){
			return '=';
		}
	}
?>