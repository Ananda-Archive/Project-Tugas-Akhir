<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Berkas extends REST_Controller {

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
        $id_mahasiswa = $this->session->userdata('id');
        if(!isset($_FILES)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."FILE"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        date_default_timezone_set('Asia/Jakarta');
        if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'pdf') {
            $filename = $this->session->userdata('nomor') . '-' . date('dmY-His') . '.pdf';
        } else {
            if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'docx') {
                $filename = $this->session->userdata('nomor') . '-' . date('dmY-His') . '.docx';
            } else {
                if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'doc') {
                    $filename = $this->session->userdata('nomor') . '-' . date('dmY-His') . '.doc';
                } else {
                    if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'zip') {
                        $filename = $this->session->userdata('nomor') . '-' . date('dmY-His') . '.zip';
                    } else {
                        if(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) == 'rar') {
                            $filename = $this->session->userdata('nomor') . '-' . date('dmY-His') . '.rar';
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
            if($this->M_Berkas->store($id_mahasiswa, base_url('assets/berkas/').$filename)) {
                $moveToDir = move_uploaded_file($tempfilename, $dir.$filename);
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => $this::INSERT_SUCCESS_MESSSAGE
                    ),
                    REST_Controller::HTTP_CREATED
                );
            } else {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => $this::INSERT_FAILED_MESSAGE
                    ),
                    REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        } else {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => 'ONLY ACCEPT ZIP / RAR / DOC / DOCX / ZIP FILE TYPE'
                ),
                REST_Controller::HTTP_UNAUTHORIZED
            );
        }

    }

    public function index_get() {
        $id_mahasiswa = $this->get('id_mahasiswa');
        $id_dosen_pembimbing = $this->get('id_dosen_pembimbing');
        $id_ketua_penguji = $this->get('id_ketua_penguji');
        $id_dosen_penguji = $this->get('id_dosen_penguji');
        if (isset($id_mahasiswa)) {
            $result = $this->M_Berkas->get_berkas_where_mahasiswa($id_mahasiswa);
            $this->response($result,REST_Controller::HTTP_OK);
        }
        if(isset($id_dosen_pembimbing)) {
            $idx = 0;
            $result = $this->M_User->get_berkas_where_dosen_pembimbing($id_dosen_pembimbing);
            foreach($result as $row) {
                $berkas = $this->M_Berkas->get_specific_berkas_where_mahasiswa($row['id']);
                $temp = array_merge($result[$idx], array('berkas' => $berkas));
                $result[$idx] = $temp;
                $idx++;
            }
            $this->response($result,REST_Controller::HTTP_OK);
        }
        if(isset($id_ketua_penguji)) {
            $idx = 0;
            $result = $this->M_User->get_berkas_where_ketua_penguji($id_ketua_penguji);
            foreach($result as $row) {
                $berkas = $this->M_Berkas->get_specific_berkas_where_mahasiswa($row['id']);
                $temp = array_merge($result[$idx], array('berkas' => $berkas));
                $result[$idx] = $temp;
                $idx++;
            }
            $this->response($result,REST_Controller::HTTP_OK);
        }
        if(isset($id_dosen_penguji)) {
            $idx = 0;
            $result = $this->M_User->get_berkas_where_dosen_penguji($id_dosen_penguji);
            foreach($result as $row) {
                $berkas = $this->M_Berkas->get_specific_berkas_where_mahasiswa($row['id']);
                $temp = array_merge($result[$idx], array('berkas' => $berkas));
                $result[$idx] = $temp;
                $idx++;
            }
            $this->response($result,REST_Controller::HTTP_OK);
        }
    }

}
