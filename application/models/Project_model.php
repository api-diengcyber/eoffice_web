<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_model extends CI_Model
{

    public $table = 'project';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables


    function json($id) {
        

        


        $this->datatables->select('id,project,description,file');
        $this->datatables->from('project');
        $this->datatables->where('id_kantor',$id);
        //add this line for join
        //$this->datatables->join('table2', 'project.field = table2.field');
        $this->datatables->add_column('file',anchor(site_url('assets/project/file/$1'),'<button class="btn btn-xs btn-success">
        <i class="ace-icon fa fa-check bigger-120"></i>'), 'file');
        


        $this->datatables->add_column('action', anchor(site_url('admin/project/read/$1'),'<button class="btn btn-xs btn-success">
            <i class="ace-icon fa fa-check bigger-120"></i>
        </button>')."&nbsp;&nbsp;".anchor(site_url('admin/project/update/$1'),
        '<button class="btn btn-xs btn-info">
        <i class="ace-icon fa fa-pencil bigger-120"></i>
        </button>')."&nbsp;&nbsp;".anchor(site_url('admin/project/delete/$1'),
        '<button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();

    
    }

    // get all
    function get_all()
    {
        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();

        $this->db->where('id_kantor', $kantor_id->id_kantor);
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('project', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('file', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('project', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('file', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Project_model.php */
/* Location: ./application/models/Project_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-09-01 05:26:37 */
/* http://harviacode.com */