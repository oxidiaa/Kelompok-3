<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        // Memuat library session
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('templates/header');
        $this->load->view('admin/home');
        $this->load->view('templates/footer');
    }
}
