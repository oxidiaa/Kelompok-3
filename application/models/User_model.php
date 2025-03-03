<?php
class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    // Fungsi untuk autentikasi pengguna berdasarkan username dan password
    public function authenticate($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('tbluser');

        // Periksa apakah ada pengguna yang cocok
        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Cek password
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false; // Jika tidak ada pengguna yang cocok atau password salah
    }

    // Register a new user
    public function register($username, $password, $email, $role) {
        // Check if username already exists
        $this->db->where('username', $username);
        $query = $this->db->get('tbluser');
        
        if ($query->num_rows() > 0) {
            return false; // Username already taken
        }

        // Persiapkan data untuk disimpan
        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'role' => $role
        );
        
        // Masukkan data ke tabel tbluser
        return $this->db->insert('tbluser', $data);
    }

    // Fungsi untuk mendapatkan role pengguna
    public function get_user_role($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('tbluser');
        if ($query->num_rows() == 1) {
            return $query->row()->role;
        }
        return null;
    }
}
