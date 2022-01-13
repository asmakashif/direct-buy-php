<?php
     $connect = mysqli_connect("localhost:3306", "direcbuy_directbuy", "Default!@#123", "direcbuy_directbuy");
   
    $sql = "SELECT * FROM  payment_integration AS p
    JOIN shop_details AS t ON t.user_id=p.user_id
     WHERE t.shopId='$this_session' AND p.provider_type='Paytm'";
     $resultset= mysqli_query($connect, $sql);
    if($resultset === false) {
    die("Database query failed");
} else {
    $row = mysqli_fetch_row($resultset);
}
   
 $api_key=$row[4];
     $secrete_key=$row[5];
   
   
     ?>
<?php

/*
*|======================================================================|
*|	PayTM Payment Gateway Integration Kit (Stack Version : 1.0.0.0)		|
*|	@Author : Chandan Sharma 											|
*|	@Email: <devchandansh@gmail.com>									|
*|	@Website: <www.chandansharma.co.in>									|
*|	@Authorized Member: <www.stackofcodes.in>							|
*|======================================================================|
*/


/*
- Use PAYTM_ENVIRONMENT as 'PROD' if you wanted to do transaction in production environment else 'TEST' for doing transaction in testing environment.
- Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_MID constant with details received from Paytm.
- Change the value of PAYTM_MERCHANT_WEBSITE constant with details received from Paytm.
- Above details will be different for testing and production environment.
*/

// define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
// define('PAYTM_MERCHANT_KEY', 'O0zUdIG%OQViK_'); //Change this constant's value with Merchant key received from Paytm.
// define('PAYTM_MERCHANT_MID', 'dZlzzF171371019'); //Change this constant's value with MID (Merchant ID) received from Paytm.
// define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm.


//=================================================
//	For PayTM Settings::
//=================================================

//===================================================
//	For Production or LIVE Credentials
//===================================================
$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';

//Change this constant's value with Merchant key received from Paytm.
$PAYTM_MERCHANT_MID 		= $api_key;
$PAYTM_MERCHANT_KEY 		= $secrete_key;

$PAYTM_CHANNEL_ID 	= "WEB";
$PAYTM_INDUSTRY_TYPE_ID = "Retail";
$PAYTM_MERCHANT_WEBSITE = "DEFAULT";
$PAYTM_CALLBACK_URL 	= "https://demo.direct-buy.in/";

//===================================================
//	For Staging or TEST Credentials
//===================================================
// $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
// $PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';

// //Change this constant's value with Merchant key received from Paytm.
// $PAYTM_MERCHANT_MID 		= $api_key; //api-key
// $PAYTM_MERCHANT_KEY 		= $secrete_key;  //secrete

// $PAYTM_CHANNEL_ID 		= "WEB";
// $PAYTM_INDUSTRY_TYPE_ID = "Retail";
// $PAYTM_MERCHANT_WEBSITE = "Default";

// $PAYTM_CALLBACK_URL 	= " ";
	

//$PAYTM_ENVIRONMENT = "PROD";	// For Production /LIVE
//$PAYTM_ENVIRONMENT = "TEST";	// For Staging / TEST

// if(!defined("PAYTM_ENVIRONMENT") ){
// 	define('PAYTM_ENVIRONMENT', $PAYTM_ENVIRONMENT); 
// }

// For LIVE
// if (PAYTM_ENVIRONMENT == 'PROD') {
// 	//===================================================
// 	//	For Production or LIVE Credentials
// 	//===================================================
// 	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
// 	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';

// 	//Change this constant's value with Merchant key received from Paytm.
// 	$PAYTM_MERCHANT_MID 		= $api_key;
// 	$PAYTM_MERCHANT_KEY 		= $secrete_key;

// 	$PAYTM_CHANNEL_ID 	= "WEB";
// 	$PAYTM_INDUSTRY_TYPE_ID = "Retail";
// 	$PAYTM_MERCHANT_WEBSITE = "DEFAULT";
// 	$PAYTM_CALLBACK_URL 	= "https://demo.direct-buy.in/";
	
// }else{
// 	//===================================================
// 	//	For Staging or TEST Credentials
// 	//===================================================
// 	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
// 	$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';

// 	//Change this constant's value with Merchant key received from Paytm.
// 	$PAYTM_MERCHANT_MID 		= $api_key; //api-key
// 	$PAYTM_MERCHANT_KEY 		= $secrete_key;  //secrete

// 	$PAYTM_CHANNEL_ID 		= "WEB";
// 	$PAYTM_INDUSTRY_TYPE_ID = "Retail";
// 	$PAYTM_MERCHANT_WEBSITE = "Default";

// 	$PAYTM_CALLBACK_URL 	= " ";
	
// }

define('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY); 
define('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID);

define("PAYTM_MERCHANT_WEBSITE", $PAYTM_MERCHANT_WEBSITE);
define("PAYTM_CHANNEL_ID", $PAYTM_CHANNEL_ID);
define("PAYTM_INDUSTRY_TYPE_ID", $PAYTM_INDUSTRY_TYPE_ID);
define("PAYTM_CALLBACK_URL", $PAYTM_CALLBACK_URL);


define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

?>
