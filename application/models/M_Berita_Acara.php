<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Berita_Acara extends CI_Model{
    private $id;
    private $id_mahasiswa;
    private $tanggal;
    private $time;
    private $id_dosen_pembimbing;
    private $id_ketua_penguji;
    private $id_dosen_penguji;
    const TABLE_NAME = 'berita_acara';

    public function insert($id_mahasiswa,$tanggal,$time) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'id_dosen_pembimbing' => $this->db->query("SELECT id_dosen_pembimbing FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_dosen_pembimbing'],
            'id_ketua_penguji' => $this->db->query("SELECT id_ketua_penguji FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_ketua_penguji'],
            'id_dosen_penguji' => $this->db->query("SELECT id_dosen_penguji FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_dosen_penguji'],
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
        $this->db->where("id_mahasiswa='{$id}'");
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_berita_acara_where_id_dosen_pembimbing($id) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_dosen_pembimbing='{$id}'");
        date_default_timezone_set('Asia/Jakarta');
        $this->db->where("tanggal >=", date('Y-m-d'));
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_berita_acara_where_id_ketua_penguji($id) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_ketua_penguji='{$id}'");
        date_default_timezone_set('Asia/Jakarta');
        $this->db->where("tanggal >=", date('Y-m-d'));
        return $this->db->get()->result_array();
    }

    public function get_berita_acara_where_id_dosen_penguji($id) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_dosen_penguji='{$id}'");
        date_default_timezone_set('Asia/Jakarta');
        $this->db->where("tanggal >=", date('Y-m-d'));
        return $this->db->get()->result_array();
    }

    public function delete_by_id_mahasiswa($id) {
        $this->db->delete($this::TABLE_NAME, "id_mahasiswa='{$id}'");
        return $this->db->affected_rows();
    }
    
}