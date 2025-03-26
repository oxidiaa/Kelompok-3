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

    // Register dengan user baru
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

    public function get_all() {
        $this->db->select('k.id,k.username, k.email, , k.role, j.nm_karyawan,k.fk_karyawan');
        $this->db->from('tbluser k');
        $this->db->join('tblkaryawan j', 'k.fk_karyawan = j.id_karyawan', 'left'); // Pastikan join dilakukan
        return $this->db->get()->result();
    }

    public function get_karyawan() {
        return $this->db->get('tblkaryawan')->result();
    }

    public function insert_user($data) {
        $this->db->insert('tbluser', $data);
    }

    // Update user in the database
    public function update_user($id, $data) {
        // Ensure the ID is provided for updating
        $this->db->where('id', $id);
        return $this->db->update('tbluser', $data);
    }

    // Check if username already exists
    public function check_username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('tbluser');
        return $query->num_rows() > 0;
    }

    // Check if email already exists
    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('tbluser');
        return $query->num_rows() > 0;
    }

}
