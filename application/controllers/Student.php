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
		$this->form_validation->set_rules('usn', 'USN', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
		if ($this->form_validation->run() == FALSE) {
			$data['page_title'] = "Student Login";
			$data['action'] = 'student';

			$this->login_template->show('student/login', $data);
		} else {
			$email = $this->input->post('email');
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
					'student_name' => $row->student_name,
					'flow' => $row->flow
				);
				$this->session->set_userdata('student_in', $sess_array);
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('check_database', 'Invalid Email or password');
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

			$flow = $this->admin_model->getDetailsFilter('flow', $data['id'], 'admissions')->row()->flow;

			if ($flow) {
				$data['admissionDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();
				$data['entranceDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();
				$data['personalDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();
				$data['parentDetails'] = $this->admin_model->getDetails('admissions', $data['id'])->row();
				$data['educations_details'] = $this->admin_model->getDetailsbyfield($student_id, 'student_id', 'student_education_details')->result();
				$data['flow_status'] = $flow;

				$upload_path = "./assets/students/$student_id/";

				// Check if the directory exists
				$photo = null;
				if (is_dir($upload_path)) {
					// Get list of files in the directory
					$files = scandir($upload_path);

					// Remove . and .. from the list
					$files = array_diff($files, array('.', '..'));

					// Filter for photo files
					$image_extensions = array('jpg', 'jpeg', 'png');
					foreach ($files as $file) {
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						$filename = pathinfo($file, PATHINFO_FILENAME);

						// Check if the file is an image and contains keywords like 'profile' or the student's ID
						if (
							in_array(strtolower($ext), $image_extensions) &&
							(stripos($filename, 'profile') !== false)
						) {
							$photo = $upload_path . $file;  // Use the first matching photo found
							break;
						}
					}

					$data['files'] = $files;
				} else {
					$data['files'] = array();
				}

				$data['student_photo'] = $photo;  // Pass the photo path to the view

				$this->student_template->show('student/finish', $data);
			} else {
				$this->student_template->show('student/Dashboard', $data);
			}
		} else {
			redirect('student', 'refresh');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('student_in');
		session_destroy();
		redirect('student', 'refresh');
	}
}
