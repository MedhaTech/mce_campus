<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aidedhook extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->load->model('admin_model', '', TRUE);
        date_default_timezone_set('Asia/Kolkata');
        
    }


    public function index()
    {
       
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            require_once APPPATH . 'libraries/Jwt.php';
            $this->load->library('logger');
            
           
            $tx_array = $_POST;
            $tx = file_get_contents("php://input");
            $message = "BillDesk webhook Response - " . $tx . "\n";
            $this->logger->write('billdesk', 'debug', $message);

         
            // If data is present
            if ($tx != '') {
                // Add the raw data to the $_POST array
                $response_decoded = JWT::decode($tx, "hbjUTwdjLDwzsFErRVCE0y0skHic1z2B", 'HS256');
				$response_array = (array) $response_decoded;
				$response_json =  json_encode($response_array);
				$message = "BillDesk webhook Response decode - " . $response_json . "\n";
				$this->logger->write('billdesk', 'debug', $message);
	
				if ($response_array['auth_status'] == '0300') {
					$status = 'pass';
				} else if ($response_array['auth_status'] == '0002') {
					$status = 'unknown';
				} else {
					$status = 'fail';
				}
	
	
	
				$return['amount']	    = (int)$response_array['amount'];
				$return['order_id']	    = $response_array['orderid'];
				$return['status']		= $status;
				$return['pgresponse']	= $response_json;
				$return['pgid']	        = $response_array['transactionid'];
	
				$updateDetails = array(
					'transaction_date' => $response_array['transaction_date'],
					'transaction_id' => $response_array['transactionid'],
					'txn_response' => $response_json,
	
				);
				if ($response_array['transaction_error_type'] == 'success') {
					$cnt_number = $this->getReceiptNo($response_array['orderid']);
					$receipt_no = $cnt_number;
					$updateDetails['receipt_no'] = $receipt_no;
					$updateDetails['transaction_status'] = '1';
				} else if ($response_array['transaction_error_type'] == 'payment_processing_error') {
					$updateDetails['transaction_status'] = '2';
				} else {
					$updateDetails['transaction_status'] = '0';
				}
	
			$result = $this->admin_model->updateDetailsbyfield('reference_no', $response_array['orderid'], $updateDetails, 'transactions');
				$params=1;
            } else {
                // No data received
                $params=0;
            }

       
            $respStatus = 200;
            $resp = array('status' => 200, 'response' => $params);
            json_output($respStatus,$resp);
            // if (!empty($tx)) {

            //     $params = json_decode(file_get_contents('php://input'), TRUE);

            //     if ($params == "") {
            //         $respStatus = 400;
            //         $resp = array('status' => 400, 'message' => 'params can\'t empty');
            //     } else {
            //     }
            //     json_output($respStatus, $resp);
            // }
        }
    }
    public function getReceiptNo($reference)
	{

		$details = $this->admin_model->getDetailsbyfield($reference, 'reference_no', 'transactions')->row();
		$cnt = $this->admin_model->getReceiptsCountNew($details->aided_unaided, $details->payment_mode)->row()->cnt;
		$cnt_number = $cnt + 1;
		$strlen = strlen(($cnt_number));
		if ($strlen == 1) {
			$cnt_number = "000" . $cnt_number;
		}
		if ($strlen == 2) {
			$cnt_number = "00" . $cnt_number;
		}
		if ($strlen == 3) {
			$cnt_number = "0" . $cnt_number;
		}
		if ($details->payment_mode == 1) {
			$prev = "MTES/2024-25/";
		} else {
			if ($details->aided_unaided == "Aided") {
				$prev = "MCE/2024-25/A/";
			} else {
				$prev = "MCE/2024-25/UA/";
			}
		}

		return $prev . $cnt_number;
	}

    
}
