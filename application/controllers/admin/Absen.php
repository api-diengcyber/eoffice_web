<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Absen extends CI_Controller
{

    public $active = array('active_utilities' => 'active_absen');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Absen_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {

        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

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
            'bulan_tahun' => $bulan.'-'.$tahun,
            'data_pegawai' =>   $this->db->select('p.*')
                                ->from('pegawai AS p')
                                ->join('users AS u','u.id=p.id_users')
                                ->where('u.id!=',$user_id) 
                                ->where('u.id_kantor=',$kantor_id->id_kantor) 
                                // $this->db->where('level!=0')
                                // ->join('users as u','u.id')
                                ->get()->result(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
        );
        $this->Tampilan_model->layar('absen/absen_list', $data, $this->active);
    } 
    
    public function json($id_users = '', $bulan = '', $tahun = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Absen_model->json($id_users, $bulan, $tahun);
    }

    public function update($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Absen_model->get_by_id($id);
        if ($row) {
            $row_pegawai = $this->db->where('id_users', $row->id_users)->get('pegawai')->row();
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/absen/update_action'),
                'id' => set_value('id', $row->id),
                'tgl' => set_value('tgl', $row->tgl),
                'nama_pegawai' => set_value('nama_pegawai', $row_pegawai->nama_pegawai),
                'jam_masuk' => set_value('jam_masuk', $row->jam_masuk),
                'jam_pulang' => set_value('jam_pulang', $row->jam_pulang),
                'status' => set_value('status', $row->status),
            );
            $this->Tampilan_model->layar('absen/absen_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/absen'));
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
            $data = array(
                'tgl' => $this->input->post('tgl', TRUE),
                'jam_masuk' => $this->input->post('jam_masuk', TRUE),
                'jam_pulang' => $this->input->post('jam_pulang', TRUE),
                'status' => $this->input->post('status', TRUE),
            );
            $this->Absen_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/absen'));
        }
    }

    public function cetak()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $active = array('active_report' => 'active_cetak_gaji');
        $data = array(
            'action' => site_url('admin/absen/cetak_action'),
            'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result()
        );
        $this->Tampilan_model->layar('absen/absen_cetak', $data, $active);
    }

    public function cetak_action()
    {
        $id_pegawai = $this->input->post('id_pegawai', true);
        $tahun = $this->input->post('tahun', true);
        $bulan = $this->input->post('bulan', true);
        $this->db->select('g.*, p.nama_pegawai, p.level, p.tingkat');
        $this->db->from('gaji_perbulan g');
        $this->db->join('pegawai p', 'p.id = g.id_pegawai');
        $this->db->where('g.id_bulan', sprintf('%02d', $bulan).'-'.$tahun);
        if (!empty($id_pegawai) && $id_pegawai!='semua') {
            $this->db->where('p.id', $id_pegawai);
        }
        $res_gaji = $this->db->get()->result();
        $data = array(
            'data_gaji' => $res_gaji
        );
        $this->load->view('admin/absen/cetak_absen', $data, FALSE);
    }

    public function delete($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Absen_model->get_by_id($id);
        if ($row) {
            $this->Absen_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/absen'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/absen'));
        }
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
        $this->form_validation->set_rules('jam_masuk', 'jam_masuk', 'trim|required');
        $this->form_validation->set_rules('jam_pulang', 'jam_pulang', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    public function test($bulan_tahun){
         $this->load->model('Absen_model');
         $test = $this->Absen_model->get_by_month($bulan_tahun);
         echo "<pre>";
         print_r($test);
         echo '</pre>';
    }
    public function excel($bulan_tahun = '')
    {
        $this->load->model('Absen_model');
        $this->load->helper('exportexcel');
        $namaFile = "absen_pegawai_".$bulan_tahun.".xls";
        $judul = "absen_pegawai_".$bulan_tahun;
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
        xlsWriteLabel($tablehead, $kolomhead++, "Pegawai");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
        xlsWriteLabel($tablehead, $kolomhead++, "Jam Masuk");
        xlsWriteLabel($tablehead, $kolomhead++, "Jam Pulang");
        xlsWriteLabel($tablehead, $kolomhead++, "Total Jam");
        xlsWriteLabel($tablehead, $kolomhead++, "Lembur");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");

        foreach ($this->Absen_model->get_by_month($bulan_tahun) as $data) {
            $kolombody = 0;
            $status = '';
            if($data->status == 1){
                $status = 'MASUK';
            }else{
                $status = 'PULANG';
            }
            $start = new \DateTime($data->tgl.' '.$data->jam_masuk);
            $end   = new \DateTime($data->tgl.' '.$data->jam_pulang);

            $interval  = $end->diff($start);
            $jam_masuk =  $interval->format('%h,%i Jam');

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pegawai);
            xlsWriteLabel($tablebody, $kolombody++, $data->tgl);
            xlsWriteLabel($tablebody, $kolombody++, $data->jam_masuk);
            xlsWriteLabel($tablebody, $kolombody++, $data->jam_pulang);
            xlsWriteLabel($tablebody, $kolombody++, $jam_masuk);
            xlsWriteLabel($tablebody, $kolombody++, $data->lembur);
            xlsWriteLabel($tablebody, $kolombody++, $status);

        $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Hari_kerja.php */
/* Location: ./application/controllers/Hari_kerja.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-30 05:50:21 */
/* http://harviacode.com */