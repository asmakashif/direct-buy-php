
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        @media screen and (max-width: 480px) {
            .mobile-hide {
                display: none !important;
            }

            .mobile-center {
                text-align: center !important;
            }
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>

<div style="background-color: #eeeeee;" bgcolor="#eeeeee">
     <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:20px">
        <br/>
        <tr>
            <td align="center" >
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:400px;">
                    <tr>
                        <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#F44336">
                            <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%; margin-top:15px">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 10px; font-weight: 800; line-height:0px ;margin-top:20px;" class="mobile-center">
                                            <h7 style="font-size: 25px; font-weight: 600; margin: 0; color: #ffffff;"><?php echo $cus_data->shop_name?></h7>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;" class="mobile-hide">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="right" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400">
                                            <table cellspacing="0" cellpadding="0" border="0" align="right">
                                                <tr>
                                                   
                                                    <td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 10px; font-weight: 400; line-height:0px;"> <img src="https://img.icons8.com/color/48/000000/small-business.png" width="27" height="23" style="display: block; border: 0px;" /></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                <tr>
                                    <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;"> <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" /><br>
                                        <h5 style=" font-weight: 800; line-height: 36px; color: #333333; margin: 0;"> Thank You For Your Order! </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 14px; padding-top: 10px;">
                                        <p style="font-size: 12px; font-weight: 400; line-height:14px; color: #777777;">A copy of this order with the complete details has been sent your your email address </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 10px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 14px; padding: 10px;"> Order Confirmation # </td>
                                                <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 14px; padding: 10px;"> <?php echo $totals->order_code ?> </td>
                                            </tr>
                                          
                                           
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 10px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="70%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">Payment Method </td>
                                                
                                                <td width="30%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"><?php echo $payment_data->Payment_method ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                  <tr>
                                    <td align="left" style="padding-top: 10px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> Total </td>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">&#8377; <?php echo $totals->total ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                    <tr>
                                    <td align="left" style="padding-top: 10px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> To Pay </td>
                                                <?php if($payment_data->payment_status==0)
                                                {?>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">&#8377; <?php echo $totals->total ?></td>
                                                <?php } else {?>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">&#8377; 0</td>

                                                <?php }?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 10px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">Payment Status </td>
                                                <?php if($payment_data->payment_status==0)
                                                {?>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">Pending</td>
                                                <?php } else {?>
                                                <td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 600; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">Paid</td>

                                                <?php }?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="100%" valign="top" width="100%" style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                                <tr>
                                    <td align="center" valign="top" style="font-size:0;">
                                        <div style="display:inline-block; max-width:100%; min-width:240px; vertical-align:top; width:100%;">
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" >
                                                <tr>
                                                    <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 24px;">
                                                        <?php if($cus_data->c_address1!='null' && $cus_data->c_address2){ ?>
                                                        <p style="font-weight: 600;">Address</p>
                                                        <p><?php echo $cus_data->c_address1?>,<?php echo $cus_data->c_address2?>,<?php echo $cus_data->city?>,<?php echo $cus_data->pincode?></p>
                                                      <?php  } ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </table>
            </td>
        </tr>
 
        </table>
           <br/>
                                                        <br/>
                                                        <br/>
                                                        
</div>