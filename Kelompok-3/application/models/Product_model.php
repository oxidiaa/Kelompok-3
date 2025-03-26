<?php
class Product_model extends CI_Model
{
    // Ambil semua data produk dengan informasi satuan
    public function get_all_products()
    {
        $this->db->select('p.*, s.nm_satuan, p.keterangan');
        $this->db->from('tblproduct p');
        $this->db->join('tblsatuan s', 'p.fk_satuan = s.kd_satuan', 'left'); // Join untuk ambil satuan
        return $this->db->get()->result();
    }

    // Ambil semua satuan dari tblsatuan
    public function get_all_satuan()
    {
        return $this->db->get('tblsatuan')->result();
    }

    // Periksa apakah kode produk sudah ada
    public function is_kd_product_exist($kd_product)
    {
        $query = $this->db->get_where('tblproduct', ['kd_product' => $kd_product]);
        return $query->num_rows() > 0;
    }

    // Tambah produk baru
    public function insert_product($data)
    {
        if ($this->is_kd_product_exist($data['kd_product'])) {
            return false; // Kode produk sudah ada, gagal insert
        }
        return $this->db->insert('tblproduct', $data);
    }

    // Update produk berdasarkan kode produk
    public function update_product($kd_product, $data)
    {
        if (empty($kd_product)) {
            return false; // Jika kd_product kosong, langsung return false
        }

        $this->db->where('id_product', $kd_product);
        $this->db->update('tblproduct', $data);
        return ($this->db->affected_rows() > 0); // Hanya TRUE jika ada perubahan data
    }

    // Hapus produk berdasarkan kode produk
    public function delete_product($id_product)
    {
        $this->db->where('id_product', $id_product);
        $this->db->delete('tblproduct');
        return $this->db->affected_rows() > 0; // Pastikan data benar-benar terhapus
    }

    // Cari produk berdasarkan nama produk atau keterangan
    public function search_product($keyword)
    {
        $this->db->select('p.*, s.nm_satuan, p.keterangan');
        $this->db->from('tblproduct p');
        $this->db->join('tblsatuan s', 'p.fk_satuan = s.kd_satuan', 'left');
        $this->db->like('p.nm_product', $keyword);
        $this->db->or_like('p.keterangan', $keyword); // Bisa cari berdasarkan keterangan juga
        return $this->db->get()->result();
    }

    // Ambil data produk berdasarkan kode produk (untuk edit atau delete)
    public function get_product_by_id($kd_product)
    {
        $this->db->select('p.*, s.nm_satuan, p.keterangan');
        $this->db->from('tblproduct p');
        $this->db->join('tblsatuan s', 'p.fk_satuan = s.kd_satuan', 'left');
        $this->db->where('p.kd_product', $kd_product);
        return $this->db->get()->row();
    }
}
?>
