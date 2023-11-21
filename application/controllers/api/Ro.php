<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
    }

    public function get_address()
    {
        $this->api->head();
        $query = $this->input->post('query');
        $data_address = $this->db->where('LOWER(address) LIKE "%' . strtolower($query) . '%"')->limit(10)->get('ro_address')->result();
        $this->api->result("ok", $data_address, "Data Alamat");
    }

    public function get_provinces()
    {
        $this->api->head();
        $data_provinces = $this->db->get('ro_provinces')->result();
        $this->api->result("ok", $data_provinces, "Data Provinsi");
    }

    public function get_cities()
    {
        $this->api->head();
        $this->form_validation->set_rules('province_id', 'ID Provinsi', 'trim|required');
        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }
        $province_id = $this->input->post('province_id');
        $data = $this->db->where('province_id', $province_id)->get('ro_cities')->result();
        $this->api->result("ok", $data, "Data Kota");
    }

    public function get_subdistricts()
    {
        $this->api->head('application/json', false);
        $this->form_validation->set_rules('city_id', 'ID Kota', 'trim|required');
        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }
        $city_id = $this->input->post('city_id');
        $data = $this->db->where('city_id', $city_id)->get('ro_subdistricts')->result();
        $this->api->result("ok", $data, "Data Kecamatan");
    }
}
