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

	function students()
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
			$data['students'] = $this->admin_model->fetchDetails2('id, app_no, adm_no,quota,dept_id,sub_quota, student_name, mobile,usn,status', 'status', $status, 'academic_year', $data['currentAcademicYear'], 'students')->result();
			// var_dump($data['admissions']); die();

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
				$print_fields = array('SL. No.', 'STUDENT NAME', 'USN', 'College Code', 'EMAIL', 'Gender', 'AADHAR NUMBER', 'Quota', 'Sub Quota', 'Category Allotted', 'Category Claimed', 'Caste', 'Sub caste', 'Father Number', 'Student Number', 'State', 'Country', 'Stream', 'Department', 'Year', 'TOTAL UNIVERSITY OTHER FEE', 'COLLEGE OTHER FEE','EXAM FEE', 'TUITION FEE', 'College fee demand', 'College fee collection', 'COLLEGE FEE BALANCE', 'RECEIPT-No & Date', 'ONLINE PAYMENT DETAILS', 'REMARKS', 'Comments', 'Corpus fee demand', 'Corpus fee collection', 'CORPUS FEE Balance', 'RECEIPT-No & Date', 'ONLINE PAYMENT DETAILS', 'REMARKS', 'Comments');
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
			$data['admissionDetails'] = $this->admin_model->getDetailsbyfield($student_id, 'usn','students')->row();
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
}
