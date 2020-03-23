<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
	public function index() {
        if($this->session->userdata('id')) {
            $data['id'] = $this->session->userdata('id');
            $data['nama'] = $this->session->userdata('nama');
            $data['nomor'] = $this->session->userdata('nomor');
            $data['role'] = $this->session->userdata('role');
            if($this->session->userdata('role') == 2) {
                $this->load->view('home',$data);
            } else {
                if($this->session->userdata('role') == 0) {
                    $this->load->view('home_mahasiswa',$data);
                }
            }
        } else {
            redirect('login');
        }
    }
    
    public function logOut() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
