<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{
    private $id;
    private $nama;
    private $nomor;
    private $password;
    const TABLE_NAME = 'user';

    public function login($nomor,$password) {
        $this->nomor = $nomor;
        $this->password = $password;

        return $this->db->get_where($this::TABLE_NAME, array (
            'nomor' => $this->nomor,
            'password' => $this->password
        ));
    }

    public function get_by_nomor($nomor) {
        $this->nomor = $nomor;

        return $this->db->get_where($this::TABLE_NAME, "nomor={$nomor}");
    }
    
}