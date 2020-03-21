<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

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
        $nama = $this->post('nama');
        $nim = $this->post('nim');
        $password = $this->post('password');
        // Kalau parameter nim kosong
        if(!isset($nim)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."nim"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        // kalau parameter password kosong
        if(!isset($password)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."password"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        // Kalau parameter terisi dan benar
        if($this->M_User->login($nim,$password)->num_rows() > 0) {
            $data = $this->M_User->login($nim,$password)->row_array();
            $data_session = array(
                'id' => $data['id'],
                'nama' => $data['nama'],
                'nim' => $data['nim'],
                'password' => $data['password']
            );
            $this->session->set_userdata($data_session);
            $this->response(
                array(
                    'status' => TRUE,
                    'message' => $this::INSERT_SUCCESS_MESSSAGE
                ), REST_Controller::HTTP_CREATED
            );
        } else {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE
                ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
