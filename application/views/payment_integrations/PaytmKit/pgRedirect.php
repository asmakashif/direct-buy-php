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
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
$this->load->view('payment_integrations/PaytmKit/lib/config_paytm',$this_session);
$this->load->view('payment_integrations/PaytmKit/lib/encdec_paytm');
// require_once("./lib/config_paytm.php");
// require_once("./lib/encdec_paytm.php");

$checkSum = "";
$paramList = array();

$ORDER_ID = $_POST["ORDER_ID"];
$CUST_ID = $_POST["CUST_ID"];
$INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
$CHANNEL_ID = $_POST["CHANNEL_ID"];
$TXN_AMOUNT = $_POST["TXN_AMOUNT"];

// Create an array having all required parameters for creating checksum.
$paramList["MID"] = $api_key;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = "WEBSTAGING";


$paramList["CALLBACK_URL"] = base_url()."frontend/payment_integrations/Paytm/pgResponse/<?php echo $this_session ?>" ;


/*
$paramList["CALLBACK_URL"] = "http://localhost/PaytmKit/pgResponse.php";
$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
$paramList["EMAIL"] = $EMAIL; //Email ID of customer
$paramList["VERIFIED_BY"] = "EMAIL"; //
$paramList["IS_USER_VERIFIED"] = "YES"; //

*/

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,$secrete_key);

?>
<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>