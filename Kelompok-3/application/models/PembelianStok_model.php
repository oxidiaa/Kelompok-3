<?php
class PembelianStok_model extends CI_Model {

    public function get_all() {
        $this->db->order_by('tgl_pesan', 'DESC');
        return $this->db->get('tblpembelian_stok')->result();
    }

    // Ambil No Pesanan dari Stored Procedure
    public function generateNoPesan() {
        // Panggil prosedur dengan parameter output
        $this->db->query("CALL GenerateNoPesan(@new_no_pesan)");

        // Ambil hasil dari variabel @new_no_pesan
        $queryResult = $this->db->query("SELECT @new_no_pesan AS no_pesan");
        $result = $queryResult->row();

        return $result ? $result->no_pesan : null;
    }

    // Simpan Data ke tblpembelian_stok
    public function insertPembelian($data) {
        return $this->db->insert('tblpembelian_stok', $data);
    }

    public function updatePembelian($no_pesan, $data) {
        $this->db->where('no_pesan', $no_pesan);
        return $this->db->update('tblpembelian_stok', $data);
    }

    // Simpan Detail Pembelian ke tblpembelian_stok_detail
    public function insertDetailPembelian($data) {
        return $this->db->insert_batch('tblpembelian_stok_detail', $data);
    }

}
?>
