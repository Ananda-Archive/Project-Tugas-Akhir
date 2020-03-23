<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Berita_Acara extends REST_Controller {

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
        $id_mahasiswa = $this->post('id_mahasiswa');
        $tanggal = $this->post('tanggal');
        $time = $this->post('time');

        if(!isset($id_mahasiswa)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."id_mahasiswa"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if(!isset($tanggal)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."tanggal"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if(!isset($time)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."time"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if($this->M_Berita_Acara->insert($id_mahasiswa,$tanggal,$time)) {
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
    }

    public function index_get() {
        $id = $this->get('id');
        if (isset($id)) {
            $result = $this->M_Berita_Acara->get_berita_acara_where($id);
            $this->response($result,REST_Controller::HTTP_OK);
        } else {
            $result = $this->M_Berita_Acara->get_all_berita_acara();
            $this->response($result,REST_Controller::HTTP_OK);
        }
    }

}
