<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_tp extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tampilan_model');
	}
    public function test(){
        $this->load->model('Default_tp_model');
        $data = $this->Default_tp_model->_total_def_tunjangan(2);
        print_r($data);
    }
	public function index()
	{
        $this->load->model('Pil_level_model');
        $data['tunjangan']   = $this->db->get('pil_tunjangan')->result();
        $data['potongan']    = $this->db->get('pil_potongan')->result();
        $data['pil_level'] = $this->Pil_level_model->get_all();

		$this->Tampilan_model->layar('default_tp/ubah_default',$data);
	}
    // function potongan
        function add_potongan($level = '')
        {
            $data = array(
                'id_pil_potongan'=>$this->input->post('id'),
                'nominal'=>$this->input->post('nominal'),
                'keterangan'=>$this->input->post('keterangan'),
                'level'=>$level
            );
            $insert = $this->db->insert('default_potongan', $data);
            if($insert){
                $this->list_potongan($level);
            }else{
                echo 'Gagal di muat';
            }
        }
        function remove_potongan($level = '')
        {
            $this->db->where('id', $this->input->post('id'));
            $delete = $this->db->delete('default_potongan');
            if($delete){
                $this->list_potongan($level);
            }else{
                echo 'Gagal dihapus';
            }
        }
        function list_potongan($level = ''){
            $this->db->select('dt.id as id, dt.nominal, p.nama_potongan')
        			 ->from('default_potongan as dt')
        			 ->join('pil_potongan as p','p.id = dt.id_pil_potongan');
            if(!empty($level)){
                $this->db->where('dt.level',$level);
            }
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
        function add_tunjangan($level = '')
        {
            $data = array(
                'id_pil_tunjangan'=>$this->input->post('id'),
                'nominal'=>$this->input->post('nominal'),
                'keterangan'=>$this->input->post('keterangan'),
                'level'=>$level,
            );
            $insert = $this->db->insert('default_tunjangan', $data);
            if($insert){
                $this->list_tunjangan($level);
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
        function remove_tunjangan($level ='')
        {
            $this->db->where('id', $this->input->post('id'));
            $delete = $this->db->delete('default_tunjangan');
            if($delete){
                $this->list_tunjangan($level);
            }else{
                echo 'Gagal dihapus';
            }
        }
        function list_tunjangan($level = ''){
        	$this->db->select('* , dt.id as id')
        			 ->from('default_tunjangan as dt')
        			 ->join('pil_tunjangan as p','p.id = dt.id_pil_tunjangan');
            if(!empty($level)){
                $this->db->where('dt.level',$level);
            }
            $tunjangan = $this->db->get()->result();
            $output = '<ul class="unstyled mt-2" style="padding-left:0px">';
            foreach ($tunjangan as $tunj) {
               $output .= '<li class="card bg-primary text-white p-2 mb-2">';
                  $output .= '<strong>'.$tunj->nama_tunjangan.'</strong>';
                  $output .= $tunj->nominal;
                  $output .= '<span style="cursor:pointer;position:absolute;top:5px;right:10px" class="text-white" onclick="remove('.$tunj->id.',2)"><i class="fa fa-times"></i></span>';
               $output .='</li>';
            }
            $output .= '</ul>';
            echo $output;
        }

}

/* End of file Default_tp.php */
/* Location: ./application/controllers/admin/Default_tp.php */