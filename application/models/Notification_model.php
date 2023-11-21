<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

	function send($data = array()){
		$id_tugas = $data['id_tugas'];
        $message = $data['message'];
        $user_id = $data['users_id_pegawai'];

        $this->load->model('Pegawai_model');
        $row_pegawai = $this->Pegawai_model->get_by_id($user_id);

        $url_prefix = '';
        if($row_pegawai->level == 2){
			$url_prefix = 'marketing';
		}else{
			$url_prefix = 'pegawai';
		}

		$url = site_url($url_prefix.'/tugas/read/'.$id_tugas);


		$headings = $data['title'];
		$img = $data['img'];
				
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.APKEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	}

}

/* End of file Notification_model.php */
/* Location: ./application/models/Notification_model.php */