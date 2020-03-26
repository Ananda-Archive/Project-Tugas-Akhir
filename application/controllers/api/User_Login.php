<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class User_Login extends REST_Controller {

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
        if(!$this->session->userdata('id')) {
            $nama = $this->post('nama');
            $nomor = $this->post('nomor');
            $password = $this->post('password');
            $password = hash('sha512', $this->post('password') . config_item('encryption_key'));
            // Kalau parameter nomor kosong
            if(!isset($nomor)) {
                $this->response(
                    array(
                        'status' => FALSE,
                        'message' => $this::REQUIRED_PARAMETER_MESSAGE."nomor"
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
            if($this->M_User->login($nomor,$password)->num_rows() > 0) {
                $data = $this->M_User->login($nomor,$password)->row_array();
                $data_session = array(
                    'id' => $data['id'],
                    'nama' => $data['nama'],
                    'nomor' => $data['nomor'],
                    'role' => $data['role']
                );
                $this->session->set_userdata($data_session);
                $this->response(
                    array(
                        'status' => TRUE,
                        'message' => $this::LOGIN_SUCCESS_MESSAGE
                    ), REST_Controller::HTTP_CREATED
                );
            } else {
                if($this->M_User->get_by_nomor($nomor)->num_rows() > 0) {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::INCORRECT_PASSWORD_MESSAGE
                        ), REST_Controller::HTTP_UNAUTHORIZED
                    );
                } else {
                    if($this->M_User->get_by_nomor($nomor)->num_rows() == 0) {
                        $this->response(
                            array(
                                'status' => FALSE,
                                'message' => $this::USER_NOT_FOUND_MESSAGE
                            ), REST_Controller::HTTP_UNAUTHORIZED
                        );
                    } else {
                        $this->response(
                            array(
                                'status' => FALSE,
                                'message' => $this::LOGIN_FAILED_MESSAGE
                            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                }
            }
        } else {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::LOGIN_FAILED_MESSAGE
                ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
