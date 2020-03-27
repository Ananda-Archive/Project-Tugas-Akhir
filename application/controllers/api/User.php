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
                // $password = $this->post('nomor');
                $password = hash('sha512',$this->post('nomor') . config_item('encryption_key'));
                $role = $this->post('role');
                $dosen_penguji = $this->post('dosen_penguji');
                $id_dosen_pembimbing = $this->post('id_dosen_pembimbing');
                $id_ketua_penguji = $this->post('id_ketua_penguji');
                $id_dosen_penguji = $this->post('id_dosen_penguji');
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
                    if($this->M_User->insert($nomor,$nama,$password,$role,$id_dosen_pembimbing,$id_ketua_penguji,$id_dosen_penguji)) {
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
            $this->response($result,REST_Controller::HTTP_OK);
        } else {
            $idx = 0;
            $result = $this->M_User->get_all_user();
            foreach($result as $row) {
                $berkas = $this->M_Berkas->get_berkas_where_mahasiswa($row['id']);
                $temp = array_merge($result[$idx], array('berkas' => $berkas));
                $result[$idx] = $temp;
                $idx++;
            }
            $this->response($result,REST_Controller::HTTP_OK);
        }
    }

    public function index_put() {
        $id = $this->put('id');
        $nomor = $this->put('nomor');
        $nama = $this->put('nama');
        $role = $this->put('role');
        $id_dosen_pembimbing = $this->put('id_dosen_pembimbing');
        $id_ketua_penguji = $this->put('id_ketua_penguji');
        $id_dosen_penguji = $this->put('id_dosen_penguji');
        if(!isset($id)){
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE." id"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if($this->M_User->is_not_exists($id)){
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::INVALID_ID_MESSAGE. " id does not exist"
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if(($id_dosen_pembimbing != $this->M_User->is_dosen_pembimbing($id)) || ($id_ketua_penguji != $this->M_User->is_ketua_penguji($id)) || ($id_dosen_penguji != $this->M_User->is_dosen_penguji($id))) {
            $this->M_Berkas->delete_by_id_mahasiswa($id);
            $this->M_Berita_Acara->delete_by_id_mahasiswa($id);
        }
        if ($this->M_User->update($id, $nomor, $nama, $role, $id_dosen_pembimbing, $id_ketua_penguji, $id_dosen_penguji)) {
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

    public function index_delete() {
        $id = $this->input->get('id');
        if (!isset($id)) {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::REQUIRED_PARAMETER_MESSAGE."id"
                ),REST_Controller::HTTP_BAD_REQUEST
            );
            return;
        }
        if ($this->M_User->delete($id)) {
            $this->response(
                array(
                    'status' => TRUE,
                    'message' => $this::DELETE_SUCCESS_MESSSAGE
                ), REST_Controller::HTTP_OK
            );
        } else {
            $this->response(
                array(
                    'status' => FALSE,
                    'message' => $this::DELETE_FAILED_MESSAGE
                ),REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}
