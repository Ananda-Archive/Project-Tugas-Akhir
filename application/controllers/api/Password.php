<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Password extends REST_Controller {

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

    public function index_put() {
        $id = $this->put('id');
        // $id = $this->put('id');
        $nomor = $this->put('nomor');
        $password = $this->put('password');
        if(!isset($id)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."id"
                ), REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if(isset($password)) {
            if($this->session->userdata('role') == 2 || $this->session->userdata('role') == 0 || $this->session->userdata('role') == 1) {
                if($this->M_User->change_password($id,hash('sha512',$password. config_item('encryption_key')))) {
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
        if(isset($nomor)) {
            if($this->M_User->change_password($id,hash('sha512',$nomor. config_item('encryption_key')))) {
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
