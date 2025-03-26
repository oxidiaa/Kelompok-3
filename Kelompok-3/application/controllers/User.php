<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->library('form_validation'); // Load library form_validation
        $this->load->helper('url'); // Load URL helper untuk redirect
    }

    public function index() {
        $this->load->view('templates/header');

       $data['user_list'] = $this->User_model->get_all();
       $data['karyawan_list'] = $this->User_model->get_karyawan();
       $this->load->view('admin/user', $data);

       $this->load->view('templates/footer');
    }

    public function save() {
        // Get the request data
        $edit_mode = $this->input->post('edit_mode');
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $karyawan_id = $this->input->post('fk_karyawan');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');

        // Password validation: if in edit mode, password is optional
        if ($edit_mode == 0) {
            if (empty($password) || $password !== $password_confirm) {
                echo json_encode(['status' => 'error', 'message' => 'Password dan konfirmasi password tidak cocok.']);
                return;
            }
            // Password strength validation
            $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
            if (!preg_match($password_pattern, $password)) {
                echo json_encode(['status' => 'error', 'message' => 'Password harus terdiri dari minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan karakter khusus.']);
                return;
            }
        }

        // Prepare user data
        $user_data = [
            'username' => $username,
            'email' => $email,
            'role' => $role,
            'fk_karyawan' => $karyawan_id,
        ];

        // If password is not empty, hash it
        if (!empty($password)) {
            $user_data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($edit_mode == 1) {
            // Edit user
            $update_result = $this->User_model->update_user($id, $user_data);
            if ($update_result) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal diperbarui.']);
            }
        } else {
            // Add user
            $insert_result = $this->User_model->insert_user($user_data);
            if ($insert_result) {
                echo json_encode(['status' => 'success', 'message' => 'User ditambahkan.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal Menambah User.']);
            }
        }
    }
}
