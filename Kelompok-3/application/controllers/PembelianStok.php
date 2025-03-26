<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PembelianStok extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PembelianStok_model');
        $this->load->model('StokProduct_model'); // Model untuk update stok produk
        $this->load->library('form_validation'); // Load library form_validation
        $this->load->helper('url'); // Load URL helper untuk redirect
    }

    public function index() {
        $this->load->view('templates/header');

        $data['pembelian_stok'] = $this->PembelianStok_model->get_all();
        $this->load->view('admin/pembelian_stok', $data);

        $this->load->view('templates/footer');
    }

    // Simpan pembelian stok dan detailnya
    public function tambah() {
        $no_pesan = $this->PembelianStok_model->generateNoPesan();
        $tgl_pesan = $this->input->post('tgl_pesan');
        $keterangan = $this->input->post('keterangan');
        $status = 'Proses';

        $data_pembelian = [
            'no_pesan' => $no_pesan,
            'tgl_pesan' => $tgl_pesan,
            'keterangan' => $keterangan,
            'status' => $status,
            'tgl_terima' => NULL,
            'tgl_batal' => NULL
        ];

        // Simpan pembelian stok
        $insert_pembelian = $this->PembelianStok_model->insertPembelian($data_pembelian);

        if (!$insert_pembelian) {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan data"]);
            return;
        }

        // Simpan detail pembelian stok
        $fk_product = $this->input->post('fk_product');
        $qty = $this->input->post('qty');
        $harga = $this->input->post('harga');

        if (!empty($fk_product)) {
            $details = [];
            for ($i = 0; $i < count($fk_product); $i++) {
                if (!empty($fk_product[$i]) && !empty($qty[$i]) && !empty($harga[$i])) {
                    $harga_clean = intval(str_replace(['.', ','], '', $harga[$i])); // Pastikan harga dalam format angka

                    $details[] = [
                        'fk_pesan' => $no_pesan,
                        'fk_product' => $fk_product[$i],
                        'qty' => $qty[$i],
                        'harga' => $harga_clean
                    ];

                    // Update stok produk
                    //$this->StokProduct_model->update_stok_product($fk_product[$i], $harga_clean, $qty[$i], 'in');
                }
            }

            if (!empty($details)) {
                $this->PembelianStok_model->insertDetailPembelian($details);
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
    }

    public function update() {
        $no_pesan = $this->input->post('no_pesan');
        $tgl_pesan = $this->input->post('tgl_pesan');
        $keterangan = $this->input->post('keterangan');

        // Update header pembelian
        $dataUpdate = [
            'tgl_pesan' => $tgl_pesan,
            'keterangan' => $keterangan
        ];
        $this->db->where('no_pesan', $no_pesan);
        $this->db->update('tblpembelian_stok', $dataUpdate);

        // Hapus semua detail lama
        $this->db->where('fk_pesan', $no_pesan);
        $this->db->delete('tblpembelian_stok_detail');

        // Simpan detail pembelian stok
        $fk_product = $this->input->post('fk_product');
        $qty = $this->input->post('qty');
        $harga = $this->input->post('harga');

        if (!empty($fk_product)) {
            $details = [];
            for ($i = 0; $i < count($fk_product); $i++) {
                if (!empty($fk_product[$i]) && !empty($qty[$i]) && !empty($harga[$i])) {
                    $harga_clean = intval(str_replace(['.', ','], '', $harga[$i])); // Pastikan harga dalam format angka

                    $details[] = [
                        'fk_pesan' => $no_pesan,
                        'fk_product' => $fk_product[$i],
                        'qty' => $qty[$i],
                        'harga' => $harga_clean
                    ];

                    // Update stok produk
                    //$this->StokProduct_model->update_stok_product($fk_product[$i], $harga_clean, $qty[$i], 'in');
                }
            }

            if (!empty($details)) {
                $this->PembelianStok_model->insertDetailPembelian($details);
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Data pembelian berhasil diperbarui.']);
    }

    public function getDetail() {
        $no_pesan = $this->input->post('no_pesan');
        
        $this->db->select('tblpembelian_stok_detail.fk_product, tblproduct.nm_product, tblpembelian_stok_detail.qty, tblpembelian_stok_detail.harga, (tblpembelian_stok_detail.qty * tblpembelian_stok_detail.harga) as total_harga');
        $this->db->from('tblpembelian_stok_detail');
        $this->db->join('tblproduct', 'tblproduct.kd_product = tblpembelian_stok_detail.fk_product');
        $this->db->where('tblpembelian_stok_detail.fk_pesan', $no_pesan);
        $query = $this->db->get();

        echo json_encode($query->result());
    }

    public function getProducts()
    {
        $this->load->model('Product_model'); // Pastikan model sudah ada
        $products = $this->Product_model->get_all_products();
        
        echo json_encode($products);
    }


}
?>
