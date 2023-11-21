<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_model extends CI_Model
{
  function sendEmail($receiver, $subject, $message, $attachment = '')
  {
    $this->load->library('email');
    $this->email->set_newline("\r\n");
    $this->email->from('aipos.diengcyber@gmail.com', 'TANGAN ANGIE');
    $this->email->to($receiver);
    $this->email->subject($subject);
    $this->email->message($this->load->view("email/template", array("isi" => $message), TRUE));
    if (!empty($attachment)) {
      $this->email->attach(site_url('assets/pdf/' . $attachment . '.pdf'));
    }
    if ($this->email->send()) {
      return true;
    } else {
      show_error($this->email->print_debugger());
    }
  }
}
/* End of file Email_model.php */
/* Location: ./application/models/Email_model.php */
