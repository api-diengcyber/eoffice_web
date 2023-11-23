<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project_board extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_model');
        $this->load->model('Email_model');
        $this->load->model('Api_model', 'api');
    }

    public function index()
    { }


    public function create_ticket()
    {
        $token = md5(md5(md5("TANGANANGIE" . date("Y-m-d H:i"))));
        $_token = $this->input->post('token');
        if ($_token == $token) {


            $data = array(
                "task" => $this->input->post('judul'),
                "description" => $this->input->post('deskripsi'),
                "attachment" => $this->input->post('attachment'),
                "id_status" => 1,
                "id_ticket" => $this->input->post('id')
            );
            $this->db->insert('tasks', $data);

            //send notification
            // $data_notif = array(
            //     'users_id_pegawai' => $id_pegawai[$i],
            //     'message' => strip_tags($this->input->post('deskripsi')),
            //     'title' => 'Ada ticket baru ' . $this->input->post('judul'),
            //     'img' => site_url('assets/images/logo-mini.png'),
            //     'id_tugas' => $id_tugas,
            // );
            // $notif = $this->Notification_model->sendAll($data_notif);
            //send back response
            $this->output->set_content_type('application/json')->set_output(json_encode(array("msg" => "Ticket Created")));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(array($token => $_POST)));
        }
    }


    public function get_data_2()
    {
        $this->api->head();
        $user_id = $this->input->post('id_users');

        $kantor_id = $this->db->select('id_kantor')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row();
        // $this->output->enable_profiler(TRUE);
        $this->db->select('t.*,p.project,CONCAT(u.first_name," ",u.last_name) as nama_member,u.email');
        $this->db->from('tasks t');
        $this->db->join('(SELECT MAX(id) max_id, id_task FROM tasks_detail GROUP BY id_task) td_max', 'td_max.id_task = t.id');
        $this->db->join('tasks_detail td', 'td.id_task = t.id AND td.id = td_max.max_id');
        $this->db->join('project p', 'p.id = t.id_project', 'left');
        // $this->db->join('users u', 'u.id = t.id_member', 'left');
        $this->db->join('users u', 'u.id = td.id_user', 'left');
        $this->db->where('p.id_kantor', $kantor_id->id_kantor);
        if (!empty($user_id)) {
            $this->db->where('td.id_user', $user_id);
        }
        // $this->db->group_by('t.id');
        $this->db->order_by('t.id', 'DESC');
        $data = $this->db->get()->result();

        $output = [];
        $i = 0;
        foreach ($data as $value) {
            $this->db->select('tsl.status,u.username');
            $this->db->from('tasks_detail td');
            $this->db->join('tasks_status_lookup tsl', 'tsl.id = td.task_status');
            $this->db->join('users u', 'u.id = td.id_user');
            $this->db->where('id_task', $value->id);
            $this->db->where('u.id', $user_id);
            $this->db->order_by('td.id', 'desc');
            $this->db->limit(1);
            $detail = $this->db->get()->row();

            $output[$i] = $value;
            $output[$i]->name = (!empty($detail->username)) ? $detail->username : "-";
            $output[$i]->status = (!empty($detail->status)) ? $detail->status : "-";
            $i++;
        }

        $this->api->result('ok', $output, 'Data');
    }


    public function get_data()
    {
        $user_id = $this->session->userdata('user_id');
        $kantor_id = $this->db->select('id_kantor')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row();
        // $this->output->enable_profiler(TRUE);
        $this->db->select('t.*,p.project,CONCAT(u.first_name," ",u.last_name) as nama_member,u.email');
        $this->db->from('tasks t');
        $this->db->join('project p', 'p.id = t.id_project', 'left');
        $this->db->join('users u', 'u.id = t.id_member', 'left');
        $this->db->where('p.id_kantor', $kantor_id->id_kantor);
        // $this->db->group_by('t.id');
        $this->db->order_by('t.id', 'DESC');
        $data = $this->db->get()->result();

        $output = [];
        $i = 0;
        foreach ($data as $value) {
            $this->db->select('tsl.status,u.username');
            $this->db->from('tasks_detail td');
            $this->db->join('tasks_status_lookup tsl', 'tsl.id = td.task_status');
            $this->db->join('users u', 'u.id = td.id_user');
            $this->db->where('id_task', $value->id);
            $this->db->order_by('td.id', 'desc');
            $this->db->limit(1);
            $detail = $this->db->get()->row();

            $output[$i] = $value;
            $output[$i]->name = (!empty($detail->username)) ? $detail->username : "-";
            $output[$i]->status = (!empty($detail->status)) ? $detail->status : "-";
            $i++;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }


    public function get_detail()
    {
        $this->db->select("td.message,td.attachment,td.date_created,u.username as name");
        $this->db->from('tasks_detail td');
        $this->db->join('users u', 'u.id = td.id_user');
        $this->db->where('td.id_task', $this->input->post('id'));
        $data = $this->db->get()->result();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function update_task_2()
    {
        $this->api->head();

        $id = $this->input->post('id');
        $id_user = $this->input->post('id_users');
        $id_status = $this->input->post('id_status');

        $statusMap = [];
        $statusMap[1] = array("title" => "", "message" => "", "label" => "TODO");
        $statusMap[2] = array("title" => "Ticket sedang di proses", "message" => "Tiket anda sedang di proses oleh tim kami", "label" => "ON PROGRESS");
        $statusMap[3] = array("title" => "Ticket anda telah selesai", "message" => "Tiket anda sedang telah selesai diproses", "label" => "FINISH");
        $statusMap[4] = array("title" => "", "message" => "", "label" => "ARSIP");

        /**
         * Update tasks status
         */
        $data = array(
            "id_status" => $id_status
        );
        $this->db->where('id', $id);
        $this->db->update('tasks', $data);

        /**
         * Set log
         */
        $data = array(
            "id_user" => $id_user,
            "id_task" => $id,
            "type" => 2,
            "task_status" => $id_status,
            "message" => "Task status updated to " . $statusMap[$id_status]['label']
        );
        $this->db->insert('tasks_detail', $data);

        /**
         * Send back response
         */

        $this->db->select('t.*,p.project,u.email');
        $this->db->from('tasks t');
        $this->db->join('project p', 'p.id = t.id_project', 'left');
        $this->db->join('users u', 'u.id = t.id_member', 'left');
        $this->db->where('t.id', $id);
        $this->db->group_by('t.id');
        $data = $this->db->get()->row();

        $this->db->select('tsl.status,u.username');
        $this->db->from('tasks_detail td');
        $this->db->join('tasks_status_lookup tsl', 'tsl.id = td.task_status', 'left');
        $this->db->join('users u', 'u.id = td.id_user');
        $this->db->where('id_task', $data->id);
        $this->db->order_by('td.id', 'desc');
        $this->db->limit(1);
        $detail = $this->db->get()->row();

        $data->name = $detail->username;
        $data->status = $detail->status;

        //send email
        $status = $statusMap[$id_status];
        if (!empty($status['message'])) {
            // $this->Email_model->sendEmail($data->email, $status['title'], $status['message']);
        }

        if ($id_status == 3) {
            // $data_notif = [
            //     'id_tugas' => '',
            //     'message' => "Ada tiket yang sudah selesai lur.",
            //     'title' => "Ada tiket yang sudah selesai",
            //     'img' => site_url('assets/images/logo-mini.png'),
            // ];
            // $this->Notification_model->sendMarketing($data_notif);
        }

        $this->api->result('ok', $data, 'Update berhasil');
    }

    public function update_task()
    {
        $statusMap = [];
        $statusMap[1] = array("title" => "", "message" => "", "label" => "TODO");
        $statusMap[2] = array("title" => "Ticket sedang di proses", "message" => "Tiket anda sedang di proses oleh tim kami", "label" => "ON PROGRESS");
        $statusMap[3] = array("title" => "Ticket anda telah selesai", "message" => "Tiket anda sedang telah selesai diproses", "label" => "FINISH");
        $statusMap[4] = array("title" => "", "message" => "", "label" => "ARSIP");

        /**
         * Update tasks status
         */
        $data = array(
            "id_status" => $this->input->post('id_status')
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('tasks', $data);

        /**
         * Set log
         */
        $data = array(
            "id_user" => $this->session->userdata("user_id"),
            "id_task" => $this->input->post('id'),
            "type" => 2,
            "task_status" => $this->input->post('id_status'),
            "message" => "Task status updated to " . $statusMap[$this->input->post('id_status')]['label']
        );
        $this->db->insert('tasks_detail', $data);

        /**
         * Send back response
         */

        $this->db->select('t.*,p.project,u.email');
        $this->db->from('tasks t');
        $this->db->join('project p', 'p.id = t.id_project', 'left');
        $this->db->join('users u', 'u.id = t.id_member', 'left');
        $this->db->where('t.id', $this->input->post('id'));
        $this->db->group_by('t.id');
        $data = $this->db->get()->row();

        $this->db->select('tsl.status,u.username');
        $this->db->from('tasks_detail td');
        $this->db->join('tasks_status_lookup tsl', 'tsl.id = td.task_status', 'left');
        $this->db->join('users u', 'u.id = td.id_user');
        $this->db->where('id_task', $data->id);
        $this->db->order_by('td.id', 'desc');
        $this->db->limit(1);
        $detail = $this->db->get()->row();

        $data->name = $detail->username;
        $data->status = $detail->status;

        //send email
        $status = $statusMap[$this->input->post('id_status')];
        if (!empty($status['message'])) {
            // $this->Email_model->sendEmail($data->email, $status['title'], $status['message']);
        }

        if ($this->input->post('id_status') == 3) {
            // $data_notif = [
            //     'id_tugas' => '',
            //     'message' => "Ada tiket yang sudah selesai lur.",
            //     'title' => "Ada tiket yang sudah selesai",
            //     'img' => site_url('assets/images/logo-mini.png'),
            // ];
            // $this->Notification_model->sendMarketing($data_notif);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function send_message()
    {
        $data = array(
            "id_user" => $this->session->userdata("user_id"),
            "id_task" => $this->input->post("id_task"),
            "message" => $this->input->post('message'),
        );
        $this->db->insert('tasks_detail', $data);
        $id = $this->db->insert_id();

        $this->db->select("td.message,td.date_created,u.username as name");
        $this->db->from('tasks_detail td');
        $this->db->join('users u', 'u.id = td.id_user');
        $this->db->where('td.id', $id);
        $data = $this->db->get()->row();

        $this->db->select('t.id,t.id_status,u.email');
        $this->db->from('tasks t');
        $this->db->join('users u', 'u.id = t.id_member', 'left');
        $this->db->where('t.id', $this->input->post('id_task'));
        $ticket = $this->db->get()->row();

        // $this->Email_model->sendEmail($ticket->email, "Ada pesan di tiket anda", "Silahkan cek tiket. ada pesan di tiket anda <br><a href='https://member.diengcyber.com/ticket/view/" . $ticket->id . "'>Buka ticket</a>");

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}

/* End of file Project_board.php */
