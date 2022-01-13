<?php
     $connect = mysqli_connect("localhost:3306", "direcbuy_directbuy", "Default!@#123", "direcbuy_directbuy");
   
    $sql = "SELECT * FROM  payment_integration AS p
    JOIN shop_details AS t ON t.user_id=p.user_id
     WHERE t.shopId='$session_id' AND p.provider_type='Paytm'";
     $resultset= mysqli_query($connect, $sql);
    if($resultset === false) {
    die("Database query failed");
} else {
    $row = mysqli_fetch_row($resultset);
}
   
 $api_key=$row[4];
     $secrete_key=$row[5];
//   $this_session=$session_id;
  
     ?>
<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
$this->load->view('frontend/payment_integrations/PaytmKit/lib/config_paytm',$session_id);
$this->load->view('frontend/payment_integrations/PaytmKit/lib/encdec_paytm');

$paytmChecksum = "";
$paramList = array();

$isValidChecksum = "FALSE";

$paramList = $_POST;

$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, $secrete_key, $paytmChecksum); //will return TRUE or FALSE string. for test
//$isValidChecksum = verifychecksum_e($paramList, "#dyxwda%REF%TKVS", $paytmChecksum); //prod

if($isValidChecksum == "TRUE") {
	echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<b>Transaction status is success</b>" . "<br/>";
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	}
	else {
		echo "<b>Transaction status is failure</b>" . "<br/>";
	}

	if (isset($_POST) && count($_POST)>0 )
	{ 
		foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
		}
	}
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>