<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Tasks extends CI_Controller
{
    public $active = array('active_task' => 'active_task');
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Tasks_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data=$this->Tasks_model->get_all();

        $data=[
            'data' =>$data
        ];

        $this->Tampilan_model->layar('tasks/tasks_list',$data,$this->active);


    }


    public function json()
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();
        header('Content-Type: application/json');
        echo $this->Tasks_model->json($kantor_id->id_kantor);
    }

    public function read($id)
    {
        $row = $this->Tasks_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'project' => $row->project,
                'id_project' => $row->id_project,
                'date_created' => $row->date_created,
                'task' => $row->task,
                'description' => $row->description,
                'id_status' => $row->id_status,
            );
            $this->Tampilan_model->layar('tasks/tasks_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tasks'));
        }
    }

    public function create()
    {
        
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();
        $data = array(
            'button' => 'Create',
            'message' => $this->session->flashdata('message'),
            'action' => site_url('admin/tasks/create_action'),
            'id' => set_value('id'),
            'id_project' => set_value('id_project'),
            'date_created' => set_value('date_created'),
            'task' => set_value('task'),
            'description' => set_value('description'),
            'id_status' => set_value('id_status'),
            'data_project' => $this->db->select('*')
                                ->from('project')
                                ->where('id_kantor',$kantor_id->id_kantor)
                                ->get()
                                ->result()
        );
        $this->Tampilan_model->layar('tasks/tasks_form', $data, $this->active);
    }


    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id_project' => $this->input->post('id_project', TRUE),
                'date_created' => date("Y-m-d"),
                'task' => $this->input->post('task', TRUE),
                'description' => $this->input->post('description', TRUE),
                'id_status' => $this->input->post('id_status', TRUE),
            );
            $this->Tasks_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/tasks'));
        }
    }

    public function update($id)
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

        $row = $this->Tasks_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'message' => $this->session->flashdata('message'),
                'action' => site_url('admin/tasks/update_action'),
                'id' => set_value('id', $row->id),
                'id_project' => set_value('id_project', $row->id_project),
                'date_created' => set_value('date_created', $row->date_created),
                'task' => set_value('task', $row->task),
                'description' => set_value('description', $row->description),
                'id_status' => set_value('id_status', $row->id_status),
                'data_project' => $this->db->select('*')
                                            ->from('project')
                                            ->where('id_kantor',$kantor_id->id_kantor)
                                            ->get()
                                            ->result()
            );
            $this->Tampilan_model->layar('tasks/tasks_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tasks'));
        }
    }


    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'id_project' => $this->input->post('id_project', TRUE),
                'task' => $this->input->post('task', TRUE),
                'description' => $this->input->post('description', TRUE),
                'id_status' => $this->input->post('id_status', TRUE),
            );
            $this->Tasks_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/tasks'));
        }
    }


    public function delete($id)
    {
        $row = $this->Tasks_model->get_by_id($id);
        if ($row) {
            $this->Tasks_model->delete($id);
            $this->session->set_flashdata('message', 's');
            redirect(site_url('admin/tasks'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tasks'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_project', 'id project', 'trim');
        $this->form_validation->set_rules('date_created', 'date created', 'trim');
        $this->form_validation->set_rules('task', 'task', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('id_status', 'id status', 'trim');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
/* End of file Tasks.php */
/* Location: ./application/controllers/Tasks.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-03-05 10:42:24 */
/* http://harviacode.com */