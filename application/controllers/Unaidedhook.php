<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unaidedhook extends CI_Controller
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
       
       
    }

    
}
