<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitor_layar_model extends CI_Model
{

    private $PREFIX_SCREENSHOT_FILE         = 'SCREENSHOT';
    private $DIRECTORY_SAVING_SCREENSHOT    = 'assets/screensharing/';

    function __construct()
    {
        parent::__construct();
        $this->load->library('firebase');
    }

    function preview_request_screen($id, $date)
    {
        $filename = $this->generate_filename($id, $date);
        return [
            'url' => site_url($this->DIRECTORY_SAVING_SCREENSHOT . $filename),
            'exists' => file_exists($this->DIRECTORY_SAVING_SCREENSHOT . $filename) ? "1" : "0",
        ];
    }

    function generate_filename($id, $date, $prefix = '')
    {
        return $prefix . $this->PREFIX_SCREENSHOT_FILE . '_' . $id . '_' . $date . '.png';
    }

    function ping_service($id)
    {
        $data = [
            'request_name' => 'ping',
            'date' => date('YmdHis'),
        ];
        return $this->send_message($id, $data);
    }

    function get_files_db($id = NULL, $limit = NULL, $page = NULL, $start_date = NULL, $end_date = NULL)
    {
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('LEFT(tgl,10) BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
        }
        $total_items = $this->db->where('id_user', $id)->get('layar_perangkat')->num_rows();
        if (empty($page)) {
            $page = 1;
        }
        if (empty($limit)) {
            $limit = 3;
        }
        $start = ($page * $limit) - $limit;
        $total_page = ceil($total_items / $limit);
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('LEFT(tgl,10) BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
        }
        $data = $this->db->where('id_user', $id)->limit($limit)->offset($start)->order_by('tgl', 'desc')->get('layar_perangkat')->result();
        $data = [
            'total_items' => $total_items,
            'total_page' => $total_page,
            'page' => $page,
            'data' => $data,
        ];
        return $data;
    }

    function get_files_screenshot($id = NULL, $limit = NULL, $page = NULL)
    {
        $prefix_filename = $this->PREFIX_SCREENSHOT_FILE;
        if (!empty($id)) {
            $prefix_filename .= '_' . $id;
        }
        $files = preg_grep('~^' . $prefix_filename . '_.*\.png$~', scandir($this->DIRECTORY_SAVING_SCREENSHOT));
        rsort($files);

        $total_items = count($files);

        if (empty($page)) {
            $page = 1;
        }

        $start = 0;
        $total_page = 1;

        if (!empty($limit)) {
            $start = ($page * $limit) - $limit;
            $total_page = ceil($total_items / $limit);
            $data = array_slice($files, $start, $limit);
        } else {
            $data = $files;
        }

        $data = [
            'total_items' => $total_items,
            'total_page' => $total_page,
            'page' => $page,
            'data' => $data,
        ];
        return $data;
    }

    function save_image($id, $date, $name_upload, $prefix = '')
    {
        $filename = $this->generate_filename($id, $date, $prefix);
        $config['upload_path'] = $this->DIRECTORY_SAVING_SCREENSHOT;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']  = '5000';
        $config['max_width']  = '6024';
        $config['max_height']  = '5768';
        $config['encrypt_name'] = FALSE;
        $config['file_name'] = $filename;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($name_upload)) {
            // $data = $this->upload->data();
            $t = substr($date, 0, 4);
            $b = substr($date, 4, 2);
            $h = substr($date, 6, 2);
            $j = substr($date, 8, 2);
            $m = substr($date, 10, 2);
            $d = substr($date, 12, 2);
            $tgl = $t . '-' . $b . '-' . $h . ' ' . $j . ':' . $m . ':' . $d;
            $this->db->insert('layar_perangkat', [
                'id_user' => $id,
                'tgl' => $tgl,
                'nama_file' => $filename,
            ]);
            return $filename;
        } else {
            // $error = $this->upload->display_errors();
            return false;
        }
    }

    function save_base64_image($id, $date, $base64str)
    {
        $this->load->helper('file');
        $filename = $this->generate_filename($id, $date);
        $screen_base = str_replace('data:image/png;base64,', '', $base64str);
        $screen_base = str_replace(' ', '+', $screen_base);
        $data = base64_decode($screen_base);
        if (!write_file('./' . $this->DIRECTORY_SAVING_SCREENSHOT . $filename, $data)) {
            return false;
        } else {
            $t = substr($date, 0, 4);
            $b = substr($date, 4, 2);
            $h = substr($date, 6, 2);
            $j = substr($date, 8, 2);
            $m = substr($date, 10, 2);
            $d = substr($date, 12, 2);
            $tgl = $t . '-' . $b . '-' . $h . ' ' . $j . ':' . $m . ':' . $d;
            $this->db->insert('layar_perangkat', [
                'id_user' => $id,
                'tgl' => $tgl,
                'nama_file' => $filename,
            ]);
            return $filename;
        }
    }

    function send_request_screen($id, $is_auto = false, $job_id_scheduler = NULL)
    {
        $dt = date('YmdHis');
        $data = [
            'request_name' => 'screen_capture',
            'date' => $dt,
            'auto' => $is_auto ? 'auto' : '',
            'job_id_scheduler' => !empty($job_id_scheduler) ? $job_id_scheduler : "",
        ];
        $r = $this->send_message($id, $data);
        if (!empty($r)) {
            return [
                'data' => $r,
                'id' => $id,
                'date' => $dt,
            ];
        } else {
            return null;
        }
    }

    function send_message($id, $data = [])
    {
        $row = $this->get_user_by_id($id);
        if (!$row) {
            return false;
        }
        if (empty($row->fcm_token)) {
            return false;
        }
        return $this->firebase->sendData($row->fcm_token, $data);
    }

    // datatables
    function json($tgl = NULL)
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
                ->from('users')
                ->where('id',$user_id)
                ->get()
                ->row();

        $this->datatables->select('p.id, p.id_users, p.nama_pegawai, p.tgl_masuk, p.rekening, p.level, p.gaji_pokok, l.level AS nm_level, t.tingkat, pj.jabatan, p.wfh, p.hybrid, u.id AS id_user');
        $this->datatables->from('pegawai AS p');
        $this->datatables->join('pil_level AS l', 'p.level = l.id', 'left');
        $this->datatables->join('pil_jabatan AS pj', 'p.id_jabatan = pj.id', 'left');
        $this->datatables->join('pil_tingkat AS t', 'p.tingkat = t.id', 'left');
        $this->datatables->join('users u', 'p.id_users = u.id', 'left');
        $this->datatables->join('status_kerja sk', 'u.id=sk.id_user', 'left');
        $this->datatables->where('u.active', 1);
        $this->datatables->where('(u.fcm_token IS NOT NULL OR u.fcm_token != "")');
        $this->datatables->where('u.id_kantor', $kantor_id->id_kantor);
        return $this->datatables->generate();
    }

    function get_user_by_id($id)
    {
        return $this->db->where('id', $id)->get('users')->row();
    }

    function get_by_id($id)
    {
        return $this->db->where('id', $id)->get('pegawai')->row();
    }

    function get_by_id_user($id)
    {
        return $this->db->where('id_users', $id)->get('pegawai')->row();
    }
}
