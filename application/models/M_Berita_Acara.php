<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Berita_Acara extends CI_Model{
    private $id;
    private $id_mahasiswa;
    private $tanggal;
    private $time;
    const TABLE_NAME = 'berita_acara';

    public function insert($id_mahasiswa,$tanggal,$time) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'tanggal' => $tanggal,
            'time' => $time,
        ));
        return $this->db->insert_id();
    }

    public function get_all_berita_acara() {
        $this->db->select("*");
        $this->db->from($this::TABLE_NAME);
        return $this->db->get()->result_array();
    }

    public function get_berita_acara_where($id) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id='{$id}'");
        return $this->db->get()->result_array();
    }
    
}