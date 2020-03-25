<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Berkas extends CI_Model{
    private $id;
    private $id_mahasiswa;
    private $id_dosen_pembimbing;
    private $id_ketua_penguji;
    private $id_dosen_penguji;
    private $status_dosen_pembimbing;
    private $status_ketua_penguji;
    private $status_dosen_penguji;
    private $file;
    private $revisi_dosen_pembimbing;
    private $revisi_ketua_penguji;
    private $revisi_dosen_penguji;
    private $tanggal;
    const TABLE_NAME = 'berkas';
    
    public function store($id_mahasiswa,$file) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'file' => $file,
            'id_dosen_pembimbing' => $this->db->query("SELECT id_dosen_pembimbing FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_dosen_pembimbing'],
            'id_ketua_penguji' => $this->db->query("SELECT id_ketua_penguji FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_ketua_penguji'],
            'id_dosen_penguji' => $this->db->query("SELECT id_dosen_penguji FROM user WHERE id='$id_mahasiswa'")->result_array()[0]['id_dosen_penguji']
        ));
        return $this->db->insert_id();
    }

    public function get_berkas_where_mahasiswa($id_mahasiswa) {
        $this->db->select('*');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_mahasiswa='{$id_mahasiswa}'");
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result_array();
    }
    
    public function get_specific_berkas_where_mahasiswa($id_mahasiswa) {
        $this->db->select('id,file,revisi,status_dosen_pembimbing,status_ketua_penguji,status_dosen_penguji,tanggal');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_mahasiswa='{$id_mahasiswa}'");
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    
    
}