<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supervisor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user_model');
    }

    public function index()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['data_bpr'] = $this->supervisor_model->getKlien();
        
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/dashboard', $data);
        $this->load->view('templates/footer');
    }
    #CATEGORY
    public function category()
    {
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();


        $data['category'] = $this->category_model->getCategory();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/category', $data);
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
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Category added!</div>');
        redirect('supervisor/category');
    }

    public function hapus_kategori($id)
    {
        $this->category_model->hapus($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Category Deleted!</div>');
        Redirect(Base_url('supervisor/category'));
    }

    public function edit_kategori()
    {
        $id            = $this->input->post('id');
        $nama_kategori = $this->input->post('nama_kategori');
        $ArrUpdate     = array(
            'nama_kategori' => $nama_kategori
        );
        $this->category_model->updateKategori($id, $ArrUpdate);
        // $this->session->set_flashdata('pesan', 'Success Edited!');
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Category Edited!</div>');
        Redirect(base_url('supervisor/category'));
    }

    #CLIENT
    public function client()
    {
        $this->load->model('Client_model', 'client_model');
        $data['no_urut'] = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        
       


        $data['klien'] = $this->client_model->getClient();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/client', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_client()
    {
        $data['no_urut']    = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();

        $this->form_validation->set_rules('no_urut', 'No Urut', 'required');
        $this->form_validation->set_rules('nama_klien', 'Kategory', 'required');
        $data = [
            'no_urut'    => $this->input->post('no_urut'),
            'nama_klien' => $this->input->post('nama_klien')
        ];
        $this->db->insert('klien', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Client added!</div>');
        redirect('supervisor/client');
    }

    public function hapus_klien($id)
    {
        $this->client_model->hapus($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Client Deleted!</div>');
        Redirect(Base_url('supervisor/client'));
    }

    public function edit_klien()
    {
        $id         = $this->input->post('id');
        $no_urut    = $this->input->post('no_urut');
        $nama_klien = $this->input->post('nama_klien');
        $ArrUpdate  = array(
            'no_urut'    => $no_urut,
            'nama_klien' => $nama_klien
        );
        $this->client_model->updateKlien($id, $ArrUpdate);
        // $this->session->set_flashdata('pesan', 'Success Edited!');
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Category Edited!</div>');
        Redirect(base_url('supervisor/client'));
    }

    #USER
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
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/user', $data);
        $this->load->view('templates/footer');

    }

    public function tambah_user()
    {
        $data['divisi']   = $this->db->get('user')->result_array();
        $data['nama']     = $this->db->get('user')->result_array();
        $data['username'] = $this->db->get('user')->result_array();
        $data['password'] = $this->db->get('user')->result_array();
        $data['role']     = $this->db->get('user')->result_array();
        $data['active']   = $this->db->get('user')->result_array();


        $this->form_validation->set_rules('no_urut', 'No Urut', 'required');
        $this->form_validation->set_rules('nama_klien', 'Kategory', 'required');

        $password = md5($this->input->post('password'));
        $data = [
            'divisi'   => $this->input->post('divisi'),
            'nama'     => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'password' => $password,
            'role'     => $this->input->post('role'),
            'active'   => $this->input->post('active')
        ];
        $this->db->insert('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>User added!</div>');
        redirect('supervisor/user');
    }

    public function edit_user()
    {
        $id       = $this->input->post('id');
        $divisi   = $this->input->post('divisi');
        $nama     = $this->input->post('nama');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role     = $this->input->post('role');
        $active   = $this->input->post('active');
        $ArrUpdate = array(
            'divisi'   => $divisi,
            'nama'     => $nama,
            'username' => $username,
            'password' => $password,
            'role'     => $role,
            'active'   => $active,

        );
        $this->usermaster_model->updateUser($id, $ArrUpdate);
        // $this->session->set_flashdata('pesan', 'Success Edited!');
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>User Edited!</div>');
        Redirect(base_url('supervisor/user'));
    }

    public function hapus_user($id)
    {
        $this->usermaster_model->hapus($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>User Deleted!</div>');
        Redirect(Base_url('supervisor/user'));
    }

    #PELAPORAN
    public function pelaporan1()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['nama'] = $this->db->get('pelaporan')->result_array();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan',$data);
        $this->load->view('templates/footer');
    }

    public function pelaporan2(){
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporan();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function AllTicket()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/allticket', $data);
        $this->load->view('templates/footer');
    }

    public function added()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->klienpelaporan_model->getKlienPelaporanAdd();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanOP();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanClose();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }
    
    public function finish()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }
    // EDIT CCS
    public function updateccs($id)
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
        $this->load->model('Category_model', 'category_model');
        $data['category']      = $this->category_model->getCategory();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/edit_ccs', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_edit_ccs()
    {
        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getCategory();
      

    
        $id = $this->input->post('id');
        $no_tiket = $this->input->post('no_tiket');
        $perihal = $this->input->post('perihal');
        $status = $this->input->post('status');
        $status_ccs = $this->input->post('status_ccs');
        $priority = $this->input->post('priority');
        $kategori = $this->input->post('kategori');


        //jika ada gambar
        // $photo = $_FILES['file']['name'];

        // if ($photo) {
        //     $config['allowed_types'] = 'pdf|xlsx|docx|jpg|png';
        //     $config['max_size'] = '2048';
        //     $config['upload_path'] = './assets/files/';

        //     $this->load->library('upload', $config);
        //     $this->upload->initialize($config);

        //     if ($this->upload->do_upload('file')) {
        //         $old_image = $data['pelaporan']['file'];
        //         if ($old_image != '') {
        //             unlink(FCPATH . 'assets/files/' . $old_image);
        //         }
        //         $new_image = $this->upload->data('file_name');
        //         $this->db->set('file', $new_image);
        //     } else {
        //         $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
        //         redirect('supervisor/edit_ccs');
        //     }
        // }
        $this->db->set('no_tiket', $no_tiket);
        $this->db->set('perihal', $perihal);
        $this->db->set('status', $status);
        $this->db->set('status_ccs', $status_ccs);
        $this->db->set('priority', $priority);
        $this->db->set('kategori', $kategori);
        $this->db->where('id', $id);
        $this->db->update('pelaporan');

        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Data Edited!</div>');
        Redirect(base_url('supervisor/pelaporan'));
    }

    public function edit_pelaporan()
    {
        $id         = $this->input->post('id');
        $no_tiket   = $this->input->post('no_tiket');
        $perihal    = $this->input->post('perihal');
        $status     = $this->input->post('status');
        $status_ccs = $this->input->post('status_ccs');
        $kategori   = $this->input->post('kategori');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday');
      
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'perihal'    => $perihal,
            'status'     => $status,
            'status_ccs' => $status_ccs,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday

        );

        $this->pelaporan_model->updateCP($id, $ArrUpdate);
        // $this->session->set_flashdata('pesan', 'Success Edited!');
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Priority and Category Updated</div>');
        Redirect(base_url('supervisor/added'));
    }

    
    // public function edit_pelaporan()
    // {
    //     $id = $this->input->post('id');
    //     $ArrUpdate = array(
    //         'no_tiket' => $this->input->post('no_tiket'),
    //         'waktu_pelaporan' => $this->input->post('waktu_pelaporan'),
    //         'nama' => $this->input->post('nama'),
    //         'perihal' => $this->input->post('perihal'),
    //         'status' => $this->input->post('status'),
    //         'status_ccs' => $this->input->post('status_ccs'),
    //         'priority' => $this->input->post('priority'),
    //         'maxday' => $this->input->post('maxday'),
    //         'kategori' => $this->input->post('kategori')

  
    //     );
    //     $this->pelaporan_model->updateCP($id, $ArrUpdate);
    //      $this->session->set_flashdata('pesan', 'Success Edited!');
    //     $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Priority and Category Updated</div>');
    //     Redirect(base_url('supervisor/added'));
    // }

    
    //FORWARD TO HELPDESK
    public function forwardtoHD($id)
    {
        // date_default_timezone_set('Asia/Jakarta');
         # add your city to set local time zone


         $sql = "UPDATE pelaporan SET status_ccs='HANDLE', status='Forward To Helpdesk 1' WHERE id=$id";
         $this->db->query($sql);
         $this->session->set_flashdata('pesan', 'Forward Success!');
        //  $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">  Data Telah Disetujui<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        //  $referred_from = $this->session->userdata('referred_from');
        //  redirect($referred_from, 'refresh');

        redirect('supervisor/onprogress');
     }

     public function forwardtoHD2($id)
     {
         // date_default_timezone_set('Asia/Jakarta');
          # add your city to set local time zone
 
 
          $sql = "UPDATE pelaporan SET status_ccs='HANDLE', status='Forward To Helpdesk 2' WHERE id=$id";
          $this->db->query($sql);
          $this->session->set_flashdata('pesan', 'Forward Success!');

         redirect('supervisor/onprogress');
      }

      public function forwardtoHD3($id)
     {
         // date_default_timezone_set('Asia/Jakarta');
          # add your city to set local time zone
 
 
          $sql = "UPDATE pelaporan SET status_ccs='HANDLE', status='Forward To Helpdesk 3' WHERE id=$id";
          $this->db->query($sql);
          $this->session->set_flashdata('pesan', 'Forward Success!');
        
        redirect('supervisor/onprogress');
      }

      public function forwardtoHD4($id)
      {
          // date_default_timezone_set('Asia/Jakarta');
           # add your city to set local time zone
  
  
           $sql = "UPDATE pelaporan SET status_ccs='HANDLE', status='Forward To Helpdesk 4' WHERE id=$id";
           $this->db->query($sql);
           $this->session->set_flashdata('pesan', 'Forward Success!');

        redirect('supervisor/onprogress');
       }

    //   Approve supervisor
      public function approve()
      {
          // date_default_timezone_set('Asia/Jakarta');
           # add your city to set local time zone
           date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
           $now = date('Y-m-d');
  
  
           $id         = $this->input->post('id');
           $no_tiket   = $this->input->post('no_tiket');
        //    $waktu_pelaporan = $this->input->post('waktu_pelaporan');
           $nama       = $this->input->post('nama');
           $perihal    = $this->input->post('perihal');
           $status_ccs ='FINISH';
           $waktu      = date('Y-m-d');
           $ArrUpdate  = array(
   
               'no_tiket'       => $no_tiket,
            //    'waktu_pelaporan' => $waktu_pelaporan,
               'nama'           => $nama,
               'perihal'        => $perihal,
               'status_ccs'     => $status_ccs,
               'waktu_approve'  =>$waktu
   
           );
           $this->pelaporan_model->approveSPV($id, $ArrUpdate);
    
           redirect('supervisor/finish');

           
       }

    //    REJECT HELPDESK
       public function reject()
       {
           // date_default_timezone_set('Asia/Jakarta');
            # add your city to set local time zone
   
   
            $id              = $this->input->post('id');
            $no_tiket        = $this->input->post('no_tiket');
            $waktu_pelaporan = $this->input->post('waktu_pelaporan');
            $nama            = $this->input->post('nama');
            $perihal         = $this->input->post('perihal');
            $status          = 'Forward To Helpdesk 1';
            $status_ccs      ='HANDLE';
            $keterangan      = $this->input->post('keterangan');
            $ArrUpdate       = array(
    
                'no_tiket'        => $no_tiket,
                'waktu_pelaporan' => $waktu_pelaporan,
                'nama'            => $nama,
                'perihal'         => $perihal,
                'status'          => $status,
                'status_ccs'      => $status_ccs,
                'keterangan'      => $keterangan
    
            );
            $this->pelaporan_model->rejecthd1($id, $ArrUpdate);
            $this->session->set_flashdata('pesan', 'Successfully Approve!');
            
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
 
            
        }

        public function reject2()
        {
            // date_default_timezone_set('Asia/Jakarta');
             # add your city to set local time zone
    
             $id              = $this->input->post('id');
             $no_tiket        = $this->input->post('no_tiket');
             $waktu_pelaporan = $this->input->post('waktu_pelaporan');
             $nama            = $this->input->post('nama');
             $perihal         = $this->input->post('perihal');
             $status          = 'Forward To Helpdesk 2';
             $status_ccs      ='HANDLE';
             $keterangan      = $this->input->post('keterangan');
             $ArrUpdate       = array(
     
                 'no_tiket'        => $no_tiket,
                 'waktu_pelaporan' => $waktu_pelaporan,
                 'nama'            => $nama,
                 'perihal'         => $perihal,
                 'status'          => $status,
                 'status_ccs'      => $status_ccs,
                 'keterangan'      => $keterangan
     
             );
             $this->pelaporan_model->rejecthd2($id, $ArrUpdate);
             $this->session->set_flashdata('pesan', 'Successfully Approve!');
             $referred_from = $this->session->userdata('referred_from');

             redirect($referred_from, 'refresh');
  
             
         }

         public function reject3()
         {
             // date_default_timezone_set('Asia/Jakarta');
              # add your city to set local time zone
              $id              = $this->input->post('id');
              $no_tiket        = $this->input->post('no_tiket');
              $waktu_pelaporan = $this->input->post('waktu_pelaporan');
              $nama            = $this->input->post('nama');
              $perihal         = $this->input->post('perihal');
              $status          = 'Forward To Helpdesk 3';
              $status_ccs      ='HANDLE';
              $keterangan      = $this->input->post('keterangan');
              $ArrUpdate       = array(
      
                  'no_tiket'        => $no_tiket,
                  'waktu_pelaporan' => $waktu_pelaporan,
                  'nama'            => $nama,
                  'perihal'         => $perihal,
                  'status'          => $status,
                  'status_ccs'      => $status_ccs,
                  'keterangan'      => $keterangan
      
              );
              $this->pelaporan_model->rejecthd3($id, $ArrUpdate);
              $this->session->set_flashdata('pesan', 'Successfully Approve!');
              $referred_from = $this->session->userdata('referred_from');
              redirect($referred_from, 'refresh');
   
              
          }

          
         public function reject4()
         {
             // date_default_timezone_set('Asia/Jakarta');
              # add your city to set local time zone
              $id              = $this->input->post('id');
              $no_tiket        = $this->input->post('no_tiket');
              $waktu_pelaporan = $this->input->post('waktu_pelaporan');
              $nama            = $this->input->post('nama');
              $perihal         = $this->input->post('perihal');
              $status          = 'Forward To Helpdesk 4';
              $status_ccs      ='HANDLE';
              $keterangan      = $this->input->post('keterangan');
              $ArrUpdate       = array(
      
                  'no_tiket'        => $no_tiket,
                  'waktu_pelaporan' => $waktu_pelaporan,
                  'nama'            => $nama,
                  'perihal'         => $perihal,
                  'status'          => $status,
                  'status_ccs'      => $status_ccs,
                  'keterangan'      => $keterangan
      
              );
              $this->pelaporan_model->rejecthd4($id, $ArrUpdate);
              $this->session->set_flashdata('pesan', 'Successfully Approve!');
              $referred_from = $this->session->userdata('referred_from');
              redirect($referred_from, 'refresh');
   
              
          }

        //   laporan filter
        public function rekapPelaporan()
        {
            $this->load->model('Client_model', 'client_model');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getAll();
            $data['klien'] = $this->client_model->getClient();
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }

        public function datepelaporan()
        {
            $tgla       = $this->input->post('tgla');
            $tglb       = $this->input->post('tglb');
            $status_ccs = $this->input->post('status_ccs');
            $nama_klien = $this->input->post('nama_klien');

            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tgla, $tglb, $status_ccs, $nama_klien);
    
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }

        //LAPORAN FILTER KATEGORI

        public function rekapKategori()
        {
            $this->load->model('Category_model', 'category_model');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getAllCategory();
            $data['category'] = $this->category_model->getCategory();
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_kategori', $data);
            $this->load->view('templates/footer');
        }

        public function dateKategori()
        {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            // $nama_kategori = $this->input->post('nama_kategori');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['category'] = $this->category_model->getCategory();
            $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb);
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_kategori', $data);
            $this->load->view('templates/footer');
        }

        // public function dateKategori()
        // {
          
        //     $tgla = $this->input->post('tgla');
        //     $tglb = $this->input->post('tglb');
        //     $nama_kategori = $this->input->post('nama_kategori');
        //     $this->load->model('Pelaporan_model', 'pelaporan_model');
    
        //     $data['category'] = $this->category_model->getCategory();
        //     $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb, $nama_kategori);
    
        //     $this->load->view('templates/header');
        //     $this->load->view('templates/supervisor_sidebar');
        //     $this->load->view('supervisor/rekap_kategori', $data);
        //     $this->load->view('templates/footer');
        // }


        // REKAP HANDLE BY HELPDESK
        
        public function rekapHelpdesk()
        {
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getHelpdesk();

    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_helpdesk', $data);
            $this->load->view('templates/footer');
        }

        public function datehelpdesk()
        {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getDateHelpdesk($tgla, $tglb);
    
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_helpdesk', $data);
            $this->load->view('templates/footer');
        }

        // REKAP PROGRESS
        public function rekapProgres()
        {
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getProgres();

    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_progres', $data);
            $this->load->view('templates/footer');
        }

        public function dateprogres()
        {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            $status_ccs = $this->input->post('status_ccs');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getDateProgres($tgla, $tglb,$status_ccs);
            
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_progres', $data);
            $this->load->view('templates/footer');
        }

     
}
