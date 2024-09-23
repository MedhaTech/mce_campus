<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://pay.billdesk.com/jssdk/v1/dist/billdesksdk/billdesksdk.esm.js"></script>
    <script nomodule="" src="https://pay.billdesk.com/jssdk/v1/dist/billdesksdk.js"></script>
    <link href="https://pay.billdesk.com/jssdk/v1/dist/billdesksdk/billdesksdk.css" rel="stylesheet">
</head>
<body>
    <script>
        var flow_config = {
            merchantId: "<?= $merchantId;?>",
            bdOrderId: "<?= $transactionid;?>",
            authToken: "<?= $authtoken;?>",
            childWindow: false,
            crossButtonHandling: 'Y',
            returnUrl: "<?= base_url('student/callback');?>",
            retryCount: 0
        };
        var responseHandler = function(txn) {
            if (txn.response) {
                alert("callback received status:: ", txn.status);
                alert("callback received response:: ", txn.response)//response handler to be implemented by the merchant
            }
        };
        var config = {
            flowConfig: flow_config,
            flowType: "payments"
        };
        window.onload = function() {
            setTimeout(function() {
                window.loadBillDeskSdk(config);
            }, 1500);
        };
    </script>
</body>
</html>