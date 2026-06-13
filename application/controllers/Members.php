<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to access Members.');
            redirect('dashboard');
        }
        $this->load->model('Member_model');
    }

    public function index()
    {
        $data['title'] = 'Members';
        $data['members'] = $this->Member_model->get_all_members();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('members/index', $data);
        $this->load->view('layout/footer');
    }

    public function store()
    {
        $data = array(
            'member_name'  => $this->input->post('member_name'),
            'phone_number' => $this->input->post('phone_number'),
            'address'      => $this->input->post('address')
        );

        $this->Member_model->insert_member($data);
        $this->session->set_flashdata('success', 'Member added successfully.');
        redirect('members');
    }

    public function update()
    {
        $id = $this->input->post('member_id');
        $data = array(
            'member_name'  => $this->input->post('member_name'),
            'phone_number' => $this->input->post('phone_number'),
            'address'      => $this->input->post('address')
        );

        $this->Member_model->update_member($id, $data);
        $this->session->set_flashdata('success', 'Member updated successfully.');
        redirect('members');
    }

    public function delete($id)
    {
        $this->Member_model->delete_member($id);
        $this->session->set_flashdata('success', 'Member deleted successfully.');
        redirect('members');
    }
}
