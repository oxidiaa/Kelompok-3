<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Karyawan_model');
        $this->load->library('form_validation'); // Load library form_validation
        $this->load->helper('url'); // Load URL helper untuk redirect
    }

    public function index() {
        $this->load->view('templates/header');

       $data['karyawan_list'] = $this->Karyawan_model->get_all();
       $data['jabatan_list'] = $this->Karyawan_model->get_jabatan();
       $this->load->view('admin/karyawan', $data);

       $this->load->view('templates/footer');
    }

    public function save() {
        $this->form_validation->set_rules('id_karyawan', 'ID Karyawan', 'required');
        $this->form_validation->set_rules('nm_karyawan', 'Nama Karyawan', 'required');
        $this->form_validation->set_rules('fk_jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $id_karyawan = $this->input->post('id_karyawan');
        $edit_mode = $this->input->post('edit_mode');

        $data = [
            'id_karyawan' => $this->input->post('id_karyawan'),
            'nm_karyawan' => $this->input->post('nm_karyawan'),
            'fk_jabatan' => $this->input->post('fk_jabatan'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'tgl_keluar' => $this->input->post('tgl_keluar') ?: null
        ];

        if ($edit_mode == "1") {
            $this->Karyawan_model->update($id_karyawan, $data);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            // Cek apakah ID Karyawan sudah ada
            if ($this->Karyawan_model->cek_id_karyawan($id_karyawan)) {
                echo json_encode(['status' => 'error', 'message' => 'ID Karyawan sudah digunakan!']);
                return;
            }

            $this->Karyawan_model->insert($data);
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan!']);
        }
    }

    // Fungsi untuk menghapus data karyawan
    public function delete() {
        // Mengambil ID karyawan yang dikirimkan melalui POST
        $id_karyawan = $this->input->post('id_karyawan');

        // Cek apakah id_karyawan tersedia
        if (empty($id_karyawan)) {
            echo json_encode(['status' => 'error', 'message' => 'ID Karyawan tidak ditemukan!']);
            return;
        }

        // Panggil model untuk menghapus data karyawan
        $delete_status = $this->Karyawan_model->delete($id_karyawan);

        if ($delete_status) {
            echo json_encode(['status' => 'success', 'message' => 'Data karyawan berhasil dihapus!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data karyawan!']);
        }
    }
}
