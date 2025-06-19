<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('landingpage');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->load->view('auth/login');
        } else {
            // validasinya success
            $this->_login();
        }
    }

    private function _login()
    {
        //Database SB2
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $userpass = $this->db->get_where('userpassword', ['username' => $username, 'password' => $password])->row_array();
        //
        //
        //
        //
        //Database SignalBit
        // $db_nag = $this->load->database('db_nag', TRUE);
        // $username = $this->input->post('username');
        // $password = $this->input->post('password');
        // $userpass = $db_nag->get_where('userpassword', ['username' => $username, 'password' => $password])->row_array();
        //
        if ($userpass) {
            $data = [
                'username'  => $userpass['username'],
                'password'  => $userpass['password']
            ];
            $this->session->set_userdata($data);
            redirect('landingpage');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Wrong username or password!</div>');
            $this->load->view('auth/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('password');

        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        // You have been logged out!</div>');
        redirect('auth');
    }
}
