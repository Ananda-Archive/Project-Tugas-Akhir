<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{
    private $id;
    private $nama;
    private $nim;
    private $password;

    public function login($nim,$password) {
        $this->nim = $nim;
        $this->password = $password;

        return $this->db->get_where('user', array (
            'nim' => $this->nim,
            'password' => $this->password
        ));
    }
    
}