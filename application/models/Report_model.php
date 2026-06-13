<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function get_sales_performance()
    {
        $this->db->select('users.full_name as sales_name, COUNT(beauty_orders.order_id) as total_transactions, SUM(beauty_orders.grand_total) as total_revenue');
        $this->db->from('users');
        $this->db->join('beauty_orders', 'beauty_orders.sales_id = users.user_id', 'left');
        $this->db->where('users.role', 'sales');
        $this->db->where('beauty_orders.order_status !=', 'Cancelled');
        $this->db->group_by('users.user_id');
        return $this->db->get()->result();
    }

    public function get_product_sales()
    {
        $this->db->select('beauty_products.product_code, beauty_products.product_name, SUM(beauty_order_items.quantity) as total_sold, SUM(beauty_order_items.subtotal) as total_revenue');
        $this->db->from('beauty_products');
        $this->db->join('beauty_order_items', 'beauty_order_items.product_id = beauty_products.product_id', 'left');
        $this->db->join('beauty_orders', 'beauty_orders.order_id = beauty_order_items.order_id', 'left');
        $this->db->where('beauty_orders.order_status !=', 'Cancelled');
        $this->db->or_where('beauty_orders.order_id IS NULL'); // Show products with 0 sales too
        $this->db->group_by('beauty_products.product_id');
        $this->db->order_by('total_sold', 'DESC');
        return $this->db->get()->result();
    }

    public function get_period_report($start_date, $end_date)
    {
        $this->db->select('beauty_orders.*, members.member_name, users.full_name as sales_name');
        $this->db->from('beauty_orders');
        $this->db->join('members', 'members.member_id = beauty_orders.member_id');
        $this->db->join('users', 'users.user_id = beauty_orders.sales_id');
        $this->db->where('beauty_orders.order_date >=', $start_date);
        $this->db->where('beauty_orders.order_date <=', $end_date);
        $this->db->where('beauty_orders.order_status !=', 'Cancelled');
        $this->db->order_by('beauty_orders.order_date', 'ASC');
        return $this->db->get()->result();
    }
}
