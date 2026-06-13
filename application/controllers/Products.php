<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'You do not have permission to access Products.');
            redirect('dashboard');
        }
        $this->load->model('Product_model');
    }

    public function index()
    {
        $data['title'] = 'Beauty Products';
        $data['products'] = $this->Product_model->get_all_products();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('products/index', $data);
        $this->load->view('layout/footer');
    }

    public function store()
    {
        $data = array(
            'product_code' => $this->input->post('product_code'),
            'product_name' => $this->input->post('product_name'),
            'category'     => $this->input->post('category'),
            'price'        => $this->input->post('price'),
            'stock'        => $this->input->post('stock')
        );

        $this->Product_model->insert_product($data);
        $this->session->set_flashdata('success', 'Product added successfully.');
        redirect('products');
    }

    public function update()
    {
        $id = $this->input->post('product_id');
        $data = array(
            'product_code' => $this->input->post('product_code'),
            'product_name' => $this->input->post('product_name'),
            'category'     => $this->input->post('category'),
            'price'        => $this->input->post('price'),
            'stock'        => $this->input->post('stock')
        );

        $this->Product_model->update_product($id, $data);
        $this->session->set_flashdata('success', 'Product updated successfully.');
        redirect('products');
    }

    public function delete($id)
    {
        $this->Product_model->delete_product($id);
        $this->session->set_flashdata('success', 'Product deleted successfully.');
        redirect('products');
    }
}
