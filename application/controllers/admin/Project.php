<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project extends CI_Controller
{
    public $active = array('active_utilities' => 'active_project');
    function __construct()
    {
        parent::__construct();
        $this->load->model('Project_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->load->model('Tampilan_model');
        $this->Tampilan_model->admin();
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();

        $data=$this->Project_model->get_all();

        $data = [
            'project' => $data,
        ];

        // var_dump($this->active);
        $this->Tampilan_model->layar('project/project_list', $data, $this->active);

    } 
    
    public function json() {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

        header('Content-Type: application/json');
        echo $this->Project_model->json( $kantor_id->id_kantor);
    }

    public function read($id) 
    {
        $row = $this->Project_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'project' => $row->project,
    		'description' => $row->description,
    		'file' => $row->file,
	    );
            $this->Tampilan_model->layar('project/project_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/project'));
        }
    }

    public function create() 
    {
       
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/project/create_action'),
    	    'id' => set_value('id'),
    	    'project' => set_value('project'),
    	    'description' => set_value('description'),
    	    'file' => set_value('file'),
	    );
        // var_dump($this->active);
        $this->Tampilan_model->layar('project/project_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $user_id = $this->session->userdata('user_id');
		$kantor_id = $this->db->select('id_kantor')
					->from('users')
					->where('id',$user_id)
					->get()
					->row();

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            if (!empty($_FILES['file']['name'])) {

                $config['upload_path'] = './assets/project/file';
                $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx|xls|xlsx|jpg|jpeg|png|zip|rar';
                $config['max_size'] = '2048';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                
                
                if (!$this->upload->do_upload('file')) {
                    
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->create();
                    
                
                } else {
                    $file = $this->upload->data('file_name');
                               $data = array(
                                'project'       => $this->input->post('project',TRUE),
                                'description'   => $this->input->post('description',TRUE),
                                'file' => $file,
                                'id_kantor'   => $kantor_id->id_kantor,
                            );


                }

            }else{
                $data = array(
                        'project'       => $this->input->post('project',TRUE),
                        'description'   => $this->input->post('description',TRUE),
                        'id_kantor'   => $kantor_id->id_kantor,
                    );
            }



        //   

            $this->Project_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/project'));
            // echo "3";
        }
    }
    
    public function update($id) 
    {
        $row = $this->Project_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/project/update_action'),
        		'id' => set_value('id', $row->id),
        		'project' => set_value('project', $row->project),
        		'description' => set_value('description', $row->description),
        		'file' => set_value('file', $row->file),
	    );
            $this->Tampilan_model->layar('project/project_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/project'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));

        } else {

            if (!empty($_FILES['file']['name'])) {

                $config['upload_path'] = './assets/project/file';
                $config['allowed_types'] = 'pdf|doc|docx|ppt|pptx|xls|xlsx|jpg|jpeg|png|zip|rar';
                $config['max_size'] = '2048';
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->create();
                    
                
                } else {
                   $files=$this->db->select('file')
                    ->from('project')
                    ->where('id',$this->input->post('id'))
                    ->get()
                    ->row();

                    if(file_exists('./assets/project/file/'.$files->file))
                        unlink('./assets/project/file/'.$files->file
                        );
                    
                $file = $this->upload->data('file_name');
                    $data = array(
                    'project' => $this->input->post('project',TRUE),
                    'description' => $this->input->post('description',TRUE),
                    'file' => $file,
                    );
                        

                }

            }else{

                $data = array(
                    'project' => $this->input->post('project',TRUE),
                    'description' => $this->input->post('description',TRUE),
                    
                );
        

            }

         
            $this->Project_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/project'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Project_model->get_by_id($id);

       

        if ($row) {

            if(file_exists('./assets/project/file/'.$row->file))
            unlink('./assets/project/file/'.$row->file
            );


            $this->Project_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/project'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/project'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('project', 'project', 'trim|required');
	$this->form_validation->set_rules('description', 'description', 'trim|required');
	$this->form_validation->set_rules('file', 'file', 'trim');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Project.php */
/* Location: ./application/controllers/Project.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-09-01 05:26:36 */
/* http://harviacode.com */