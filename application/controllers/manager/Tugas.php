<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tugas extends CI_Controller
{

    public $active = array('active_utilities' => 'active_tugas');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Tugas_model');
        $this->load->model('Pegawai_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->Tampilan_model->manager();
    }
    public function my_index()
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
            'data_tugas' => $this->db->select('*')
                                     ->from('tugas')
                                     ->where('id_pegawai', $data_login['users_id_pegawai'])
                                     ->where('SUBSTRING(tgl,4,2) = "'.sprintf('%02d', $bulan).'"')
                                     ->where('SUBSTRING(tgl,7,4) = "'.$tahun.'"')
                                     ->order_by('id', 'desc')
                                     ->get()->result(),
            'data_riwayat_upload' => $this->db->where('id_pegawai', $data_login['users_id_pegawai'])->order_by('id', 'DESC')->limit(5)->get('upload_tugas')->result(),
            'tugas_belum_selesai' => $this->db->where('id_pegawai',$data_login['users_id_pegawai'])->where('selesai',0)->get('tugas')->result()
            ,
            'tugas_pagi' => $this->Tugas_model->get_upload_by_id($data_login['users_id_pegawai'],1),
            'tugas_siang' => $this->Tugas_model->get_upload_by_id($data_login['users_id_pegawai'],2),
            'message'=>$this->session->flashdata('message'),
        );

        $this->Tampilan_model->layar('tugas/my_tugas_list', $data, $this->active);
    }
    public function my_laporan_harian(){
        $data_login = $this->Tampilan_model->cek_login();

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
        $id_pegawai = $data_login['users_id'];
        $data['data_tahun'] = $this->db->group_by('tahun')->get('hari_kerja')->result();
        $data['data_bulan'] = $this->db->get('bulan')->result();
        $data['data_pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $data['data_hari']  = $this->db->where('tahun', $tahun)->where('bulan',$bulan)->get('hari_kerja')->row();
        $data['hari']  = $hari;
        $data['id_pegawai'] = $id_pegawai;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['laporan'] = $this->Laporan_model->get_laporan_harian($tahun,$bulan,$hari,$id_pegawai);
        $this->Tampilan_model->layar('tugas/my_laporan_harian',$data);
    }
    public function my_detail($id_tugas)
    {
        $this->load->model('Tugas_model');
        $this->load->model('Laporan_model');
        $this->active = array('active_utilities'=>'active_detail_tugas');
        $data['detail_tugas'] = $this->Tugas_model->get_by_id($id_tugas);
        $this->Tampilan_model->layar('tugas/my_detail',$data,$this->active);
    }
	public function my_read($id)
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
			$this->Tampilan_model->layar('tugas/my_tugas_read', $data, $this->active);
		} else {
			redirect(site_url('manager/tugas/my_index'));
		}
	}
    public function my_read_message()
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
        function my_update_status($id){
            $data = array('status'=>1);
            $this->db->where('id_upload_tugas', $id);
            $this->db->update('message_tugas', $data);
        }

	public function my_create_action()
	{
	    
		$data_login = $this->Tampilan_model->cek_login();
		$this->my_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->read($this->input->post('id', TRUE));
        } else {
        	$config['upload_path'] = 'assets/tugas/upload/';
        	$config['allowed_types'] = 'jpg|jpeg|gif|png';
        	$config['max_size']  = '2048';
        	$config['width'] = '900';
        	$config['quality'] = '50%';
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
                $this->session->set_flashdata('message', 'Gambar harus berformat .gif ( jangan rename dari png/jpg ke gif ) dan maksimal 500KB');
            }
            redirect(site_url('manager/tugas/my_read/'.$this->input->post('id', TRUE).''));
        }
        
        //redirect(site_url('manager/tugas/my_read/'));
        
	}

    public function my_reply_message()
    {
        $id = $this->input->post('id_upload_tugas');
        $data = array(
            'id_upload_tugas'=>$id,
            'id_user'=>$this->input->post('id_user'),
            'message'=>$this->input->post('message')
        );
        $this->db->insert('message_tugas', $data);
        redirect(site_url('manager/tugas/my_read/'.$id),'refresh');
    }
    public function my_susulan()
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
        redirect(site_url('manager/tugas/my_index'),'refresh');
    }

    /* end my tugas */
    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();

        $id_pegawai = 'semua';
        $bulan = date('m');
        $tahun = date('Y');
        $status = 'semua';

        if (!empty($this->input->post('id_pegawai', TRUE))) {
            $id_pegawai = $this->input->post('id_pegawai', TRUE);
        }
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }
        if (!empty($this->input->post('status',TRUE))) {
            $status = $this->input->post('status');
        }

        $data = array(
            'id_pegawai' => $id_pegawai,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status,
            'data_pegawai' => $this->Pegawai_model->get_pegawai_aktif(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
        );

        $this->Tampilan_model->layar('tugas/tugas_list', $data, $this->active);
    } 
    public function laporan_harian(){
        $this->active = array('active_utilities'=>'active_laporan_harian');
        $this->load->model('Laporan_model');
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
        if($hari == 'SEMUA'){
            $hari = 'semua';
        }
        $id_pegawai = $this->input->post('id_pegawai');
        echo '<h1>'.$id_pegawai.'</h1>';
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
    public function export_harian($id_pegawai='',$tahun='',$bulan='',$hari=''){
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=laporan_harian_".date('d-m-Y').".xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        if(empty($tahun)){
            $tahun = date('Y');
        }
        if(empty($bulan)){
            $bulan = date('m');
        }
        if(empty($hari)){
            $hari = date('d');
        }
        $this->load->model('Laporan_model');
        $data['laporan'] = $this->Laporan_model->get_laporan_harian($tahun,$bulan,$hari,$id_pegawai);
        $view = $this->load->view('manager/tugas/export_harian',$data,TRUE);
        echo $view;
        exit;
    }
    public function json($id_pegawai = '', $bulan = '', $tahun = '' , $status = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        echo $this->Tugas_model->json($id_pegawai, $bulan, $tahun ,$status);
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->db->select('t.*, u.username')
                        ->from('tugas t')
                        ->join('pegawai as p','p.id=t.id_pegawai')
                        ->join('users u', 'p.id_users=u.id')
                        ->where('t.id', $id)
                        ->get()->row();
        if ($row) {
            $data_t = array('is_update'=>0);
            $this->db->update('tugas', $data_t);
            $data = array(
    		'id' => $row->id,
    		'tgl' => $row->tgl,
            'tugas' => $row->tugas,
    		'file_tugas' => $row->file_tugas,
    		'tgl_selesai' => $row->tgl_selesai,
            'upload' => $row->upload,
    		'selesai' => $row->selesai,
            'username' => $row->username,
            'data_upload' => $this->db->where('id_tugas', $row->id)->get('upload_tugas')->result(),
            'progress'=>$row->progress,
    	    );
            $this->Tampilan_model->layar('tugas/tugas_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manager/tugas'));
        }
    }

    public function create() 
    {
        $this->load->model('Project_model');
        $data_login = $this->Tampilan_model->cek_login();
        $data = array(
            'button' => 'Create',
            'action' => site_url('manager/tugas/create_action'),
    	    'id' => set_value('id'),
    	    'tgl' => set_value('tgl', date('d-m-Y')),
            'id_pegawai' => set_value('id_pegawai'),
            'tugas' => set_value('tugas'),
    	    'tgl_selesai' => set_value('tgl_selesai', date('d-m-Y')),
    	    'selesai' => set_value('selesai', '0'),
            'data_pegawai' => $this->Pegawai_model->get_pegawai_aktif(),
            'project' => $this->Project_model->get_all(),
            'id_project' => '',
            'judul'=>'',
    	);
        $this->Tampilan_model->layar('tugas/tugas_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $notif = '';
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $config['upload_path'] = 'assets/tugas/';
            $config['allowed_types'] = 'gif|jpg|png|rar|zip|txt|xls|xlsx|doc|docx|css|php';
            $config['max_size']  = '2000';
            $config['max_width']  = '2024';
            $config['max_height']  = '2068';
            
            $this->load->library('upload', $config);
            
            $nm_file_tugas = "";
            if (!$this->upload->do_upload('file_tugas')){
            } else {
                $file_tugas = $this->upload->data();
                $nm_file_tugas = $file_tugas['file_name'];
            }

            $id_pegawai = $this->input->post('id_pegawai', TRUE);
            $row_tugas = $this->db->order_by('priority','desc')->get('tugas')->row();
            $priority = 1;
            if(!empty($row_tugas)){
                $priority = $row_tugas->priority+$priority;
            }
            for ($i=0; $i < count($id_pegawai); $i++) {
                $data = array(
                'tgl' => $this->rDate($this->input->post('tgl',TRUE)),
                'id_pegawai' => $id_pegawai[$i],
                'tugas' => $this->input->post('tugas',TRUE),
                'file_tugas' => $nm_file_tugas,
                'tgl_selesai' => $this->input->post('tgl_selesai',TRUE),
                'selesai' => $this->input->post('selesai',TRUE),
                'id_project' => $this->input->post('id_project',TRUE),
                'judul'=>$this->input->post('judul',TRUE),
                'priority'=>$priority,

                );
                $this->Tugas_model->insert($data);
                $id_tugas = $this->db->insert_id();
                //notification system
                $data_notif = array(
                                'users_id_pegawai'=>$id_pegawai[$i],
                                'message'=>strip_tags($this->input->post('tugas')),
                                'title'=>'Ada tugas baru '.$this->input->post('judul'),
                                'img'=>site_url('assets/images/logo-mini.png'),
                                'id_tugas'=>$id_tugas,
                            );
                $this->load->model('Notification_model');
                $notif = $this->Notification_model->send($data_notif);
            }
            $this->session->set_flashdata('message', 'Create Record Success');

            

            redirect(site_url('manager/tugas'));
        }
    }
    public function update($id)
    {
        $this->load->model('Project_model');
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tugas_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('manager/tugas/update_action'),
        		'id' => set_value('id', $row->id),
        		'tgl' => set_value('tgl', $row->tgl),
                'id_pegawai' => set_value('id_pegawai', $row->id_pegawai),
        		'tugas' => set_value('tugas', $row->tugas),
        		'tgl_selesai' => set_value('tgl_selesai', $row->tgl_selesai),
        		'selesai' => set_value('selesai', $row->selesai),
                'data_pegawai' => $this->Pegawai_model->get_pegawai_aktif(),
                'id_project' => set_value('id_project', $row->id_project),
                'project' => $this->Project_model->get_all(),
                'judul'=> set_value('judul',$row->judul),
                'data_tugas'=>$row,
        	    );
            $this->Tampilan_model->layar('tugas/tugas_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manager/tugas'));
        }
    }
    
    public function update_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {

            $config['upload_path'] = 'assets/tugas/';
            $config['allowed_types'] = 'gif|jpg|png|rar|zip|txt|xls|xlsx|doc|docx|css|php';
            $config['max_size']  = '2000';
            $config['max_width']  = '2024';
            $config['max_height']  = '2068';
            
            $this->load->library('upload', $config);
            
            $nm_file_tugas = "";
            if (!$this->upload->do_upload('file_tugas')){
            } else {
                $file_tugas = $this->upload->data();
                $nm_file_tugas = $file_tugas['file_name'];
            }

            $data = array(
            'tgl' => $this->rDate($this->input->post('tgl',TRUE)),
    		'id_pegawai' => $this->input->post('id_pegawai',TRUE),
            'tugas' => $this->input->post('tugas',TRUE),
    		'file_tugas' => $nm_file_tugas,
    		'tgl_selesai' => $this->input->post('tgl_selesai',TRUE),
    		'selesai' => $this->input->post('selesai',TRUE),
            'id_project' => $this->input->post('id_project',TRUE),
            'judul'=>$this->input->post('judul'),

    	    );

            $this->Tugas_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('manager/tugas'));
        }
    }
    public function rekap(){
        $data_login = $this->Tampilan_model->cek_login();
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
            $hari = 'semua';
        }
        $id_pegawai = $this->input->post('id_pegawai');
        $data['data_tugas'] = $this->Tugas_model->get_rekap_tugas($tahun,$bulan,$hari,$id_pegawai);
        $data['data_tahun'] = $this->db->group_by('tahun')->get('hari_kerja')->result();
        $data['data_bulan'] = $this->db->get('bulan')->result();
        $data['data_pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $data['data_hari']  = $this->db->where('tahun', $tahun)->where('bulan',$bulan)->get('hari_kerja')->row();
        $data['hari']  = $hari;
        $data['id_pegawai'] = $id_pegawai;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $this->Tampilan_model->layar('tugas/rekap_tugas', $data, $this->active);
    }
        public function cetak_rekap($tahun='',$bulan='',$hari='',$id_pegawai=''){
            $data['data_tugas'] = $this->Tugas_model->get_rekap_tugas($tahun,$bulan,$hari,$id_pegawai); 
            $this->load->view('manager/tugas/cetak_rekap', $data);
        }
    public function priority()
    {
        $this->load->model('Pegawai_model');
        $data_login = $this->Tampilan_model->cek_login();

        $data['id'] = '';
        $data['tugas'] = array();
        if(isset($_POST['id_pegawai'])){
            $data['id'] = $this->input->post('id_pegawai');
            $data['tugas'] = $this->Tugas_model->get_by_peg($this->input->post('id_pegawai'));
        }

        $data['pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $this->Tampilan_model->layar('tugas/tugas_priority', $data, $this->active);
    }
        function set_priority()
        {
            $id   = $this->input->post('id');
            $sort = $this->input->post('item');
            if(!empty($sort)){
                $i = 0;
                $result = $this->Tugas_model->get_by_peg($id);
                $b = count($result);
                foreach ($result as $row) {
                   $id = $row->id;
                   $this->db->where('id', $sort[$i]);
                   $data = array('priority'=>$b);
                   $this->db->update('tugas', $data);
                   //echo $sort[$i];
                   $i++;
                   $b--;
                }
            }
        }
    public function reply_message()
    {
        $id = $this->input->post('id_tugas');
        $data = array(
            'id_upload_tugas'=>$this->input->post('id_upload_tugas'),
            'message'=>$this->input->post('message')
        );
        $this->db->insert('message_tugas', $data);
        $this->load->model('Notification_model');

        $this->load->model('Tugas_model');
        $row_tugas = $this->Tugas_model->get_by_id($id);

        //notification system
        $data_notif = array(
                        'users_id_pegawai'=>$row_tugas->id_pegawai,
                        'message'=>$this->input->post('message'),
                        'title'=>'Ada pesan baru '.$this->input->post('judul'),
                        'img'=>site_url('assets/images/logo-mini.png'),
                        'id_tugas'=>$id,
                    );
        $notif = $this->Notification_model->send($data_notif);
        echo $notif;
        //redirect(site_url('manager/tugas/read/'.$id),'refresh');
    }
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tugas_model->get_by_id($id);

        if ($row) {
            if (file_exists('assets/tugas/'.$row->file_tugas.'')) {
                unlink('assets/tugas/'.$row->file_tugas.'');
            }
            $this->Tugas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('manager/tugas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manager/tugas'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
    	$this->form_validation->set_rules('tugas', 'tugas', 'trim|required');
    	$this->form_validation->set_rules('tgl_selesai', 'tgl selesai', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function my_rules() 
    {
    	$this->form_validation->set_rules('file', 'file', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function selesai($id, $selesai = '1')
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tugas_model->get_by_id($id);
        if ($row) {
            $data = array(
                'selesai' => $selesai,
            );
            $this->db->where('id', $id);
            $this->db->update('tugas', $data);
            $this->session->set_flashdata('message', 'Tugas telah selesai');
            redirect(site_url('manager/tugas/read/'.$id.''));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('manager/tugas'));
        }
    }
    private function rDate($text){
        return date('d-m-Y',strtotime($text));
    }


}

/* End of file Tugas.php */
/* Location: ./application/controllers/Tugas.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-04 03:39:43 */
/* http://harviacode.com */