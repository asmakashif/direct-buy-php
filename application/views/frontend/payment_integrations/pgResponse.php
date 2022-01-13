<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");



// following files need to be included
$this->load->view('frontend/PaytmKit/lib/config_paytm');
$this->load->view('frontend/PaytmKit/lib/encdec_paytm');

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your applicationï¿½s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if ($isValidChecksum == "TRUE") {
    //echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
    if ($_POST["STATUS"] == "TXN_SUCCESS") {
        //echo "<b>Transaction status is success</b>" . "<br/>";
        //Process your transaction here as success transaction.
        //Verify amount & order id received from Payment gateway with your application's order id and amount.
        $this->load->view('header');
        ?>




        <div class="container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="myform-container">

                    <div class="logo-container">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url(); ?>vendor/images/logo.png" alt="Rathorji" class="img-responsive" />
                        </a>
                    </div><br>

                    <h1>Hello <?php echo $this->session->userdata('username'); ?>,</h1>
                    <p>Payment successfully done, your transaction id is 
                        <?php echo $_POST["TXNID"]; ?>
                        <?php
                        $username = $this->session->userdata('username');
                        $Paytm->update_membership($username);
                        $tid = $_POST["TXNID"];
                        $Paytm->pay($username, $tid, "600", "TXN_SUCCESS");
                        ?>
                    </p>


                    <p class="text-center" style="margin-top: 25px;">
                        <a style="width: 100%" class="btn my-btn get-start" href="<?php echo base_url(); ?>" role="button">Jump into code</a>
                    </p>
                    <div class="clearfix"></div>
                </div>


            </div>
            <div class="col-md-4"></div>
        </div>



        <?php
        $this->load->view('footer');
    } else {
        $this->load->view('header');
        $this->load->view('payment-fail');
        $this->load->view('footer');
        // echo "<b>Transaction status is failure</b>" . "<br/>";
    }

    if (isset($_POST) && count($_POST) > 0) {
        foreach ($_POST as $paramName => $paramValue) {
            // echo "<br/>" . $paramName . " = " . $paramValue;

            /*
             * Checksum matched and following are the transaction details:
              Transaction status is success

              ORDERID = ORDS66131927
              MID = qwMCfj37320568057457
              TXNID = 20190216111212800110168599657504509
              TXNAMOUNT = 1.00
              PAYMENTMODE = PPI
              CURRENCY = INR
              TXNDATE = 2019-02-16 11:20:30.0
              STATUS = TXN_SUCCESS
              RESPCODE = 01
              RESPMSG = Txn Success
              GATEWAYNAME = WALLET
              BANKTXNID = 66998115273
              BANKNAME = WALLET
              CHECKSUMHASH = PhCW9y5OwBP9NpeXZGXkRlEJouQCGDmUK/wIF+eLVhTkLu25tIT3+7/lVa4GvnuphjzxWOU57+ZWpIKFgr1rHVyK1z4eWVbTE7Dn5AfVPVw=
             */
        }
    }
} else {
    echo "<b>Checksum mismatched.</b>";
    //Process transaction as suspicious.
}
?>