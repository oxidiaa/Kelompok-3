<?php
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model User_model
        $this->load->model('User_model');
    }

    // Form login
    public function index() {
        $this->load->view('login');
    }

    // Logika autentikasi
    public function authenticate() {
        // Ambil data dari form
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Cek kredensial pengguna
        $user = $this->User_model->authenticate($username, $password);

        if ($user) {
            // Set session data jika login berhasil
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('role', $user->role); // Menyimpan role di session

            // Cek apakah ada redirect URL yang disimpan
            $redirect_url = $this->session->userdata('redirect_url');
            if ($redirect_url) {
                $this->session->unset_userdata('redirect_url'); // Hapus URL redirect setelah digunakan
                redirect($redirect_url); // Redirect ke halaman yang diminta sebelumnya
            } else {
                // Redirect berdasarkan role pengguna
                if ($user->role == 1) {
                    redirect('admin'); // Redirect ke dashboard admin
                } else {
                    redirect('user'); // Redirect ke dashboard user
                }
            }
        } else {
            // Set pesan error jika login gagal
            $this->session->set_flashdata('error', 'Username atau password salah.');
            redirect('login');
        }
    }

    // Form registrasi
    public function register() {
        $this->load->view('register');
    }

    // Proses registrasi
    public function create_account() {
        // Ambil data dari form
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $email = $this->input->post('email');
        $role = $this->input->post('role'); // Ambil role dari form

        // Simpan inputan kembali ke session flash data jika terjadi error
        $this->session->set_flashdata('username', $username);
        $this->session->set_flashdata('email', $email);
        $this->session->set_flashdata('role', $role);

        // Cek apakah password dan konfirmasi password cocok
        if ($password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Password dan konfirmasi password tidak cocok.');
            redirect('register');  // Kembali ke halaman registrasi jika tidak cocok
        }

        // Enkripsi password sebelum disimpan
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Coba daftarkan pengguna baru
        $result = $this->User_model->register($username, $password_hashed, $email, $role);

        if ($result) {
            $this->session->set_flashdata('success', 'Akun berhasil dibuat.');
            redirect('login');

            $this->session->keep_flashdata('username');
            $this->session->keep_flashdata('email');
            $this->session->keep_flashdata('role');
        } else {
            $this->session->set_flashdata('error', 'Username sudah terdaftar.');
            redirect('register');
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('username');
        redirect('login');
    }

}
