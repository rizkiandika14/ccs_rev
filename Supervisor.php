<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['data_bpr'] = $this->superadmin_model->getKlien();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    #CATEGORY
    public function category()
    {
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $data['category'] = $this->category_model->getCategory();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/category', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_category()
    {
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $this->form_validation->set_rules('nama_kategori', 'Kategory', 'required');
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori')
        ];
        $this->db->insert('category', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('superadmin/category');
    }

    public function hapus_kategori($id)
    {
        $this->category_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/category'));
    }

    public function edit_kategori()
    {
        $id            = $this->input->post('id');
        $nama_kategori = $this->input->post('nama_kategori');
        $ArrUpdate     = array(
            'nama_kategori' => $nama_kategori
        );
        $this->category_model->updateKategori($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('superadmin/category'));
    }

    // DATA CLIENT
    public function client()
    {
        $this->load->model('Client_model', 'client_model');
        $data['no_urut'] = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        
        $data['klien'] = $this->client_model->getClient();
        $data['user'] = $this->client_model->getUserClient();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/client', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_client()
    {
        $data['no_klien']    = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_klien', 'No Klien', 'required|is_unique[klien.no_klien]');
        $this->form_validation->set_rules('nama_klien', 'Nama Klient', 'required');
        $this->form_validation->set_rules('nama_user_klien', 'Nama User', 'required');
   
        if ($this->form_validation->run() == FALSE)
        {
            // belum menampilkan pesan error
            redirect('superadmin/client');
        }
        else
        {

            $data = [
                'no_klien'    => $this->input->post('no_klien'),
                'nama_klien' => $this->input->post('nama_klien'),
                'id_user_klien' => $this->input->post('nama_user_klien')
            ];
            $this->db->insert('klien', $data);
            $this->session->set_flashdata('pesan', 'Successfully Added!');
            redirect('superadmin/client');
        }


    }

    public function hapus_klien($id)
    {
        $this->client_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/client'));
    }

    public function edit_klien()
    {
        $id         = $this->input->post('id');
        $no_klien    = $this->input->post('no_klien');
        $nama_klien = $this->input->post('nama_klien');
        $ArrUpdate  = array(
            'no_klien'    => $no_klien,
            'nama_klien' => $nama_klien
        );
        $this->client_model->updateKlien($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('superadmin/client'));
    }

     # DATA USER
     public function user(){

        $this->load->model('Usermaster_model', 'usermaster_model');
        $data['divisi']     = $this->db->get('user')->result_array();
        $data['nama']       = $this->db->get('user')->result_array();
        $data['username']   = $this->db->get('user')->result_array();
        $data['active']     = $this->db->get('user')->result_array();
        $this->load->model('Client_model', 'client_model');
        $data['nama_klien'] = $this->db->get('klien')->result_array();

        $data['user'] = $this->usermaster_model->getUser();
        $data['klien'] = $this->client_model->getClient();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/user', $data);
        $this->load->view('templates/footer');

    }

    public function tambah_user()
    {
        $data['divisi']   = $this->db->get('user')->result_array();
        $data['nama_user']     = $this->db->get('user')->result_array();
        $data['username'] = $this->db->get('user')->result_array();
        $data['password'] = $this->db->get('user')->result_array();
        $data['role']     = $this->db->get('user')->result_array();
        $data['tgl_register']   = $this->db->get('user')->result_array();

        $this->form_validation->set_rules('no_urut', 'No Urut', 'required');
        $this->form_validation->set_rules('nama_klien', 'Kategory', 'required');

        // $password = md5($this->input->post('password'));
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data = [
            'divisi'   => $this->input->post('divisi'),
            'nama_user'     => $this->input->post('nama_user'),
            'username' => $this->input->post('username'),
            'password' => $password,
            'role'     => $this->input->post('role'),
            'tgl_register'   => $this->input->post('tgl_register')
        ];
        $this->db->insert('user', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('superadmin/user');
    }

    public function edit_user()
    {
        $id       = $this->input->post('id_user');
        $divisi   = $this->input->post('divisi');
        $nama     = $this->input->post('nama_user');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role     = $this->input->post('role');
        $active   = $this->input->post('active');
        $ArrUpdate = array(
            'divisi'   => $divisi,
            'nama_user'     => $nama,
            'username' => $username,
            'password' => $password,
            'role'     => $role,
            'active'   => $active,

        );
        $this->usermaster_model->updateUser($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('superadmin/user'));
    }

    public function hapus_user($id)
    {
        $this->usermaster_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/user'));
    }

    // LIST TICKET
    public function AllTicket()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/allticket', $data);
        $this->load->view('templates/footer');
    }

    public function added()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->superadmin_model->getKlienPelaporanAdd();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanOP();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanClose();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }
    
    public function finish()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }

    // EDIT PELAPORAN
    public function edit_pelaporan()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $perihal      = $this->input->post('perihal');
        $status_ccs   = $this->input->post('status_ccs');
        $kategori     = $this->input->post('kategori');
        $priority     = $this->input->post('priority');
        $maxday       = $this->input->post('maxday');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'perihal'    => $perihal,
            'status_ccs' => $status_ccs,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday,
            'tags'       => $tags

        );
        $this->pelaporan_model->updateCP($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('superadmin/added'));
    }

     //DISTRIBUSI TO HELPDESK
    public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namahd');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

         // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->insert('forward', $data);
        $this->supervisor_model->updateForward($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('superadmin/added'));
     }

    // FUNGSI EDIT HELPDESK
    public function fungsi_edit()
    {
    // Load the form validation library
    $this->load->library('form_validation');

    // Set validation rules
    $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
    $this->form_validation->set_rules('namahd', 'Helpdesk', 'required');

    // Check if the form passes validation
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', 'Form validation failed. Please fill in all required fields.');
        redirect(base_url('supervisor/onprogress'));
    } else {
        // Retrieve POST data
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namahd');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

        // Fetch the user name based on the user ID
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();

        // Check if user exists
        if ($query->num_rows() > 0) {
            $user = $query->row();
            $nama_user = $user->nama_user;

            // Update the forward table
            $this->db->where('pelaporan_id', $id_pelaporan);
            $this->db->update('forward', $data);

            // Update the Helpdesk in the supervisor_model
            $this->supervisor_model->updateHD($id_pelaporan, $nama_user);

            // Set success message
            $this->session->set_flashdata('pesan', 'Helpdesk has been updated!');
        } else {
            // Set error message if user not found
            $this->session->set_flashdata('error', 'User not found.');
        }

        // Redirect to the onprogress page
        redirect(base_url('superadmin/onprogress'));
    }
}


// FUNGSI REJECT
public function fungsi_reject()
{

        // Load the form validation library
    $this->load->library('form_validation');

    // Set validation rules
    $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
    $this->form_validation->set_rules('namahd', 'Helpdesk', 'required');

    // Check if the form passes validation
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', 'Form validation failed. Please fill in all required fields.');
        redirect(base_url('supervisor/onprogress'));
    } else {
        // Retrieve POST data
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namahd');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

        // Fetch the user name based on the user ID
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();

        // Check if user exists
        if ($query->num_rows() > 0) {
            $user = $query->row();
            $nama_user = $user->nama_user;

            // Update the forward table
            $this->db->where('pelaporan_id', $id_pelaporan);
            $this->db->update('forward', $data);

            // Update the Helpdesk in the supervisor_model
            $this->supervisor_model->updateReject($id_pelaporan, $nama_user);

            // Set success message
            $this->session->set_flashdata('pesan', 'Helpdesk has been updated!');
        } else {
            // Set error message if user not found
            $this->session->set_flashdata('error', 'User not found.');
        }

        // Redirect to the onprogress page
        redirect(base_url('superadmin/close'));
    }

}

  //Approve supervisor
    public function approve()
    {
        // date_default_timezone_set('Asia/Jakarta');
        # add your city to set local time zone
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');


        $id         = $this->input->post('id_pelaporan');
        $no_tiket   = $this->input->post('no_tiket');
        //$waktu_pelaporan = $this->input->post('waktu_pelaporan');
        $nama       = $this->input->post('nama');
        $perihal    = $this->input->post('perihal');
        $status_ccs ='FINISH';
        $waktu      = date('Y-m-d');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday');
        $kategori   = $this->input->post('kategori');
        $ArrUpdate  = array(

            'no_tiket'       => $no_tiket,
          //    'waktu_pelaporan' => $waktu_pelaporan,
            'nama'           => $nama,
            'perihal'        => $perihal,
            'status_ccs'     => $status_ccs,
            'waktu_approve'  => $waktu,
            'priority'       => $priority,
            'maxday'         => $maxday,
            'kategori'       => $kategori

        );
        $this->pelaporan_model->approveSPV($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Approve!');
        redirect('superadmin/finish');

    }

    
    //   FILTER LAPORAN
    public function rekapPelaporan1()
    {
            $this->load->model('Client_model', 'client_model');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getAll();
            $data['klien'] = $this->client_model->getClient();
    
            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
    }

    public function rekapPelaporan(){
         // Load necessary models
    $this->load->model('Pelaporan_model', 'pelaporan_model');
    $this->load->model('Client_model', 'client_model');

	// var data for view 
	$data['tanggal_awal'] = '';
	$data['tanggal_akhir'] = '';
	$data['status_ccs'] = '';
	$data['nama_klien'] = '';
	$data['tags'] = '';

    // Get all data from the models
    $data['klien'] = $this->client_model->getClient();
    $data['pencarian_data'] = $this->pelaporan_model->getAllData(); // A method that returns all data

    // Load views with data
    $this->load->view('templates/header');
    $this->load->view('templates/superadmin_sidebar');
    $this->load->view('superadmin/rekap_pelaporan', $data);
    $this->load->view('templates/footer');
    }

    

    // public function datepelaporan()
    // {
    //     // Load the necessary models
    //     $this->load->model('Pelaporan_model', 'pelaporan_model');
    //     $this->load->model('Client_model', 'client_model');

    //     // Retrieve and sanitize input data
    //     $tgla = $this->input->post('tgla', TRUE);
    //     $tglb = $this->input->post('tglb', TRUE);
    //     $status_ccs = $this->input->post('status_ccs', TRUE);
    //     $nama_klien = $this->input->post('nama_klien', TRUE);
    //     $tags = $this->input->post('tags', TRUE);

    //     // Fetch client data
    //     $data['klien'] = $this->client_model->getClient();

    //     // Fetch reporting data
    //     try {
    //         $data['pencarian_data'] = $this->pelaporan_model->getDate($tgla, $tglb, $status_ccs, $nama_klien, $tags);
    //     } catch (Exception $e) {
    //         // Handle potential errors
    //         $data['pencarian_data'] = [];
    //         $data['error_message'] = $e->getMessage();
    //     }

    //     // Load the views with the retrieved data
    //     $this->load->view('templates/header');
    //     $this->load->view('templates/superadmin_sidebar');
    //     $this->load->view('superadmin/rekap_pelaporan', $data);
    //     $this->load->view('templates/footer');
    // }

//     public function datepelaporan()
// {
//     // Load necessary libraries and models
//     $this->load->library('form_validation');
//     $this->load->model('Pelaporan_model', 'pelaporan_model');
//     $this->load->model('Client_model', 'client_model');

//     // Set form validation rules
//     $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'required');
//     $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'required');
//     $this->form_validation->set_rules('status_ccs', 'Status CCS', 'required');
//     $this->form_validation->set_rules('nama_klien', 'Client Name', 'required');
//     $this->form_validation->set_rules('tags', 'Tags', 'required');

//     if ($this->form_validation->run() == FALSE) {
//         // Validation failed, prepare data for the view with error messages
//         $data['errors'] = validation_errors();
//         $data['klien'] = $this->client_model->getClient();
//         $data['pencarian_data'] = [];

//         $this->load->view('templates/header');
//         $this->load->view('templates/superadmin_sidebar');
//         $this->load->view('superadmin/rekap_pelaporan', $data);
//         $this->load->view('templates/footer');
//     } else {
//         // Validation passed, retrieve POST data
//         $tanggal_awal = $this->input->post('tanggal_awal');
//         $tanggal_akhir = $this->input->post('tanggal_akhir');
//         $status_ccs = $this->input->post('status_ccs');
//         $nama_klien = $this->input->post('nama_klien');
//         $tags = $this->input->post('tags');

//         // Get data from the models
//         $data['klien'] = $this->client_model->getClient();
//         $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);

//         // Load views with data
//         $this->load->view('templates/header');
//         $this->load->view('templates/superadmin_sidebar');
//         $this->load->view('superadmin/rekap_pelaporan', $data);
//         $this->load->view('templates/footer');
//     }
// }

public function datepelaporan()
{
    // Load necessary libraries and models
    $this->load->library('form_validation');
    $this->load->model('Pelaporan_model', 'pelaporan_model');
    $this->load->model('Client_model', 'client_model');

    // Set form validation rules (allow empty)
    $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'trim');
    $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'trim');
    $this->form_validation->set_rules('status_ccs', 'Status CCS', 'trim');
    $this->form_validation->set_rules('nama_klien', 'Client Name', 'trim');
    $this->form_validation->set_rules('tags', 'Tags', 'trim');

    if ($this->form_validation->run() == FALSE) {
        // Validation failed, prepare data for the view with error messages
        $data['errors'] = validation_errors();
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = [];

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_pelaporan', $data);
        $this->load->view('templates/footer');
    } else {
        // Validation passed, retrieve POST data
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $status_ccs = $this->input->post('status_ccs');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');

		// var data for view 
		$data['tanggal_awal'] = $tanggal_awal;
		$data['tanggal_akhir'] = $tanggal_akhir;
		$data['status_ccs'] = $status_ccs;
		$data['nama_klien'] = $nama_klien;
		$data['tags'] = $tags;

        // Get data from the models
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_pelaporan', $data);
        $this->load->view('templates/footer');
    }
}



    // REKAP KATEGORI
    public function rekapKategori()
    {
        $this->load->model('Category_model', 'category_model');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getAllCategory();
        $data['category'] = $this->category_model->getCategory();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_kategori', $data);
        $this->load->view('templates/footer');

        
    }

    public function dateKategori()
    {
        // $tgla = $this->input->post('tgla');
        // $tglb = $this->input->post('tglb');
        // // $nama_kategori = $this->input->post('nama_kategori');
        // $this->load->model('Pelaporan_model', 'pelaporan_model');
        // $data['category'] = $this->category_model->getCategory();
        // $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb);

        // $this->load->view('templates/header');
        // $this->load->view('templates/superadmin_sidebar');
        // $this->load->view('superadmin/rekap_kategori', $data);
        // $this->load->view('templates/footer');

        //Load necessary libraries and models
    $this->load->library('form_validation');
    $this->load->model('Pelaporan_model', 'pelaporan_model');
    $this->load->model('Category_model', 'category_model');

    // Set form validation rules
    $this->form_validation->set_rules('tgla', 'Start Date', 'required');
    $this->form_validation->set_rules('tglb', 'End Date', 'required');
    $this->form_validation->set_rules('kategori', 'Category Name', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Validation failed, prepare data for the view with error messages
        $data['errors'] = validation_errors();
        $data['category'] = $this->category_model->getCategory();
        $data['pencarian_data'] = [];

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_kategori', $data);
        $this->load->view('templates/footer');
    } else {
        // Validation passed, retrieve POST data
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $kategori = $this->input->post('kategori');

        // Get data from the models
        $data['category'] = $this->category_model->getCategory();
        $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb,  $kategori);

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_kategori', $data);
        $this->load->view('templates/footer');
    }
    }

    // REKAP HANDLE BY HELPDESK
    public function rekapHelpdesk()
    {
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getHelpdesk();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_helpdesk', $data);
        $this->load->view('templates/footer');
    }

    public function datehelpdesk()
    {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getDateHelpdesk($tgla, $tglb);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_helpdesk', $data);
        $this->load->view('templates/footer');
    }

    

    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['datapelaporan'] = $this->superadmin_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->get_latest_comments($id);
        $data['datareply']     = $this->supervisor_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        //jika ada gambar
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/comment/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {

                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                $referred_from = $this->session->userdata('referred_from');
                redirect($referred_from, 'refresh');
            }
        }

        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('user_id','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('user_id');
        $body = $this->input->post('body');
        $create_at = date('Y-m-d H:i:s');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body,
            'file' => $photo,
            'created_at' => $create_at
        ];
        $data = preg_replace("/^<p.*?>/", "",$data);
        $data = preg_replace("|</p>$|", "",$data);
        $this->db->insert('comment', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('superadmin/detail_pelaporan/'.$id_pelaporan));
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/reply/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {

                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                $referred_from = $this->session->userdata('referred_from');
                redirect($referred_from, 'refresh');
            }
        }
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('user_id','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('user_id');
        $body = $this->input->post('body');
        $create_at  = date('Y-m-d H:i:s');
        $comment_id = $this->input->post('id_comment');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body,
            'file' => $photo,
            'created_at' => $create_at,
            'comment_id' => $comment_id
        ];
        $data = preg_replace("/^<p.*?>/", "",$data);
        $data = preg_replace("|</p>$|", "",$data);
        $this->db->insert('reply', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('superadmin/detail_pelaporan/'.$id_pelaporan));
    }

}
