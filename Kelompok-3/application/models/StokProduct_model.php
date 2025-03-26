<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StokProduct_model extends CI_Model {

    public function update_stok_product($fk_product, $harga, $qty, $tipe = 'in') {
        // Ambil bulan dan tahun saat ini
        $bulan = date('m');
        $tahun = date('Y');

        // Cek apakah data stok sudah ada untuk bulan dan tahun ini
        $this->db->where('fk_product', $fk_product);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get('tblstok_product');

        if ($query->num_rows() > 0) {
            // Jika data stok sudah ada, lakukan update
            $stok = $query->row();

            if ($tipe == 'in') {
                $new_qty_in = $stok->qty_in + $qty;
                $new_on_hand = $stok->on_hand + $qty;
            } else {
                $new_qty_out = $stok->qty_out + $qty;
                $new_on_hand = $stok->on_hand - $qty;
            }

            $this->db->where('fk_product', $fk_product);
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $this->db->update('tblstok_product', [
                'qty_in'  => isset($new_qty_in) ? $new_qty_in : $stok->qty_in,
                'qty_out' => isset($new_qty_out) ? $new_qty_out : $stok->qty_out,
                'on_hand' => $new_on_hand,
                'hpp'     => $harga
            ]);
        } else {
            // Jika belum ada data stok, lakukan insert baru
            $this->db->insert('tblstok_product', [
                'fk_product' => $fk_product,
                'bulan'      => $bulan,
                'tahun'      => $tahun,
                'on_hand'    => $qty,
                'hpp'        => $harga,
                'qty_in'     => $tipe == 'in' ? $qty : 0,
                'qty_out'    => $tipe == 'out' ? $qty : 0
            ]);
        }
    }
}
