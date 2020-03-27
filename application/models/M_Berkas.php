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
        $this->db->select('id,file,revisi_dosen_pembimbing,revisi_ketua_penguji,revisi_dosen_penguji,status_dosen_pembimbing,status_ketua_penguji,status_dosen_penguji,tanggal');
        $this->db->from($this::TABLE_NAME);
        $this->db->where("id_mahasiswa='{$id_mahasiswa}'");
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result_array();
    }

    public function is_not_exists($id) {
        $this->db->get_where($this::TABLE_NAME, "id='{$id}'")->num_rows() == 0 ? true : false;
    }

    public function delete($id) {
        $this->db->delete($this::TABLE_NAME, "id='{$id}'");
        return $this->db->affected_rows();
    }

    public function delete_by_id_mahasiswa($id) {
        $this->db->delete($this::TABLE_NAME, "id_mahasiswa='{$id}'");
        return $this->db->affected_rows();
    }

    public function store_revisi_pembimbing($id_mahasiswa, $id_dosen_pembimbing, $id_ketua_penguji, $id_dosen_penguji, $file, $revisi_dosen_pembimbing, $revisi_ketua_penguji, $revisi_dosen_penguji, $status_ketua_penguji, $status_dosen_penguji) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'id_dosen_pembimbing' => $id_dosen_pembimbing,
            'id_ketua_penguji' => $id_ketua_penguji,
            'id_dosen_penguji' => $id_dosen_penguji,
            'file' => $file,
            'revisi_dosen_pembimbing' => $revisi_dosen_pembimbing,
            'revisi_ketua_penguji' => $revisi_ketua_penguji,
            'revisi_dosen_penguji' => $revisi_dosen_penguji,
            'status_dosen_pembimbing' => 2,
            'status_ketua_penguji' => $status_ketua_penguji,
            'status_dosen_penguji' => $status_dosen_penguji

        ));
        return $this->db->insert_id();
    }

    public function store_revisi_ketua($id_mahasiswa, $id_dosen_pembimbing, $id_ketua_penguji, $id_dosen_penguji, $file, $revisi_dosen_pembimbing, $revisi_ketua_penguji, $revisi_dosen_penguji, $status_dosen_pembimbing, $status_dosen_penguji) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'id_dosen_pembimbing' => $id_dosen_pembimbing,
            'id_ketua_penguji' => $id_ketua_penguji,
            'id_dosen_penguji' => $id_dosen_penguji,
            'file' => $file,
            'revisi_dosen_pembimbing' => $revisi_dosen_pembimbing,
            'revisi_ketua_penguji' => $revisi_ketua_penguji,
            'revisi_dosen_penguji' => $revisi_dosen_penguji,
            'status_dosen_pembimbing' => $status_dosen_pembimbing,
            'status_ketua_penguji' => 2,
            'status_dosen_penguji' => $status_dosen_penguji

        ));
        return $this->db->insert_id();
    }

    public function store_revisi_penguji($id_mahasiswa, $id_dosen_pembimbing, $id_ketua_penguji, $id_dosen_penguji, $file, $revisi_dosen_pembimbing, $revisi_ketua_penguji, $revisi_dosen_penguji, $status_dosen_pembimbing, $status_ketua_penguji) {
        $this->db->insert($this::TABLE_NAME, array(
            'id_mahasiswa' => $id_mahasiswa,
            'id_dosen_pembimbing' => $id_dosen_pembimbing,
            'id_ketua_penguji' => $id_ketua_penguji,
            'id_dosen_penguji' => $id_dosen_penguji,
            'file' => $file,
            'revisi_dosen_pembimbing' => $revisi_dosen_pembimbing,
            'revisi_ketua_penguji' => $revisi_ketua_penguji,
            'revisi_dosen_penguji' => $revisi_dosen_penguji,
            'status_dosen_pembimbing' => $status_dosen_pembimbing,
            'status_ketua_penguji' => $status_ketua_penguji,
            'status_dosen_penguji' => 2

        ));
        return $this->db->insert_id();
    }

    public function update_lolos_pembimbing($id) {
        $this->db->update($this::TABLE_NAME, array(
            'status_dosen_pembimbing' => 1
        ), "id='{$id}'");

        return $this->db->affected_rows();
    }

    public function update_lolos_ketua($id) {
        $this->db->update($this::TABLE_NAME, array(
            'status_ketua_penguji' => 1
        ), "id='{$id}'");

        return $this->db->affected_rows();
    }

    public function update_lolos_penguji($id) {
        $this->db->update($this::TABLE_NAME, array(
            'status_dosen_penguji' => 1
        ), "id='{$id}'");

        return $this->db->affected_rows();
    }

    
    
}