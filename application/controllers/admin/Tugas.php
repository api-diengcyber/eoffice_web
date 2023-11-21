<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tugas extends CI_Controller
{

    public $active = array('active_utilities' => 'active_tugas');

    function __construct()
    {
        parent::__construct();
        $this->load->model('Tampilan_model');
        $this->load->model('Tugas_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Officedata_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->Tampilan_model->admin();
    }

    public function index()
    {
      
        $data_login = $this->Tampilan_model->cek_login();

        $id_pegawai = 'semua';
        $bulan = date('m');
        $tahun = date('Y');
        $status = 'semua';

        if (!empty($this->input->post('id_pegawai', TRUE))) {
            $id_pegawai = $this->input->post('id_pegawai', TRUE);
        }
        if (!empty($this->input->post('bulan', TRUE))) {
            $bulan = $this->input->post('bulan', TRUE);
        }
        if (!empty($this->input->post('tahun', TRUE))) {
            $tahun = $this->input->post('tahun', TRUE);
        }
        if (!empty($this->input->post('status', TRUE))) {
            $status = $this->input->post('status');
        }

        $data = array(
            'id_pegawai' => $id_pegawai,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status,
            'data_pegawai' => $this->Pegawai_model->get_pegawai_aktif(),
            'data_tahun' => $this->db->group_by('tahun')->get('hari_kerja')->result(),
            'data_bulan' => $this->db->get('bulan')->result(),
        );

        $this->Tampilan_model->layar('tugas/tugas_list', $data, $this->active);
    }

    public function get_tugas_files()
    {
        header('Content-Type: application/json');

        $id = $this->input->post('id');
        $limit = $this->input->post('limit');
        $page = $this->input->post('page');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (!empty($id) && $id != "SEMUA") {
            $this->db->where('id_pegawai', $id);
        }
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
        }
        $total_items = $this->db->get('upload_tugas')->num_rows();
        if (empty($page)) {
            $page = 1;
        }
        if (empty($limit)) {
            $limit = 3;
        }

        $start = ($page * $limit) - $limit;
        $total_page = ceil($total_items / $limit);

        if (!empty($id) && $id != "SEMUA") {
            $this->db->where('id_pegawai', $id);
        }
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('DATE(CONCAT(SUBSTRING(tgl,7,4),"-",SUBSTRING(tgl,4,2),"-",SUBSTRING(tgl,1,2))) BETWEEN "' . $start_date . '" AND "' . $end_date . '"');
        }
        $this->db->limit($limit);
        $this->db->offset($start);
        $this->db->order_by('tgl', 'desc');
        $res = $this->db->get('upload_tugas')->result();

        $data = [
            'total_items' => $total_items,
            'total_page' => $total_page,
            'page' => $page,
            'data' => $res,
        ];
        echo json_encode([
            'dir' => site_url('assets/tugas/upload'),
            'files' => $data,
        ]);
    }

    public function galeri($id_pegawai = '', $start = '', $end = '')
    {
        $exstart = explode("-", $start);
        $start_h = $exstart[0];
        $start_m = !empty($exstart[1]) ? $exstart[1] : date('m');
        $start_y = !empty($exstart[2]) ? $exstart[2] : date('Y');
        $zstart = $start_y . "-" . $start_m . "-" . $start_h;
        $exend = explode("-", $end);
        $end_h = $exend[0];
        $end_m = !empty($exend[1]) ? $exend[1] : date('m');
        $end_y = !empty($exend[2]) ? $exend[2] : date('Y');
        $zend = $end_y . "-" . $end_m . "-" . $end_h;

        $nama_pegawai = 'SEMUA';
        if (!empty($id_pegawai) && $id_pegawai != 'SEMUA') {
            $row = $this->Pegawai_model->get_by_id($id_pegawai);
            if ($row) {
                $nama_pegawai = $row->nama_pegawai;
            }
        }

        $pstart = $this->input->post('start');
        $pend = $this->input->post('end');

        $pzstart = $zstart;
        $pzend = $zend;
        if (!empty($pstart)) {
            $pzstart = $pstart;
        }
        if (!empty($pend)) {
            $pzend = $pend;
        }

        $data = [
            'id_pegawai' => $id_pegawai,
            'nama_pegawai' => $nama_pegawai,
            'start' => $pzstart,
            'end' => $pzend,
        ];

        $this->Tampilan_model->layar('tugas/galeri', $data, $this->active);
    }

    // public function laporan_harian(){
    //     $this->active = array('active_utilities'=>'active_laporan_harian');
    //     $this->load->model('Laporan_model');
    //     $tahun = $this->input->post('tahun');
    //     if(empty($tahun)){
    //         $tahun = date('Y');
    //     }
    //     $bulan = $this->input->post('bulan');
    //     if(empty($bulan)){
    //         $bulan = date('m');
    //     }
    //     $hari  = $this->input->post('hari');
    //     if(empty($hari)){
    //         $hari = date('d');
    //     }
    //     if($hari == 'SEMUA'){
    //         $hari = 'semua';
    //     }
    //     $id_pegawai = $this->input->post('id_pegawai');
    //     echo '<h1>'.$id_pegawai.'</h1>';
    //     $data['data_tahun'] = $this->db->group_by('tahun')->get('hari_kerja')->result();
    //     $data['data_bulan'] = $this->db->get('bulan')->result();
    //     $data['data_pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
    //     $data['data_hari']  = $this->db->where('tahun', $tahun)->where('bulan',$bulan)->get('hari_kerja')->row();
    //     $data['hari']  = $hari;
    //     $data['id_pegawai'] = $id_pegawai;
    //     $data['tahun'] = $tahun;
    //     $data['bulan'] = $bulan;
    //     $data['laporan'] = $this->Laporan_model->get_laporan_harian($tahun,$bulan,$hari,$id_pegawai);
    //     $this->Tampilan_model->layar('tugas/laporan_harian',$data,$this->active);
    // }
    public function laporan_harian()
    {
        $this->active = array('active_utilities'=>'active_laporan_harian');
        $this->load->model('Laporan_model');
        $start = date('d-m-Y');
        if (!empty($this->input->post('start', true))) {
            $start = $this->input->post('start', true);
        }
        $end = date('t-m-Y');
        if (!empty($this->input->post('end', true))) {
            $end = $this->input->post('end', true);
        }
        if (!empty($this->input->post('id_pegawai', true))) {
            $id_pegawai = $this->input->post('id_pegawai', true);
            $data['id_pegawai'] = $id_pegawai;
        } else {
            $id_pegawai = "SEMUA";
            $data['id_pegawai'] = $id_pegawai;
        }
        $data['data_pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['laporan'] = $this->Laporan_model->get_laporan_periode($id_pegawai, $start, $end);

        $this->Tampilan_model->layar('tugas/laporan_harian_new', $data,$this->active);
    }

    public function export_harian($id_pegawai = '', $tahun = '', $bulan = '', $hari = '')
    {
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=laporan_harian_" . date('d-m-Y') . ".xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        if (empty($tahun)) {
            $tahun = date('Y');
        }
        if (empty($bulan)) {
            $bulan = date('m');
        }
        if (empty($hari)) {
            $hari = date('d');
        }
        $this->load->model('Laporan_model');
        $data['laporan'] = $this->Laporan_model->get_laporan_harian($tahun, $bulan, $hari, $id_pegawai);
        $view = $this->load->view('admin/tugas/export_harian', $data, TRUE);
        echo $view;
        exit;
    }
    public function json($id_pegawai = '', $bulan = '', $tahun = '', $status = '')
    {
        header('Content-Type: application/json');
        $data_login = $this->Tampilan_model->cek_login();
        echo $this->Tugas_model->json($id_pegawai, $bulan, $tahun, $status);
    }

    public function read($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->db->select('t.*, u.username')
            ->from('tugas t')
            ->join('pegawai as p', 'p.id=t.id_pegawai')
            ->join('users u', 'p.id_users=u.id')
            ->where('t.id', $id)
            ->get()->row();
        if ($row) {
            $data_t = array('is_update' => 0);
            $this->db->update('tugas', $data_t);
            $data = array(
                'id' => $row->id,
                'tgl' => $row->tgl,
                'tugas' => $row->tugas,
                'file_tugas' => $row->file_tugas,
                'tgl_selesai' => $row->tgl_selesai,
                'upload' => $row->upload,
                'selesai' => $row->selesai,
                'username' => $row->username,
                'data_upload' => $this->db->where('id_tugas', $row->id)->get('upload_tugas')->result(),
                'progress' => $row->progress,
            );
            $this->Tampilan_model->layar('tugas/tugas_read', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tugas'));
        }
    }

    public function create()
    {
        $this->load->model('Project_model');
        $data_login = $this->Tampilan_model->cek_login();
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/tugas/create_action'),
            'id' => set_value('id'),
            'tgl' => set_value('tgl', date('d-m-Y')),
            'id_pegawai' => set_value('id_pegawai'),
            'tugas' => set_value('tugas'),
            'tgl_selesai' => set_value('tgl_selesai', date('d-m-Y')),
            'selesai' => set_value('selesai', '0'),
            'data_pegawai' => $this->Pegawai_model->get_pegawai_aktif(),
            'project' => $this->Project_model->get_all(),
            'id_project' => '',
            'judul' => '',
        );
        $this->Tampilan_model->layar('tugas/tugas_form', $data, $this->active);
    }

    public function create_action()
    {
        $notif = '';
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $this->load->model('Tasks_model');

            $config['upload_path'] = 'assets/tugas/';
            $config['allowed_types'] = 'gif|jpg|png|rar|zip|txt|xls|xlsx|doc|docx|css|php';
            $config['max_size']  = '2000';
            $config['max_width']  = '2024';
            $config['max_height']  = '2068';

            $this->load->library('upload', $config);

            $nm_file_tugas = "";
            if (!$this->upload->do_upload('file_tugas')) { } else {
                $file_tugas = $this->upload->data();
                $nm_file_tugas = $file_tugas['file_name'];
            }

            $id_pegawai = $this->input->post('id_pegawai', TRUE);
            $row_tugas = $this->db->order_by('priority', 'desc')->get('tugas')->row();
            $priority = 1;
            if (!empty($row_tugas)) {
                $priority = $row_tugas->priority + $priority;
            }
            $id_project = $this->input->post('id_project', TRUE);
            for ($i = 0; $i < count($id_pegawai); $i++) {
                $data = array(
                    'tgl' => $this->rDate($this->input->post('tgl', TRUE)),
                    'id_pegawai' => $id_pegawai[$i],
                    'tugas' => $this->input->post('tugas', TRUE),
                    'file_tugas' => $nm_file_tugas,
                    'tgl_selesai' => $this->input->post('tgl_selesai', TRUE),
                    'selesai' => $this->input->post('selesai', TRUE),
                    'id_project' => $id_project,
                    'judul' => $this->input->post('judul', TRUE),
                    'priority' => $priority,

                );
                $this->Tugas_model->insert($data);
                $id_tugas = $this->db->insert_id();

                // insert tasks
                $id_task = $this->Tasks_model->insert([
                    'id_project' => $id_project,
                    'date_created' => $this->rSDate($this->input->post('tgl', TRUE)),
                    'task' => $this->input->post('judul', TRUE),
                    'description' => $this->input->post('tugas', TRUE),
                    'id_status' => 1,
                ]);

                $row_pegawai = $this->db->where('id', $id_pegawai[$i])->get('pegawai')->row();

                $this->db->insert('tasks_detail', [
                    'id_task' => $id_task,
                    'id_user' => $row_pegawai->id_users,
                    'date_created' => date('Y-m-d H:i:s'),
                    'message' => 'Task status created',
                    'task_status' => 2,
                    'type' => '2',
                ]);

                //notification system
                $data_notif = array(
                    'users_id_pegawai' => $id_pegawai[$i],
                    'message' => strip_tags($this->input->post('tugas')),
                    'title' => 'Ada tugas baru ' . $this->input->post('judul'),
                    'img' => site_url('assets/images/logo-mini.png'),
                    'id_tugas' => $id_tugas,
                );
                $this->load->model('Notification_model');
                $notif = $this->Notification_model->send($data_notif);
            }
            $this->session->set_flashdata('message', 'Create Record Success');



            redirect(site_url('admin/tugas'));
        }
    }
    public function test()
    {
        $message = 'asd';
        $user_id = '18';
        $url = site_url();
        $headings = 'Ada tugas baru';
        $img = '';

        $content = array(
            "en" => "$message"
        );
        $headings = array(
            "en" => "$headings"
        );

        $fields = array(
            'app_id' => APPID,
            'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
            'url' => $url,
            'contents' => $content,
            'chrome_web_icon' => $img,
            'headings' => $headings
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . APKEY
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function prints2($id_pegawai = '', $start = '', $end = '')
    {
        $exstart = explode("-", $start);
        $start_h = $exstart[0];
        $start_m = !empty($exstart[1]) ? $exstart[1] : date('m');
        $start_y = !empty($exstart[2]) ? $exstart[2] : date('Y');
        $zstart = $start_y . "-" . $start_m . "-" . $start_h;
        $exend = explode("-", $end);
        $end_h = $exend[0];
        $end_m = !empty($exend[1]) ? $exend[1] : date('m');
        $end_y = !empty($exend[2]) ? $exend[2] : date('Y');
        $zend = $end_y . "-" . $end_m . "-" . $end_h;
        $this->load->model('Laporan_model');
        $data['office_alamat'] = $this->Officedata_model->office_alamat;
        $data['start'] = $start;
        $data['end'] = $end;
        $data['start_m'] = $start_m;
        $data['end_m'] = $end_m;
        $data['start_y'] = $start_y;
        $data['end_y'] = $end_y;
        $data['laporan'] = $this->Laporan_model->get_laporan_periode($id_pegawai, $start, $end);
        $this->load->view('admin/tugas/export_harian_new', $data);
        //echo "<script>window.print();</script>";
    }
    public function update($id)
    {
        $this->load->model('Project_model');
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tugas_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/tugas/update_action'),
                'id' => set_value('id', $row->id),
                'tgl' => set_value('tgl', $row->tgl),
                'id_pegawai' => set_value('id_pegawai', $row->id_pegawai),
                'tugas' => set_value('tugas', $row->tugas),
                'tgl_selesai' => set_value('tgl_selesai', $row->tgl_selesai),
                'selesai' => set_value('selesai', $row->selesai),
                'data_pegawai' => $this->Pegawai_model->get_pegawai_aktif(),
                'id_project' => set_value('id_project', $row->id_project),
                'project' => $this->Project_model->get_all(),
                'judul' => set_value('judul', $row->judul),
                'data_tugas' => $row,
            );
            $this->Tampilan_model->layar('tugas/tugas_form', $data, $this->active);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tugas'));
        }
    }

    public function update_action()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {

            $config['upload_path'] = 'assets/tugas/';
            $config['allowed_types'] = 'gif|jpg|png|rar|zip|txt|xls|xlsx|doc|docx|css|php';
            $config['max_size']  = '2000';
            $config['max_width']  = '2024';
            $config['max_height']  = '2068';

            $this->load->library('upload', $config);

            $nm_file_tugas = "";
            if (!$this->upload->do_upload('file_tugas')) { } else {
                $file_tugas = $this->upload->data();
                $nm_file_tugas = $file_tugas['file_name'];
            }

            $data = array(
                'tgl' => $this->rDate($this->input->post('tgl', TRUE)),
                'id_pegawai' => $this->input->post('id_pegawai', TRUE),
                'tugas' => $this->input->post('tugas', TRUE),
                'file_tugas' => $nm_file_tugas,
                'tgl_selesai' => $this->input->post('tgl_selesai', TRUE),
                'selesai' => $this->input->post('selesai', TRUE),
                'id_project' => $this->input->post('id_project', TRUE),
                'judul' => $this->input->post('judul'),

            );

            $this->Tugas_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/tugas'));
        }
    }
    public function rekap()
    {
        $data_login = $this->Tampilan_model->cek_login();
        $tahun = $this->input->post('tahun');
        if (empty($tahun)) {
            $tahun = date('Y');
        }
        $bulan = $this->input->post('bulan');
        if (empty($bulan)) {
            $bulan = date('m');
        }
        $hari  = $this->input->post('hari');
        if (empty($hari)) {
            $hari = 'semua';
        }
        $id_pegawai = $this->input->post('id_pegawai');
        $data['data_tugas'] = $this->Tugas_model->get_rekap_tugas($tahun, $bulan, $hari, $id_pegawai);
        $data['data_tahun'] = $this->db->group_by('tahun')->get('hari_kerja')->result();
        $data['data_bulan'] = $this->db->get('bulan')->result();
        $data['data_pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $data['data_hari']  = $this->db->where('tahun', $tahun)->where('bulan', $bulan)->get('hari_kerja')->row();
        $data['hari']  = $hari;
        $data['id_pegawai'] = $id_pegawai;
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $this->Tampilan_model->layar('tugas/rekap_tugas', $data, $this->active);
    }
    public function cetak_rekap($tahun = '', $bulan = '', $hari = '', $id_pegawai = '')
    {
        $data['data_tugas'] = $this->Tugas_model->get_rekap_tugas($tahun, $bulan, $hari, $id_pegawai);
        $this->load->view('admin/tugas/cetak_rekap', $data);
    }
    public function priority()
    {
        $this->load->model('Pegawai_model');
        $data_login = $this->Tampilan_model->cek_login();

        $data['id'] = '';
        $data['tugas'] = array();
        if (isset($_POST['id_pegawai'])) {
            $data['id'] = $this->input->post('id_pegawai');
            $data['tugas'] = $this->Tugas_model->get_by_peg($this->input->post('id_pegawai'));
        }

        $data['pegawai'] = $this->Pegawai_model->get_pegawai_aktif();
        $this->Tampilan_model->layar('tugas/tugas_priority', $data, $this->active);
    }
    function set_priority()
    {
        $id   = $this->input->post('id');
        $sort = $this->input->post('item');
        if (!empty($sort)) {
            $i = 0;
            $result = $this->Tugas_model->get_by_peg($id);
            $b = count($result);
            foreach ($result as $row) {
                $id = $row->id;
                $this->db->where('id', $sort[$i]);
                $data = array('priority' => $b);
                $this->db->update('tugas', $data);
                //echo $sort[$i];
                $i++;
                $b--;
            }
        }
    }
    public function reply_message()
    {
        $id = $this->input->post('id_tugas');
        $data = array(
            'id_upload_tugas' => $this->input->post('id_upload_tugas'),
            'message' => $this->input->post('message')
        );
        $this->db->insert('message_tugas', $data);
        $this->load->model('Notification_model');

        $this->load->model('Tugas_model');
        $row_tugas = $this->Tugas_model->get_by_id($id);

        //notification system
        $data_notif = array(
            'users_id_pegawai' => $row_tugas->id_pegawai,
            'message' => $this->input->post('message'),
            'title' => 'Ada pesan baru ' . $this->input->post('judul'),
            'img' => site_url('assets/images/logo-mini.png'),
            'id_tugas' => $id,
        );
        $notif = $this->Notification_model->send($data_notif);
        echo $notif;
        //redirect(site_url('admin/tugas/read/'.$id),'refresh');
    }
    public function delete($id)
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tugas_model->get_by_id($id);

        if ($row) {
            if (file_exists('assets/tugas/' . $row->file_tugas . '')) {
                unlink('assets/tugas/' . $row->file_tugas . '');
            }
            $this->Tugas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/tugas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tugas'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
        $this->form_validation->set_rules('tugas', 'tugas', 'trim|required');
        $this->form_validation->set_rules('tgl_selesai', 'tgl selesai', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function selesai($id, $selesai = '1')
    {
        $data_login = $this->Tampilan_model->cek_login();
        $row = $this->Tugas_model->get_by_id($id);
        if ($row) {
            $data = array(
                'selesai' => $selesai,
            );
            $this->db->where('id', $id);
            $this->db->update('tugas', $data);
            $this->session->set_flashdata('message', 'Tugas telah selesai');
            redirect(site_url('admin/tugas/read/' . $id . ''));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/tugas'));
        }
    }

    private function rDate($text)
    {
        return date('d-m-Y', strtotime($text));
    }

    private function rSDate($text)
    {
        return date('Y-m-d', strtotime($text));
    }
}

/* End of file Tugas.php */
/* Location: ./application/controllers/Tugas.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-01-04 03:39:43 */
/* http://harviacode.com */
