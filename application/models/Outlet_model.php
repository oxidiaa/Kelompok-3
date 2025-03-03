<?php
class Outlet_model extends CI_Model
{
    // Ambil semua data outlet
    public function get_all_outlets()
    {
        return $this->db->get('tbloutlet')->result();
    }

    // Periksa apakah ID Outlet sudah ada
    public function is_id_outlet_exist($id_outlet) {
        $query = $this->db->get_where('tbloutlet', ['id_outlet' => $id_outlet]);
        return $query->num_rows() > 0;
    }

    // Tambah data outlet
    public function insert_outlet($data) {
        if ($this->is_id_outlet_exist($data['id_outlet'])) {
            return false; // ID sudah ada, gagal insert
        }
        return $this->db->insert('tbloutlet', $data);
    }

    // Update data outlet berdasarkan ID
    public function update_outlet($id, $data) {
        $this->db->where('id_outlet', $id);
        $this->db->update('tbloutlet', $data);
        return $this->db->affected_rows() > 0; // Pastikan data benar-benar diperbarui
    }

    // Hapus outlet berdasarkan ID
    public function delete_outlet($id) {
        $this->db->where('id_outlet', $id);
        $this->db->delete('tbloutlet');
        return $this->db->affected_rows() > 0; // Pastikan data benar-benar terhapus
    }
}
?>
