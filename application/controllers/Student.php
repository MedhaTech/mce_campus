<?php
defined('BASEPATH') or exit('No direct script access allowed');

use io\billdesk\client\hmacsha256\BillDeskJWEHS256Client;
use io\billdesk\client\Logging;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class Student extends CI_Controller
{
	private $client;

	protected function setUp(): void
	{
		$this->client = new BillDeskJWEHS256Client("https://pguat.billdesk.io", "cnbmlndegc", "WHjXW5WHk27mr50KetSh75vyapmO14IT");
		$logger = new Logger("default");
		$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
		$this->client->setLogger($logger);
	}

	function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
		$this->load->model('admin_model', '', TRUE);
		$this->load->library(array('table', 'form_validation'));
		$this->load->helper(array('form', 'form_helper', 'file'));
		date_default_timezone_set('Asia/Kolkata');
		ini_set('upload_max_filesize', '20M');
	}

	// function index()
	// {
	// 	$this->form_validation->set_rules('usn', 'USN', 'trim|required');
	// 	$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
	// 	if ($this->form_validation->run() == FALSE) {
	// 		$data['page_title'] = "Student Login";
	// 		$data['action'] = 'student';

	// 		$this->login_template->show('student/login', $data);
	// 	} else {
	// 		$usn = $this->input->post('usn');
	// 		redirect('student/dashboard', 'refresh');
	// 	}
	// }

	function index()
	{
		$this->form_validation->set_rules('usn', 'USN', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

		if ($this->form_validation->run() == FALSE) {
			$data['page_title'] = "Student Login";
			$data['action'] = 'student';
			$this->login_template->show('student/login', $data);
		} else {
			$usn = $this->input->post('usn');
			$student = $this->admin_model->get_student_by_usn($usn); // Fetch student details

			if ($student->change_password == 0) {
				// Redirect to change password page if password not changed yet
				redirect('student/changePassword', 'refresh');
			} else {
				// Proceed to dashboard if password is already changed
				redirect('student/dashboard', 'refresh');
			}
		}
	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$usn = trim($this->input->post('usn'));
		$password = trim($password);
		//query the database
		$result = $this->admin_model->studentlogin($usn, md5($password));
		if ($result) {
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array(
					'id' => $row->id,
					'usn' => $row->usn,
					'student_name' => $row->student_name,
					'flow' => $row->flow
				);
				$this->session->set_userdata('student_in', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid Usn or password');
			return false;
		}
	}

	// function dashboard()
	// {
	// 	if ($this->session->userdata('student_in')) {
	// 		$student_session = $this->session->userdata('student_in');
	// 		$data['id'] = $student_session['id'];
	// 		$student_id = $student_session['id'];
	// 		$data['student_name'] = $student_session['student_name'];
	// 		$data['page_title'] = "Dashboard";
	// 		$data['menu'] = "dashboard";

	// 		$this->student_template->show('student/dashboard', $data);
	// 	} else {
	// 		redirect('student', 'refresh');
	// 	}
	// }

	public function dashboard()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$student_id = $student_session['id'];
			$data['id'] = $student_id;
			$data['usn'] = $student_session['usn'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Dashboard";
			$data['menu'] = "dashboard";

			// Fetch student details, including change_password column
			$student = $this->admin_model->get_student_by_id($student_id);
			$data['change_password'] = $student->change_password;
			
			$data['details'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();

			$this->student_template->show('student/dashboard', $data);
		} else {
			redirect('student', 'refresh');
		}
	}

	// function profile()
	// {
	// 	if ($this->session->userdata('student_in')) {
	// 		$student_session = $this->session->userdata('student_in');
	// 		$data['id'] = $student_session['id'];
	// 		$data['usn'] = $student_session['usn'];
	// 		$data['student_name'] = $student_session['student_name'];
	// 		$data['page_title'] = "My Profile";
	// 		$data['menu'] = "my_profile";

	// 		$data['details'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();

	// 		$this->student_template->show('student/profile', $data);
	// 	} else {
	// 		redirect('student', 'refresh');
	// 	}
	// }

	public function profile()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$student_id = $student_session['id'];
			$data['id'] = $student_id;
			$data['usn'] = $student_session['usn'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "My Profile";
			$data['menu'] = "my_profile";

			// Fetch student details, including change_password column
			$student = $this->admin_model->get_student_by_id($student_id);
			$data['change_password'] = $student->change_password;

			$data['details'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();

			$this->student_template->show('student/profile', $data);
		} else {
			redirect('student', 'refresh');
		}
	}

	public function personaldetails()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$student_id = $student_session['id'];
			$data['id'] = $student_id;
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Edit Personal Details";
			$data['menu'] = "editpersonaldetails";
			$data['username'] = $student_session['username'];
			$data['userTypes'] = $this->globals->userTypes();
			$data['admissionDetails'] = $this->admin_model->getDetails('students', $student_id)->row();

			// Check if edit_status is already set to 1
			$currentDetails = $this->admin_model->getDetails('students', $student_id)->row();
			if ($currentDetails->edit_status == 1) {
				// Redirect to profile if already edited
				$this->session->set_flashdata('message', 'You have already edited your personal details.');
				$this->session->set_flashdata('status', 'alert-warning');
				redirect('student/profile', 'refresh');
			}

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

			// Set form validation rules
			$this->form_validation->set_rules('student_number', 'Student Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('father_number', 'Father Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');

			if ($this->form_validation->run() === FALSE) {
				// If validation fails, reload the form with existing details
				$data['action'] = 'student/personaldetails/' . $student_id;
				$personalDetails = $this->admin_model->getDetails('students', $student_id)->row();

				$data['student_number'] = $personalDetails->student_number;
				$data['father_number'] = $personalDetails->father_number;
				$data['email'] = $personalDetails->email;
				$data['date_of_birth'] = $personalDetails->date_of_birth;

				$this->student_template->show('student/personal_details', $data);
			} else {
				// Update personal details after validation
				$updateDetails = array(
					'student_number' => $this->input->post('student_number'),
					'father_number' => $this->input->post('father_number'),
					'email' => $this->input->post('email'),
					'date_of_birth' => $this->input->post('date_of_birth'),
				);

				$result = $this->admin_model->updateDetails($student_id, $updateDetails, 'students');

				if ($result) {
					$this->admin_model->updateEditStatus($student_id, 1);

					$this->session->set_flashdata('message', 'Personal Details updated successfully...!');
					$this->session->set_flashdata('status', 'alert-success');
				} else {
					$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
					$this->session->set_flashdata('status', 'alert-warning');
				}

				// Redirect to the student profile after update
				redirect('student/profile', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	// function fees(): void
	// {
	// 	if ($this->session->userdata('student_in')) {
	// 		$student_session = $this->session->userdata('student_in');
	// 		$data['id'] = $student_session['id'];
	// 		$data['usn'] = $student_session['usn'];
	// 		$data['student_name'] = $student_session['student_name'];
	// 		$data['page_title'] = "Fees";
	// 		$data['menu'] = "profile";
	// 		$data['action'] = "student/pay_now";
	// 		$data['voucher_types'] = $this->globals->voucher_types();
	// 		$data['paymentDetail'] = $this->admin_model->getDetailsbyfield2('usn',$data['usn'], 'offline','0', 'payment_structure1')->result();
	// 		$data['transactionDetails'] = $this->admin_model->getDetailsbyfield($data['usn'], 'reg_no', 'transactions')->result();
	// 		$data['student'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();
	// 		$data['fees'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'fee_master')->result();

	// 		$this->student_template->show('student/fees', $data);
	// 	} else {
	// 		redirect('student', 'refresh');
	// 	}
	// }

	public function fees(): void
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$student_id = $student_session['id'];
			$data['id'] = $student_id;
			$data['usn'] = $student_session['usn'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Fees";
			$data['menu'] = "fees";

			// Fetch student details, including change_password column
			$student = $this->admin_model->get_student_by_id($student_id);
			$data['change_password'] = $student->change_password;

			$data['action'] = "student/pay_now";
			$data['voucher_types'] = $this->globals->voucher_types();
			$data['paymentDetail'] = $this->admin_model->getDetailsbyfield2('usn', $data['usn'], 'offline', '0', 'payment_structure1')->result();
			$data['transactionDetails'] = $this->admin_model->getDetailsbyfield($data['usn'], 'reg_no', 'transactions')->result();
			$data['student'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();
			$data['fees'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'fee_master')->result();

			$this->student_template->show('student/fees', $data);
		} else {
			redirect('student', 'refresh');
		}
	}

	public function pay_now()
	{

		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['student_name'] = $student_session['student_name'];
			$data['id'] = $student_session['id'];
			require_once APPPATH . 'libraries/Jwt.php';
			$acc_type = $this->input->post('payment_mode');
			$aided_unaided = $this->input->post('aided_unaided');


			if ($acc_type == 0) {

				if ($aided_unaided == 'Aided') {

					$mid = "CNBMLNDAID";
					$clientid = "cnbmlndaid";
					$midkey = "hbjUTwdjLDwzsFErRVCE0y0skHic1z2B";
					$returnurl = base_url() . 'student/callbackaided';
					$page = 'student/payment_aided';

				} else {

					$mid = "CNBMLNDEGC";
					$clientid = "cnbmlndegc";
					$midkey = "WHjXW5WHk27mr50KetSh75vyapmO14IT";
					$returnurl = base_url() . 'student/callback';
					$page = 'student/payment';

				}

				$payment_mode = 0;

			} else {
				$mid = "CNBMLNDTRT";
				$clientid = "cnbmlndtrt";
				$midkey = "k2ieff4ugn8Ehv31tUhXTRoHK2MEBrdJ";
				$returnurl = base_url() . 'student/callbackcorpus';
				$page = 'student/payment_corpus';
				$payment_mode = 1;
			}

			$this->load->library('logger');
			$insert = array(
				'amount' => number_format((float) $this->input->post('amount'), 2, '.', ''),
				// 'amount' => '100.00',
				'reg_no' => $this->input->post('usn'),
				'year' => $this->input->post('year'),
				'aided_unaided' => $this->input->post('aided_unaided'),
				'mobile' => $this->input->post('mobile'),
				'reference_no' => $this->input->post('usn') . time(),
				'transaction_type' => '3',
				'academic_year' => "2024-2025",
				'admissions_id' => "60",
				'reference_date' => date('Y-m-d'),
				'payment_id' => $this->input->post('pay_id'),
				'payment_mode' => $payment_mode,
				'transaction_status' => '0',
				'created_on' => date('Y-m-d h:i:s')
			);

			$result = $this->admin_model->insertDetails('transactions', $insert);

			$headers = array(
				"alg" => "HS256",
				"clientid" => $clientid,
				"kid" => "HMAC"
			);
			$order_id = rand();
			$trace_id = rand(1000000000, 9999999999);
			$servertime = time();
			//    $config                         = $this->CI->config->item('billdesk');
			$api_url = "https://api.billdesk.com/payments/ve1_2/orders/create";
			$payload = array();


			$payload['orderid'] = $insert['reference_no'];
			$payload['mercid'] = $mid;
			$payload['order_date'] = date("c");
			$payload['amount'] = $insert['amount'];
			$payload['currency'] = '356';

			$payload['ru'] = $returnurl; // Return URL

			$payload['additional_info'] = array(
				"additional_info1" => $insert['reg_no'],
				"additional_info2" => $this->input->post('name'),
				"additional_info3" => $this->input->post('email'),
				"additional_info4" => $insert['mobile'],
				"additional_info5" => "Fee Payment",
				"additional_info6" => $this->input->post('payment_mode'),
				"additional_info7" => $this->input->post('aided_unaided')
			);
			$payload['itemcode'] = 'DIRECT';
			$payload['device'] = array(
				"init_channel" => "internet",
				"ip" => $_SERVER['REMOTE_ADDR'],
				"user_agent" => $_SERVER['HTTP_USER_AGENT'],
				"accept_header" => "text/html",
			);


			/*****************************************/
			// Encode payload
			/*****************************************/
			$curl_payload = JWT::encode($payload, $midkey, "HS256", $headers);



			/*****************************************/
			// Submit to Billdesk
			/*****************************************/
			$ch = curl_init($api_url);
			$ch_headers = array(
				"Content-Type: application/jose",
				"accept: application/jose",
				"bd-traceid: $trace_id",
				"bd-timestamp: $servertime"
			);

			// Append additional headers
			$ch_headers[] = "Content-Length: " . strlen($curl_payload);
			// pr($ch_headers);exit;
			$message = "Billdesk create order curl header - " . json_encode($ch_headers) . "\n";
			$this->logger->write('billdesk', 'debug', $message);
			$message1 = "Billdesk Request payload - " . $curl_payload . "\n";
			$this->logger->write('billdesk', 'debug', $message1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $ch_headers);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_payload);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			$message2 = "Billdesk create order response - " . $response . "\n";
			$this->logger->write('billdesk', 'debug', $message2);
			curl_close($response);
			$result_decoded = JWT::decode($response, $midkey, 'HS256');
			$result_array = (array) $result_decoded;
			// print_r($result_array);
			$message = "Billdesk create order response decoded - " . json_encode($result_array) . "\n";
			// print_r($message);
			$this->logger->write('billdesk', 'debug', $message);

			if ($result_decoded->status == 'ACTIVE') {
				$transactionid = $result_array['links'][1]->parameters->bdorderid;
				$authtoken = $result_array['links'][1]->headers->authorization;
				$requestParams['order_id'] = $result_decoded->orderid;
				$requestParams['merchantId'] = $result_decoded->mercid;
				$requestParams['transactionid'] = $transactionid;
				$requestParams['authtoken'] = $authtoken;
				// return $requestParams;
				$this->load->view($page, $requestParams);
			} else {
				$status = isset($result_decoded->status) ? $result_decoded->status : "Status not available";
				$message = "Billdesk create order status - " . $status;
				$this->logger->write('billdesk', 'debug', $message);
				$this->session->set_flashdata('process', 'Sorry, something went wrong. Please try again later.');
				redirect('student/fees', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	public function set_session($usn, $mobile)
	{
		//Field validation succeeded.  Validate against database
		$usn = $this->input->post('usn');

		//query the database
		$result = $this->admin_model->set_session($usn, $mobile);
		if ($result) {
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array(
					'id' => $row->id,
					'student_name' => $row->student_name

				);
				$this->session->set_userdata('student_in', $sess_array);
			}
			return TRUE;
		} else {

			return false;
		}
	}

	public function callbackaided()
	{
		require_once APPPATH . 'libraries/Jwt.php';
		$this->load->library('logger');
		$message = "BillDesk Response - " . json_encode($_POST) . "\n";
		$this->logger->write('billdesk', 'debug', $message);
		$tx = "";
		if (!empty($_POST)) {
			$tx_array = $_POST;
			if (isset($tx_array['transaction_response'])) {
				$tx = $tx_array['transaction_response'];
			}


			if (!empty($tx)) {
				$response_decoded = JWT::decode($tx, "hbjUTwdjLDwzsFErRVCE0y0skHic1z2B", 'HS256');
				$response_array = (array) $response_decoded;
				$response_json = json_encode($response_array);
				$message = "BillDesk callback Response decode - " . $response_json . "\n";
				$this->logger->write('billdesk', 'debug', $message);

				if ($response_array['auth_status'] == '0300') {
					$status = 'pass';
				} else if ($response_array['auth_status'] == '0002') {
					$status = 'unknown';
				} else {
					$status = 'fail';
				}



				$return['amount'] = (int) $response_array['amount'];
				$return['order_id'] = $response_array['orderid'];
				$return['status'] = $status;
				$return['pgresponse'] = $response_json;
				$return['pgid'] = $response_array['transactionid'];

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
					$updateDetails1['status'] = '1';
				} else if ($response_array['transaction_error_type'] == 'payment_processing_error') {
					$updateDetails['transaction_status'] = '2';
					$updateDetails1['status'] = '2';
				} else {
					$updateDetails['transaction_status'] = '0';
					$updateDetails1['status'] = '0';
				}

				$this->set_session($response_array['additional_info']->additional_info3, $response_array['additional_info']->additional_info4);

				$result = $this->admin_model->updateDetailsbyfield('reference_no', $response_array['orderid'], $updateDetails, 'transactions');
				$result1 = $this->admin_model->update_payment_structure($response_array['orderid'], $updateDetails1);
				$payment = ['orderid' => $response_array['orderid']];
				$this->session->set_userdata('payment', $payment);

				redirect('student/payment_status', 'refresh');
			} else {
				$status = 'fail';
				$return['status'] = $status;
				redirect('student', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	public function callback()
	{
		require_once APPPATH . 'libraries/Jwt.php';
		$this->load->library('logger');
		$message = "BillDesk Response - " . json_encode($_POST) . "\n";
		$this->logger->write('billdesk', 'debug', $message);
		$tx = "";
		if (!empty($_POST)) {
			$tx_array = $_POST;
			if (isset($tx_array['transaction_response'])) {
				$tx = $tx_array['transaction_response'];
			}


			if (!empty($tx)) {
				$response_decoded = JWT::decode($tx, "WHjXW5WHk27mr50KetSh75vyapmO14IT", 'HS256');
				$response_array = (array) $response_decoded;
				$response_json = json_encode($response_array);
				$message = "BillDesk callback Response decode - " . $response_json . "\n";
				$this->logger->write('billdesk', 'debug', $message);

				if ($response_array['auth_status'] == '0300') {
					$status = 'pass';
				} else if ($response_array['auth_status'] == '0002') {
					$status = 'unknown';
				} else {
					$status = 'fail';
				}



				$return['amount'] = (int) $response_array['amount'];
				$return['order_id'] = $response_array['orderid'];
				$return['status'] = $status;
				$return['pgresponse'] = $response_json;
				$return['pgid'] = $response_array['transactionid'];

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
					$updateDetails1['status'] = '1';
				} else if ($response_array['transaction_error_type'] == 'payment_processing_error') {
					$updateDetails['transaction_status'] = '2';
					$updateDetails1['status'] = '2';
				} else {
					$updateDetails['transaction_status'] = '0';
					$updateDetails1['status'] = '0';
				}

				$this->set_session($response_array['additional_info']->additional_info3, $response_array['additional_info']->additional_info4);

				$result = $this->admin_model->updateDetailsbyfield('reference_no', $response_array['orderid'], $updateDetails, 'transactions');
				$result1 = $this->admin_model->update_payment_structure($response_array['orderid'], $updateDetails1);
				$payment = ['orderid' => $response_array['orderid']];
				$this->session->set_userdata('payment', $payment);

				redirect('student/payment_status', 'refresh');
			} else {
				$status = 'fail';
				$return['status'] = $status;
				redirect('student', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	public function callbackcorpus()
	{
		require_once APPPATH . 'libraries/Jwt.php';
		$this->load->library('logger');
		$message = "BillDesk Response - " . json_encode($_POST) . "\n";
		$this->logger->write('billdesk', 'debug', $message);
		$tx = "";
		if (!empty($_POST)) {
			$tx_array = $_POST;
			if (isset($tx_array['transaction_response'])) {
				$tx = $tx_array['transaction_response'];
			}


			if (!empty($tx)) {
				$response_decoded = JWT::decode($tx, "k2ieff4ugn8Ehv31tUhXTRoHK2MEBrdJ", 'HS256');
				$response_array = (array) $response_decoded;
				$response_json = json_encode($response_array);
				$message = "BillDesk callback Response decode - " . $response_json . "\n";
				$this->logger->write('billdesk', 'debug', $message);

				if ($response_array['auth_status'] == '0300') {
					$status = 'pass';
				} else if ($response_array['auth_status'] == '0002') {
					$status = 'unknown';
				} else {
					$status = 'fail';
				}



				$return['amount'] = (int) $response_array['amount'];
				$return['order_id'] = $response_array['orderid'];
				$return['status'] = $status;
				$return['pgresponse'] = $response_json;
				$return['pgid'] = $response_array['transactionid'];

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
					$updateDetails1['status'] = '1';
				} else if ($response_array['transaction_error_type'] == 'payment_processing_error') {
					$updateDetails['transaction_status'] = '2';
					$updateDetails1['status'] = '2';
				} else {
					$updateDetails['transaction_status'] = '0';
					$updateDetails1['status'] = '0';
				}

				$this->set_session($response_array['additional_info']->additional_info3, $response_array['additional_info']->additional_info4);

				$result = $this->admin_model->updateDetailsbyfield('reference_no', $response_array['orderid'], $updateDetails, 'transactions');
				$result1 = $this->admin_model->update_payment_structure($response_array['orderid'], $updateDetails1);

				$payment = ['orderid' => $response_array['orderid']];
				$this->session->set_userdata('payment', $payment);

				redirect('student/payment_status', 'refresh');
			} else {
				$status = 'fail';
				$return['status'] = $status;
				redirect('student', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}
	function payment_status()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['id'] = $student_session['id'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Payment Status";
			$data['menu'] = "payment";
			$payment_session = $this->session->userdata('payment');

			$orderid = $payment_session['orderid'];
			$data['orderdetails'] = $this->admin_model->getDetailsbyfield($orderid, 'reference_no', 'transactions')->row();

			$this->student_template->show('student/payment_status', $data);
		} else {
			redirect('student', 'refresh');
		}
	}


	// function changePassword()
	// {
	// 	if ($this->session->userdata('student_in')) {
	// 		$student_session = $this->session->userdata('student_in');
	// 		$data['id'] = $student_session['id'];
	// 		$student_id = $student_session['id'];
	// 		$data['student_name'] = $student_session['student_name'];
	// 		$data['page_title'] = "Change Password";
	// 		$data['menu'] = "change_password";
	// 		$data['admissionDetails'] = $this->admin_model->getDetails('students', $data['id'])->row();

	// 		// $this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
	// 		$this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
	// 		$this->form_validation->set_rules('newpassword', 'New Password', 'required|min_length[8]|callback_check_password_strength');
	// 		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[newpassword]');

	// 		if ($this->form_validation->run() === FALSE) {

	// 			$data['action'] = 'student/changePassword';
	// 			$this->student_template->show('student/changepassword', $data);
	// 		} else {
	// 			// $oldPassword = $this->input->post('oldPassword');
	// 			$oldpassword = $this->input->post('oldpassword');
	// 			$newpassword = $this->input->post('newpassword');
	// 			$confirmpassword = $this->input->post('confirmpassword');

	// 			if ($oldpassword == $newpassword) {
	// 				$this->session->set_flashdata('message', 'Old and New Password should not be same...!');
	// 				$this->session->set_flashdata('status', 'alert-warning');
	// 			} else {
	// 				$updateDetails = array('password' => md5($newpassword));
	// 				$result = $this->admin_model->changePassword($data['id'], $oldpassword, $updateDetails, 'students');
	// 				if ($result) {
	// 					$this->session->set_flashdata('message', 'Password udpated successfully...!');
	// 					$this->session->set_flashdata('status', 'alert-success');
	// 				} else {
	// 					$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
	// 					$this->session->set_flashdata('status', 'alert-warning');
	// 				}
	// 			}
	// 			redirect('/student/changePassword', 'refresh');
	// 		}
	// 	} else {
	// 		redirect('student', 'refresh');
	// 	}
	// }

	public function changePassword()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$student_id = $student_session['id'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Change Password";
			$data['menu'] = "change_password";
			$data['admissionDetails'] = $this->admin_model->getDetails('students', $student_id)->row();

			// Fetch student details, including change_password column
			$student = $this->admin_model->get_student_by_id($student_id);
			$data['change_password'] = $student->change_password;

			// Set security message if the password needs to be changed
			if ($data['change_password'] == 0) {
				$data['security_message'] = "For security reasons and to ensure proper access to the application, we kindly request that you change your password from the default USN.";
			} else {
				$data['security_message'] = ""; // No message if the password has already been changed
			}

			$this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
			$this->form_validation->set_rules('newpassword', 'New Password', 'required|min_length[8]|callback_check_password_strength');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[newpassword]');

			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'student/changePassword';
				$this->student_template->show('student/changepassword', $data);
			} else {
				$oldpassword = $this->input->post('oldpassword');
				$newpassword = $this->input->post('newpassword');

				if ($oldpassword == $newpassword) {
					$this->session->set_flashdata('message', 'Old and New Password should not be the same!');
					$this->session->set_flashdata('status', 'alert-warning');
				} else {
					// Call model function to change password
					$result = $this->admin_model->change_password($student_id, $oldpassword, $newpassword);

					if ($result) {
						$this->session->set_flashdata('message', 'Password updated successfully!');
						$this->session->set_flashdata('status', 'alert-success');

						// Logout the student after password change
						$this->session->unset_userdata('student_in');
						$this->session->sess_destroy();

						// Redirect to login page with a message
						$this->session->set_flashdata('message', 'Password updated. Please log in again with your new password.');
						redirect('student', 'refresh');
					} else {
						$this->session->set_flashdata('message', 'Old password incorrect. Please try again.');
						$this->session->set_flashdata('status', 'alert-danger');
					}
				}

				redirect('/student/changePassword', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	public function check_password_strength($password)
	{
		// Check for at least one uppercase, one lowercase, one number, and one special character
		if (
			preg_match('/[A-Z]/', $password) &&
			preg_match('/[a-z]/', $password) &&
			preg_match('/[0-9]/', $password) &&
			preg_match('/[\W]/', $password)
		) {
			return TRUE;
		} else {
			$this->form_validation->set_message('check_password_strength', 'The {field} must contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
			return FALSE;
		}
	}


	function logout()
	{
		$this->session->unset_userdata('student_in');
		session_destroy();
		redirect('student', 'refresh');
	}

	function downloadReceipt($usn, $transaction_id)
	{
		if ($this->session->userdata('student_in')) {
			$sess = $this->session->userdata('student_logs');
			$data['id'] = $session_data['id'];
			$data['name'] = $sess['name'];
			// $data['mobile'] = $sess['mobile'];

			$data['page_title'] = 'Download Receipt';
			$data['menu'] = 'studnet';

			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$transactionDetails = $this->admin_model->getDetails('transactions', $transaction_id)->row();
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$paid_amount = $this->admin_model->paidfee('reg_no', $usn, 'transaction_status', '1', 'transactions');
			$studentfeeDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();


			$fees = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();
			$balance_amount = $fees->final_fee - $paid_amount;
			$voucherDetails = $this->admin_model->getDetails('payment_structure', $transactionDetails->payment_id)->row();
			$feeDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();
			$this->load->library('fpdf'); // Load library
			ini_set("session.auto_start", 0);
			ini_set('memory_limit', '-1');
			define('FPDF_FONTPATH', 'plugins/font');




			$pdf = new FPDF();
			$pdf->AddPage('P', 'A4'); // 'P' for portrait orientation, 'A4' for A4 size (210x297 mm)

			// Set margins
			$pdf->SetMargins(20, 20, 20);

			$pdf->SetFont('Arial', 'B', 9);

			// Centered header
			// $cellWidth = 40;
			// $cellHeight = 5;
			$pdf->SetFont('Arial', '', 9);
			if ($transactionDetails->payment_mode == 0) {

				$collegeName = "MALNAD COLLEGE OF ENGINEERING";
				$collegeName1 = "Autonomous Institute Affiliated to the VTU";
				$collegeName2 = "Under the auspices of the MTES (R),";
				$collegeName3 = "PB NO. 21,SALAGAME ROAD HASSAN, KARNATAKA";
				$contactInfo = "FEES RECEIPT - " . $admissionDetails->sub_quota;
				$tableData[] = ['Tution Fee', $transactionDetails->amount];
			} else {

				$collegeName = "MALNAD TECHNICAL EDUCATION SOCIETY (R)";
				$collegeName1 = "REGD NO. S .2080/589 Dtd 22.01.1959";
				$collegeName2 = "BESIDE MCE GANAPATHI TEMPLE ,MG ROAD,VIDYANAGAR,HASSAN-573202";
				$collegeName3 = "STATE-KARNATAKA";
				$contactInfo = "CORPUS FUND RECEIPT";
				$tableData[] = ['Corpus Fund', $transactionDetails->amount];
			}




			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(0, 2, $collegeName, 0, 1, 'C');


			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(160, 8, $collegeName1, 0, 1, 'C');


			$pdf->Cell(161, 1, $collegeName2, 0, 1, 'C');
			$pdf->SetFont('Arial', '', 8);
			$pdf->Cell(160, 7, $collegeName3, 0, 1, 'C');
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(160, 7, $contactInfo, 0, 1, 'C');

			$pageWidth = $pdf->GetPageWidth();
			$xPos = ($pageWidth - $cellWidth) / 2;
			// // Amount Paid Box

			// Transaction Details Table
			$pdf->Ln(3);
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor(33, 33, 33);
			$rowHeight = 7;
			$cellWidth1 = 80; // Width for the label column
			$cellWidth2 = 70; // Width for the value column
			$pdf->SetX(10);
			// $pdf->Cell($cellWidth1 + $cellWidth2, $rowHeight, 'TRANSACTION DETAILS:', 0, 1, 'L');
			$boxWidth = 188;
			$boxHeight = 8;
			$boxXPos = ($pageWidth - $boxWidth) / 2;
			$pdf->SetX($boxXPos);
			$pdf->SetFillColor(230, 230, 230);
			$pdf->Rect($boxXPos, $pdf->GetY(), $boxWidth, $boxHeight, 'F');
			$pdf->SetX($boxXPos + 2);
			$pdf->Cell($boxWidth, $boxHeight, 'STUDENT DETAILS', 0, 1, 'L');
			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 1, 0);

			function printStudent($pdf, $label, $value, $startY, $rowHeight, $cellWidth1, $cellWidth2)
			{
				$pdf->SetXY(13, $startY);
				$pdf->Cell($cellWidth1, $rowHeight, $label, 0, 0, 'L', false);
				$pdf->Cell(10, $rowHeight, ':', 0, 0, 'L', false);
				$pdf->Cell($cellWidth2, $rowHeight, $value, 0, 1, 'L', false);
			}
			$pdf->Ln(2);

			printStudent($pdf, "USN ", $admissionDetails->usn, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Student Name ", $admissionDetails->student_name, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Email ID ", $admissionDetails->email, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Mobile Number ", $admissionDetails->student_number, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Category Claimed ", $admissionDetails->category_claimed, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Quota ", $admissionDetails->quota, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "College Code ", $admissionDetails->college_code, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Gender ", $admissionDetails->gender, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Year ", $feeDetails->year, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printStudent($pdf, "Ug ", 'Ug - ' . $admissionDetails->department, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			// printStudent($pdf, "Pg :", '', $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			$pdf->Ln(4);

			// Student Details Table

			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetX(10);
			$boxWidth = 188;
			$boxHeight = 8;
			$boxXPos = ($pageWidth - $boxWidth) / 2;
			$pdf->SetX($boxXPos);
			$pdf->SetFillColor(230, 230, 230);
			$pdf->Rect($boxXPos, $pdf->GetY(), $boxWidth, $boxHeight, 'F');
			$pdf->SetX($boxXPos + 2);
			$pdf->Cell($boxWidth, $boxHeight, 'PAYMENT DESCRIPTION', 0, 1, 'L');
			$pdf->Ln(1);
			$pdf->SetFont('Arial', '', 11);
			$pdf->SetTextColor(0, 0, 0);

			function printRow($pdf, $label, $value, $startY, $rowHeight, $cellWidth1, $cellWidth2)
			{
				$pdf->SetXY(13, $startY);
				$pdf->Cell($cellWidth1, $rowHeight, $label, 0, 0, 'L', false);
				$pdf->Cell(10, $rowHeight, ':', 0, 0, 'L', false);
				$pdf->Cell($cellWidth2, $rowHeight, $value, 0, 1, 'L', false);
				$pdf->Ln(1);
			}

			printRow($pdf, "Fee Receipt Number ", $transactionDetails->receipt_no, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printRow($pdf, "Transaction Status ", 'Successful', $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printRow($pdf, "Transaction Date-Time ", date('d-m-Y', strtotime($transactionDetails->transaction_date)), $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printRow($pdf, "Transaction ID ", $transactionDetails->transaction_id, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			printRow($pdf, "Payment Ref No ", $transactionDetails->reference_no, $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			if ($voucherDetails->type == 0) {
				foreach ($tableData as $row) {

					printRow($pdf, $row[0], number_format($row[1], 2), $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
				}
			}
			printRow($pdf, "Amount In Rupees :", number_format($transactionDetails->amount, 2), $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
			$pdf->Ln(1);

			// // Amount in Words Heading
			$pdf->Ln(4);
			$pdf->SetX(13);
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(0, $cellHeight, 'Amount In Words:' . convert_number_to_words($transactionDetails->amount) . ' Only', 0, 1, 'L');

			// Note and Receipt Date
			$cellWidth = $pdf->GetPageWidth() - 20;
			$rowHeight = 10;
			$pdf->Ln(60);
			$pdf->SetFont('Arial', '', 8);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetX(12);
			$pdf->Cell($cellWidth, $rowHeight, 'NOTE: THIS IS A COMPUTER GENERATED RECEIPT AND DOES NOT REQUIRED SIGNATURE.', 0, 1, 'L');
			$pdf->SetX(12);
			$pdf->Cell($cellWidth, $rowHeight, 'RECEIPT GENERATED DATE & TIME : ' . date('F j, Y h:i:s A'), 0, 1, 'L');

			// $pdf->Output();
			$fileName = $admissionDetails->student_name . '-Receipt.pdf';
			$pdf->output($fileName, 'D');
		} else {
			redirect('student', 'refresh');
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
