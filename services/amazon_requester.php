<?php
	require_once RASP_SERVICES_PATH . 'abstract_service.php';
	require_once RASP_RESOURCES_PATH . 'socket.php';
	require_once RASP_TYPES_PATH . 'array.php';

	class RaspAmazonRequester extends RaspAbstractService {

		public static $default_connection_options = array('url' => 'ecs.amazonaws.com', 'port' => 80, 'timeout' => 60);
		public static $default_request_options = array('Service' => 'AWSECommerceService');
		public static $default_operation_options = array(
			'SellerListingSearch' => array(
				'Operation' => 'SellerListingSearch',
				'ResponseGroup' => 'SellerListing',
				'SearchIndex' => 'Books',
				'ListingPage' => 1
			),
			'ItemLookup' => array(
				'Operation' => 'ItemLookup'
			)
		);

		public function send($request_params, $connection_params){
			$headers = "GET /onca/xml?" . join('&', self::to_get_variables($request_params)) . " HTTP/1.0\r\n";
			$headers .= "Connection: close\r\n\r\n";
			return RaspSocket::request($connection_params['url'], $connection_params, $headers);
		}

		public static function to_get_variables($variables){
			$data = array();
			foreach($variables as $name => $value) $data[] = join(self::variables_joiner(), array($name, $value));
			return $data;
		}

		public static function request($request_params, $connection_params = array()){
			$request_params = array_merge(self::$default_request_options, $request_params);
			$connection_params = array_merge(self::$default_connection_options, $connection_params);

			$response = RaspAmazonRequester::send($request_params, $connection_params);
			return self::parse($response);
		}

		public static function request_items_by_seller($seller_id, $request_params, $connection_params = array()){
			$request_params = array_merge(self::$default_operation_options['SellerListingSearch'], $request_params);
			$request_params['SellerId'] = $seller_id;
			return self::request($request_params, $connection_params);
		}

		public static function seller_listing_search($request_params, $connection_params = array()){
			return self::request_items_by_seller(RaspArray::delete($request_params, 'SellerId'), $request_params, $connection_params);
		}

		private static function parse($response){
			$data = array();
			preg_match('/(\<\?xml(?:.*))/', $response, $data);
			return RaspArray::second($data);
		}

		public static function request_item_by_asin($asin, $request_params, $connection_params = array()){
			$request_params = array_merge(self::$default_operation_options['ItemLookup'], $request_params);
			$request_params['ItemId'] = $asin;
			return self::request($request_params, $connection_params);
		}

		public static function item_lookup($request_params, $connection_params = array()){
			return self::request_item_by_asin(RaspArray::delete($request_params, 'ItemId'), $request_params, $connection_params);
		}

		private static function variables_joiner(){
			return '=';
		}
	}
?>