<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        $role = $this->session->userdata('role');
        if ($role !== 'admin' && $role !== 'manager') {
            $this->session->set_flashdata('error', 'You do not have permission to access Reports.');
            redirect('dashboard');
        }
        
        $this->load->model('Report_model');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['title'] = 'Reports';
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('reports/index');
        $this->load->view('layout/footer');
    }

    public function sales()
    {
        $data['title'] = 'Sales Performance Report';
        $data['report_data'] = $this->Report_model->get_sales_performance();

        if ($this->input->get('export') == 'pdf') {
            $html = $this->load->view('reports/pdf_sales', $data, true);
            $this->pdf->generate($html, 'Sales_Report_'.date('Ymd'));
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/topbar');
            $this->load->view('reports/sales', $data);
            $this->load->view('layout/footer');
        }
    }

    public function products()
    {
        $data['title'] = 'Product Sales Report';
        $data['report_data'] = $this->Report_model->get_product_sales();

        if ($this->input->get('export') == 'pdf') {
            $html = $this->load->view('reports/pdf_products', $data, true);
            $this->pdf->generate($html, 'Product_Sales_Report_'.date('Ymd'));
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/topbar');
            $this->load->view('reports/products', $data);
            $this->load->view('layout/footer');
        }
    }

    public function period()
    {
        $data['title'] = 'Report By Period';
        
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : date('Y-m-01');
        $end_date   = $this->input->get('end_date') ? $this->input->get('end_date') : date('Y-m-t');

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;
        $data['report_data'] = $this->Report_model->get_period_report($start_date, $end_date);

        if ($this->input->get('export') == 'pdf') {
            $html = $this->load->view('reports/pdf_period', $data, true);
            $this->pdf->generate($html, 'Period_Report_'.date('Ymd'));
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar');
            $this->load->view('layout/topbar');
            $this->load->view('reports/period', $data);
            $this->load->view('layout/footer');
        }
    }
}
