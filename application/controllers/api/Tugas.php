<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tugas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model', 'api');
        $this->load->library('form_validation');
    }

    public function upload_tugas2()
    {
        $this->api->head();

        $nama_file = "";
        if (!empty($_FILES['lampiran']['name'])) {
            $config['upload_path'] = 'assets/tugas/upload2';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '8000';
            $this->load->library("upload", $config);
            if (!$this->upload->do_upload('lampiran')) {
                $this->api->result('error', $this->upload->display_errors(), "Lampiran gagal diupload");
                return;
            }
            $nama_file = $this->upload->data()['file_name'];
        }

        $this->api->result('ok', [], "Tugas berhasil di ubah");
    }

    public function update_upload_tugas()
    {
        $this->api->head();

        $this->form_validation->set_rules('id', 'ID Upload Tugas', 'trim|required');
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id = $this->input->post("id", true);
        $judul = $this->input->post("judul", true);
        $deskripsi = $this->input->post("deskripsi", true);
        $progress = $this->input->post("progress", true);
        $waktu = $this->input->post("waktu", true);
        $keterangan = $this->input->post("keterangan", true);

        $row_upload = $this->db->where('id', $id)->get('upload_tugas')->row();
        if (!$row_upload) {
            $this->api->result('error', [], "Tidak ada data!");
            return;
        }

        $nama_file = "";
        if (!empty($_FILES['lampiran']['name'])) {
            $config['upload_path'] = 'assets/tugas/upload';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '3000';
            $this->load->library("upload", $config);
            if (!$this->upload->do_upload('lampiran')) {
                $this->api->result('error', $this->upload->display_errors(), "Lampiran gagal diupload");
                return;
            }
            $nama_file = $this->upload->data()['file_name'];

            // delete old file
            if (!empty($row_upload->file)) {
                if (file_exists('assets/tugas/upload/' . $row_upload->file)) {
                    unlink('assets/tugas/upload/' . $row_upload->file);
                }
            }
        }

        $data_up = [
            'ket' => $keterangan,
            'waktu' => $waktu,
        ];
        if (!empty($nama_file)) {
            $data_up['file'] = $nama_file;
        }
        $this->db->where('id', $id);
        $this->db->update('upload_tugas', $data_up);

        $data_tugas = array(
            'judul' => $judul,
            'tugas' => $deskripsi,
            'upload' => '1',
            'progress' => $progress,
            'is_update' => 1,
        );
        $this->db->where('id', $row_upload->id_tugas);
        $this->db->update('tugas', $data_tugas);

        $this->api->result('ok', [], "Tugas berhasil di ubah");
    }

    public function get_upload_tugas_by_id()
    {
        $this->api->head();

        $id = $this->input->post("id");

        $this->db->select('ut.*, IF(ut.file IS NOT NULL OR ut.file != "", CONCAT("' . site_url() . 'assets/tugas/upload/",ut.file), "") AS url_file, t.judul, t.tugas, t.progress');
        $this->db->from('upload_tugas ut');
        $this->db->join('tugas t', 'ut.id_tugas=t.id');
        $this->db->where('ut.id', $id);
        $row = $this->db->get()->row();

        $this->api->result('ok', $row, "Data Upload Tugas Tanggungan");
    }

    public function get_upload_tugas_by_id_sample()
    {
        $this->api->head('application/json', false);

        $id = 18;

        $this->db->select('ut.*, IF(ut.file IS NOT NULL OR ut.file != "", CONCAT("' . site_url() . 'assets/tugas/upload/",ut.file), "") AS url_file, t.judul, t.tugas, t.progress');
        $this->db->from('upload_tugas ut');
        $this->db->join('tugas t', 'ut.id_tugas=t.id');
        $this->db->where('ut.id', $id);
        $row = $this->db->get()->row();

        $this->api->result('ok', $row, "Data Upload Tugas Tanggungan");
    }

    public function get_belum_selesai()
    {
        $this->api->head();

        $id_pegawai = $this->input->post("id_pegawai");

        $row = $this->db->where('id_pegawai', $id_pegawai)->where('selesai', 0)->get('tugas')->result();

        if ($row) {
            $this->api->result("ok", $row, "Berhasil mendapatkan tugas.");
        } else {
            print_r($this->db->error());
            $this->api->result("error", [], "Gagal mendapatkan tugas.");
        }
    }


    public function get_tanggungan()
    {
        $this->api->head();

        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id_pegawai = $this->input->post("id_pegawai");

        $this->db->select('*');
        $this->db->from('tugas');
        $this->db->where('id_pegawai', $id_pegawai);
        $this->db->where('tanggungan', 1);
        $this->db->where('selesai!=', 1);
        $this->db->group_by('id');
        $res_tugas = $this->db->get()->result();

        $data = [];
        foreach ($res_tugas as $key) :
            $this->db->select('*');
            $this->db->from('upload_tugas');
            $this->db->where('id_tugas', $key->id);
            $res_up_tugas = $this->db->get()->result();
            $key->list_upload_tugas = $res_up_tugas;
            $data[] = $key;
        endforeach;

        $this->api->result('ok', $data, "List Tugas tanggungan");
    }


    public function susulan()
    {
        $this->api->head();
        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        if (empty($_FILES['lampiran']['name'])) {
            $this->api->result('error', [], "Tidak ada lampiran");
            return;
        }

        $config['upload_path'] = 'assets/tugas/upload';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '3000';
        $this->load->library("upload", $config);
        if (!$this->upload->do_upload('lampiran')) {
            $this->api->result('error', $this->upload->display_errors(), "Lampiran gagal diupload");
            return;
        }

        $id_pegawai = $this->input->post("id_pegawai");
        $judul = $this->input->post("judul");
        $deskripsi = $this->input->post("deskripsi");
        $progress = $this->input->post("progress");
        $keterangan = $this->input->post("keterangan");
        $waktu = $this->input->post("waktu");
        $nama_file = $this->upload->data()['file_name'];

        $data = array(
            'id_pegawai' => $id_pegawai,
            'judul' => $judul,
            'tugas' => $deskripsi,
            'tgl' => date('d-m-Y'),
            'jenis' => 1,
            'upload' => 1,
            'progress' => $progress,
            'is_update' => 1,
        );
        $this->db->insert('tugas', $data);
        $id = $this->db->insert_id();

        $ut = array(
            'id_tugas' => $id,
            'file' => $nama_file,
            'tgl' => date('d-m-Y'),
            'id_pegawai' => $id_pegawai,
            'ket' => $keterangan,
            'waktu' => $waktu,
        );
        $this->db->insert('upload_tugas', $ut);

        $this->api->result('ok', [], "Tugas berhasil diupload");
        return;
    }


    public function edit_upload()
    {
        $this->api->head();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id = $this->input->post("id");

        $this->db->where('id', $id);
        $row = $this->db->get('upload_tugas')->row();
        if (!$row) {
            $this->api->result('error', [], "Tidak ada data!");
        }

        $nama_file = '';
        if (!empty($_FILES['lampiran']['name'])) {
            $config['upload_path'] = 'assets/tugas/upload';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '3000';
            $this->load->library("upload", $config);
            if (!$this->upload->do_upload('lampiran')) {
                $this->api->result('error', $this->upload->display_errors(), "Lampiran gagal diupload");
                return;
            }
            $nama_file = $this->upload->data()['file_name'];

            // delete old file
            if (!empty($row->file)) {
                if (file_exists('assets/tugas/upload/' . $row->file)) {
                    unlink('assets/tugas/upload/' . $row->file);
                }
            }
        }

        $progress = $this->input->post("progress");
        $keterangan = $this->input->post("keterangan");
        $waktu = $this->input->post("waktu");

        $data_up = [
            'tgl' => date('d-m-Y'),
            'ket' => $keterangan,
            'waktu' => $waktu,
        ];
        if (!empty($nama_file)) {
            $data_up['file'] = $nama_file;
        }
        $this->db->where('id', $id);
        $this->db->update('upload_tugas', $data_up);

        $data_tugas = array(
            'upload' => '1',
            'progress' => $progress,
            'is_update' => 1,
        );
        $this->db->where('id', $row->id_tugas);
        $this->db->update('tugas', $data_tugas);

        $this->api->result('ok', [], "Tugas berhasil di ubah");
        return;
    }


    public function delete_upload()
    {
        $this->api->head();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id = $this->input->post("id");

        $this->db->where('id', $id);
        $row = $this->db->get('upload_tugas')->row();
        if (!$row) {
            $this->api->result('error', [], "Tidak ada data!");
        }

        // delete old file
        if (!empty($row->file)) {
            if (file_exists('assets/tugas/upload/' . $row->file)) {
                unlink('assets/tugas/upload/' . $row->file);
            }
        }

        $this->db->where('id', $id);
        $this->db->delete('upload_tugas');

        $this->api->result('ok', [], "Hapus tugas berhasil");
        return;
    }


    public function upload()
    {
        $this->api->head();

        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        if (empty($_FILES['lampiran']['name'])) {
            $this->api->result('error', [], "Tidak ada lampiran");
            return;
        }

        $config['upload_path'] = 'assets/tugas/upload';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '3000';
        $this->load->library("upload", $config);
        if (!$this->upload->do_upload('lampiran')) {
            $this->api->result('error', $this->upload->display_errors(), "Lampiran gagal diupload");
            return;
        }

        $id_pegawai = $this->input->post("id_pegawai");
        $id = $this->input->post("id");
        $progress = $this->input->post("progress");
        $keterangan = $this->input->post("keterangan");
        $waktu = $this->input->post("waktu");
        $nama_file = $this->upload->data()['file_name'];

        $data_tugas = array(
            'upload' => '1',
            'progress' => $progress,
            'is_update' => 1,
        );
        $this->db->where('id', $id);
        $this->db->update('tugas', $data_tugas);

        $ut = array(
            'id_tugas' => $id,
            'file' => $nama_file,
            'tgl' => date('d-m-Y'),
            'id_pegawai' => $id_pegawai,
            'ket' => $keterangan,
            'waktu' => $waktu,
        );
        $this->db->insert('upload_tugas', $ut);

        $this->api->result('ok', [], "Tugas berhasil diupload");
        return;
    }


    public function get_list_upload_now()
    {
        $this->api->head();

        $this->form_validation->set_rules('id_pegawai', 'ID Pegawai', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_error_delimiters('', ',');

        if ($this->form_validation->run() !== TRUE) {
            $this->api->result('error', $this->form_validation->error_array(), validation_errors());
            return;
        }

        $id_pegawai = $this->input->post("id_pegawai");
        $waktu = $this->input->post("waktu");
        if (!empty($this->input->post("tgl"))) {
            $tgl = $this->input->post("tgl");
        } else {
            $tgl = date('d-m-Y');
        }

        $this->db->select('t.*');
        $this->db->from('tugas t');
        $this->db->join('upload_tugas ut', 't.id=ut.id_tugas');
        $this->db->where('t.id_pegawai', $id_pegawai);
        // $this->db->where('t.tanggungan!=', 1);
        $this->db->where('ut.waktu', $waktu);
        $this->db->where('ut.tgl', $tgl);
        $this->db->group_by('t.id');
        $res_tugas = $this->db->get()->result();

        $data = [];
        foreach ($res_tugas as $key) :
            $this->db->select('*, IF(file IS NOT NULL OR file != "", CONCAT("' . site_url() . 'assets/tugas/upload/",file), "") AS url_file');
            $this->db->from('upload_tugas');
            $this->db->where('id_tugas', $key->id);
            $this->db->where('tgl', $tgl);
            $res_up_tugas = $this->db->get()->result();
            $key->list_upload_tugas = $res_up_tugas;
            $data[] = $key;
        endforeach;

        $this->api->result('ok', $data, "List Tugas sudah upload");
    }
}
