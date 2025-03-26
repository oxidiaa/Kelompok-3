<?php
class LoginCheck {

    public function check_login() {
        $CI = &get_instance();
        // Cek apakah user sudah login dan coba mengakses halaman login
        if (!$CI->session->userdata('logged_in') && $CI->uri->segment(1) != 'login') {
            // Jika belum login dan bukan halaman login, arahkan ke halaman login
            $CI->session->set_userdata('redirect_url', current_url());
            redirect('login');
        }
    }
}

