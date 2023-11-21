<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal_monitor extends CI_Controller
{

    public $active = array('active_utilities' => 'active_jadwal_monitor');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Jadwal_monitor_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = [
            'url' => site_url('admin/jadwal_monitor/upsert'),
            'data_jadwal' => $this->Jadwal_monitor_model->get_all(),
        ];
        // var_dump($data);
        $this->Tampilan_model->layar('jadwal_monitor/jadwal_monitor_list', $data, $this->active);
    }

    public function upsert()
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

                $cekIdKantor= $this->db->select('id_kantor')
                                ->from('jadwal_monitor')
                                ->where('id_kantor',$kantor_id->id_kantor)
                                ->get()
                                ->row();


                
        $id = $this->input->post('id');
        $indeks = $this->input->post('indeks');
        if($cekIdKantor!=null){
            foreach ($indeks as $key => $idx) :
                $jam = $this->input->post('jam')[$key];
                $indx = $this->input->post('indeks')[$key];
                $status = $this->input->post('status')[$key];
    
                // $row = $this->Jadwal_monitor_model->get_by_indeks($idx);
                $row = $this->Jadwal_monitor_model->get_by_id($id[$key]);
                // $row = $this->Jadwal_monitor_model->get_by_id_kantor($cekIdKantor->id_kantor);
                $data_upsert = [
                    // 'indeks' =>  $indx,
                    'jam' => $jam,
                    'status' => $status,
                    'id_kantor' => $kantor_id->id_kantor,
                ];
                if ($row) {
                        $this->Jadwal_monitor_model->update($row->id,  $data_upsert);
                        // var_dump($row);
                    } else {
                            // $this->Jadwal_monitor_model->insert($data_upsert);
                        }
                // var_dump($row);
             endforeach;

        }else{
        
             foreach ($indeks as $key => $idx) :
                $jam = $this->input->post('jam')[$key];
                $status = $this->input->post('status')[$key];
    
                $data_upsert = [
                    'indeks' => $idx,
                    'jam' => $jam,
                    'status' => $status,
                    'id_kantor' => $kantor_id->id_kantor,
                ];
              
                            $this->Jadwal_monitor_model->insert($data_upsert);
                      
             endforeach;
        }
// 
        // var_dump($id);
                
        $this->session->set_flashdata('message', 'Simpan jadwal berhasil');
        redirect(site_url('admin/jadwal_monitor'));
    }
}
