<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_tp_model extends CI_Model {
	public function default_potongan($level = ''){
		$this->db->select('dt.id as id, dt.nominal, p.nama_potongan')
        			 ->from('default_potongan as dt')
        			 ->join('pil_potongan as p','p.id = dt.id_pil_potongan');
        if(!empty($level)){
        	$this->db->where('level', $level);
        }
        return $this->db->get()->result();
	}
		public function _total_def_potongan($level = ''){
			$total = 0;
			foreach ($this->default_potongan($level) as $dp) {
				$total += $dp->nominal;
			}
			return $total;
		}
	public function default_tunjangan($level = ''){
		$this->db->select('dt.id as id, dt.nominal, p.nama_tunjangan')
        			 ->from('default_tunjangan as dt')
        			 ->join('pil_tunjangan as p','p.id = dt.id_pil_tunjangan');
        if(!empty($level)){
        	$this->db->where('level', $level);
        }
        return $this->db->get()->result();
	}
		public function _total_def_tunjangan($level = ''){
			$total = 0;
			foreach ($this->default_tunjangan($level) as $dp) {
				$total += $dp->nominal;
			}
			return $total;
		}
	

}

/* End of file Default_model.php */
/* Location: ./application/models/Default_model.php */