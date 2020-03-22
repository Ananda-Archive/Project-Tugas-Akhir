<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Dosen_Penguji extends CI_Model{
    private $id;
    private $id_dosen_penguji;
    private $id_mahasiswa;
    const TABLE_NAME = 'dosen_penguji';

    public function insert($id_dosen_penguji,$id_mahasiswa) {
        foreach ($id_dosen_penguji as $user) {
            $this->db->insert($this::TABLE_NAME, array (
                'id_dosen_penguji' => $user,
                'id_mahasiswa' => $id_mahasiswa
            ));
        } return $this->db->affected_rows();
    }

    public function get_all_dosen_penguji() {
        $this->db->select("*");
        $this->db->from($this::TABLE_NAME);
        return $this->db->get()->result_array();
    }

    public function get_dosen_penguji_where($id_mahasiswa) {
        $this->db->select("id_dosen_penguji");
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_mahasiswa = '{$id_mahasiswa}'");
        $res = [];
        foreach($this->db->get()->result_array() as $a){
            array_push($res,$a['id_dosen_penguji']);
        }
        return $res;
    }
    
}