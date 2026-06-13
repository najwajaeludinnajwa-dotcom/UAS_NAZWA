<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Product_model');
        $this->load->model('Member_model');
        $this->load->model('Order_model');
    }

    public function index()
    {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        $data['title'] = 'Dashboard';
        
        if ($role == 'admin' || $role == 'manager') {
            // Admin and Manager see all data
            $data['total_products'] = $this->Product_model->count_all_products();
            $data['total_members']  = $this->Member_model->count_all_members();
            $data['total_orders']   = $this->Order_model->count_orders();
            $data['total_revenue']  = $this->Order_model->get_total_revenue();
            $data['latest_transactions'] = $this->Order_model->get_latest_transactions(5);
        } else if ($role == 'sales') {
            // Sales sees only their data
            $data['total_products'] = $this->Product_model->count_all_products(); // Can see products count
            $data['total_members']  = $this->Member_model->count_all_members();   // Can see members count
            $data['total_orders']   = $this->Order_model->count_orders($user_id);
            $data['total_revenue']  = $this->Order_model->get_total_revenue($user_id);
            $data['latest_transactions'] = $this->Order_model->get_latest_transactions(5, $user_id);
        }

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer');
    }
}
