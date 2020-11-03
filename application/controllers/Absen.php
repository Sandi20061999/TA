<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Refresh: 10');

class Absen extends CI_Controller {
    function __construct()
    {
        parent::__construct();
                if($this->session->userdata('logged_in') !== TRUE){
          redirect('login');
        }
    } 


	function tampil(){
		$this->load->library('ciqrcode');
		$params['data'] = $this->test();
		$params['level'] = 'H';
		$params['size'] = 10;
		$params['savename'] = FCPATH.'tes.png';
		$this->ciqrcode->generate($params);
		$data['url'] = base_url('tes.png');
        $this->load->view('absen',$data);

	}

	public function test()
	{
		
		date_default_timezone_set('Asia/Jakarta');
		$tanggal= date("Ymd");
		$waktu= date("Hi");

		$key = "ab53ns1ku";
		$stringawal = $tanggal.",".$waktu;
		
		// enkripsi dengan fungsi base64_encrypt
		$qr = $this->base64_encrypt($stringawal,$key);

		
		//$data['qr'] = strToHex($datastr);

		// $stringdekripsi = base64_decrypt("CPSLuqv7gqqTqt7TBnJS4FrjuvvWMvJ3RwNcFiGVRmc=",$key);
		// echo $stringdekripsi;
 
		var_dump($qr);
		die;
	}

	function base64_encrypt($plain_text, $password, $iv_len = 16)
		{
		$plain_text .= "\x13";
		$n = strlen($plain_text);
			if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
				$i = 0;
				$enc_text = $this->get_rnd_iv($iv_len);
				$iv = substr($password ^ $enc_text, 0, 512);
				while ($i < $n) {
					$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
					$enc_text .= $block;
					$iv = substr($block . $iv, 0, 512) ^ $password;
					$i += 16;
				}
			$hasil=base64_encode($enc_text);
			return str_replace('+', '@', $hasil);
		}
		
		function get_rnd_iv($iv_len)
		{
			$iv = '';
			while ($iv_len-- > 0) {
				$iv .= chr(mt_rand() & 0xff);
			}
			return $iv;
		}
}
