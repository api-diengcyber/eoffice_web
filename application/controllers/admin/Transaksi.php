<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public $active = array('active_utilities' => 'active_transaksi');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Transaksi_model');
        $this->load->model('Cpdf_model');
        $this->load->model('Officedata_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
    	$this->load->library('email');
    }

    public function index()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array();
        $this->Tampilan_model->layar('transaksi/transaksi_list', $data, $this->active);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Transaksi_model->json();
    }

    public function json_barang_temp()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Transaksi_model->json_barang_temp();
    }

    public function json_barang_edit($id_transaksi)
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        echo $this->Transaksi_model->json_barang_edit($id_transaksi);
    }

    public function read($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $data = array(
    		'id' => $row->id,
    		'tgl' => $row->tgl,
    		'no_faktur' => $row->no_faktur,
            'harga' => $row->harga,
    		'dp' => $row->dp,
    		'kepada_nama' => $row->kepada_nama,
    		'kepada_hp' => $row->kepada_hp,
            'kepada_alamat' => $row->kepada_alamat,
    		'ket' => $row->ket,
            'data_barang' => $this->db->where('id_transaksi', $row->id)->get('transaksi_barang')->result(),
    	    );
            $this->Tampilan_model->layar('transaksi/transaksi_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/transaksi'));
        }
    }

    private function _faktur()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $digit = 5;
        $row = $this->db->select('RIGHT(no_faktur,'.$digit.') AS no')
                        ->from('transaksi')
                        ->where('SUBSTRING(tgl,1,10) = "'.date('d-m-Y').'"')
                        ->order_by('RIGHT(no_faktur,'.$digit.') DESC')
                        ->get()->row();
        if ($row) {
            $no = $row->no+1;
        } else {
            $no = 1;
        }
        return "DC".date('dmY').sprintf('%0'.$digit.'d', $no);
    }

    public function create()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/transaksi/create_action'),
    	    'id' => set_value('id'),
            'tgl' => set_value('tgl', date('d-m-Y')),
    	    'jam' => set_value('jam', date('H:i:s')),
    	    'no_faktur' => set_value('no_faktur', $this->_faktur()),
    	    'barang' => set_value('barang'),
    	    'harga' => set_value('harga'),
    	    'dp' => set_value('dp'),
    	    'kepada_nama' => set_value('kepada_nama'),
    	    'kepada_hp' => set_value('kepada_hp'),
            'kepada_alamat' => set_value('kepada_alamat'),
    	    'ket' => set_value('ket'),
    	);
        $this->Tampilan_model->layar('transaksi/transaksi_form', $data, $this->active);
    }
    
    public function create_action() 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
    		'tgl' => $this->input->post('tgl',TRUE).' '.$this->input->post('jam',TRUE),
            'no_faktur' => $this->input->post('no_faktur',TRUE),
    		'dp' => str_replace('.','',$this->input->post('dp',TRUE)),
    		'kepada_nama' => $this->input->post('kepada_nama',TRUE),
    		'kepada_hp' => $this->input->post('kepada_hp',TRUE),
            'kepada_alamat' => $this->input->post('kepada_alamat',TRUE),
    		'ket' => $this->input->post('ket',TRUE),
    	    );
            $this->Transaksi_model->insert($data);
            $id_transaksi = $this->db->insert_id();
            $res_temp = $this->db->get('transaksi_barang_temp')->result();
            $total_harga = 0;
            foreach ($res_temp as $key) {
                $data_barang = array(
                    'id_transaksi' => $id_transaksi,
                    'barang' => $key->barang,
                    'harga' => $key->harga,
                    'diskon' => $key->diskon,
                    'jumlah' => $key->jumlah,
                    'total' => $key->total,
                );
                $this->db->insert('transaksi_barang', $data_barang);
                $total_harga += $key->total;
            }
            $data_update = array(
                'harga' => $total_harga,
            );
            $this->db->where('id', $id_transaksi);
            $this->db->update('transaksi', $data_update);
            $this->db->truncate('transaksi_barang_temp');
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/transaksi'));
        }
    }
    
    public function update($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $this->db->where('id_transaksi', $row->id);
            $this->db->delete('transaksi_barang_edit');
            $res_barang = $this->db->where('id_transaksi', $row->id)->get('transaksi_barang')->result();
            foreach ($res_barang as $key) {
                $data_barang = array(
                    'id_transaksi' => $key->id_transaksi,
                    'barang' => $key->barang,
                    'harga' => $key->harga,
                    'diskon' => $key->diskon,
                    'jumlah' => $key->jumlah,
                    'total' => $key->total,
                );
                $this->db->insert('transaksi_barang_edit', $data_barang);
            }
            $tgl = $row->tgl;
            $extgl = explode(" ", $tgl);
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/transaksi/update_action'),
        		'id' => set_value('id', $row->id),
                'tgl' => set_value('tgl', $extgl[0]),
        		'jam' => set_value('jam', (!empty($extgl[1]) ? $extgl[1] : '')),
        		'no_faktur' => set_value('no_faktur', $row->no_faktur),
                'harga' => set_value('harga', $row->harga),
        		'dp' => set_value('dp', $row->dp),
        		'kepada_nama' => set_value('kepada_nama', $row->kepada_nama),
        		'kepada_hp' => set_value('kepada_hp', $row->kepada_hp),
                'kepada_alamat' => set_value('kepada_alamat', $row->kepada_alamat),
        		'ket' => set_value('ket', $row->ket),
        	    );
            $this->Tampilan_model->layar('transaksi/transaksi_form_edit', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/transaksi'));
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
            $id = $this->input->post('id', true);
            $this->db->where('id_transaksi', $id);
            $this->db->delete('transaksi_barang');
            $res_edit = $this->db->where('id_transaksi', $id)->get('transaksi_barang_edit')->result();
            $total_harga = 0;
            foreach ($res_edit as $key) {
                $data_barang = array(
                    'id_transaksi' => $key->id_transaksi,
                    'barang' => $key->barang,
                    'harga' => $key->harga,
                    'diskon' => $key->diskon,
                    'jumlah' => $key->jumlah,
                    'total' => $key->total,
                );
                $this->db->insert('transaksi_barang', $data_barang);
                $total_harga += $key->total;
            }
            $this->db->where('id_transaksi', $id);
            $this->db->delete('transaksi_barang_edit');
            $data = array(
            'tgl' => $this->input->post('tgl',TRUE).' '.$this->input->post('jam',TRUE),
    		'no_faktur' => $this->input->post('no_faktur',TRUE),
            'harga' => $total_harga,
            'dp' => str_replace('.','',$this->input->post('dp',TRUE)),
    		'kepada_nama' => $this->input->post('kepada_nama',TRUE),
    		'kepada_hp' => $this->input->post('kepada_hp',TRUE),
            'kepada_alamat' => $this->input->post('kepada_alamat',TRUE),
    		'ket' => $this->input->post('ket',TRUE),
    	    );
            $this->Transaksi_model->update($this->input->post('id', TRUE), $data, $this->active);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/transaksi'));
        }
    }
    
    public function delete($id) 
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $this->db->where('id_transaksi', $row->id);
            $this->db->delete('transaksi_barang');
            $this->Transaksi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/transaksi'));
        }
    }

    public function _rules() 
    {
    	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
    	$this->form_validation->set_rules('no_faktur', 'no faktur', 'trim|required');
    	$this->form_validation->set_rules('kepada_nama', 'kepada nama', 'trim|required');
    	$this->form_validation->set_rules('kepada_hp', 'kepada hp', 'trim|required');
    	$this->form_validation->set_rules('kepada_alamat', 'kepada alamat', 'trim|required');
        $this->form_validation->set_rules('ket', 'ket', 'trim');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function simpan_barang_temp()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'barang' => $this->input->post('barang', true),
            'harga' => $this->input->post('harga', true),
            'jumlah' => 1,
            'total' => $this->input->post('harga', true),
        );
        $this->db->insert('transaksi_barang_temp', $data);
        echo json_encode($data);
    }

    public function update_barang_temp()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $id = $this->input->post('id', true);
        $row = $this->db->where('id', $id)->get('transaksi_barang_temp')->row();
        if ($row) {
            $diskon = $this->input->post('diskon', true);
            $harga_diskon = $row->harga;
            if ($diskon > 0) {
                $harga_diskon = $row->harga - ($row->harga*($diskon/100));
            }
            $total = $harga_diskon * $this->input->post('jumlah', true);
            $data = array(
                'diskon' => $this->input->post('diskon', true),
                'jumlah' => $this->input->post('jumlah', true),
                'total' => $total,
            );
            $this->db->where('id', $id);
            $this->db->update('transaksi_barang_temp', $data);
        } 
        $d = array('1');
        echo json_encode($d);
    }

    public function hapus_barang_temp()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $id = $this->input->post('id', true);
        $row = $this->db->where('id', $id)->get('transaksi_barang_temp')->row();
        if ($row) {
            $this->db->where('id', $id);
            $this->db->delete('transaksi_barang_temp');
        } 
        $data = array('1');
        echo json_encode($data);
    }

    public function simpan_barang_edit()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $data = array(
            'id_transaksi' => $this->input->post('id', true),
            'barang' => $this->input->post('barang', true),
            'harga' => $this->input->post('harga', true),
            'jumlah' => 1,
            'total' => $this->input->post('harga', true),
        );
        $this->db->insert('transaksi_barang_edit', $data);
        echo json_encode($data);
    }

    public function update_barang_edit()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $id = $this->input->post('id', true);
        $row = $this->db->where('id', $id)->get('transaksi_barang_edit')->row();
        if ($row) {
            $diskon = $this->input->post('diskon', true);
            $harga_diskon = $row->harga;
            if ($diskon > 0) {
                $harga_diskon = $row->harga - ($row->harga*($diskon/100));
            }
            $total = $harga_diskon * $this->input->post('jumlah', true);
            $data = array(
                'diskon' => $this->input->post('diskon', true),
                'jumlah' => $this->input->post('jumlah', true),
                'total' => $total,
            );
            $this->db->where('id', $id);
            $this->db->update('transaksi_barang_edit', $data);
        } 
        $d = array('1');
        echo json_encode($d);
    }

    public function hapus_barang_edit()
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $id = $this->input->post('id', true);
        $row = $this->db->where('id', $id)->get('transaksi_barang_edit')->row();
        if ($row) {
            $this->db->where('id', $id);
            $this->db->delete('transaksi_barang_edit');
        } 
        $data = array('1');
        echo json_encode($data);
    }

    public function barcode($kode)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text' => $kode), array());
    }

    public function barcode_image($kode)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $kode), array())->draw();
        imagepng($imageResource, 'assets/barcode/'.$kode.'.png');
    }

    public function barcode_image_pdf($kode)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $kode), array())->draw();
        imagepng($imageResource, 'assets/pdf/pdf_barcode.png');
    }

    public function invoice_print($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $this->barcode_image($row->no_faktur);
            $data = array(
                'office_alamat' => $this->Officedata_model->office_alamat,
                'office_rek_mandiri' => $this->Officedata_model->office_rek_mandiri,
                'office_rek_bri1' => $this->Officedata_model->office_rek_bri1,
                'office_rek_bri2' => $this->Officedata_model->office_rek_bri2,
                'office_footer_s' => $this->Officedata_model->office_footer_s,
                'onload' => 'print()',
                'no_faktur' => $row->no_faktur,
                'kepada_nama' => $row->kepada_nama,
                'kepada_hp' => $row->kepada_hp,
                'kepada_alamat' => $row->kepada_alamat,
                'ket' => $row->ket,
                'harga' => $row->harga,
                'dp' => $row->dp,
                'data_barang' => $this->db->where('id_transaksi', $row->id)->get('transaksi_barang')->result(),
            );
            $this->load->view('admin/transaksi/invoice', $data);
        } else {
            redirect(site_url('admin/transaksi'));
        }
    }

    public function invoice_email()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $id = $this->input->post('id', true);
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $this->barcode_image($row->no_faktur);
            $email = $this->input->post('email', true);
            $data = array(
                'office_alamat' => $this->Officedata_model->office_alamat,
                'office_rek_mandiri' => $this->Officedata_model->office_rek_mandiri,
                'office_rek_bri1' => $this->Officedata_model->office_rek_bri1,
                'office_rek_bri2' => $this->Officedata_model->office_rek_bri2,
                'office_footer_s' => $this->Officedata_model->office_footer_s,
                'onload' => '',
                'no_faktur' => $row->no_faktur,
                'kepada_nama' => $row->kepada_nama,
                'kepada_hp' => $row->kepada_hp,
                'kepada_alamat' => $row->kepada_alamat,
                'ket' => $row->ket,
                'harga' => $row->harga,
                'dp' => $row->dp,
                'data_barang' => $this->db->where('id_transaksi', $row->id)->get('transaksi_barang')->result(),
            );
            $this->load->library('email');
            $message = $this->load->view('admin/transaksi/invoice', $data, true);
            $this->email->clear();
            $this->email->from('support@diengcyber.com', 'diengcyber.com');
            $this->email->to($email);
            $this->email->subject('INVOICE '.$row->no_faktur);
            $this->email->set_mailtype('html');
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('message', 'Berhasil mengirim email ke '.$email.'');
            } else {
                $this->session->set_flashdata('message', 'Gagal kirim email');
            }
            redirect(site_url('admin/transaksi'));
        } else {
            redirect(site_url('admin/transaksi'));
        }
    }

    public function invoice_pdf($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->Tampilan_model->admin();
        $row = $this->Transaksi_model->get_by_id($id);
        if ($row) {
            $this->barcode_image($row->no_faktur);
            $data = array(
                'office_alamat' => $this->Officedata_model->office_alamat,
                'office_rek_mandiri' => $this->Officedata_model->office_rek_mandiri,
                'office_rek_bri1' => $this->Officedata_model->office_rek_bri1,
                'office_rek_bri2' => $this->Officedata_model->office_rek_bri2,
                'office_footer_s' => $this->Officedata_model->office_footer_s,
                'onload' => '',
                'no_faktur' => $row->no_faktur,
                'kepada_nama' => $row->kepada_nama,
                'kepada_hp' => $row->kepada_hp,
                'kepada_alamat' => $row->kepada_alamat,
                'ket' => $row->ket,
                'harga' => $row->harga,
                'dp' => $row->dp,
                'data_barang' => $this->db->where('id_transaksi', $row->id)->get('transaksi_barang')->result(),
            );
            $content = $this->load->view('admin/transaksi/invoice_pdf', $data, true);
            $this->Cpdf_model->generating_pdf($row->no_faktur, $row->no_faktur.'.pdf', $content);
            echo '<script>document.location.href="'.base_url().'assets/pdf/'.$row->no_faktur.'.pdf";setTimeout(function(){window.close()}, 1000);</script>';
        } else {
            redirect(site_url('admin/transaksi'));
        }
    }

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-02-21 01:51:51 */
/* http://harviacode.com */