<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{
    private $id;
    private $nama;
    private $nim;
    private $password;

    public function login() {
        $this->nim = $this->input->post('nim');
        $this->password = $this->input->post('password');

        $this->db->get_where('user', array (
            'nim' => $this->nim,
            'password' => $this->password
        ));

        if($this->db->affected_rows()) {
            $this->nim = $this->input->post('nim');
            return array(
                'status' => TRUE,
                'data' => $this->db->get_where('user', "nim='{$this->nim}'")->result_array()
            );
        } else {
            return array(
                'status' => 'FALSE',
                'data' => $this->db->get_where('user', "nim='{$this->nim}'")->result_array()
            );
        }
    }
    
}