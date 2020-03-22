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
            
                $nomor = $this->post('nomor');
                $nama = $this->post('nama');
                $password = $this->post('nomor');
                $role = $this->post('role');
                $dosen_penguji = $this->post('dosen_penguji');
                $id_dosen_pembimbing = $this->post('id_dosen_pembimbing');
                if(!isset($nomor)) {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::REQUIRED_PARAMETER_MESSAGE."nomor"
                        ), REST_Controller::HTTP_BAD_REQUEST
                    );
                    return;
                }
                if(!isset($nama)) {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::REQUIRED_PARAMETER_MESSAGE."nama"
                        ), REST_Controller::HTTP_BAD_REQUEST
                    );
                    return;
                }
                if(!isset($password)) {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::REQUIRED_PARAMETER_MESSAGE."password"
                        ), REST_Controller::HTTP_BAD_REQUEST
                    );
                    return;
                }
                if(!isset($role)) {
                    $this->response(
                        array(
                            'status' => FALSE,
                            'message' => $this::REQUIRED_PARAMETER_MESSAGE."role"
                        ), REST_Controller::HTTP_BAD_REQUEST
                    );
                    return;
                }
                if($this->M_User->get_by_nomor($nomor)->num_rows() == 0) {
                    if($user_id = $this->M_User->insert($nomor,$nama,$password,$role,$id_dosen_pembimbing)) {
                        if(isset($dosen_penguji)) {
                            if(!$this->M_Dosen_Penguji->insert($dosen_penguji, $user_id)) {
                                $this->response(
                                    array(
                                        'status' => FALSE,
                                        'message' => $this::INSERT_FAILED_MESSAGE." failed to insert Dosen Penguji"
                                    ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                                );
                                return;
                            }
                        }
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
                            'message' => $this::NUMBER_FAILED_MESSAGE
                        ),
                        REST_Controller::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
            
    }

    public function index_get() {
        $id = $this->get('id');
        $role = $this->get('role');
        if (isset($id)) {
            $result = $this->M_User->get_user_where($id);
            if($role == 0) {
                $dosen = $this->M_Dosen_Penguji->get_dosen_penguji_where($id);
                $result = array_merge($result[0],array('dosen' => $dosen));
            }

            $this->response($result,REST_Controller::HTTP_OK);
        } else {
            $result = $this->M_User->get_all_user();
            if($role == 0) {
                $res =[];
                $index = 0;
                foreach ($result as $row){
                    $dosen = $this->M_Dosen_Penguji->get_dosen_penguji_where($row['id']);
                    $temp = array_merge($result[$index], array('dosen' => $dosen));
                    $result[$index] = $temp;
                    $index++;
                }
            }
            $this->response($result,REST_Controller::HTTP_OK);
        }
    }

}
