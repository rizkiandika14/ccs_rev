<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function cetak_barang()
    {
        $this->load->model('Barang_model', 'barang_model');
        $data['nama_brg'] = $this->db->get('barang')->result_array();
        $data['barang'] = $this->barang_model->getBarang();

        $this->load->view('cetak/laporan_barang', $data);
    }

    public function cetak_hari($waktu, $divisi, $minggu)
    {
        $this->load->model('Dpengajuan_model', 'dpengajuan_model');
        $data['waktu'] = $this->dpengajuan_model->getPengajuanDetail($waktu, $divisi, $minggu);
        $data['dpengajuan'] = $this->dpengajuan_model->getLaporanTemp($waktu, $divisi, $minggu);
        $data['user_id'] = $divisi;
        $data['minggu'] = $minggu;
        $data['tanggal'] = $waktu;

        $this->load->view('cetak/laporan_hari', $data);
    }

    public function cetak_barang_ruangan($kode_ruangan)
    {
        $this->load->model('Upbmaster_model', 'upbmaster_model');
        $data['kode_ruang'] = $this->upbmaster_model->ambil_kode_ruangan_isi($kode_ruangan);
        $data['kode_ruangan'] = $kode_ruangan;
        $this->load->view('cetak/laporan_barang_ruangan', $data);
    }

    public function cetak_pengajuan($waktu, $divisi, $minggu)
    {
        $this->load->model('Dpengajuan_model', 'dpengajuan_model');
        $data['waktu'] = $this->dpengajuan_model->getPengajuanDetail($waktu, $divisi, $minggu);
        $data['dpengajuan'] = $this->dpengajuan_model->getPengajuanTemp($waktu, $divisi, $minggu);
        $data['user_id'] = $divisi;
        $data['minggu']  = $minggu;
        $data['tanggal'] = $waktu;

        $this->load->view('cetak/laporan_pengajuan', $data);
    }

    public function cetak_pengajuan_upb($waktu, $divisi, $minggu)
    {
        $this->load->model('Upb_model', 'upb_model');
        $data['waktu'] = $this->upb_model->getPengajuanDetail($waktu, $divisi, $minggu);
        $data['dpengajuan'] = $this->upb_model->getPengajuanTemp($waktu, $divisi, $minggu);
        $data['user_id'] = $divisi;
        $data['minggu']  = $minggu;
        $data['tanggal'] = $waktu;

        $this->load->view('cetak/laporan_pengajuan_upb', $data);
    }

    public function cetak_purchase_requisition($waktu, $divisi, $minggu)
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');
        $surat = [
            'kode_surat' => $this->input->post('no_surat'),
            'tanggal_surat' => $now
        ];
        $this->db->insert('surat',$surat);
        $this->load->model('Upb_model', 'upb_model');
        $data['waktu'] = $this->upb_model->getPengajuanPrDetail($waktu, $divisi, $minggu);
        $data['dpengajuanpr'] = $this->upb_model->getPengajuanTempPr($waktu, $divisi, $minggu);
        $data['user_id'] = $divisi;
        $data['minggu'] = $minggu;
        $data['tanggal'] = $waktu;



        $this->load->view('cetak/laporan_purchase_requisition', $data);
    }

    public function cetak_purchase_order($id_vendor)
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');
        $surat = [
            'kode_surat' => $this->input->post('no_surat'),
            'tanggal_surat' => $now
        ];
        $this->db->insert('surat_po',$surat);
        $this->load->model('Upb_model', 'upb_model');
        $data['waktu'] = $this->upb_model->getPengajuanPoDetail($id_vendor);
        $data['dpengajuanpr'] = $this->upb_model->getPengajuanTempPo($id_vendor);

        $data['id_vendor'] = $id_vendor;



        $this->load->view('cetak/laporan_purchase_order', $data);
    }

    // public function cetak_pengajuan_upb($waktu, $divisi, $minggu)
    // {
    //     $this->load->model('Dpengajuan_model', 'dpengajuan_model');
    //     $data['waktu'] = $this->dpengajuan_model->getPengajuanDetail($waktu, $divisi, $minggu);
    //     $data['dpengajuan'] = $this->dpengajuan_model->getPengajuanTemp($waktu, $divisi, $minggu);
    //     $data['divisi'] = $divisi;
    //     $data['minggu'] = $minggu;
    //     $data['tanggal'] = $waktu;

    //     $this->load->view('cetak/laporan_pengajuan_upb', $data);
    // }

    //berita acara
    public function cetak_berita_acara($waktu, $divisi, $minggu)
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');
        $surat = [
            'kode_surat' => $this->input->post('no_surat'),
            'tanggal_surat' => $now
        ];
        $this->db->insert('surat_ba',$surat);
        $this->load->model('Upb_model', 'upb_model');
        $data['waktu'] = $this->upb_model->getBeritaAcaraDetail($waktu, $divisi, $minggu);
        $data['dpengajuanpr'] = $this->upb_model->getBeritaAcaraTemp($waktu, $divisi, $minggu);
        $data['user_id'] = $divisi;
        $data['minggu'] = $minggu;
        $data['tanggal'] = $waktu;

        $this->load->view('cetak/laporan_berita_acara', $data);
    }
}