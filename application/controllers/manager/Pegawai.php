<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pegawai extends CI_Controller
{

    public $active = array('active_master' => 'active_pegawai');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Ion_auth_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        
        $status = $this->input->post('status');
        if($status != ''){
            $data['status'] = $status;
        }else{
            $data['status'] = 1;
        }
        $this->Tampilan_model->layar('pegawai/pegawai_list', $data, $this->active);
    } 
    
    public function json($status = 1) {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Pegawai_model->json($status);
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pegawai_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'nama_pegawai' => $row->nama_pegawai,
    		'tgl_masuk' => $row->tgl_masuk,
    		'rekening' => $row->rekening,
            'level' => $row->level,
    		'tingkat' => $row->tingkat,
    		'gaji_pokok' => $row->gaji_pokok,
    	    );
            $this->Tampilan_model->layar('pegawai/pegawai_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pegawai'));
        }
    }

    public function create() 
    {
        $this->load->model('Pil_jabatan_model');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/pegawai/create_action'),
    	    'id' => set_value('id'),
            'username' => set_value('username'),
            'nama_pegawai' => set_value('nama_pegawai'),
    	    'tgl_masuk' => set_value('tgl_masuk', date('d-m-Y')),
    	    'rekening' => set_value('rekening'),
            'level' => set_value('level'),
            'tingkat' => 0,
            'gaji_pokok' => set_value('gaji_pokok'),
            'password' => set_value('password'),
            'data_pil_level' => $this->db->get('pil_level')->result(),
            'data_pil_tingkat' => $this->db->get('pil_tingkat')->result(),
            'jabatan' => $this->Pil_jabatan_model->get_all(),
            'id_jabatan' => '',
            'status'=>'',
    	);
        $this->Tampilan_model->layar('pegawai/pegawai_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            // users //
            $identity = $this->input->post('username',TRUE);
            $password = $this->input->post('password', TRUE);
            $email = $this->input->post('username',TRUE);
            $additional_data = array(
                'phone' => '',
            );
            $id_users = $this->ion_auth->register($identity, $password, $email, $additional_data);
            // det_users //

            $data = array(
    		'id_users' => $id_users,
    		'nama_pegawai' => $this->input->post('nama_pegawai',TRUE),
    		'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
    		'rekening' => $this->input->post('rekening',TRUE),
            'level' => $this->input->post('level',TRUE),
            'tingkat' => $this->input->post('tingkat',TRUE),
    		'gaji_pokok' => str_replace('.','',$this->input->post('gaji_pokok',TRUE)),
            'id_jabatan' => $this->input->post('id_jabatan'),
    	    );

            $this->Pegawai_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/pegawai'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pegawai_model->get_by_id($id);
        $this->load->model('Pil_jabatan_model');
        $this->load->model('Pil_tingkat_model');

        if($row){
            $row_users = $this->db->where('id', $row->id_users)->get('users')->row();
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/pegawai/update_action'),
        		'id' => set_value('id', $row->id),
                'username' => set_value('username', $row_users->username),
                'nama_pegawai' => set_value('nama_pegawai', $row->nama_pegawai),
        		'tgl_masuk' => set_value('tgl_masuk', $row->tgl_masuk),
        		'rekening' => set_value('rekening', $row->rekening),
                'level' => set_value('level', $row->id_level),
                'tingkat' => set_value('tingkat', $row->id_tingkat),
                'gaji_pokok' => set_value('gaji_pokok', number_format($row->gaji_pokok,0,',','.')),
                'password' => set_value('password'),
                'data_pil_level' => $this->db->get('pil_level')->result(),
                'data_pil_tingkat' => $this->db->get('pil_tingkat')->result(),
                'data_tingkat'=> $this->Pil_tingkat_model->get_by_jabatan($row->id_jabatan),
                'jabatan' => $this->Pil_jabatan_model->get_all(),
                'id_jabatan' => $row->id_jabatan,
                'id_tingkat' => $row->id_tingkat,
                'status'  => $row_users->active,
                'users' => $row_users,
        	    );
            $this->Tampilan_model->layar('pegawai/pegawai_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pegawai'));
        }
    }
    
    public function update_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $row_pegawai = $this->db->where('id',$this->input->post('id'))->get('pegawai')->row();
            $row_users = $this->db->where('id', $row_pegawai->id_users)->get('users')->row();
            
            $hash_password = $this->Ion_auth_model->hash_password($this->input->post('password', TRUE));
            
            if(!empty($this->input->post('password'))){
                $data_users = array(
                    'username' => $this->input->post('username', TRUE),
                    'password' => $hash_password,
                    'email' => $this->input->post('username', TRUE),
                );
            }else{
                $data_users = array(
                    'username' => $this->input->post('username', TRUE),
                    //'password' => $hash_password,
                    'email' => $this->input->post('username', TRUE),
                );   
            }
            $this->db->where('id', $row_pegawai->id_users);
            $this->db->update('users', $data_users);
            $data = array(
    		'nama_pegawai' => $this->input->post('nama_pegawai',TRUE),
    		'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
    		'rekening' => $this->input->post('rekening',TRUE),
            'level' => $this->input->post('level',TRUE),
            'tingkat' => $this->input->post('tingkat',TRUE),
    		'gaji_pokok' => str_replace('.','',$this->input->post('gaji_pokok',TRUE)),
            'id_jabatan' => $this->input->post('id_jabatan'),
    	    );

            $this->Pegawai_model->update($this->input->post('id', TRUE), $data);

            $data_status = array('active'=>$this->input->post('status'));
            $this->db->where('id', $row_users->id);
            $this->db->update('users', $data_status);

            echo $this->input->post('status').' --- '.$row_users->id;
            
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/pegawai'));
        }
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Pegawai_model->get_by_id($id);

        if ($row) {
            $this->Pegawai_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/pegawai'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pegawai'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('nama_pegawai', 'nama pegawai', 'trim|required');
    	$this->form_validation->set_rules('tgl_masuk', 'tgl masuk', 'trim|required');
    	$this->form_validation->set_rules('rekening', 'rekening', 'trim|required');
        $this->form_validation->set_rules('level', 'level', 'trim');
        $this->form_validation->set_rules('tingkat', 'tingkat', 'trim');
    	$this->form_validation->set_rules('gaji_pokok', 'gaji pokok', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->helper('exportexcel');
        $namaFile = "pegawai.xls";
        $judul = "pegawai";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
    	xlsWriteLabel($tablehead, $kolomhead++, "Id Users");
    	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pegawai");
    	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Masuk");
    	xlsWriteLabel($tablehead, $kolomhead++, "Rekening");
    	xlsWriteLabel($tablehead, $kolomhead++, "Level");
    	xlsWriteLabel($tablehead, $kolomhead++, "Gaji Pokok");

	foreach ($this->Pegawai_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->id_users);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pegawai);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_masuk);
    	    xlsWriteLabel($tablebody, $kolombody++, $data->rekening);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->level);
    	    xlsWriteNumber($tablebody, $kolombody++, $data->gaji_pokok);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pegawai.doc");

        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $data = array(
            'pegawai_data' => $this->Pegawai_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('pegawai/pegawai_doc',$data);
    }
    function json_tingkat()
    {
        $this->load->model('Pil_tingkat_model');
        $id = $this->input->post('id',TRUE);
        echo json_encode($this->Pil_tingkat_model->get_by_id_jabatan($id));
    }

}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-29 10:12:33 */
/* http://harviacode.com */