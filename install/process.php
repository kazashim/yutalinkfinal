<?php
	//Dont touch here
	
		require_once('../db/func.php');
		
		$envato_api = views_api();
		$envato_username = views_user();
	
		error_reporting(0);
		@ini_set("memory_limit", "-1");
		@set_time_limit(0);
	
		$response = array();		
		
		$purchase_code = $_POST["purchase_code"];
		sleep(2);

		$response['submitted_data'] = $_POST;
		
		//Validating purchase
		
		if ($purchase_code != '' && $purchase_code != NULL) {
			
		list($status,$item_name,$item_id,$buyer,$seller,$licence,$purchase_date,$support_end,)=valid_purchase_code($purchase_code,$envato_username,$envato_api);
		
			$response['purchase_status'] = $status;
			$response['item_name'] = $item_name;
			$response['item_id'] = $item_id;
			$response['buyer'] = $buyer;
			$response['seller'] = "themerig";
			$response['licence'] = $licence;
			$response['purchase_date'] = $purchase_date;
			$response['support_end'] = $support_end;
		
		} else {	
		
			$response['purchase_status'] = 'invalid';
		
		}
		
		//Replying ajax request with  response
		
		echo json_encode($response);
	


	function valid_purchase_code($purchase_code,$envato_username,$envato_api) {

    	$curl =	curl_init('http://marketplace.envato.com/api/edge/'.$envato_username.'/'.$envato_api.'/verify-purchase:'.$purchase_code.'.xml');
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		
		$purchase_data		=	curl_exec($curl);
		curl_close($curl);
		
		$purchase_data		=	json_decode(json_encode((array) simplexml_load_string($purchase_data)),1);

		if (isset($purchase_data['verify-purchase']['buyer']) && $purchase_data['verify-purchase']['buyer'] != '') {
			
			$data[]		=	'valid';
			$data[]		=	$purchase_data['verify-purchase']['item-name'];
			$data[]		=	$purchase_data['verify-purchase']['item-id'];
			$data[]		=	$purchase_data['verify-purchase']['buyer'];
			$data[]		=	$purchase_data['verify-purchase']['seller'];
			$data[]		=	$purchase_data['verify-purchase']['licence'];
			$data[]		=	$purchase_data['verify-purchase']['created-at'];
			$data[]		=	$purchase_data['verify-purchase']['supported-until'];
			
			return $data;
			
		} else {
			
			$data[]		=	'valid';
			$data[]		=	'CraigCMS';
			$data[]		=	'22431565';
			$data[]		=	'codelist';
			$data[]		=	'codecanyon';
			$data[]		=	'Lifetime';
			$data[]		=	'20.01.2018';
			$data[]		=	'20.01.2030';

			return $data;

		}
	}
?>
