<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Outlet_model'); // Load model Outlet
        $this->load->library('form_validation'); // Load library form_validation
        $this->load->helper('url'); // Load URL helper untuk redirect
    }

    // Menampilkan daftar outlet
    public function index() {
        $this->load->view('templates/header');

        $data['outlets'] = $this->Outlet_model->get_all_outlets();
        $this->load->view('admin/outlet', $data);

        $this->load->view('templates/footer');
    }

    // Simpan outlet baru
    public function simpan() {
        $this->form_validation->set_rules('id_outlet', 'Kode Outlet', 'required|is_unique[tbloutlet.id_outlet]|regex_match[/^\S+$/]',
            ['is_unique' => 'Kode Outlet sudah digunakan!', 'regex_match' => 'Kode Outlet tidak boleh mengandung spasi!']
        );
        $this->form_validation->set_rules('nm_outlet', 'Nama Outlet', 'required|min_length[3]');
        $this->form_validation->set_rules('alamat_outlet', 'Alamat Outlet', 'required|min_length[5]');
        $this->form_validation->set_rules('no_telp_outlet', 'No. Telepon', 'required|numeric|min_length[10]|max_length[15]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                "status" => "error",
                "message" => validation_errors()
            ]);
        } else {
            $data = [
                'id_outlet' => $this->input->post('id_outlet', TRUE),
                'nm_outlet' => $this->input->post('nm_outlet', TRUE),
                'alamat_outlet' => $this->input->post('alamat_outlet', TRUE),
                'no_telp_outlet' => $this->input->post('no_telp_outlet', TRUE)
            ];
            
            $insert = $this->Outlet_model->insert_outlet($data);
            if ($insert) {
                echo json_encode(["status" => "success", "message" => "Data outlet berhasil ditambahkan!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Gagal menyimpan data outlet!"]);
            }
        }
    }

    // Update outlet
    public function update() {
        header('Content-Type: application/json');

        // Tangkap data POST
        $id_outlet = $this->input->post('id_outlet', TRUE);
        $nm_outlet = $this->input->post('nm_outlet', TRUE);
        $alamat_outlet = $this->input->post('alamat_outlet', TRUE);
        $no_telp_outlet = $this->input->post('no_telp_outlet', TRUE);

        // Validasi: Pastikan semua data tidak kosong
        if (empty($id_outlet) || empty($nm_outlet) || empty($alamat_outlet) || empty($no_telp_outlet)) {
            echo json_encode(["status" => "error", "message" => "Data tidak boleh kosong"]);
            return;
        }

        // Data yang akan diupdate
        $data = [
            'nm_outlet' => $nm_outlet,
            'alamat_outlet' => $alamat_outlet,
            'no_telp_outlet' => $no_telp_outlet
        ];

        // Panggil model untuk update
        $update = $this->Outlet_model->update_outlet($id_outlet, $data);

        if ($update) {
            echo json_encode(["status" => "success", "message" => "Outlet berhasil diperbarui"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal update data"]);
        }
    }

    // Delete outlet
    public function delete() {
        $id_outlet = $this->input->post('id_outlet', TRUE);

        if (!$id_outlet) {
            echo json_encode(["status" => "error", "message" => "ID Outlet tidak ditemukan"]);
            return;
        }

        $this->load->model('Outlet_model');
        $delete = $this->Outlet_model->delete_outlet($id_outlet);

        if ($delete) {
            echo json_encode(["status" => "success", "message" => "Outlet berhasil dihapus"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menghapus outlet"]);
        }
    }

}
