<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{

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
			$data['religion_option'] = array(" " => "Select Religion") + $this->globals->religion();
			$data['caste_option'] = array(" " => "Select Caste") + $this->globals->caste();
			$data['countries'] = $this->admin_model->getCountries();
			$data['states1'] = $this->admin_model->get_states();
			$data['admissionDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();

			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			// $data['admissions'] = $this->admin_model->get_details_by_id($id, 'id', 'admissions');

			$this->form_validation->set_rules('student_name', 'Student Name', 'required');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required');
			$this->form_validation->set_rules('email', 'Email Id', 'required');
			$this->form_validation->set_rules('aadhaar', 'Aadhar Number', 'required');
			$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('sports', 'Sports', 'required');
			$this->form_validation->set_rules('blood_group', 'Blood Group', 'required');
			$this->form_validation->set_rules('place_of_birth', 'Place of Birth', 'required');
			$this->form_validation->set_rules('country_of_birth', '	Country of Birth', 'required');
			$this->form_validation->set_rules('nationality', 'Nationality', 'required');
			$this->form_validation->set_rules('religion', 'Religion', 'required');
			$this->form_validation->set_rules('caste', 'Caste', 'required');
			$this->form_validation->set_rules('current_address', 'Current Address', 'required');
			$this->form_validation->set_rules('present_address', 'Present Address', 'required');

			if ($this->form_validation->run() === FALSE) {

				$data['action'] = 'student/personaldetails/' . $data['id'];

				$personalDetails = $this->admin_model->getDetails('admissions', $data['id'])->row();

				$data['student_name'] = $personalDetails->student_name;
				$data['mobile'] = $personalDetails->mobile;
				$data['email'] = $personalDetails->email;
				$data['aadhaar'] = $personalDetails->aadhaar;
				$data['date_of_birth'] = $personalDetails->date_of_birth;
				$data['gender'] = $personalDetails->gender;
				$data['sports'] = $personalDetails->sports;
				$data['blood_group'] = $personalDetails->blood_group;
				$data['place_of_birth'] = $personalDetails->place_of_birth;
				$data['country_of_birth'] = $personalDetails->country_of_birth;
				$data['nationality'] = $personalDetails->nationality;
				$data['religion'] = $personalDetails->religion;
				$data['caste'] = $personalDetails->caste;
				$data['mother_tongue'] = $personalDetails->mother_tongue;
				$data['current_address'] = $personalDetails->current_address;
				$data['present_address'] = $personalDetails->present_address;
				$this->student_template->show('student/personal_details', $data);
			} else {
				$updateDetails = array(
					'student_name' => $this->input->post('student_name'),
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'aadhaar' => $this->input->post('aadhaar'),
					'date_of_birth' => $this->input->post('date_of_birth'),
					'gender' => $this->input->post('gender'),
					'sports' => $this->input->post('sports'),
					'blood_group' => $this->input->post('blood_group'),
					'place_of_birth' => $this->input->post('place_of_birth'),
					'country_of_birth' => $this->input->post('country_of_birth'),
					'nationality' => $this->input->post('nationality'),
					'religion' => $this->input->post('religion'),
					'caste' => $this->input->post('caste'),
					'mother_tongue' => $this->input->post('mother_tongue'),
					'current_address' => $this->input->post('current_address'),
					'present_address' => $this->input->post('present_address'),
				);
				// print_r($updateDetails);
				// die();
				$result = $this->admin_model->updateDetails($data['id'], $updateDetails, 'admissions');

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
