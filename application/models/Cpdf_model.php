<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

class Cpdf_model extends TCPDF {
	
	/**
	 * Constructor
	 * @access  public
	 */
	public function __construct() {
		parent::__construct('P', 'Cm', 'F4', true, 'UTF-8', false);
	}

	/**
	 * Overide Header
	 */
	public function Header() {

	}

	/**
	 * Overide Footer
	 */
	public function Footer() {
    	$content = '';
    	$this->setY(-1);
    	$this->writeHTML($content, true, false, true, false, 'L');
	}

	/**
	 * Generating PDF
	 * @param 	Array
	 * @access 	public
	 */
	public function generating_pdf($judul, $file_name, $content) {
		$CI = &get_instance();
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->SetAutoPageBreak(TRUE, 1);
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->SetTitle($judul);
		$this->SetAuthor('http://www.diengcyber.com');
		$this->SetSubject('PDF');
		$this->SetKeywords('PDF');
		$this->SetCreator('http://www.diengcyber.com');
		$this->SetMargins(1, 1, 1, true);
		$this->AddPage();
		$this->SetFont('freesans', '', 10);
		$this->writeHTML($content, true, false, true, false, 'C');
		$this->Output(FCPATH.'assets/pdf/'.$file_name, 'F');
	}
}

/* End of file Admission.php */
/* Location: ./application/libraries/Admission.php */