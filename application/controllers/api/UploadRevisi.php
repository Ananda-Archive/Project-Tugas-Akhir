<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class UploadRevisi extends REST_Controller {

    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
        die();
        }
    }


    public function index_post(){
        /*
        id
        id_mahasiswa
        id_dosen_pembimbing
        id_ketua_penguji
        id_dosen_penguji
        file
        revisi_dosen_pembimbing
        revisi_ketua_penguji
        revisi_dosen_penguji
        status_dosen_pembimbing
        status_ketua_penguji
        status_dosen_penguji
        */
        $id = $this->post('id');
        $id_mahasiswa = $this->post('id_mahasiswa');
        $id_dosen_pembimbing = $this->post('id_dosen_pembimbing');
        $id_ketua_penguji = $this->post('id_ketua_penguji');
        $id_dosen_penguji = $this->post('id_dosen_penguji');
        $file_mahasiswa = $this->post('file_mahasiswa');
        $revisi_dosen_pembimbing = $this->post('revisi_dosen_pembimbing');
        $revisi_ketua_penguji = $this->post('revisi_ketua_penguji');
        $revisi_dosen_penguji = $this->post('revisi_dosen_penguji');
        $status_dosen_pembimbing = $this->post('status_dosen_pembimbing');
        $status_ketua_penguji = $this->post('status_ketua_penguji');
        $status_dosen_penguji = $this->post('status_dosen_penguji');
        $file = $this->post('file');
        $status_revisi = $this->post('status_revisi');

        if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'pdf') {
            $filename = 'Revisi' . $id_mahasiswa . '-' . date('dmY-His') . '.pdf';
        } else {
            if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'docx') {
                $filename = 'Revisi' . $id_mahasiswa . '-' . date('dmY-His') . '.docx';
            } else {
                if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'doc') {
                    $filename = 'Revisi' . $id_mahasiswa . '-' . date('dmY-His') . '.doc';
                } else {
                    if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'zip') {
                        $filename = 'Revisi' . $id_mahasiswa . '-' . date('dmY-His') . '.zip';
                    } else {
                        if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'rar') {
                            $filename = 'Revisi' . $id_mahasiswa . '-' . date('dmY-His') . '.rar';
                        } else {
                            $this->response(
                                array(
                                    'status' => FALSE,
                                    'message' => 'ONLY ACCEPT ZIP / RAR / DOC / DOCX / ZIP FILE TYPE'
                                ),
                                REST_Controller::HTTP_BAD_REQUEST
                            );
                        }
                    }
                }
            }
        }
        $tempfilename = $_FILES['file']['tmp_name'];
        $dir = './assets/berkas/';
        if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'pdf' || pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'docx' || pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'doc' || pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'zip' || pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'rar') {
            if(6 == $id_dosen_pembimbing) {
                if($this->M_Berkas->delete($id)) {
                    if($this->M_Berkas->store_revisi_pembimbing($id_mahasiswa, $id_dosen_pembimbing, $id_ketua_penguji, $id_dosen_penguji, $file_mahasiswa, base_url('assets/berkas/').$filename, $revisi_ketua_penguji, $revisi_dosen_penguji, $status_ketua_penguji, $status_dosen_penguji)) {
                        $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                        $this->response(
                            array(
                                'status' => TRUE,
                                'message' => $this::UPDATE_SUCCESS_MESSSAGE
                            ), REST_Controller::HTTP_OK
                        );
                    } else {
                        $this->response(
                            array(
                                'status' => FALSE,
                                'message' => $this::UPDATE_FAILED_MESSAGE
                            ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                } else {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::UPDATE_FAILED_MESSAGE
                        ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => 'hwehwe'
                    ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }

    }

    public function index_put() {
        $id = $this->put('id');
        $status_revisi = $this->put('status_revisi');
        $id_dosen_pembimbing = $this->put('id_dosen_pembimbing');
        $id_ketua_penguji = $this->put('id_ketua_penguji');
        $id_dosen_penguji = $this->put('id_dosen_penguji');
        $id_dosen = $this->put('id_dosen');
        if($status_revisi == 1) {
            if($id_dosen == $id_dosen_pembimbing) {
                if($this->M_Berkas->update_lolos_pembimbing($id)) {
                    $this->response(
                        array(
                            'status' => TRUE,
                            'message' => $this::UPDATE_SUCCESS_MESSSAGE
                        ), REST_Controller::HTTP_OK
                    );
                } else {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::UPDATE_FAILED_MESSAGE
                        ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            } else {
                if($id_dosen == $id_ketua_penguji) {
                    if($this->M_Berkas->update_lolos_ketua($id)) {
                        $this->response(
                            array(
                                'status' => TRUE,
                                'message' => $this::UPDATE_SUCCESS_MESSSAGE
                            ), REST_Controller::HTTP_OK
                        );
                    } else {
                        $this->response(
                            array(
                                'status' => FALSE,
                                'message' => $this::UPDATE_FAILED_MESSAGE
                            ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                }
            }
        }
    }
}
