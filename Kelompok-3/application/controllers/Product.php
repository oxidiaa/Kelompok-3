<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Product_model'); // Load model Product
        $this->load->library('form_validation'); // Load library form_validation
        $this->load->helper(['url', 'form']); // Load URL & form helper
    }

    // Menampilkan daftar produk
    public function index() {
        $this->load->view('templates/header');

        $data['products'] = $this->Product_model->get_all_products();
        $data['satuan'] = $this->Product_model->get_all_satuan(); // Ambil semua satuan

        $this->load->view('admin/product', $data);

        $this->load->view('templates/footer');
    }

    // Simpan produk baru
    public function simpan() {
        $this->form_validation->set_rules('kd_product', 'Kode Produk', 'required|is_unique[tblproduct.kd_product]|regex_match[/^\S+$/]',
            ['is_unique' => 'Kode Produk sudah digunakan!', 'regex_match' => 'Kode Produk tidak boleh mengandung spasi!']
        );
        $this->form_validation->set_rules('nm_product', 'Nama Produk', 'required|min_length[3]');
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
        $this->form_validation->set_rules('is_active', 'Status Produk', 'required|in_list[0,1]');
        $this->form_validation->set_rules('fk_satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[255]'); // Tambahkan validasi keterangan

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                "status" => "error",
                "message" => validation_errors()
            ]);
        } else {
            // Upload gambar jika ada
            $image_product = '';
            if (!empty($_FILES['image_product']['name'])) {
                $config['upload_path']   = './uploads/products/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 2048; // Maksimum 2MB
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image_product')) {
                    $image_product = $this->upload->data('file_name');
                } else {
                    echo json_encode(["status" => "error", "message" => $this->upload->display_errors()]);
                    return;
                }
            }

            $data = [
                'kd_product'    => $this->input->post('kd_product', TRUE),
                'nm_product'    => $this->input->post('nm_product', TRUE),
                'harga_beli'   => str_replace('.', '', $this->input->post('harga_beli')),
                'harga_jual'   => str_replace('.', '', $this->input->post('harga_jual')),
                'image_product' => $image_product,
                'is_active'     => $this->input->post('is_active', TRUE),
                'keterangan'    => $this->input->post('keterangan', TRUE),
                'fk_satuan'     => $this->input->post('fk_satuan', TRUE) // Tambahkan fk_satuan
            ];
            
            $insert = $this->Product_model->insert_product($data);
            if ($insert) {
                echo json_encode(["status" => "success", "message" => "Produk berhasil ditambahkan!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Gagal menyimpan produk!"]);
            }
        }
    }

    // Update produk
    public function update() {
        header('Content-Type: application/json');

        // Tangkap data POST
        $kd_product   = $this->input->post('kd_product', TRUE);
        $nm_product   = $this->input->post('nm_product', TRUE);
        $harga_beli   = $this->input->post('harga_beli', TRUE);
        $harga_jual   = $this->input->post('harga_jual', TRUE);
        $is_active    = $this->input->post('is_active', TRUE);
        $keterangan   = $this->input->post('keterangan', TRUE); // Ambil keterangan


        if (empty($kd_product) || empty($nm_product) || empty($harga_beli) || empty($harga_jual) || !isset($is_active)) {
            echo json_encode(["status" => "error", "message" => "Data tidak boleh kosong"]);
            return;
        }

        // Upload gambar jika ada perubahan
        $image_product = $this->input->post('old_image_product');
        if (!empty($_FILES['image_product']['name'])) {
            $config['upload_path']   = './uploads/products/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048; // Maksimum 2MB
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image_product')) {
                // Hapus gambar lama
                if ($image_product && file_exists('./uploads/products/' . $image_product)) {
                    unlink('./uploads/products/' . $image_product);
                }
                $image_product = $this->upload->data('file_name');
            } else {
                echo json_encode(["status" => "error", "message" => $this->upload->display_errors()]);
                return;
            }
        }

        // Data yang akan diupdate
        $data = [
            'nm_product'   => $this->input->post('nm_product'),
            'harga_beli'   => str_replace('.', '', $this->input->post('harga_beli')),
            'harga_jual'   => str_replace('.', '', $this->input->post('harga_jual')),
            'fk_satuan'    => $this->input->post('fk_satuan'),
            'keterangan'   => $this->input->post('keterangan'),
            'image_product' => $image_product,
            'is_active'    => $this->input->post('is_active')
        ];
        // Panggil model untuk update
        $update = $this->Product_model->update_product($kd_product, $data);
        if (empty($kd_product)) {
            echo json_encode(["status" => "error", "message" => "Kode produk tidak valid"]);
            return;
        }
        
        if ($update) {
            echo json_encode(["status" => "success", "message" => "Produk berhasil diperbarui"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal update produk"]);
        }
    }

    // Delete product
public function delete() {
    $id_product = $this->input->post('id_product', TRUE); // Ambil id_product dari POST request

    if (!$id_product) {
        echo json_encode(["status" => "error", "message" => "ID Product tidak ditemukan"]);
        return;
    }

    // Load model untuk produk
    $this->load->model('Product_model');
    
    // Panggil fungsi delete_product dari model Product_model
    $delete = $this->Product_model->delete_product($id_product);

    if ($delete) {
        echo json_encode(["status" => "success", "message" => "Produk berhasil dihapus"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menghapus produk"]);
    }
}


    // Search produk (pencarian dengan keterangan)
    public function search()
    {
        $keyword = $this->input->post('keyword');
        $this->load->model('Product_model');

        $products = $this->Product_model->search_product($keyword);

        if (!empty($products)) {
            foreach ($products as $product) {
                echo "<tr>
                        <td>{$product->kd_product}</td>
                        <td>{$product->nm_product}</td>
                        <td>Rp ".number_format($product->harga_beli, 0, ',', '.')."</td>
                        <td>Rp ".number_format($product->harga_jual, 0, ',', '.')."</td>
                        <td>{$product->keterangan}</td>
                        <td><img src='" . base_url('uploads/products/' . $product->image_product) . "' width='50'></td>
                        <td>" . ($product->is_active ? 'Aktif' : 'Tidak Aktif') . "</td>
                        <td>
                            <button class='btn btn-primary btn-sm editProduct' 
                                data-id='{$product->kd_product}' 
                                data-nama='{$product->nm_product}' 
                                data-beli='{$product->harga_beli}' 
                                data-jual='{$product->harga_jual}' 
                                data-keterangan='{$product->keterangan}'
                                data-image='{$product->image_product}'
                                data-active='{$product->is_active}'>
                                Edit
                            </button>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center text-muted'>Data Tidak Ditemukan</td></tr>";
        }
    }
}
