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
			redirect('student/dashboard', 'refresh');
		}
	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$usn = $this->input->post('usn');

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

	function dashboard()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['id'] = $student_session['id'];
			$student_id = $student_session['id'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Dashboard";
			$data['menu'] = "dashboard";

			$this->student_template->show('student/dashboard', $data);
		} else {
			redirect('student', 'refresh');
		}
	}

	function profile()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['id'] = $student_session['id'];
			$data['usn'] = $student_session['usn'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "My Profile";
			$data['menu'] = "my_profile";

			$data['details'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();

			$this->student_template->show('student/profile', $data);
		} else {
			redirect('student', 'refresh');
		}
	}

	function personaldetails()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['id'] = $student_session['id'];
			$student_id = $student_session['id'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Edit Personal Details";
			$data['menu'] = "editpersonaldetails";

			$data['username'] = $student_session['username'];
			$data['id'] = $student_session['id'];
			$data['menu'] = "personaldetails";
			$data['userTypes'] = $this->globals->userTypes();
			$data['states'] = array(" " => "Select State") + $this->globals->states();
			$data['countries'] = $this->admin_model->getCountries();
			$data['states1'] = $this->admin_model->get_states();
			$data['admissionDetails'] = $this->admin_model->getDetails('students', $data['id'])->row();
			// var_dump($data['admissionDetails']); die();

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			// $data['admissions'] = $this->admin_model->get_details_by_id($id, 'id', 'admissions');

			$this->form_validation->set_rules('student_number', 'Student Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('father_number', 'Father Number', 'required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('state', 'State', 'required');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('aadhar_number', 'Aadhar Number', 'required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');

			if ($this->form_validation->run() === FALSE) {

				$data['action'] = 'student/personaldetails/' . $data['id'];

				$personalDetails = $this->admin_model->getDetails('students', $data['id'])->row();

				$data['student_number'] = $personalDetails->student_number;
				$data['father_number'] = $personalDetails->father_number;
				$data['state'] = $personalDetails->state;
				$data['country'] = $personalDetails->country;
				$data['email'] = $personalDetails->email;
				$data['gender'] = $personalDetails->gender;
				$data['aadhar_number'] = $personalDetails->aadhar_number;
				$data['date_of_birth'] = $personalDetails->date_of_birth;
				$this->student_template->show('student/personal_details', $data);
			} else {
				$updateDetails = array(
					'student_number' => $this->input->post('student_number'),
					'father_number' => $this->input->post('father_number'),
					'state' => $this->input->post('state'),
					'country' => $this->input->post('country'),
					'email' => $this->input->post('email'),
					'gender' => $this->input->post('gender'),
					'aadhar_number' => $this->input->post('aadhar_number'),
					'date_of_birth' => $this->input->post('date_of_birth'),
				);
				// print_r($updateDetails);
				// die();
				$result = $this->admin_model->updateDetails($data['id'], $updateDetails, 'students');

				// var_dump($this->db->last_query());
				// die();
				if ($result) {
					$this->session->set_flashdata('message', 'Personal Details updated successfully...!');
					$this->session->set_flashdata('status', 'alert-success');
				} else {
					$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
					$this->session->set_flashdata('status', 'alert-warning');
				}

				redirect('student/profile', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	function fees(): void
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['id'] = $student_session['id'];
			$data['usn'] = $student_session['usn'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Fees";
			$data['menu'] = "profile";

			$data['details'] = $this->admin_model->getDetailsbyfield($data['usn'], 'usn', 'students')->row();
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
			$acc_type = $this->input->post('type');

			$acc_type = 0;
			if ($acc_type == 0) {
				$mid = "CNBMLNDEGC";
				$clientid = "cnbmlndegc";
				$midkey = "WHjXW5WHk27mr50KetSh75vyapmO14IT";
				$returnurl = base_url() . 'student/callback';
				$page = 'student/payment';
			} else {
				$mid = "CNBMLNDTRT";
				$clientid = "cnbmlndtrt";
				$midkey = "k2ieff4ugn8Ehv31tUhXTRoHK2MEBrdJ";
				$returnurl = base_url() . 'student/callbackcorpus';
				$page = 'student/payment_corpus';
			}

			$this->load->library('logger');
			$insert = array(
				// 'amount' => number_format((float)$this->input->post('amount'), 2, '.', ''),
				'amount' => '100.00',
				'reg_no' => "2024058",
				'aided_unaided' => "Aided",
				'mobile' => "9035761122",
				'reference_no' => "2024058",
				'transaction_type' => '3',
				'academic_year' => "2024-2025",
				'admissions_id' => "60",
				'reference_date' => date('Y-m-d'),
				'payment_id' => "61",
				'transaction_status' => '0',
				'created_on' => date('Y-m-d h:i:s')
			);

			// $result = $this->admin_model->insertDetails('transactions', $insert);

			$headers = array(
				"alg" => "HS256",
				"clientid" => $clientid,
				"kid" => "HMAC"
			);
			$order_id = rand();
			$trace_id = rand(1000000000, 9999999999);
			$servertime = time();
			//    $config                         = $this->CI->config->item('billdesk');
			$api_url                        = "https://api.billdesk.com/payments/ve1_2/orders/create";
			$payload                        = array();


			$payload['orderid']             = $insert['reference_no'];
			$payload['mercid']              = $mid;
			$payload['order_date']          = date("c");
			$payload['amount']              = $insert['amount'];
			$payload['currency']            = '356';

			$payload['ru'] 	           =  $returnurl; // Return URL

			$payload['additional_info']    =  array(
				"additional_info1" => $insert['reg_no'],
				"additional_info2" => $this->input->post('name'),
				"additional_info3" => $this->input->post('email'),
				"additional_info4" => $insert['mobile'],
				"additional_info5" => "Fee Payment",
				"additional_info6" => $this->input->post('type'),
				"additional_info7" => $this->input->post('pay_id')
			);
			$payload['itemcode']           = 'DIRECT';
			$payload['device']             =  array(
				"init_channel" => "internet",
				"ip" => $_SERVER['REMOTE_ADDR'],
				"user_agent"    => $_SERVER['HTTP_USER_AGENT'],
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
			print_r($result_array);
			$message = "Billdesk create order response decoded - " . json_encode($result_array) . "\n";
			print_r($message);
			$this->logger->write('billdesk', 'debug', $message);
			die;
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
				redirect('student/fee_details', 'refresh');
			}
		} else {
			redirect('student', 'refresh');
		}
	}


	function changePassword()
	{
		if ($this->session->userdata('student_in')) {
			$student_session = $this->session->userdata('student_in');
			$data['id'] = $student_session['id'];
			$student_id = $student_session['id'];
			$data['student_name'] = $student_session['student_name'];
			$data['page_title'] = "Change Password";
			$data['menu'] = "change_password";
			$data['admissionDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();

			// $this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
			$this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
			$this->form_validation->set_rules('newpassword', 'New Password', 'required|min_length[8]|callback_check_password_strength');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[newpassword]');

			if ($this->form_validation->run() === FALSE) {

				$data['action'] = 'student/changePassword';
				$this->student_template->show('student/changepassword', $data);
			} else {
				// $oldPassword = $this->input->post('oldPassword');
				$oldpassword = $this->input->post('oldpassword');
				$newpassword = $this->input->post('newpassword');
				$confirmpassword = $this->input->post('confirmpassword');

				if ($oldpassword == $newpassword) {
					$this->session->set_flashdata('message', 'Old and New Password should not be same...!');
					$this->session->set_flashdata('status', 'alert-warning');
				} else {
					$updateDetails = array('password' => md5($newpassword));
					$result = $this->admin_model->changePassword($data['id'], $oldpassword, $updateDetails, 'students');
					if ($result) {
						$this->session->set_flashdata('message', 'Password udpated successfully...!');
						$this->session->set_flashdata('status', 'alert-success');
					} else {
						$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
						$this->session->set_flashdata('status', 'alert-warning');
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
}
