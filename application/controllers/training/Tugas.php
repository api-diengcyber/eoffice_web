<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tugas extends CI_Controller {

    public $active = array('active_utilities' => 'active_tugas');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->library('form_validation');
        $this->Tampilan_model->training();
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();

        $this->load->model('Tugas_model');

        $bulan = date('m');
        $tahun = date('Y');
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }

        $data = array(
            'tgl_ini' => date('d-m-Y'),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
            'data_tugas' => $this->Tugas_model->get_by_id_peg($data_login['users_id_pegawai'],$bulan),
            'data_riwayat_upload' => $this->db->where('id_pegawai', $data_login['users_id_pegawai'])->order_by('id', 'DESC')->limit(5)->get('upload_tugas')->result(),
            'tugas_belum_selesai' => $this->db->where('id_pegawai',$data_login['users_id_pegawai'])->where('selesai',0)->get('tugas')->result()
            ,
            
            'tugas_pagi' => $this->Tugas_model->get_upload_by_id($data_login['users_id_pegawai'],1,$bulan),

            'tugas_siang' => $this->Tugas_model->get_upload_by_id($data_login['users_id_pegawai'],2,$bulan),
            'message'=>$this->session->flashdata('message'),
        );

        $this->Tampilan_model->layar('tugas/tugas_list', $data, $this->active);
        // var_dump($bulan);
    }
    public function laporan_harian(){
        $this->active = array('active_utilities' => 'active_laporan');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->training();

        $this->load->model('Laporan_model');
        $this->load->model('Pegawai_model');
        
        $tahun = $this->input->post('tahun');
        if(empty($tahun)){
            $tahun = date('Y');
        }
        $bulan = $this->input->post('bulan');
        if(empty($bulan)){
            $bulan = date('m');
        }
        $hari  = $this->input->post('hari');
        if(empty($hari)){
            $hari = date('d');
        }
        $id_pegawai = $data_login['users_id_pegawai'];
        $data['data_tahun'] = $this->db->group_by('tahun')->get('hari_kerja')->result();
        $data['data_bulan'] = $this->db->get('bulan')->result();
        $data['data_pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $data['data_hari']  = $this->db->where('tahun', $tahun)->where('bulan',$bulan)->get('hari_kerja')->row();
        $data['hari']  = $hari;
        $data['id_pegawai'] = $id_pegawai;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['laporan'] = $this->Laporan_model->get_laporan_harian($tahun,$bulan,$hari,$id_pegawai);
        $this->Tampilan_model->layar('tugas/laporan_harian',$data,$this->active);
    }
    public function read($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->db->select('*,t.id as id')
                        ->from('tugas as t')
                        ->join('project as p','t.id_project = p.id','left')
                        ->where('t.id_pegawai', $data_login['users_id_pegawai'])
                        ->where('t.id', $id)
                        ->get()->row();
        if ($row) {
            $res_gb = $this->db->where('id_tugas', $row->id)->group_by('tgl')->get('upload_tugas')->result();
            $row_upload = $this->db->where('id_tugas', $row->id)->order_by('id', 'DESC')->get('upload_tugas')->row();
            $data = array(
                'file' => set_value('file'),
                'data_tugas' => $row,
                'data_upload_tugas_gb' => $res_gb,
                'row_upload_tugas' => $row_upload,
                'message' => $this->session->flashdata('message'),
            );
            // var_dump($data['data_tugas']);
            $this->Tampilan_model->layar('tugas/tugas_read', $data, $this->active);
        } else {
            redirect(site_url('training/tugas'));
        }
    }
    public function read_message()
    {
        $id = $this->input->post('id',TRUE);
        $this->db->where('id_upload_tugas', $id);
        $result = $this->db->get('message_tugas');
        foreach ($result as $r) {
            if($r->status == 0){
                $this->update_status($id);
            }
        }
    }
        function update_status($id){
            $data = array('status'=>1);
            $this->db->where('id_upload_tugas', $id);
            $this->db->update('message_tugas', $data);
        }

    public function create_action()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->read($this->input->post('id', TRUE));
        } else {
            $config['upload_path'] = 'assets/tugas/upload/';
            $config['allowed_types'] = 'gif|png|jpg';
            $config['max_size']  = '500';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $nm_file = "";
            if (!$this->upload->do_upload('file')){
            } else {
                $file = $this->upload->data();
                $nm_file = $file['file_name'];
            }
            
            if($nm_file != ''){
            $data = array(
                'id_tugas' => $this->input->post('id', TRUE),
                'id_pegawai' => $data_login['users_id_pegawai'],
                'tgl' => date('d-m-Y'),
                'ket' => $this->input->post('keterangan', TRUE),
                'file' => $nm_file,
                'waktu' => $this->input->post('waktu'),
            );
            $this->db->insert('upload_tugas', $data);
            $data_tugas = array(
                'upload' => '1',
                'progress' => $this->input->post('progress'),
                'is_update' => 1,
            );
            $this->db->where('id', $this->input->post('id', TRUE));
            $this->db->update('tugas', $data_tugas);
            $this->session->set_flashdata('message', 'Create Record Success');
            }else{
                $this->session->set_flashdata('message', 'Gambar harus berformat ( png/jpg/gif ) dan maksimal 500KB');
            }
            redirect(site_url('training/tugas/read/'.$this->input->post('id', TRUE).''));
        }
    }

    public function reply_message()
    {
        $id = $this->input->post('id_upload_tugas');
        $data = array(
            'id_upload_tugas'=>$id,
            'id_user'=>$this->input->post('id_user'),
            'message'=>$this->input->post('message')
        );
        $this->db->insert('message_tugas', $data);
        redirect(site_url('training/tugas/read/'.$id),'refresh');
    }
    public function susulan()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->load->model('Upload_model');

        $data = array(
            'id_pegawai'=>$data_login['users_id_pegawai'],
            'judul'=>$this->input->post('judul'),
            'tugas'=>$this->input->post('tugas'),
            'tgl'=>date('d-m-Y'),
            'jenis'=>1,
            'upload'=>1,
            'progress'=>$this->input->post('progress'),
            'is_update'=>1,
        );
        $this->db->insert('tugas', $data);
        $id = $this->db->insert_id();
        $files = '';
        if(!empty($_FILES['lampiran']['name'])){
         $file = $this->Upload_model->upload_files('assets/tugas/upload/','',$_FILES['lampiran']);
            $files = $file;
        }
        if($files != false){
            $ut = array(
                'id_tugas'=>$id,
                'file'=>$files,
                'tgl'=>date('d-m-Y'),
                'id_pegawai'=>$data_login['users_id_pegawai'],
                'ket'=>$this->input->post('keterangan'),
                'waktu'=>$this->input->post('waktu'),
            );
            $this->db->insert('upload_tugas', $ut);
        }
        else{
            $this->session->set_flashdata('message', 'Gambar harus berformat .gif ( jangan rename dari png/jpg ke gif ) dan maksimal 500KB');
        }
        redirect(site_url('training/tugas'),'refresh');
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('file', 'file', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */