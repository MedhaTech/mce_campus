<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
		$this->load->model('admin_model', '', TRUE);
		$this->load->library(array('table', 'form_validation'));
		$this->load->helper(array('form', 'form_helper'));

		date_default_timezone_set('Asia/Kolkata');
		ini_set('upload_max_filesize', '20M');
	}

	function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
		if ($this->form_validation->run() == FALSE) {
			$data['page_title'] = "Admin Login";
			$data['action'] = 'admin';

			$this->login_template->show('admin/login', $data);
		} else {
			$username = $this->input->post('username');
			redirect('admin/dashboard', 'refresh');
		}
	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username') . '@mcehassan.ac.in';

		//query the database
		$result = $this->admin_model->login($username, md5($password));

		if ($result) {
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array(
					'id' => $row->user_id,
					'username' => $row->username,
					'full_name' => $row->full_name,
					'role' => $row->role
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}

	function dashboard()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = "Dashboard";
			$data['menu'] = "dashboard";
			$data['enquiryStatus'] = $this->globals->enquiryStatus();
			$data['enquiryStatusColor'] = $this->globals->enquiryStatusColor();
			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();

			$this->admin_template->show('admin/dashboard', $data);
		} else {
			redirect('admin', 'refresh');
		}
	}

	function students($status = '')
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = "Students";
			$data['menu'] = "students";

			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();
			$data['students'] = $this->admin_model->fetchDetails1('id, quota,department,sub_quota, student_name, student_number,usn,status', 'status', $status, 'students')->result();


			$this->admin_template->show('admin/students', $data);
		} else {
			redirect('admin', 'refresh');
		}
	}

	function reports()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = "Reports";
			$data['menu'] = "reports";

			$this->admin_template->show('admin/reports', $data);
		} else {
			redirect('admin', 'refresh');
		}
	}

	public function fee_details()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Fee Details Report';
			$data['menu'] = 'reports';

			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();
			$data['academicYears'] = array("" => "Select") + $this->globals->academicYears();
			$data['quota_options'] = array("0" => "All") + $this->globals->quota();
			$data['department_options'] = array("0" => "All") + $this->departments();


			$this->admin_template->show('admin/report_fee_details', $data);
		} else {
			redirect('admin/timeout');
		}
	}

	public function fee_details_report()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Fee Details Report';
			$data['menu'] = 'reports';

			$academic_year = $this->input->post('academic_year');
			$department = $this->input->post('department');
			$quota = $this->input->post('quota');
			$year = $this->input->post('year');

			$results = $this->admin_model->get_fee_details($academic_year, $department, $quota, $year)->result();
			if ($results) {
				$table_setup = array('table_open' => '<table class="table table-bordered" border="1" id="example2" >');
				$this->table->set_template($table_setup);
				$print_fields = array('SL. No.', 'STUDENT NAME', 'USN', 'College Code', 'EMAIL', 'Gender', 'AADHAR NUMBER', 'Quota', 'Sub Quota', 'Category Allotted', 'Category Claimed', 'Caste', 'Sub caste', 'Father Number', 'Student Number', 'State', 'Country', 'Stream', 'Department', 'Year', 'TOTAL UNIVERSITY OTHER FEE', 'COLLEGE OTHER FEE', 'EXAM FEE', 'TUITION FEE', 'College fee demand', 'College fee collection', 'COLLEGE FEE BALANCE', 'RECEIPT-No & Date', 'ONLINE PAYMENT DETAILS', 'REMARKS', 'Comments', 'Corpus fee demand', 'Corpus fee collection', 'CORPUS FEE Balance', 'RECEIPT-No & Date', 'ONLINE PAYMENT DETAILS', 'REMARKS', 'Comments');
				$this->table->set_heading($print_fields);
				$i = 1;
				foreach ($results as $results1) {
					$result_array = array(
						$i++,
						$results1->student_name,
						$results1->usn,
						$results1->college_code,
						$results1->email,
						$results1->gender,
						$results1->aadhar_number,
						$results1->quota,
						$results1->sub_quota,
						$results1->category_allotted,
						$results1->category_claimed,
						$results1->caste,
						$results1->sub_caste,
						$results1->father_number,
						$results1->student_number,
						$results1->state,
						$results1->country,
						$results1->stream,
						$results1->department,
						$results1->year,
						$results1->total_university_other_fee,
						$results1->college_other_fees,
						$results1->exam_fee,
						$results1->tuition_fee,
						$results1->college_fee_demand,
						$results1->college_fee_collection,
						$results1->balance,
						$results1->college_receipts,
						$results1->college_payments,
						$results1->college_remarks,
						$results1->college_comments,
						$results1->corpus_fee_demand,
						$results1->corpus_fee_collection,
						$results1->corpus_balance,
						$results1->corpus_receipts,
						$results1->corpus_payments,
						$results1->corpus_remarks,
						$results1->corpus_comments
					);
					$this->table->add_row($result_array);
				}
				$details = $this->table->generate();
			} else {
				$details = 'No student details found';
			}
			$response = array(
				'op' => 'ok',
				'file' => "data:application/vnd.ms-excel;base64," . base64_encode($details)
			);
			die(json_encode($response));
		} else {
			redirect('admin/timeout');
		}
	}

	function dateTransactions()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = "Dashboard";
			$data['menu'] = "dashboard";
			$data['transactionTypes'] = $this->globals->transactionTypes();

			// $from = date('Y-m-d');
			// $from = date('Y-m-d');
			$details = $this->admin_model->dateTransactions()->result();
			// echo "<pre>";
			// print_r($details);
			$res = array();
			foreach ($details as $details1) {
				$am = array();
				$am[$details1->transaction_type] = $details1->total_amount;
				if (array_key_exists($details1->transaction_date, $res)) {
					// array_push($res[$details1->transaction_date], $am);
					$res[$details1->transaction_date][$details1->transaction_type] = $details1->total_amount;
				} else {
					$res[$details1->transaction_date] = $am;
				}
				// $am = array();
				// $am[$details1->transaction_type] = $details1->total_amount;
				// $res[$details1->transaction_date] = 0;
			}
			// print_r($res);
			$data['res'] = $res;
			$this->admin_template->show('admin/day_transactions', $data);
		} else {
			redirect('admin', 'refresh');
		}
	}

	public function department_quota_report($download = '')
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'ACADEMIC YEAR REPORT';
			$data['menu'] = 'reports';
			// $data['report_type'] = $report;
			$admissionStatus = $this->globals->admissionStatus();
			$admissionStatusColor = $this->globals->admissionStatusColor();
			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();
			$data['quota_options'] = array(" " => "Select Quota") + $this->globals->quota();
			$data['course_options'] = array(" " => "Select Course") + $this->courses();
			$data['action'] = 'admin/department_quota_report';
			$this->form_validation->set_rules('academic_year', 'Academic year', 'required');
			$this->form_validation->set_rules('course', 'Course', 'required');
			$this->form_validation->set_rules('quota', 'Quota', 'required');
			if ($this->form_validation->run() === FALSE) {

				$this->admin_template->show('admin/department_quota_report', $data);
			} else {
				$data['academic_year'] = $this->input->post('academic_year');
				$data['course'] = $this->input->post('course');
				$data['quota'] = $this->input->post('quota');

				$admissions = $this->admin_model->getAdmissions_quota($data['currentAcademicYear'], $data['course'], $data['quota'])->result();

				// var_dump($admissions); die();

				if (count($admissions)) {
					$table_setup = array('table_open' => '<table class="table dt-responsive nowrap table-bordered" border="1" id="basic-datatable">');
					$this->table->set_template($table_setup);
					$print_fields = array('S.No', 'Academic Year', 'Applicant Name', 'Mobile', 'Course', 'Aadhaar Number', 'Quota', 'Sub Quota', 'Status', 'Admit. Date');
					$this->table->set_heading($print_fields);

					$i = 1;
					foreach ($admissions as $admissions1) {
						$dmn = $this->admin_model->get_dept_by_id($admissions1->dept_id)["department_name"];
						$result_array = array(
							$i++,
							$admissions1->academic_year,
							$admissions1->student_name,
							$admissions1->mobile,
							$dmn,
							$admissions1->aadhaar,
							$admissions1->quota,
							$admissions1->sub_quota,
							'<strong class="text-' . $admissionStatusColor[$admissions1->status] . '">' . $admissionStatus[$admissions1->status] . '</strong>',
							date('d-m-Y h:i A', strtotime($admissions1->admit_date))
						);
						$this->table->add_row($result_array);
						$course = $data['course_options'][$course_id];
					}
					$details = $this->table->generate();
				} else {
					$details = 'No student details found';
				}
				if ($download == 1) {
					$response = array(
						'op' => 'ok',
						'file' => "data:application/vnd.ms-excel;base64," . base64_encode($details)
					);
					die(json_encode($response));
				} else {
					$data['admissions'] = $details;
					$this->admin_template->show('admin/department_quota_report', $data);
				}
			}
		} else {
			redirect('admin/timeout');
		}
	}

	public function profile()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Profile';
			$data['menu'] = 'profileDetails';

			$this->form_validation->set_rules('usn', 'USN', 'required');
			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'admin/profileDetails';
				$this->admin_template->show('admin/profileDetails', $data);
			} else {

				$usn = $this->input->post('usn');
				$details = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
				if ($details) {
					$student_id = $details->id;
					$encryptId = base64_encode($student_id);
					redirect('admin/profileDetails/' . $encryptId, 'refresh');
				} else {
					redirect('admin/profileDetails', 'refresh');
				}
			}
		} else {
			redirect('admin/timeout');
		}
	}

	public function profileDetails()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Collect Fee';
			$data['menu'] = 'profileDetail';
			$encryptId = $this->input->post('usn');
			$data['encryptId'] = $encryptId;
			$student_id = $encryptId;
			$data['stud_id'] = $student_id;
			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();
			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($student_id, 'usn', 'students')->row();
			//   var_dump($this->db->last_query());

			$this->admin_template->show('admin/profileDetails', $data);
		} else {
			redirect('admin/timeout');
		}
	}

	function changepassword()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Change Password';
			$data['menu'] = 'changepassword';

			$this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
			$this->form_validation->set_rules('newpassword', 'New Password', 'required');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[newpassword]');

			if ($this->form_validation->run() === FALSE) {

				$data['action'] = 'admin/changepassword/' . $data['id'];
				$this->admin_template->show('admin/changepassword', $data);
			} else {
				$oldpassword = $this->input->post('oldpassword');
				$newpassword = $this->input->post('newpassword');
				$confirmpassword = $this->input->post('confirmpassword');

				if ($oldpassword == $newpassword) {
					$this->session->set_flashdata('message', 'Old and New Password should not be same...!');
					$this->session->set_flashdata('status', 'alert-warning');
				} else {
					$updateDetails = array('password' => md5($newpassword));
					$result = $this->admin_model->AdminChangePassword($data['id'], $oldpassword, $updateDetails, 'users');
					if ($result) {
						$this->session->set_flashdata('message', 'Password udpated successfully...!');
						$this->session->set_flashdata('status', 'alert-success');
					} else {
						$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
						$this->session->set_flashdata('status', 'alert-warning');
					}
				}
				redirect('/admin/changepassword', 'refresh');
			}
		} else {
			redirect('admin', 'refresh');
		}
	}

	function departments()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$details = $this->admin_model->getDetailsbyfield('1', 'status', 'departments')->result();

			$result = array();
			foreach ($details as $details1) {
				$row = $this->admin_model->get_stream_by_id($details1->stream_id);
				$result[$details1->department_id] = $row['stream_short_name'] . ' - ' . $details1->department_name;
			}

			return $result;
		} else {
			redirect('admin/timeout');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('admin', 'refresh');
	}

	public function payments()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];



			$data['page_title'] = 'New Payment';
			$data['menu'] = 'payments';
			// $data['admissionDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();

			$this->form_validation->set_rules('usn', 'USN', 'required');
			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'admin/payments';
				$this->admin_template->show('admin/payments', $data);
			} else {

				$usn = $this->input->post('usn');

				$encryptId = base64_encode($usn);
				redirect('admin/paymentDetail/' . $encryptId, 'refresh');
			}
		} else {
			redirect('admin/timeout');
		}
	}


	public function paymentDetail($encryptId)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Collect Fee';
			$data['menu'] = 'payments';
			$data['encryptId'] = $encryptId;
			$usn = base64_decode($encryptId);
			$data['usn'] = $usn;

			$data['voucher_types'] = $this->globals->voucher_types();
			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();
			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();

			$data['paymentDetail'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'payment_structure1')->result();
			$data['transactionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'reg_no', 'transactions')->result();
			$data['paid_amount'] = $this->admin_model->paidfee('reg_no', $usn, 'transaction_status', '1', 'transactions');
			$admissionSingle = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$data['fee_structure'] = $this->admin_model->getFee($admissionSingle->dept_id, $admissionSingle->quota, $admissionSingle->sub_quota)->row();

			$data['fees'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->result();

			$this->admin_template->show('admin/paymentDetail', $data);
		} else {
			redirect('admin/timeout');
		}
	}
	function new_voucher($encryptId, $feemaster_id)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];
			$data['page_title'] = "New Voucher Request";
			$data['menu'] = "payments";
			$usn = base64_decode($encryptId);
			$admissionSingle = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();

			$data['fee_structure'] = $this->admin_model->getDetails('fee_master', $feemaster_id)->row();
			$data['usn'] = $usn;
			$data['encryptId'] = $encryptId;
			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$this->form_validation->set_rules('voucher_type', 'Voucher Type', 'required');

			$this->form_validation->set_rules('final_fee', 'Total Amount', 'numeric|required');
			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'admin/new_voucher/' . $encryptId . '/' . $feemaster_id;
				$this->admin_template->show('admin/new_voucher', $data);
			} else {


				$selectedFees = $this->input->post('selected_fees');

				$finalFee = $this->input->post('final_fee');
				$selectedFeesArray = json_decode($selectedFees, true);

				// Debugging - Output selected fees array (adjust as needed)
				$updateDetails['type'] = 0;
				foreach ($selectedFeesArray as $selected) {
					$field = $newName = preg_replace('/_checkbox$/', '', $selected['name']);

					$updateDetails[$field] = $selected['newvalue'];

					if ($field == 'corpus_fee_demand') {
						$updateDetails['type'] = 1;
					}
				}
				$updateDetails['voucher_type'] = $this->input->post('voucher_type');
				if ($updateDetails['voucher_type'] == 5 || $updateDetails['voucher_type'] == 2) {

					$updateDetails['dd_bank'] = $this->input->post('dd_bank');
					$updateDetails['dd_number'] = $this->input->post('dd_number');
					if ($this->input->post('dd_date') == '') {
						$updateDetails['dd_date'] = '';
					} else {
						$updateDetails['dd_date'] = date('Y-m-d', strtotime($this->input->post('dd_date')));
					}
				}
				if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
					$config['upload_path'] = './assets/voucher/';
					$config['allowed_types'] = 'pdf'; // Adjust file types as needed
					$config['max_size'] = 10240; // Maximum file size in kilobytes (10MB)
					$config['encrypt_name'] = FALSE; // Encrypt the file name for security

					// Load the upload library with the config settings
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('file')) {
						// If the upload failed, display the error
						$error = array('error' => $this->upload->display_errors());
						echo "Failed to upload file: " . $error['error'];
					} else {
						$upload_data = $this->upload->data();

						// Define the new file name
						$new_file_name = time().'.pdf';

						// Define old and new file paths
						$old_file_path = $upload_data['full_path'];
						$new_file_path = $config['upload_path'] . $new_file_name;

						// Rename the file
						if (rename($old_file_path, $new_file_path)) {
							// echo "File uploaded and renamed successfully!";
							$updateDetails['file'] = $new_file_name;
						} else {
							// echo "File uploaded but failed to rename.";
						}
					}
				}
				if ($updateDetails['voucher_type'] == 3) {
					$updateDetails['offline'] = 0;
				} else {
					$updateDetails['offline'] = 1;
				}
				$updateDetails['comments'] = $this->input->post('comments');
				$updateDetails['remarks'] = $this->input->post('remarks');

				$updateDetails['year'] = $this->input->post('year');
				$updateDetails['usn'] = $usn;
				$updateDetails['mobile'] = $data['admissionDetails']->student_number;

				$updateDetails['final_fee'] = $this->input->post('final_fee');
				$updateDetails['requested_by'] = $data['full_name'];
				$updateDetails['requested_on'] = date('Y-m-d h:i:s');

				// var_dump($updateDetails);

				$result = $this->admin_model->insertDetails('payment_structure1', $updateDetails);


				if ($result) {
					$this->session->set_flashdata('message', 'New Payment Details are added successfully...!');
					$this->session->set_flashdata('status', 'alert-success');
				} else {
					$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
					$this->session->set_flashdata('status', 'alert-warning');
				}

				redirect('admin/paymentDetail/' . $encryptId, 'refresh');
			}
		} else {
			redirect('admin', 'refresh');
		}
	}

	public function voucher_delete($encryptId, $id)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];





			$voucherExists = $this->admin_model->getDetails('payment_structure1', $id)->num_rows();

			if ($voucherExists > 0) {

				$this->admin_model->delDetails('payment_structure1', $id);


				$this->session->set_flashdata('message', 'Voucher deleted successfully.');
				$this->session->set_flashdata('status', 'alert-success');
			} else {

				$this->session->set_flashdata('message', 'Voucher not found.');
				$this->session->set_flashdata('status', 'alert-warning');
			}


			redirect('admin/paymentDetail/' . $encryptId, 'refresh');
		} else {
			redirect('admin', 'refresh');
		}
	}

	function update_voucher($encryptId,$feestruct_id) {
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];
			$data['page_title'] = "Update Voucher Request";
			$data['menu'] = "payments";
			
			$usn = base64_decode($encryptId);
			$admissionSingle = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			
			// Fetch existing voucher data
			$voucherData = $this->admin_model->getDetails('payment_structure1', $feestruct_id)->row();
			if (!$voucherData) {
				$this->session->set_flashdata('message', 'Voucher not found.');
				$this->session->set_flashdata('status', 'alert-warning');
				redirect('admin/paymentDetail/' . $encryptId, 'refresh');
			}
			
			$data['voucherData'] = $voucherData;
			$data['fee_structure'] = $this->admin_model->get_fee_details_usn($voucherData->usn, $voucherData->year)->row();
			

			$data['usn'] = $usn;
			$data['encryptId'] = $encryptId;
			$data['admissionDetails'] = $admissionSingle;
			
			// Set validation rules for updating
			$this->form_validation->set_rules('voucher_type', 'Voucher Type', 'required');
			$this->form_validation->set_rules('final_fee', 'Total Amount', 'numeric|required');
			
			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'admin/update_voucher/' . $encryptId . '/' . $feestruct_id;
				$this->admin_template->show('admin/update_voucher', $data);
			} else {
				$selectedFees = $this->input->post('selected_fees');
				$finalFee = $this->input->post('final_fee');
				$selectedFeesArray = json_decode($selectedFees, true);
				
				$updateDetails = array();
				$updateDetails['type'] = 0;
				foreach ($selectedFeesArray as $selected) {
					$field = preg_replace('/_checkbox$/', '', $selected['name']);
					$updateDetails[$field] = $selected['newvalue'];
					
					if ($field == 'corpus_fee_demand') {
						$updateDetails['type'] = 1;
					}
				}
				if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
					$config['upload_path'] = './assets/voucher/';
					$config['allowed_types'] = 'pdf'; // Adjust file types as needed
					$config['max_size'] = 10240; // Maximum file size in kilobytes (10MB)
					$config['encrypt_name'] = FALSE; // Encrypt the file name for security

					// Load the upload library with the config settings
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('file')) {
						// If the upload failed, display the error
						$error = array('error' => $this->upload->display_errors());
						echo "Failed to upload file: " . $error['error'];
					} else {
						$upload_data = $this->upload->data();

						// Define the new file name
						$new_file_name = time().'.pdf';

						// Define old and new file paths
						$old_file_path = $upload_data['full_path'];
						$new_file_path = $config['upload_path'] . $new_file_name;

						// Rename the file
						if (rename($old_file_path, $new_file_path)) {
							// echo "File uploaded and renamed successfully!";
							$updateDetails['file'] = $new_file_name;
						} else {
							// echo "File uploaded but failed to rename.";
						}
					}
				}
				
				$updateDetails['voucher_type'] = $this->input->post('voucher_type');
				if ($updateDetails['voucher_type'] == 5 || $updateDetails['voucher_type'] == 2) {
					$updateDetails['dd_bank'] = $this->input->post('dd_bank');
					$updateDetails['dd_number'] = $this->input->post('dd_number');
					$updateDetails['dd_date'] = $this->input->post('dd_date') ? date('Y-m-d', strtotime($this->input->post('dd_date'))) : '';
				}
				$updateDetails['offline'] = ($updateDetails['voucher_type'] == 3) ? 0 : 1;
				$updateDetails['comments'] = $this->input->post('comments');
				$updateDetails['remarks'] = $this->input->post('remarks');
				$updateDetails['year'] = $this->input->post('year');
				$updateDetails['usn'] = $usn;
				$updateDetails['mobile'] = $data['admissionDetails']->student_number;
				$updateDetails['final_fee'] = $this->input->post('final_fee');
				$updateDetails['requested_by'] = $data['full_name'];
				$updateDetails['requested_on'] = date('Y-m-d h:i:s');
				
				// Update voucher details in the database
				$result = $this->admin_model->updateDetails($feestruct_id, $updateDetails,'payment_structure1');
				
				if ($result) {
					$this->session->set_flashdata('message', 'Voucher updated successfully!');
					$this->session->set_flashdata('status', 'alert-success');
				} else {
					$this->session->set_flashdata('message', 'Failed to update voucher. Please try again.');
					$this->session->set_flashdata('status', 'alert-warning');
				}
				
				redirect('admin/paymentDetail/' . $encryptId, 'refresh');
			}
		} else {
			redirect('admin', 'refresh');
		}
	}
	
	function mark_paid($encryptId, $id)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Payments Details';
			$data['menu'] = 'payments';
			$usn = base64_decode($encryptId);
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $id)->row();
			$data['voucherDetails'] = $this->admin_model->getDetails('payment_structure1', $id)->row();


			$this->form_validation->set_rules('transaction_date', 'Paid Date', 'required');
			$this->form_validation->set_rules('receipt_no', 'Receipt Number(Tally)', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'admin/mark_paid/' . $encryptId . '/' . $id;
				$this->admin_template->show('admin/mark_paid', $data);
			} else {

				$receipt_no = $this->input->post('receipt_no');
				$transaction_date = $this->input->post('transaction_date');
				$remarks = $this->input->post('remarks');

				if ($voucherDetails->voucher_type == 2 || $voucherDetails->voucher_type == 5) {
					$bank_name = $this->input->post('dd_bank');
					$reference_date = $this->input->post('dd_date');
					$reference_no = $this->input->post('dd_number');
				} else {
					$bank_name = '';
					$reference_date = '';
					$reference_no = '';
				}
				if ($voucherDetails->type == 1) {
					$payment_mode = 1;
				} else {
					$payment_mode = 0;
				}
				if ($voucherDetails->voucher_type == 4) {
					$transfer_mode = $this->input->post('transfer_mode');
				} else {
					$transfer_mode = '';
				}
				$insert = array(
					'amount' => $voucherDetails->final_fee,
					'reg_no' => $voucherDetails->usn,
					'aided_unaided' => $admissionDetails->sub_quota,

					'receipt_no' => $receipt_no,
					'transaction_date' => $transaction_date,
					'transaction_type' => $voucherDetails->voucher_type,
					'bank_name' => $bank_name,
					'reference_no' => $reference_no,
					'reference_date' => $reference_date,
					'payment_mode' => $payment_mode,
					'transfer_mode' => $transfer_mode,


					'mobile' => $voucherDetails->mobile,

					'remarks' => $remarks,
					'academic_year' => "2024-2025",
					'year' => $voucherDetails->year,

					'payment_id' => $voucherDetails->id,
					'transaction_status' => '1',
					'created_on' => date('Y-m-d h:i:s')
				);

				$result = $this->admin_model->insertDetails('transactions', $insert);
				$updateDetails1['status'] = '1';
				$result1 = $this->admin_model->updateDetailsbyfield('id', $id, $updateDetails1, 'payment_structure1');


				if ($result) {
					$this->session->set_flashdata('message', 'New Payment Details are added successfully...!');
					$this->session->set_flashdata('status', 'alert-success');
				} else {
					$this->session->set_flashdata('message', 'Oops something went wrong please try again.!');
					$this->session->set_flashdata('status', 'alert-warning');
				}

				redirect('admin/paymentDetail/' . $encryptId, 'refresh');
			}
		} else {
			redirect('admin', 'refresh');
		}
	}
	public function cashvoucher($encryptId, $transaction_id)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Admission Details';
			$data['menu'] = 'admissions';
			$usn = base64_decode($encryptId);
			$admission_id = $usn;
			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();

			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $transaction_id)->row();


			$this->load->library('fpdf'); // Load library
			ini_set("session.auto_start", 0);
			ini_set('memory_limit', '-1');
			define('FPDF_FONTPATH', 'plugins/font');
			$pdf = new FPDF();

			$collegeName = "MALNAD COLLEGE OF ENGINEERING";
			$collegeName1 = "Autonomous Institute Affiliated to the VTU";
			$collegeName2 = "Under the auspices of the MTES (R),";
			$collegeName3 = "PB NO. 21";
			$contactInfo1 = "SALAGAME ROAD HASSAN";
			$contactInfo2 = "State Name : Karnataka";
			$affiliation = "ACKNOWLEDGEMENT";
			$contactInfo = "UG (AY-2024-2025)";

			$issuedOn = "Date : " . date("d-m-Y ");
			$programe = "PROGRAM : B.E";
			$chellan = "Challan : MCE24-25/" . $voucherDetails->id;
			$dept = "Dept. :" . $this->admin_model->get_department_short_code($admissionDetails->department_id);
			$bcopy = "BANK COPY";
			$copyData = array('S.A Copy', 'Office Copy');

			// Define the data for the table
			$tableData = [
				['USN', $admissionDetails->usn],
				['Name', $admissionDetails->student_name],
				['Year', $voucherDetails->year],
				['Quota', $admissionDetails->quota],
				['College Code', $admissionDetails->college_code . ' - ' . $admissionDetails->sub_quota],
				['Category', $admissionDetails->category_allotted]
			];

			if ($voucherDetails->voucher_type == 1) {
				$tableData[] = ['Payment Mode', 'Cash'];
			} elseif ($voucherDetails->voucher_type == 5) {
				$tableData[] = ['Payment Mode', 'Bank DD'];
				$tableData[] = ['DD. No.', $voucherDetails->dd_number];
				$tableData[] = ['DD. Date', date('d-m-Y', strtotime($voucherDetails->dd_date))];
				$tableData[] = ['Bank Name', $voucherDetails->dd_bank];
			}

			$fees = [
				'University Registration Fee' => $voucherDetails->renewal_of_registration_fees,
				'E-Consortium Fee' => $voucherDetails->e_consortium_fees,
				'Sport Fee' => $voucherDetails->students_sports_fees,
				'Sports Development Fee' => $voucherDetails->students_sports_development_fees,
				'Career Guidance Counseling Fee' => $voucherDetails->career_guideliness_and_counselling_fees,
				'University Development Fund' => $voucherDetails->university_development_fees,
				'Cultural Fee' => $voucherDetails->cultural_activities_fees,
				'Teachers Development Fee' => $voucherDetails->teachers_development_fees,
				'Student Development Fee' => $voucherDetails->student_development_fees,
				'Indian Red Cross Membership Fee' => $voucherDetails->indian_red_cross_membership_fees,
				'Women Cell Fee' => $voucherDetails->women_cell_fees,
				'NSS Fee' => $voucherDetails->nss_fees,
				'Teachers Flag Fee' => $voucherDetails->teachers_flag_fees
			];

			$university = 0;
			foreach ($fees as $feeName => $feeValue) {
				if ($feeValue > 0) {
					$university += $feeValue;
				}
			}
			if ($university > 0) {
				$tableData[] = ["University Other Fee", $university];
			}
			if ($voucherDetails->college_other_fees > 0) {
				$tableData[] = ['College Other Fee', $voucherDetails->college_other_fees];
			}
			if ($voucherDetails->exam_fee > 0) {
				$tableData[] = ['Exam Fee', $voucherDetails->exam_fee];
			}
			if ($voucherDetails->tuition_fee > 0) {
				$tableData[] = ['Tution Fee', $voucherDetails->tuition_fee];
			}
			if ($voucherDetails->corpus_fee_demand > 0) {
				$tableData[] = ['Corpus Fund', $voucherDetails->corpus_fee_demand];
			}

			// Create a function to generate a single copy
			function generateCopy($i, $pdf, $x, $y, $collegeName, $affiliation, $contactInfo, $contactInfo1, $issuedOn, $programe, $chellan, $dept, $tableData, $voucherDetails, $copy)
			{
				$collegeName1 = "Autonomous Institute Affiliated to the VTU";
				$collegeName2 = "Under the auspices of the MTES (R),";
				$collegeName3 = "PB NO. 21";
				$contactInfo1 = "SALAGAME ROAD HASSAN";
				$contactInfo2 = "State Name : Karnataka";
				$contactInfo = "UG (AY-2024-2025)";
				$pdf->Rect($x - 2, $y, 90, 200); // Increase the size of each copy
				$pdf->SetXY($x, $y);
				$pdf->SetFont('Arial', 'B', 10);
				$pdf->Cell(85, 5, $collegeName, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(85, 4, $collegeName1, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(85, 4, $collegeName2, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(85, 4, $collegeName3, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(85, 4, $contactInfo1, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->Cell(85, 4, $contactInfo2, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(85, 5, $affiliation, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(85, 5, $contactInfo, 0, 1, 'C');

				// Draw a line
				$pdf->SetLineWidth(0.2);
				$pdf->Line($x, $y + 30, $x + 87, $y + 30);
				$pdf->Ln(5);
				$pdf->SetLineWidth(0.2);
				$pdf->Line($x, $y + 35, $x + 87, $y + 35);
				$pdf->Ln(5);
				$pdf->SetFont('Arial', '', 8);
				$pdf->SetXY($x, $y + 40);
				$pdf->Cell(85, 5, $issuedOn, 0, 0, 'L');
				$pdf->SetXY($x, $y + 40);
				$pdf->Cell(85, 5, $programe, 0, 1, 'R');
				$pdf->SetXY($x, $y + 45);
				$pdf->Cell(85, 5, $chellan, 0, 0, 'L');
				$pdf->SetXY($x, $y + 45);
				$pdf->Cell(85, 5, $dept, 0, 1, 'R');
				$pdf->SetXY($x, $y + 50);
				$pdf->SetFont('Arial', '', 8);
				$pdf->MultiCell(85, 5, "");

				$tableY = $pdf->GetY(); // Get current Y position for the table
				foreach ($tableData as $row) {
					$pdf->SetXY($x, $tableY);
					$pdf->Cell(42.5, 7, $row[0], 1, 0, 'C');
					$pdf->Cell(42.5, 7, $row[1], 1, 1, 'C');
					$tableY += 7; // Move Y position down for the next row
				}
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetXY($x, $tableY);
				$pdf->Cell(42.5, 5, "TOTAL", 1, 0, 'C');
				$pdf->Cell(42.5, 5, $voucherDetails->final_fee, 1, 1, 'C');
				$tableY += 8;
				$pdf->SetFont('Arial', '', 8);
				$pdf->SetXY($x, $tableY);
				$pdf->MultiCell(85, 5, "Amount (In Words) : " . convert_number_to_words($voucherDetails->final_fee) . " Only");
				$pdf->SetXY($x, $tableY + 25);
				$pdf->Cell(42.5, 5, ' ', 0, 0, 'L');
				$pdf->Cell(42.5, 5, "Signature of Remitter", 0, 1, 'R');
				$pdf->SetXY($x, $tableY + 60);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(85, 5, $copy, 0, 1, 'C');
			}

			// Add page and set margins
			$pdf->AddPage('P', 'A4'); // 'L' for landscape orientation, 'A4' for A4 size (210x297 mm)
			$pdf->SetMargins(10, 10, 10);

			// Generate two copies horizontally
			$startX = 10;
			$startY = 10;
			$spacingX = 100; // Adjust this spacing to fit the copies horizontally
			$spacingY = 120; // Adjust this spacing to fit the copies vertically

			for ($i = 0; $i < 2; $i++) {
				generateCopy($i, $pdf, $startX + ($i * $spacingX), $startY, $collegeName, $affiliation, $contactInfo, $contactInfo1, $issuedOn, $programe, $chellan, $dept, $tableData, $voucherDetails, $copyData[$i]);
			}

			// $pdf->Output();
			$fileName = $admissionDetails->student_name . '- Voucher.pdf';
			$pdf->output($fileName, 'D');
		} else {
			redirect('admin/timeout');
		}
	}

	public function voucherletter($encryptId, $id)
	{

		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Admission Details';
			$data['menu'] = 'admissions';
			$usn = base64_decode($encryptId);
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $id)->row();



			$this->load->library('fpdf'); // Load library
			ini_set("session.auto_start", 0);
			ini_set('memory_limit', '-1');
			define('FPDF_FONTPATH', 'plugins/font');
			$pdf = new FPDF();



			$collegeName = "MALNAD COLLEGE OF ENGINEERING";
			$collegeName1 = "Autonomous Institute Affiliated to the VTU";
			$collegeName2 = "Under the auspices of the MTES (R),";
			$collegeName3 = "PB NO. 21";
			$contactInfo1 = "SALAGAME ROAD HASSAN";
			$contactInfo2 = "State Name : Karnataka";
			$affiliation = "FEE RECEIPT";
			$contactInfo = "UG (AY-2024-2025)";

			$issuedOn = "Date : " . date("d-m-Y ");
			$programe = "PROGRAM : B.E";
			$chellan = "Challan : MCE24-25/" . $voucherDetails->id;
			$dept = "Dept. :" . $this->admin_model->get_department_short_code($admissionDetails->department_id);
			$bcopy = "BANK COPY";
			$copyData = array('Bank Copy', 'Office Copy', 'S.A Copy', 'Student Copy');
			// Define the data for the table
			if ($voucherDetails->dd_date == '0000-00-00') {
				$dddate = '';
			} else {
				$dddate = date('d-m-Y', strtotime($voucherDetails->dd_date));
			}


			$tableData = [
				['USN', $admissionDetails->usn],
				['Name', $admissionDetails->student_name],
				['Year', $voucherDetails->year],
				['Quota', $admissionDetails->quota],
				['College Code', $admissionDetails->college_code . ' - ' . $admissionDetails->sub_quota],
				['Category', $admissionDetails->category_allotted],
				['DD No.', $voucherDetails->dd_number],
				['DD Date', $dddate],
				['Bank Name', $voucherDetails->dd_bank]
			];

			$fees = [
				'University Registration Fee' => $voucherDetails->renewal_of_registration_fees,
				'E-Consortium Fee' => $voucherDetails->e_consortium_fees,
				'Sport Fee' => $voucherDetails->students_sports_fees,
				'Sports Development Fee' => $voucherDetails->students_sports_development_fees,
				'Career Guidance Counseling Fee' => $voucherDetails->career_guideliness_and_counselling_fees,
				'University Development Fund' => $voucherDetails->university_development_fees,
				'Cultural Fee' => $voucherDetails->cultural_activities_fees,
				'Teachers Development Fee' => $voucherDetails->teachers_development_fees,
				'Student Development Fee' => $voucherDetails->student_development_fees,
				'Indian Red Cross Membership Fee' => $voucherDetails->indian_red_cross_membership_fees,
				'Women Cell Fee' => $voucherDetails->women_cell_fees,
				'NSS Fee' => $voucherDetails->nss_fees,
				'Teachers Flag Fee' => $voucherDetails->teachers_flag_fees
			];

			$university = 0;
			foreach ($fees as $feeName => $feeValue) {
				if ($feeValue > 0) {
					$university += $feeValue;
				}
			}
			if ($university > 0) {
				$tableData[] = ["University Other Fee", $university];
			}
			if ($voucherDetails->college_other_fees > 0) {
				$tableData[] = ['College Other Fee', $voucherDetails->college_other_fees];
			}
			if ($voucherDetails->exam_fee > 0) {
				$tableData[] = ['Exam Fee', $voucherDetails->exam_fee];
			}
			if ($voucherDetails->tuition_fee > 0) {
				$tableData[] = ['Tution Fee', $voucherDetails->tuition_fee];
			}
			if ($voucherDetails->corpus_fee_demand > 0) {
				$tableData[] = ['Corpus Fund', $voucherDetails->corpus_fee_demand];
			}

			if ($admissionDetails->sub_quota == 'Aided') {
				$accno = "120030893500";
			} else {
				$accno = "14053070001574";
			}

			// Create a function to generate a single copy
			function generateCopy($i, $pdf, $x, $y, $collegeName, $affiliation, $contactInfo, $contactInfo1, $issuedOn, $programe, $chellan, $dept, $tableData, $voucherDetails, $copy, $accno)
			{
				$collegeName1 = "Autonomous Institute Affiliated to the VTU";
				$collegeName2 = "Under the auspices of the MTES (R),";
				$collegeName3 = "";
				$contactInfo1 = "PB NO. 21,SALAGAME ROAD HASSAN, KARNATAKA";
				$contactInfo2 = "";
				$contactInfo = "UG (AY-2024-2025)";
				$pdf->Rect($x - 2, $y, 69, 90 + 70);
				$pdf->SetXY($x, $y);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(65, 6, $collegeName, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(65, 3, $collegeName1, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(65, 4, $collegeName2, 0, 1, 'C');
				// $pdf->SetX($x);
				// $pdf->SetFont('Arial', '', 7);
				// $pdf->Cell(65, 3, $collegeName3, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 6);
				$pdf->Cell(65, 3, $contactInfo1, 0, 1, 'C');
				// $pdf->SetX($x);
				// $pdf->Cell(65, 3, $contactInfo2, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->Cell(65, 5, $affiliation, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 6);
				$pdf->Cell(65, 4, $contactInfo, 0, 1, 'C');


				// Draw a line
				$pdf->SetLineWidth(0.2);
				$pdf->Line($x, $y + 21, $x + 65, $y + 21);
				$pdf->Ln(3);
				$pdf->SetLineWidth(0.2);
				$pdf->Line($x, $y + 25, $x + 65, $y + 25);
				$pdf->Ln(3);
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY($x, $y + 29);
				$pdf->Cell(65, 4, $issuedOn, 0, 0, 'L');
				$pdf->SetXY($x, $y + 29);
				$pdf->Cell(65, 4, $programe, 0, 1, 'R');
				$pdf->SetXY($x, $y + 34);
				$pdf->Cell(65, 4, $chellan, 0, 0, 'L');
				$pdf->SetXY($x, $y + 34);
				$pdf->Cell(65, 4, $dept, 0, 1, 'R');
				$pdf->SetXY($x, $y + 39);
				$pdf->SetFont('Arial', '', 7);
				$pdf->MultiCell(65, 4, "Paid into the credit of CANARA BANK M.C.E BRANCH,\nHASSAN -573202., CA A/C No. " . $accno . " of \nThe Principal Malnad College of Engineering, Hassan.");
				$pdf->SetXY($x, $y + 52);
				// $pdf->SetFont('Arial', '', 7);
				// $pdf->MultiCell(65, 4, "Cash/D.D.No.________________________Dt________\n");
				// $pdf->SetXY($x, $y + 56);
				// $pdf->SetFont('Arial', '', 7);
				// $pdf->MultiCell(65, 4, "Bank_________________________________________");
				$pdf->SetFont('Arial', '', 7);
				$pdf->MultiCell(65, 4, "");
				$tableY = $pdf->GetY(); // Get current Y position for the table
				foreach ($tableData as $row) {
					$pdf->SetXY($x, $tableY);
					$pdf->Cell(32.5, 5, $row[0], 1, 0, 'L');
					$pdf->Cell(32.5, 5, $row[1], 1, 1, 'L');
					$tableY += 5; // Move Y position down for the next row
				}

				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetXY($x, $tableY + 3);
				$pdf->Cell(32.5, 4, "TOTAL", 1, 0, 'L');
				$pdf->Cell(32.5, 4, number_format($voucherDetails->final_fee, 2), 1, 1, 'L');
				$tableY += 9;
				$pdf->SetFont('Arial', '', 7.5);
				$pdf->SetXY($x, $tableY);
				$pdf->MultiCell(65, 4, "Amount (In Words) : Rs." . convert_number_to_words($voucherDetails->final_fee) . " Only");
				$pdf->SetXY($x, $tableY + 14);
				$pdf->Cell(32.5, 4, ' ', 0, 0, 'L');
				$pdf->Cell(32.5, 4, "Signature of Remitter", 0, 1, 'R');
				$pdf->SetXY($x, $tableY + 30);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(65, 4, $copy, 0, 1, 'C');
			}

			// Add page and set margins
			$pdf->AddPage('L', 'A4'); // 'L' for landscape orientation, 'A4' for A4 size (210x297 mm)
			$pdf->SetMargins(10, 10, 10);

			// Generate four copies horizontally
			$startX = 10;
			$startY = 10;
			$spacingX = 70; // Adjust this spacing to fit the copies horizontally

			for ($i = 0; $i < 4; $i++) {
				generateCopy($i, $pdf, $startX + ($i * $spacingX), $startY, $collegeName, $affiliation, $contactInfo, $contactInfo1, $issuedOn, $programe, $chellan, $dept, $tableData, $voucherDetails, $copyData[$i], $accno);
			}

			// $pdf->Output();
			$fileName = $admissionDetails->student_name . '-Voucher.pdf';
			$pdf->output($fileName, 'D');
		} else {
			redirect('admin/timeout');
		}
	}

	public function onlinevoucher($encryptId, $id)
	{

		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Admission Details';
			$data['menu'] = 'admissions';
			$usn = base64_decode($encryptId);
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $id)->row();


			$this->load->library('fpdf'); // Load library
			ini_set("session.auto_start", 0);
			ini_set('memory_limit', '-1');
			define('FPDF_FONTPATH', 'plugins/font');
			$pdf = new FPDF();

			// College Information
			$collegeName = "MALNAD COLLEGE OF ENGINEERING, HASSAN";
			$affiliation = "";
			$contactInfo = "Payment made by NEFT/RTGS/IMPS or any other online mode,";
			$contactInfo1 = "Fill all the below mentioned data with Seal & Signature of the Payee Bank Officlal,";
			$contactInfo2 = "and Upload to E Mail swdcb@mcehassan.ac.in,";
			$contactInfo3 = "Submit the hard copy to Fees Section, Dean (SA) Office";

			if ($voucherDetails->type == 1) {
				$contactInfo4 = "CORPUS FUND ACCOUNT NUMBER - 110173085919 , IFSC CODE - CNRB0011405";
			} else {
				if ($admissionDetails->sub_quota == 'Aided') {
					$contactInfo4 = "ACCOUNT NUMBER -  120030893500 IFSC -CNRB0011405";
				} else {
					$contactInfo4 = "UA ACCOUNT NUMBER -  14053070001574 IFSC -CNRB0011405";
				}
			}

			$issuedOn = "Date : " . date("d-m-Y ");
			$programe = "PROGRAME : B.E";
			$chellan = "Chellan : MCE24-25/" . $voucherDetails->id;
			$dept = "Dept. :" . $this->admin_model->get_department_short_code($admissionDetails->department_id);
			$scopy = "STUDENT COPY";
			$bcopy = "BANK COPY";
			$sacopy = "S.A COPY";
			$ocopy = "OFFICE COPY";
			// Define the data for the table
			$tableData = [
				['USN', $admissionDetails->usn],
				['Name', $admissionDetails->student_name],
				['Branch', 'B.E - ' . $admissionDetails->department],
				['Year', $voucherDetails->year],
				['Quota', $admissionDetails->quota],
				['College Code', $admissionDetails->college_code . ' - ' . $admissionDetails->sub_quota],
				['Category', $admissionDetails->category_allotted],
				['Mobile No.', $admissionDetails->student_number],
				['Email ID', $admissionDetails->email],
				['Mode of Payment NEFT/RTGS/IMPS/UPI',],
				['Fee paid in Rupees', $voucherDetails->final_fee],
				['Date of Transaction', ''],
				['UTR No. /PG Reference No.', ''],


			];




			///bank copy
			$pdf->AddPage('P', 'A4'); // 'P' for portrait orientation, 'A4' for A4 size (210x297 mm)
			$pdf->SetMargins(17, 20, 20);
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(0, 10, $collegeName, 0, 1, 'C');
			// $pdf->SetFont('Arial', 'B', 10);
			// $pdf->Cell(0, 4, $affiliation, 0, 1, 'C');
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(0, 4, $contactInfo, 0, 1, 'C');
			$pdf->Cell(0, 4, $contactInfo1, 0, 1, 'C');
			$pdf->Cell(0, 4, $contactInfo2, 0, 1, 'C');
			$pdf->Cell(0, 4, $contactInfo3, 0, 1, 'C');
			$pdf->Cell(0, 4, $contactInfo4, 0, 1, 'C');
			$x1 = 17;  // Starting point x-coordinate
			$y1 = 41;  // Starting point y-coordinate
			$x2 = 198; // Ending point x-coordinate
			$y2 = 41;  // Ending point y-coordinate


			// Set line width
			$pdf->SetLineWidth(0.5);

			// Draw a line from (x1, y1) to (x2, y2)
			$pdf->Line($x1, $y1, $x2, $y2);
			$pdf->Ln(1);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(0, 6, $issuedOn, 0, 0, 'L');
			$pdf->Cell(0, 6, $programe, 0, 1, 'R');
			$pdf->Cell(0, 6, $chellan, 0, 0, 'L');
			$pdf->Cell(0, 6, $dept, 0, 1, 'R');

			$pdf->SetFont('Arial', '', 10);



			foreach ($tableData as $row) {
				$pdf->Cell(90, 7, $row[0], 1, 0, 'C');
				$pdf->Cell(90, 7, $row[1], 1, 1, 'C');
			}

			$pdf->Ln(1);
			$pdf->SetFont('Arial', '', 10);

			$pdf->Cell(0, 50, "Seal with signature of the Paid Bank", 0, 0, 'L');
			$pdf->Cell(0, 50, "Signature of the Student", 0, 1, 'R');
			$pdf->Ln(4);

			$pdf->Ln(10);




			// $pdf->output();
			$fileName = $admissionDetails->student_name . '- Voucher.pdf';
			$pdf->output($fileName, 'D');
		} else {
			redirect('admin/timeout');
		}
	}

	public function feereceipt($usn, $transaction_id)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Fees Receipt';
			$data['menu'] = 'feereceipt';

			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$transactionDetails = $this->admin_model->getDetails('transactions', $transaction_id)->row();
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$paid_amount = $this->admin_model->paidfee('reg_no', $usn, 'transaction_status', '1', 'transactions');
			$studentfeeDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();


			$fees = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();
			$balance_amount = $fees->final_fee - $paid_amount;
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $transactionDetails->payment_id)->row();
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
			} else {

				$collegeName = "MALNAD TECHNICAL EDUCATION SOCIETY (R)";
				$collegeName1 = "REGD NO. S .2080/589 Dtd 22.01.1959";
				$collegeName2 = "BESIDE MCE GANAPATHI TEMPLE ,MG ROAD,VIDYANAGAR,HASSAN-573202";
				$collegeName3 = "STATE-KARNATAKA";
				$contactInfo = "CORPUS FUND RECEIPT";
			}

			$fees = [
				'University Registration Fee' => $voucherDetails->renewal_of_registration_fees,
				'E-Consortium Fee' => $voucherDetails->e_consortium_fees,
				'Sport Fee' => $voucherDetails->students_sports_fees,
				'Sports Development Fee' => $voucherDetails->students_sports_development_fees,
				'Career Guidance Counseling Fee' => $voucherDetails->career_guideliness_and_counselling_fees,
				'University Development Fund' => $voucherDetails->university_development_fees,
				'Cultural Fee' => $voucherDetails->cultural_activities_fees,
				'Teachers Development Fee' => $voucherDetails->teachers_development_fees,
				'Student Development Fee' => $voucherDetails->student_development_fees,
				'Indian Red Cross Membership Fee' => $voucherDetails->indian_red_cross_membership_fees,
				'Women Cell Fee' => $voucherDetails->women_cell_fees,
				'NSS Fee' => $voucherDetails->nss_fees,
				'Teachers Flag Fee' => $voucherDetails->teachers_flag_fees
			];

			$university = 0;
			foreach ($fees as $feeName => $feeValue) {
				if ($feeValue > 0) {
					$university += $feeValue;
				}
			}
			if ($university > 0) {
				$tableData[] = ["University Other Fee", $university];
			}
			if ($voucherDetails->college_other_fees > 0) {
				$tableData[] = ['College Other Fee', $voucherDetails->college_other_fees];
			}
			if ($voucherDetails->exam_fee > 0) {
				$tableData[] = ['Exam Fee', $voucherDetails->exam_fee];
			}
			if ($voucherDetails->tuition_fee > 0) {
				$tableData[] = ['Tution Fee', $voucherDetails->tuition_fee];
			}
			if ($voucherDetails->corpus_fee_demand > 0) {
				$tableData[] = ['Corpus Fund', $voucherDetails->corpus_fee_demand];
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
			redirect('admin/timeout');
		}
	}

	public function feereceiptonline($usn, $transaction_id)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Fees Receipt';
			$data['menu'] = 'feereceipt';

			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$transactionDetails = $this->admin_model->getDetails('transactions', $transaction_id)->row();
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$paid_amount = $this->admin_model->paidfee('reg_no', $usn, 'transaction_status', '1', 'transactions');
			$studentfeeDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();


			$fees = $this->admin_model->getDetailsbyfield($usn, 'usn', 'fee_master')->row();
			$balance_amount = $fees->final_fee - $paid_amount;
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $transactionDetails->payment_id)->row();
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

			foreach ($tableData as $row) {

				printRow($pdf, $row[0], number_format($row[1], 2), $pdf->GetY(), $rowHeight, $cellWidth1, $cellWidth2);
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
			redirect('admin/timeout');
		}
	}

	public function cashvoucherletter($encryptId, $id)
	{

		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$data['page_title'] = 'Admission Details';
			$data['menu'] = 'admissions';
			$usn = base64_decode($encryptId);
			$admissionDetails = $this->admin_model->getDetailsbyfield($usn, 'usn', 'students')->row();
			$voucherDetails = $this->admin_model->getDetails('payment_structure1', $id)->row();

			if ($admissionDetails->sub_quota == 'Aided') {
				$accno = "120030893500";
			} else {
				$accno = "14053070001574";
			}

			$this->load->library('fpdf'); // Load library
			ini_set("session.auto_start", 0);
			ini_set('memory_limit', '-1');
			define('FPDF_FONTPATH', 'plugins/font');
			$pdf = new FPDF();



			$collegeName = "MALNAD COLLEGE OF ENGINEERING";
			$collegeName1 = "Autonomous Institute Affiliated to the VTU";
			$collegeName2 = "Under the auspices of the MTES (R),";
			$collegeName3 = "PB NO. 21";
			$contactInfo1 = "SALAGAME ROAD HASSAN";
			$contactInfo2 = "State Name : Karnataka";
			$affiliation = "FEE RECEIPT";
			$contactInfo = "UG (AY-2024-2025)";

			$issuedOn = "Date : " . date("d-m-Y ");
			$programe = "PROGRAM : B.E";
			$chellan = "Challan : MCE24-25/" . $voucherDetails->id;
			$dept = "Dept. :" . $this->admin_model->get_department_short_code($admissionDetails->department_id);
			$bcopy = "BANK COPY";
			$copyData = array('Bank Copy', 'Office Copy', 'S.A Copy', 'Student Copy');
			// Define the data for the table
			if ($voucherDetails->dd_date == '0000-00-00') {
				$dddate = '';
			} else {
				$dddate = date('d-m-Y', strtotime($voucherDetails->dd_date));
			}


			$tableData = [
				['USN', $admissionDetails->usn],
				['Name', $admissionDetails->student_name],
				['Year', $voucherDetails->year],
				['Quota', $admissionDetails->quota],
				['College Code', $admissionDetails->college_code . ' - ' . $admissionDetails->sub_quota],
				['Category', $admissionDetails->category_allotted],

				['Payment Mode', "Cash"]
			];

			$fees = [
				'University Registration Fee' => $voucherDetails->renewal_of_registration_fees,
				'E-Consortium Fee' => $voucherDetails->e_consortium_fees,
				'Sport Fee' => $voucherDetails->students_sports_fees,
				'Sports Development Fee' => $voucherDetails->students_sports_development_fees,
				'Career Guidance Counseling Fee' => $voucherDetails->career_guideliness_and_counselling_fees,
				'University Development Fund' => $voucherDetails->university_development_fees,
				'Cultural Fee' => $voucherDetails->cultural_activities_fees,
				'Teachers Development Fee' => $voucherDetails->teachers_development_fees,
				'Student Development Fee' => $voucherDetails->student_development_fees,
				'Indian Red Cross Membership Fee' => $voucherDetails->indian_red_cross_membership_fees,
				'Women Cell Fee' => $voucherDetails->women_cell_fees,
				'NSS Fee' => $voucherDetails->nss_fees,
				'Teachers Flag Fee' => $voucherDetails->teachers_flag_fees
			];

			$university = 0;
			foreach ($fees as $feeName => $feeValue) {
				if ($feeValue > 0) {
					$university += $feeValue;
				}
			}
			if ($university > 0) {
				$tableData[] = ["University Other Fee", $university];
			}
			if ($voucherDetails->college_other_fees > 0) {
				$tableData[] = ['College Other Fee', $voucherDetails->college_other_fees];
			}
			if ($voucherDetails->exam_fee > 0) {
				$tableData[] = ['Exam Fee', $voucherDetails->exam_fee];
			}
			if ($voucherDetails->tuition_fee > 0) {
				$tableData[] = ['Tution Fee', $voucherDetails->tuition_fee];
			}
			if ($voucherDetails->corpus_fee_demand > 0) {
				$tableData[] = ['Corpus Fund', $voucherDetails->corpus_fee_demand];
			}

			// Create a function to generate a single copy
			function generateCopy($i, $pdf, $x, $y, $collegeName, $affiliation, $contactInfo, $contactInfo1, $issuedOn, $programe, $chellan, $dept, $tableData, $voucherDetails, $copy, $accno)
			{
				$collegeName1 = "Autonomous Institute Affiliated to the VTU";
				$collegeName2 = "Under the auspices of the MTES (R),";
				$collegeName3 = "";
				$contactInfo1 = "PB NO. 21,SALAGAME ROAD HASSAN, KARNATAKA";
				$contactInfo2 = "";
				$contactInfo = "UG (AY-2024-2025)";
				$pdf->Rect($x - 2, $y, 69, 90 + 70);
				$pdf->SetXY($x, $y);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(65, 6, $collegeName, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(65, 3, $collegeName1, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(65, 4, $collegeName2, 0, 1, 'C');
				// $pdf->SetX($x);
				// $pdf->SetFont('Arial', '', 7);
				// $pdf->Cell(65, 3, $collegeName3, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 6);
				$pdf->Cell(65, 3, $contactInfo1, 0, 1, 'C');
				// $pdf->SetX($x);
				// $pdf->Cell(65, 3, $contactInfo2, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', 'B', 7);
				$pdf->Cell(65, 5, $affiliation, 0, 1, 'C');
				$pdf->SetX($x);
				$pdf->SetFont('Arial', '', 6);
				$pdf->Cell(65, 4, $contactInfo, 0, 1, 'C');


				// Draw a line
				$pdf->SetLineWidth(0.2);
				$pdf->Line($x, $y + 21, $x + 65, $y + 21);
				$pdf->Ln(3);
				$pdf->SetLineWidth(0.2);
				$pdf->Line($x, $y + 25, $x + 65, $y + 25);
				$pdf->Ln(3);
				$pdf->SetFont('Arial', '', 7);
				$pdf->SetXY($x, $y + 29);
				$pdf->Cell(65, 4, $issuedOn, 0, 0, 'L');
				$pdf->SetXY($x, $y + 29);
				$pdf->Cell(65, 4, $programe, 0, 1, 'R');
				$pdf->SetXY($x, $y + 34);
				$pdf->Cell(65, 4, $chellan, 0, 0, 'L');
				$pdf->SetXY($x, $y + 34);
				$pdf->Cell(65, 4, $dept, 0, 1, 'R');
				$pdf->SetXY($x, $y + 39);
				$pdf->SetFont('Arial', '', 7);
				$pdf->MultiCell(65, 4, "Paid into the credit of CANARA BANK M.C.E BRANCH,\nHASSAN -573202., CA A/C No. " . $accno . " of \nThe Principal Malnad College of Engineering, Hassan.");
				$pdf->SetXY($x, $y + 52);
				// $pdf->SetFont('Arial', '', 7);
				// $pdf->MultiCell(65, 4, "Cash/D.D.No.________________________Dt________\n");
				// $pdf->SetXY($x, $y + 56);
				// $pdf->SetFont('Arial', '', 7);
				// $pdf->MultiCell(65, 4, "Bank_________________________________________");
				$pdf->SetFont('Arial', '', 7);
				$pdf->MultiCell(65, 4, "");
				$tableY = $pdf->GetY(); // Get current Y position for the table
				foreach ($tableData as $row) {
					$pdf->SetXY($x, $tableY);
					$pdf->Cell(32.5, 5, $row[0], 1, 0, 'L');
					$pdf->Cell(32.5, 5, $row[1], 1, 1, 'L');
					$tableY += 5; // Move Y position down for the next row
				}

				$pdf->SetFont('Arial', 'B', 7);
				$pdf->SetXY($x, $tableY + 3);
				$pdf->Cell(32.5, 4, "TOTAL", 1, 0, 'L');
				$pdf->Cell(32.5, 4, number_format($voucherDetails->final_fee, 2), 1, 1, 'L');
				$tableY += 9;
				$pdf->SetFont('Arial', '', 7.5);
				$pdf->SetXY($x, $tableY);
				$pdf->MultiCell(65, 4, "Amount (In Words) : Rs." . convert_number_to_words($voucherDetails->final_fee) . " Only");
				$pdf->SetXY($x, $tableY + 14);
				$pdf->Cell(32.5, 4, ' ', 0, 0, 'L');
				$pdf->Cell(32.5, 4, "Signature of Remitter", 0, 1, 'R');
				$pdf->SetXY($x, $tableY + 30);
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(65, 4, $copy, 0, 1, 'C');
			}

			// Add page and set margins
			$pdf->AddPage('L', 'A4'); // 'L' for landscape orientation, 'A4' for A4 size (210x297 mm)
			$pdf->SetMargins(10, 10, 10);

			// Generate four copies horizontally
			$startX = 10;
			$startY = 10;
			$spacingX = 70; // Adjust this spacing to fit the copies horizontally

			for ($i = 0; $i < 4; $i++) {
				generateCopy($i, $pdf, $startX + ($i * $spacingX), $startY, $collegeName, $affiliation, $contactInfo, $contactInfo1, $issuedOn, $programe, $chellan, $dept, $tableData, $voucherDetails, $copyData[$i], $accno);
			}

			// $pdf->Output();
			$fileName = $admissionDetails->student_name . '-Voucher.pdf';
			$pdf->output($fileName, 'D');
		} else {
			redirect('admin/timeout');
		}
	}


	public function getTransactionDetails($order_id)
	{
		require_once APPPATH . 'libraries/Jwt.php';
		$this->load->library('logger');
		$transact = $this->admin_model->getDetailsbyfield($order_id, 'reference_no', 'transactions')->row();

		$billdesk_URL_retrive = "https://api.billdesk.com/payments/ve1_2/transactions/get";
		$trace_id = rand(1000000000, 9999999999);
		$servertime = time();

		if ($transact->payment_mode == 0) {

			if ($transact->aided_unaided == 'Aided') {

				$headers = array("alg" => "HS256", "clientid" => "cnbmlndaid", "kid" => "HMAC");
				$payload = array(
					"mercid" => 'CNBMLNDAID',
					"orderid" => $order_id,
				);

				$curl_payload = JWT::encode($payload, 'hbjUTwdjLDwzsFErRVCE0y0skHic1z2B', 'HS256', $headers);
			} else {

				$headers = array("alg" => "HS256", "clientid" => "cnbmlndegc", "kid" => "HMAC");
				$payload = array(
					"mercid" => 'CNBMLNDEGC',
					"orderid" => $order_id,
				);
				$curl_payload = JWT::encode($payload, 'WHjXW5WHk27mr50KetSh75vyapmO14IT', 'HS256', $headers);
			}
		} else {
			$headers = array("alg" => "HS256", "clientid" => "cnbmlndtrt", "kid" => "HMAC");
			$payload = array(
				"mercid" => 'CNBMLNDTRT',
				"orderid" => $order_id,
			);
			$curl_payload = JWT::encode($payload, 'k2ieff4ugn8Ehv31tUhXTRoHK2MEBrdJ', 'HS256', $headers);
		}





		$message = "BillDesk retrieve payload - " . $curl_payload . "\n";
		$this->logger->write('billdesk', 'debug', $message);
		$ch = curl_init($billdesk_URL_retrive);
		$ch_headers = array(
			"Content-Type: application/jose",
			"accept: application/jose",
			"BD-Traceid: $trace_id",
			"BD-Timestamp: $servertime"
		);

		$message = "BillDesk retrieve curl header - " . json_encode($ch_headers) . "\n";
		$this->logger->write('billdesk', 'debug', $message);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $ch_headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);

		$message = "Billdesk retrieve order response - " . $response;
		$this->logger->write('billdesk', 'debug', $message);
		curl_close($ch);
		if ($transact->payment_mode == 0) {

			if ($transact->aided_unaided == 'Aided') {

				$result_decoded = JWT::decode($response, 'hbjUTwdjLDwzsFErRVCE0y0skHic1z2B', 'HS256');
			} else {


				$result_decoded = JWT::decode($response, 'WHjXW5WHk27mr50KetSh75vyapmO14IT', 'HS256');
			}
		} else {

			$result_decoded = JWT::decode($response, 'k2ieff4ugn8Ehv31tUhXTRoHK2MEBrdJ', 'HS256');
		}
		$response_array = (array) $result_decoded;
		$message = "Billdesk retrieve order response decoded - " . json_encode($response_array);
		$this->logger->write('billdesk', 'debug', $message);
		$res['status'] = 3;
		$res['reason'] = "UNKNOWN";

		if ($response_array['transactionid']) {

			$response_json = json_encode($response_array);

			if ($response_array['auth_status'] == '0300') {
				$res['status'] = 5;
				$res['txn_id'] = $response_array['transactionid'];
				$res['reason'] = 'success';
				$cnt_number = $this->getReceiptNo($order_id);
				$receipt_no = $cnt_number;


				$updateDetails = array(
					'transaction_date' => $response_array['transaction_date'],
					'transaction_id' => $response_array['transactionid'],
					'txn_response' => $response_json,
					'receipt_no' => $receipt_no,
					'transaction_status' => '1'

				);
			} else if ($response_array['auth_status'] == '0002') {
				$res['status'] = 2;
				$res['reason'] = 'pending';
				$updateDetails = array(
					'transaction_date' => $response_array['transaction_date'],
					'transaction_id' => $response_array['transactionid'],
					'txn_response' => $response_json,

					'transaction_status' => '0'

				);
			} else if ($response_array['auth_status'] == '0399') {
				$res['status'] = 6;
				$res['reason'] = 'fail';
				$updateDetails = array(
					'transaction_date' => $response_array['transaction_date'],
					'transaction_id' => $response_array['transactionid'],
					'txn_response' => $response_json,

					'transaction_status' => '2'

				);
			}
			// print_r($updateDetails);
			// $res['amount'] = (int)$response_array['amount'];

		} else {
			$updateDetails = array(

				'transaction_status' => '2'

			);
		}

		$result = $this->admin_model->updateDetailsbyfield('reference_no', $order_id, $updateDetails, 'transactions');
		return $result;
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

	public function updateTransactionsByUsn1($usn)
	{

		$transactions = $this->db->get_where('transactions', [
			'reg_no' => $usn,
			'transaction_status' => '0'
		])->result();

		foreach ($transactions as $transact) {

			$order_id = $transact->reference_no;
			$updateDetails = $this->getTransactionDetails($order_id);
		}

		return true; // or return some status
	}

	function timeout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('admin', 'refresh');
	}



	public function updateTransactionsByUsn()
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];



			$data['page_title'] = 'Update Transactions By Usn';
			$data['menu'] = 'payments';
			// $data['admissionDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();

			$this->form_validation->set_rules('usn', 'USN', 'required');
			if ($this->form_validation->run() === FALSE) {
				$data['action'] = 'admin/updateTransactionsByUsn';
				$this->admin_template->show('admin/updateTransactions', $data);
			} else {

				$usn = $this->input->post('usn');

				$transactions = $this->db->get_where('transactions', [
					'reg_no' => $usn,
					'transaction_status' => '0'
				])->result();

				foreach ($transactions as $transact) {

					$order_id = $transact->reference_no;
					$updateDetails = $this->getTransactionDetails($order_id);
				}
				$this->session->set_flashdata('message', 'Transactions Updated');
				$data['action'] = 'admin/updateTransactionsByUsn';
				$this->admin_template->show('admin/updateTransactions', $data);
			}
		} else {
			redirect('admin/timeout');
		}
	}

	public function corpusoverall_report($download = 0)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$currentAcademicYear = $this->globals->currentAcademicYear();
			$data['page_title'] = $currentAcademicYear . ' CORPUS OVERALL FEE';
			$data['menu'] = 'CorpusoverallfeeReport';

			$data['download_action'] = 'admin/corpusoverall_report';

			// Fetch students with Corpus balance greater than 0
			$students = $this->admin_model->CorpusReport($currentAcademicYear)->result();

			$table_setup = array('table_open' => '<table class="table dt-responsive nowrap table-bordered" border="1" id="basic-datatable">');
			$this->table->set_template($table_setup);

			$print_fields = array('S.No', 'Academic Year', 'Usn', 'Student Name', 'Course', 'Corpus Fee Demand', 'Quota', 'College Code', 'Mobile', 'Corpus Balance');
			$this->table->set_heading($print_fields);

			$i = 1;
			foreach ($students as $student) {

				$dmm = $this->admin_model->get_dept_by_id($student->department_id)["department_name"];

				$result_array = array(
					$i++,
					$student->admission_year,  // Display the current academic year
					$student->usn,
					$student->student_name,
					$dmm,  // Department name
					number_format((float) $student->Corpus_fee_demand, 0),
					$student->quota,
					$student->college_code,
					$student->student_number,  // Assuming this is the mobile number or student number
					number_format($student->Corpus_balance, 0),  // Format corpus balance
				);

				$this->table->add_row($result_array);
			}

			$data['table'] = $this->table->generate();

			if (!$download) {
				$this->admin_template->show('admin/corpusoverall_report', $data);
			} else {
				$response = array(
					'op' => 'ok',
					'file' => "data:application/vnd.ms-excel;base64," . base64_encode($data['table'])
				);
				die(json_encode($response));
			}
		} else {
			redirect('admin/timeout');
		}
	}

	public function corpusbalance_report($download = 0)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			$currentAcademicYear = $this->globals->currentAcademicYear();
			$data['page_title'] = $currentAcademicYear . ' CORPUS BALANCE FEE';
			$data['menu'] = 'corpusbalancereport';

			$data['download_action'] = 'admin/corpusoverall_report';

			// Fetch students with Corpus balance greater than 0
			$students = $this->admin_model->CorpusBalanceReport($currentAcademicYear)->result();

			$table_setup = array('table_open' => '<table class="table dt-responsive nowrap table-bordered" border="1" id="basic-datatable">');
			$this->table->set_template($table_setup);

			$print_fields = array('S.No', 'Academic Year', 'Usn', 'Student Name', 'Course', 'Quota', 'College Code', 'Corpus Balance', 'Mobile', 'Corpus Fee Demand');
			$this->table->set_heading($print_fields);

			$i = 1;
			foreach ($students as $student) {

				$dmm = $this->admin_model->get_dept_by_id($student->department_id)["department_name"];

				$result_array = array(
					$i++,
					$currentAcademicYear,  // Display the current academic year
					$student->usn,
					$student->student_name,
					$dmm,  // Department name
					$student->quota,
					$student->college_code,
					number_format($student->Corpus_balance, 0),  // Format corpus balance
					$student->student_number,  // Assuming this is the mobile number or student number
					number_format($student->Corpus_fee_demand, 0)  // Format corpus balance
				);

				$this->table->add_row($result_array);
			}

			$data['table'] = $this->table->generate();

			if (!$download) {
				$this->admin_template->show('admin/corpusbalance_report', $data);
			} else {
				$response = array(
					'op' => 'ok',
					'file' => "data:application/vnd.ms-excel;base64," . base64_encode($data['table'])
				);
				die(json_encode($response));
			}
		} else {
			redirect('admin/timeout');
		}
	}

	public function academic_report($download = 0)
	{
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['role'] = $session_data['role'];

			// Retrieve current academic year and available academic years
			$data['currentAcademicYear'] = $this->globals->currentAcademicYear();
			$data['academicYears'] = array("" => "Select") + $this->globals->academicYears();
			$data['page_title'] = 'ACADEMIC YEAR WISE';
			$data['menu'] = 'academicyearwise';
			$data['download_action'] = 'admin/academic_report';

			// Fetch input values
			$academic_year = $this->input->post('academic_year');
			$year = $this->input->post('year');

			// Fetch students with Corpus balance greater than 0 based on filters
			$students = $this->admin_model->get_academicyear($academic_year, $year)->result();

			// Table setup for displaying data
			$table_setup = array('table_open' => '<table class="table dt-responsive nowrap table-bordered" border="1" id="basic-datatable">');
			$this->table->set_template($table_setup);

			$print_fields = array('S.No', 'Academic Year', 'Usn', 'Student Name', 'Course', 'Year', 'Student Number', 'College Code', 'Quota', 'Category Claimed');
			$this->table->set_heading($print_fields);

			$i = 1;
			foreach ($students as $student) {
				$dmm = $this->admin_model->get_dept_by_id($student->department_id)["department_name"];

				$result_array = array(
					$i++,
					$student->admission_year,
					// $academic_year ?: $data['currentAcademicYear'],  // Display selected or current academic year
					$student->usn,
					$student->student_name,
					$dmm,  // Department name
					$student->year,
					$student->student_number,  // Assuming this is the mobile number or student number
					$student->quota,
					$student->college_code,
					$student->category_claimed,
				);

				$this->table->add_row($result_array);
			}

			$data['table'] = $this->table->generate();

			// Handle download request
			if (!$download) {
				$this->admin_template->show('admin/academic_report', $data);
			} else {
				$response = array(
					'op' => 'ok',
					'file' => "data:application/vnd.ms-excel;base64," . base64_encode($data['table'])
				);
				die(json_encode($response));
			}
		} else {
			redirect('admin/timeout');
		}
	}
}
