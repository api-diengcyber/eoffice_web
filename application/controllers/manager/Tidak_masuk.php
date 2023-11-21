<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tidak_masuk extends CI_Controller
{

    public $active = array('active_utilities' => 'active_tidak_masuk');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Tidak_masuk_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->Tampilan_model->manager();
    }

    public function my_index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $id_users = 'semua';
        $bulan = date('m');
        $tahun = date('Y');
        if (!empty($this->input->post('id_users', TRUE))) {
            $id_users = $this->input->post('id_users', TRUE);
        }
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }

        $data = array(
            'id_users' => $id_users,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
        );
        $this->Tampilan_model->layar('tidak_masuk/my/tidak_masuk_list', $data, $this->active);
    } 
    
    public function my_json($bulan = '', $tahun = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $id_users = $data_login['users_id'];
        echo $this->Tidak_masuk_model->json($id_users, $bulan, $tahun);
    }

    public function my_read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        
        $row = $this->Tidak_masuk_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'tgl' => $row->tgl,
    		'id_users' => $row->id_users,
    		'tidak_masuk' => $row->tidak_masuk,
    	    );
            $this->Tampilan_model->layar('tidak_masuk/my/tidak_masuk_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai/tidak_masuk/my_index'));
        }
    }

    public function my_create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        
        $data = array(
            'button' => 'Create',
            'action' => site_url('pegawai/tidak_masuk/my_create_action'),
    	    'id' => set_value('id'),
    	    'tgl' => set_value('tgl', date('Y-m-d')),
    	    'id_users' => set_value('id_users'),
    	    'tidak_masuk' => set_value('tidak_masuk'),
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_pil_tidak_masuk' => $this->db->get('pil_tidak_masuk')->result(),
            'keterangan' => '',
    	);
        $this->Tampilan_model->layar('tidak_masuk/my/tidak_masuk_form', $data, $this->active);
    }
    
    public function my_create_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->my__rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $row_absen = $this->db->select('*')
                                  ->from('jam_kerja')
                                  ->where('tgl', $this->input->post('tgl', TRUE))
                                  ->where('id_users', $this->input->post('id_users', TRUE))
                                  ->get()->row();

            if ($row_absen) {
                $this->session->set_flashdata('message', 'Record Cannot Saved');
                redirect(site_url('pegawai/tidak_masuk/my_index'));
            } else {
                $data = array(
                'tgl' => $this->input->post('tgl',TRUE),
                'id_users' => $data_login['users_id'],
                'tidak_masuk' => $this->input->post('tidak_masuk',TRUE),
                'keterangan' => $this->input->post('keterangan',TRUE),
                );
                $this->Tidak_masuk_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('pegawai/tidak_masuk/my_index'));
            }

        }
    }
    
    public function my_update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        
        $row = $this->Tidak_masuk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pegawai/tidak_masuk/my_update_action'),
        		'id' => set_value('id', $row->id),
        		'tgl' => set_value('tgl', $row->tgl),
        		'id_users' => set_value('id_users', $row->id_users),
        		'tidak_masuk' => set_value('tidak_masuk', $row->tidak_masuk),
                'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
                'data_pil_tidak_masuk' => $this->db->get('pil_tidak_masuk')->result(),
                'keterangan' => $row->keterangan,
        	    );
            $this->Tampilan_model->layar('tidak_masuk/my/tidak_masuk_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai/tidak_masuk/my_index'));
        }
    }
    
    public function my_update_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        
        $this->my__rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
    		'tgl' => $this->input->post('tgl',TRUE),
    		'id_users' => $data_login['users_id'],
            'tidak_masuk' => $this->input->post('tidak_masuk',TRUE),
            'keterangan' => $this->input->post('keterangan',TRUE),
    	    );

            $this->Tidak_masuk_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pegawai/tidak_masuk/my_index'));
        }
    }
    
    public function my_delete($id) 
    {
        $row = $this->Tidak_masuk_model->get_by_id($id);

        if ($row) {
            $this->Tidak_masuk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pegawai/tidak_masuk/my_index'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pegawai/tidak_masuk/my_index'));
        }
    }

    public function my__rules() 
    {
    	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
    	$this->form_validation->set_rules('id_users', 'id users', 'trim');
    	$this->form_validation->set_rules('tidak_masuk', 'tidak masuk', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function my_excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        
        $this->load->helper('exportexcel');
        $namaFile = "tidak_masuk.xls";
        $judul = "tidak_masuk";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Tgl");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Users");
        xlsWriteLabel($tablehead, $kolomhead++, "Tidak Masuk");

	foreach ($this->Tidak_masuk_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_users);
	    xlsWriteNumber($tablebody, $kolombody++, $data->tidak_masuk);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function my_word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tidak_masuk.doc");

        $data_login = $this->Tampilan_model->cek_login();
        

        $data = array(
            'tidak_masuk_data' => $this->Tidak_masuk_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('tidak_masuk/tidak_masuk_doc',$data);
    }
    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();

        $id_users = 'semua';
        $bulan = date('m');
        $tahun = date('Y');
        if (!empty($this->input->post('id_users', TRUE))) {
            $id_users = $this->input->post('id_users', TRUE);
        }
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }

        $data = array(
            'id_users' => $id_users,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
        );
        $this->Tampilan_model->layar('tidak_masuk/tidak_masuk_list', $data, $this->active);
    } 
    
    public function json($id_users = '', $bulan = '', $tahun = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        echo $this->Tidak_masuk_model->json($id_users, $bulan, $tahun);
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tidak_masuk_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'tgl' => $row->tgl,
    		'id_users' => $row->id_users,
    		'tidak_masuk' => $row->tidak_masuk,
    	    );
            $this->Tampilan_model->layar('tidak_masuk/tidak_masuk_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tidak_masuk'));
        }
    }

    public function create() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/tidak_masuk/create_action'),
    	    'id' => set_value('id'),
    	    'tgl' => set_value('tgl', date('Y-m-d')),
    	    'id_users' => set_value('id_users'),
    	    'tidak_masuk' => set_value('tidak_masuk'),
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_pil_tidak_masuk' => $this->db->get('pil_tidak_masuk')->result(),
    	);
        $this->Tampilan_model->layar('tidak_masuk/tidak_masuk_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $row_absen = $this->db->select('*')
                                  ->from('jam_kerja')
                                  ->where('tgl', $this->input->post('tgl', TRUE))
                                  ->where('id_users', $this->input->post('id_users', TRUE))
                                  ->get()->row();

            if ($row_absen) {
                $this->session->set_flashdata('message', 'Record Cannot Saved');
                redirect(site_url('admin/tidak_masuk'));
            } else {
                $data = array(
                'tgl' => $this->input->post('tgl',TRUE),
                'id_users' => $this->input->post('id_users',TRUE),
                'tidak_masuk' => $this->input->post('tidak_masuk',TRUE),
                );
                $this->Tidak_masuk_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('admin/tidak_masuk'));
            }

        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tidak_masuk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/tidak_masuk/update_action'),
        		'id' => set_value('id', $row->id),
        		'tgl' => set_value('tgl', $row->tgl),
        		'id_users' => set_value('id_users', $row->id_users),
        		'tidak_masuk' => set_value('tidak_masuk', $row->tidak_masuk),
                'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
                'data_pil_tidak_masuk' => $this->db->get('pil_tidak_masuk')->result(),
        	    );
            $this->Tampilan_model->layar('tidak_masuk/tidak_masuk_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tidak_masuk'));
        }
    }
    
    public function update_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
    		'tgl' => $this->input->post('tgl',TRUE),
    		'id_users' => $this->input->post('id_users',TRUE),
    		'tidak_masuk' => $this->input->post('tidak_masuk',TRUE),
    	    );

            $this->Tidak_masuk_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/tidak_masuk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tidak_masuk_model->get_by_id($id);

        if ($row) {
            $this->Tidak_masuk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/tidak_masuk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tidak_masuk'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
    	$this->form_validation->set_rules('id_users', 'id users', 'trim|required');
    	$this->form_validation->set_rules('tidak_masuk', 'tidak masuk', 'trim|required');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->load->helper('exportexcel');
        $namaFile = "tidak_masuk.xls";
        $judul = "tidak_masuk";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Users");
	xlsWriteLabel($tablehead, $kolomhead++, "Tidak Masuk");

	foreach ($this->Tidak_masuk_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_users);
	    xlsWriteNumber($tablebody, $kolombody++, $data->tidak_masuk);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tidak_masuk.doc");

        $data_login = $this->Tampilan_model->cek_login();

        $data = array(
            'tidak_masuk_data' => $this->Tidak_masuk_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('tidak_masuk/tidak_masuk_doc',$data);
    }

}

/* End of file Tidak_masuk.php */
/* Location: ./application/controllers/Tidak_masuk.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-03 04:12:12 */
/* http://harviacode.com */