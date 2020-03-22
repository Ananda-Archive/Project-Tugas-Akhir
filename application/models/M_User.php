<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model{
    private $id;
    private $nama;
    private $nomor;
    private $password;
    private $role;
    private $id_dosen_pembimbing;
    private $id_ketua_penguji;
    private $id_dosen_penguji;
    const TABLE_NAME = 'user';

    public function login($nomor,$password) {
        $this->nomor = $nomor;
        $this->password = $password;

        return $this->db->get_where($this::TABLE_NAME, array (
            'nomor' => $this->nomor,
            'password' => $this->password
        ));
    }

    public function insert($nomor,$nama,$password,$role,$id_dosen_pembimbing,$id_ketua_penguji,$id_dosen_penguji) {
        $this->db->insert($this::TABLE_NAME, array(
            'nomor' => $nomor,
            'nama' => $nama,
            'password ' => $password,
            'role' => $role,
            'id_dosen_pembimbing' => $id_dosen_pembimbing,
            'id_ketua_penguji' => $id_ketua_penguji,
            'id_dosen_penguji' => $id_dosen_penguji
        ));
        return $this->db->insert_id();
    }

    public function get_all_user() {
        $this->db->select("*");
        $this->db->from($this::TABLE_NAME);
        return $this->db->get()->result_array();
    }

    public function get_all_dosen() {
        $this->db->select("*");
        $this->db->from($this::TABLE_NAME);
        $this->db->where("role=1");
        return $this->db->get()->result_array();
    }
    
    public function get_by_nomor($nomor) {
        $this->nomor = $nomor;

        return $this->db->get_where($this::TABLE_NAME, "nomor={$nomor}");
    }

    public function get_user_where($id) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id='{$id}'");
        return $this->db->get()->result_array();
    }

    public function check_admin($id) {
        $this->id = $id;

        $query = $this->db->get_where($this::TABLE_NAME, array (
            'id' => $this->id,
            'role' => 2
        ));

        $query->num_rows() > 0 ? true : false;
    }
    
}