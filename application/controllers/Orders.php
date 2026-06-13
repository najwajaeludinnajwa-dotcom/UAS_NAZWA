<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Member_model');
    }

    public function index()
    {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        $data['title'] = 'Sales Orders';
        
        if ($role == 'admin' || $role == 'manager') {
            $data['orders'] = $this->Order_model->get_all_orders();
        } else {
            $data['orders'] = $this->Order_model->get_all_orders($user_id);
        }

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('orders/index', $data);
        $this->load->view('layout/footer');
    }

    public function create()
    {
        if ($this->session->userdata('role') == 'manager') {
            $this->session->set_flashdata('error', 'Managers cannot create orders.');
            redirect('orders');
        }

        $data['title'] = 'Create Sales Order';
        $data['members'] = $this->Member_model->get_all_members();
        // Only get products with stock > 0
        $this->db->where('stock >', 0);
        $data['products'] = $this->Product_model->get_all_products();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('orders/create', $data);
        $this->load->view('layout/footer');
    }

    public function store()
    {
        if ($this->session->userdata('role') == 'manager') {
            redirect('orders');
        }

        $member_id = $this->input->post('member_id');
        $products = $this->input->post('product_id');
        $quantities = $this->input->post('quantity');
        $prices = $this->input->post('price');
        
        if(empty($products)) {
            $this->session->set_flashdata('error', 'Please select at least one product.');
            redirect('orders/create');
        }

        $grand_total = 0;
        $items_data = array();

        for($i = 0; $i < count($products); $i++) {
            if($quantities[$i] > 0) {
                $subtotal = $prices[$i] * $quantities[$i];
                $grand_total += $subtotal;
                
                $items_data[] = array(
                    'product_id' => $products[$i],
                    'quantity'   => $quantities[$i],
                    'unit_price' => $prices[$i],
                    'subtotal'   => $subtotal
                );
            }
        }

        if(empty($items_data)) {
            $this->session->set_flashdata('error', 'Quantities must be greater than zero.');
            redirect('orders/create');
        }

        $order_data = array(
            'invoice_number' => $this->Order_model->generate_invoice_number(),
            'member_id'      => $member_id,
            'sales_id'       => $this->session->userdata('user_id'),
            'order_date'     => date('Y-m-d'),
            'order_status'   => 'Pending',
            'grand_total'    => $grand_total
        );

        if($this->Order_model->insert_order($order_data, $items_data)) {
            $this->session->set_flashdata('success', 'Sales order created successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to create sales order.');
        }
        
        redirect('orders');
    }

    public function detail($id)
    {
        $role = $this->session->userdata('role');
        $user_id = $this->session->userdata('user_id');

        $data['title'] = 'Order Detail';
        
        if ($role == 'admin' || $role == 'manager') {
            $data['order'] = $this->Order_model->get_order_by_id($id);
        } else {
            $data['order'] = $this->Order_model->get_order_by_id($id, $user_id);
        }

        if(empty($data['order'])) {
            $this->session->set_flashdata('error', 'Order not found or unauthorized access.');
            redirect('orders');
        }

        $data['items'] = $this->Order_model->get_order_items($id);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/topbar');
        $this->load->view('orders/detail', $data);
        $this->load->view('layout/footer');
    }

    public function update_status()
    {
        if ($this->session->userdata('role') == 'manager') {
            redirect('orders');
        }

        $order_id = $this->input->post('order_id');
        $status = $this->input->post('order_status');
        
        // Check if sales, only allow updating own orders
        if ($this->session->userdata('role') == 'sales') {
            $order = $this->Order_model->get_order_by_id($order_id, $this->session->userdata('user_id'));
            if(empty($order)) {
                $this->session->set_flashdata('error', 'Unauthorized access.');
                redirect('orders');
            }
            if($order->order_status == 'Completed' || $order->order_status == 'Cancelled') {
                $this->session->set_flashdata('error', 'Cannot update completed or cancelled orders.');
                redirect('orders/detail/'.$order_id);
            }
        }

        $this->Order_model->update_status($order_id, $status);
        $this->session->set_flashdata('success', 'Order status updated successfully.');
        redirect('orders/detail/'.$order_id);
    }
}
