<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public $active = array('active_utilities' => 'active_presensi');

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Laporan_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->Tampilan_model->admin();
	}

	public function index()
	{

        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();

        $pegawai= $this->db->select('p.*')
            ->from('pegawai p')
            ->join('users u','u.id=p.id_users','left')
            ->where('id_kantor',$kantor_id->id_kantor)
            ->where('level!=0')
            ->get()
            ->result();
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->model('Hari_kerja_model');
        $id_pegawai = 'semua';
        $tahun = date('Y');
        $bulan = date('m');

        if (!empty($this->input->post('id_pegawai', TRUE))) {
            $id_pegawai = $this->input->post('id_pegawai', TRUE);
        }
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }

        $data = array(
        	'id_pegawai' => $id_pegawai,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulan_tahun' => $bulan.'-'.$tahun,
            'hari_aktif' => $this->Hari_kerja_model->get_by_bulan_tahun($bulan,$tahun),
            'tunjangan' => $this->Laporan_model->get_tunjangan_bulan($bulan.'-'.$tahun),
            'potongan' => $this->Laporan_model->get_potongan_bulan($bulan.'-'.$tahun),
            'potongan_absen' => $this->Laporan_model->get_potongan_absen($bulan.'-'.$tahun),
            'tidak_masuk' => $this->Laporan_model->get_tidak_masuk($tahun.'-'.$bulan),
            // 'data_pegawai' => $this->db->where('level!=0')->get('pegawai')->result(),
            'data_pegawai' => $pegawai,
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
            'gajian_pegawai' => $this->Laporan_model->get_gajian_pegawai($bulan.'-'.$tahun),
       	);
        $this->Tampilan_model->layar('laporan/laporan_list', $data, $this->active);
	}
    public function cetak_gaji($id = '',$bulan = '',$tahun = '')
    {
        $data['data_laporan']= $this->db->where('id',$id)->get('gaji_perbulan')->row();
        $data['tunjangan']   = $this->db->select('*')->from('pil_tunjangan')->where('id NOT IN( select id_pil_tunjangan from default_tunjangan )')->get()->result();
        $data['potongan']    = $this->db->select('*')->from('pil_potongan')->where('id NOT IN( select id_pil_potongan from default_potongan )')->get()->result();
        $data['bulan_tahun'] = $bulan.'-'.$tahun;
        $this->Tampilan_model->layar('laporan/cetak_gaji', $data, $this->active);
    }
    // function potongan
        function add_potongan()
        {
            $id_pegawai  = $this->input->post('id_pegawai');
            $bulan_tahun = $this->input->post('bulan_tahun'); 
            $data = array(
                'id_potongan'=>$this->input->post('id'),
                'nominal'=>$this->input->post('nominal'),
                'keterangan'=>$this->input->post('keterangan'),
                'bulan_tahun'=>$bulan_tahun,
                'id_pegawai'=>$id_pegawai
            );
            $insert = $this->db->insert('potongan', $data);
            if($insert){
                $this->list_potongan($id_pegawai,$bulan_tahun);
            }else{
                echo 'Gagal di muat';
            }
        }
        function remove_potongan($id_pegawai,$bulan_tahun)
        {
            $this->db->where('id', $this->input->post('id'));
            $delete = $this->db->delete('potongan');
            if($delete){
                $this->list_potongan($id_pegawai,$bulan_tahun);
            }else{
                echo 'Gagal dihapus';
            }
        }
        function list_potongan($id_pegawai,$bulan_tahun){
            $this->db->select('p.*,pp.nama_potongan as nama_potongan')
                     ->from('potongan as p')
                     ->where('id_pegawai',$id_pegawai)
                     ->where('bulan_tahun',$bulan_tahun)
                     ->join('pil_potongan as pp','pp.id = p.id_potongan');
            $potongan = $this->db->get()->result();
            $output = '<ul class="unstyled mt-2" style="padding-left:0px">';
            foreach ($potongan as $pot) {
               $output .= '<li class="card bg-primary text-white p-2 mb-2">';
                  $output .= '<strong>'.$pot->nama_potongan.'</strong>';
                  $output .= $pot->nominal;
                  $output .= '<span style="cursor:pointer;position:absolute;top:5px;right:10px" class="text-white" onclick="remove('.$pot->id.',1)"><i class="fa fa-times"></i></span>';
               $output .='</li>';
            }
            $output .= '</ul>';
            echo $output;
        }


    //function tunjangan
        function add_tunjangan()
        {
            $id_pegawai  = $this->input->post('id_pegawai');
            $bulan_tahun = $this->input->post('bulan_tahun'); 
            $data = array(
                'id_tunjangan'=>$this->input->post('id'),
                'nominal'=>$this->input->post('nominal'),
                'keterangan'=>$this->input->post('keterangan'),
                'bulan_tahun'=>$bulan_tahun,
                'id_pegawai'=>$id_pegawai
            );
            $insert = $this->db->insert('tunjangan', $data);
            if($insert){
                $this->list_tunjangan($id_pegawai,$bulan_tahun);
            }else{
                echo 'Gagal di muat';
            }
        }
        function update_bonus($bulan_tahun)
        {
            $data = array(
                    'bonus_gaji'=>$this->input->post('bonus_gaji'),
                    'keterangan_bonus'=>$this->input->post('keterangan_bonus')
            );
            $this->db->where('id_pegawai', $this->input->post('id_pegawai'));
            $this->db->where('id_bulan', $bulan_tahun);
            $this->db->update('gaji_perbulan', $data);
        }
        function remove_tunjangan($id_pegawai,$bulan_tahun)
        {
            $this->db->where('id', $this->input->post('id'));
            $delete = $this->db->delete('tunjangan');
            if($delete){
                $this->list_tunjangan($id_pegawai,$bulan_tahun);
            }else{
                echo 'Gagal dihapus';
            }
        }
        function list_tunjangan($id_pegawai,$bulan_tahun){
            $this->db->select('p.*,pp.nama_tunjangan as nama_tunjangan')
                     ->from('tunjangan as p')
                     ->where('id_pegawai',$id_pegawai)
                     ->where('bulan_tahun',$bulan_tahun)
                     ->join('pil_tunjangan as pp','pp.id = p.id_tunjangan');
            $tunjangan = $this->db->get()->result();
            $output = '<ul class="unstyled mt-2" style="padding-left:0px">';
            foreach ($tunjangan as $pot) {
               $output .= '<li class="card bg-primary text-white p-2 mb-2">';
                  $output .= '<strong>'.$pot->nama_tunjangan.'</strong>';
                  $output .= $pot->nominal;
                  $output .= '<span style="cursor:pointer;position:absolute;top:5px;right:10px" class="text-white" onclick="remove('.$pot->id.',2)"><i class="fa fa-times"></i></span>';
               $output .='</li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    public function print_gaji($bulan_tahun)
    {
        $data['gajian_pegawai'] = $this->Laporan_model->get_gajian_pegawai($bulan_tahun);
        $this->load->view('admin/laporan/print_gajian', $data, $this->active);
    }

    public function json($id_pegawai = '', $bulan = '', $tahun = '') {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Laporan_model->json($id_pegawai, $bulan, $tahun);
    }

}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */