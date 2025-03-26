<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model {
    public function get_all() {
        $this->db->select('k.id_karyawan, k.nm_karyawan, k.fk_jabatan, j.nm_jabatan, k.tempat_lahir, k.tgl_lahir, k.tgl_masuk, k.tgl_keluar');
        $this->db->from('tblkaryawan k');
        $this->db->join('tbljabatan j', 'k.fk_jabatan = j.kd_jabatan', 'left'); // Pastikan join dilakukan
        return $this->db->get()->result();
    }

    public function get_jabatan() {
        return $this->db->get('tbljabatan')->result();
    }

    public function insert($data) {
        $this->db->insert('tblkaryawan', $data);
    }

    public function update($id, $data) {
        $this->db->where('id_karyawan', $id);
        $this->db->update('tblkaryawan', $data);
    }

    public function cek_id_karyawan($id) {
        return $this->db->where('id_karyawan', $id)->count_all_results('tblkaryawan') > 0;
    }

    // Fungsi untuk menghapus data karyawan berdasarkan ID
    public function delete($id_karyawan) {
        // Menghapus data karyawan berdasarkan id_karyawan
        $this->db->where('id_karyawan', $id_karyawan);
        return $this->db->delete('tblkaryawan');
    }
}
