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

    public function is_not_exists($id) {
        $this->db->get_where($this::TABLE_NAME, "id='{$id}'")->num_rows() == 0 ? true : false;
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
    
    public function get_berkas_where_dosen_pembimbing($id_dosen_pembimbing) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_dosen_pembimbing='{$id_dosen_pembimbing}'");
        return $this->db->get()->result_array();
    }

    public function get_berkas_where_ketua_penguji($id_ketua_penguji) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_ketua_penguji='{$id_ketua_penguji}'");
        return $this->db->get()->result_array();
    }

    public function get_berkas_where_dosen_penguji($id_dosen_penguji) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_dosen_penguji='{$id_dosen_penguji}'");
        return $this->db->get()->result_array();
    }

    public function get_nama_nim_mahasiswa($id_mahasiswa) {
        $this->db->select('nomor,nama');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id='{$id_mahasiswa}'");
        return $this->db->get()->result_array();
    }

    public function update($id, $nomor, $nama, $role, $id_dosen_pembimbing, $id_ketua_penguji, $id_dosen_penguji) {
        $result = $this->db->get_where($this::TABLE_NAME, array(
            'id' => $id,
            'nomor' => $nomor,
            'nama' => $nama,
            'role' => $role,
            'id_dosen_pembimbing' => $id_dosen_pembimbing,
            'id_ketua_penguji' => $id_ketua_penguji,
            'id_dosen_penguji' => $id_dosen_penguji
        ));
        if ($result->num_rows() > 0) return true;
        $this->db->update($this::TABLE_NAME, array(
            'nomor' => $nomor,
            'nama' => $nama,
            'role' => $role,
            'id_dosen_pembimbing' => $id_dosen_pembimbing,
            'id_ketua_penguji' => $id_ketua_penguji,
            'id_dosen_penguji' => $id_dosen_penguji

        ), "id='{$id}'");

        return $this->db->affected_rows();
    }

    public function is_dosen_pembimbing($id_mahasiswa) {
        return $this->db->query("SELECT id_dosen_pembimbing FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_dosen_pembimbing'];
    }

    public function is_ketua_penguji($id_mahasiswa) {
        return $this->db->query("SELECT id_ketua_penguji FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_ketua_penguji'];
    }

    public function is_dosen_penguji($id_mahasiswa) {
        return $this->db->query("SELECT id_dosen_penguji FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_dosen_penguji'];
    }

    public function delete($id) {
        $this->db->delete($this::TABLE_NAME, "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function change_password($id,$password) {
        $result = $this->db->get_where($this::TABLE_NAME, array(
            'id' => $id,
            'password' => $password
        ));
        if ($result->num_rows() > 0) return true;

        $this->db->update($this::TABLE_NAME, array(
            'password' => $password
        ), "id='{$id}'");

        return $this->db->affected_rows();
    }
}