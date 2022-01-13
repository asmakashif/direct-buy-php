<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Payment Test</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h2>Web Payment Test</h2>
    <p>This page is for testing web payment.</p>

    <div id="inputSection">

        <form class="form-horizontal">
            <div class="form-group row">
                <label class="control-label col-xs-3" for="amount">Amount:</label>
                <div class="col-xs-9">
                    <input class="form-control" type="number" id="amount" value="1">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="pa">Payee VPA (pa):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" id="pa" value="arscnetworks@icici">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="pn">Payee Name (pn):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" id="pn" value="ARSC Networks">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="tn">Txn Note (tn):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" id="tn" value="test note">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="mc">Merchant Code (mc):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" id="mc" value="5734">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="tid">Txn ID (tid):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" id="tid" value="TXNARSC<?php echo uniqid(); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="tr">Txn Ref ID (tr):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="text" id="tr" value="TXNARSC<?php echo uniqid(); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-xs-3" for="url">Ref URL (url):</label>
                <div class="col-xs-9">
                    <input class="form-control" type="url" id="url" value="https://teztytreats.com/demo">
                </div>
            </div>
        </form>

        <div class="form-group row clearfix">
            <div class="col-xs-12">
                <button class="btn btn-info pull-right" onclick="onBuyClicked()">Buy</button>
            </div>
        </div>
    </div>

    <div id="outputSection" style="display:none">
        <pre id="response"></pre>
    </div>
</div>

<script src="<?php echo base_url('assets1/js/demo.js');?>"></script>
</body>
</html>