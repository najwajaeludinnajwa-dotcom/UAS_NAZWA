<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function get_all_orders($sales_id = null)
    {
        $this->db->select('beauty_orders.*, members.member_name, users.full_name as sales_name');
        $this->db->from('beauty_orders');
        $this->db->join('members', 'members.member_id = beauty_orders.member_id');
        $this->db->join('users', 'users.user_id = beauty_orders.sales_id');
        
        if ($sales_id) {
            $this->db->where('beauty_orders.sales_id', $sales_id);
        }
        
        $this->db->order_by('beauty_orders.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_order_by_id($id, $sales_id = null)
    {
        $this->db->select('beauty_orders.*, members.member_name, members.address, members.phone_number, users.full_name as sales_name');
        $this->db->from('beauty_orders');
        $this->db->join('members', 'members.member_id = beauty_orders.member_id');
        $this->db->join('users', 'users.user_id = beauty_orders.sales_id');
        $this->db->where('beauty_orders.order_id', $id);
        
        if ($sales_id) {
            $this->db->where('beauty_orders.sales_id', $sales_id);
        }
        
        return $this->db->get()->row();
    }

    public function get_order_items($order_id)
    {
        $this->db->select('beauty_order_items.*, beauty_products.product_code, beauty_products.product_name');
        $this->db->from('beauty_order_items');
        $this->db->join('beauty_products', 'beauty_products.product_id = beauty_order_items.product_id');
        $this->db->where('beauty_order_items.order_id', $order_id);
        return $this->db->get()->result();
    }

    public function generate_invoice_number()
    {
        $this->db->select('invoice_number');
        $this->db->from('beauty_orders');
        $this->db->order_by('order_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $last_invoice = $query->row()->invoice_number;
            $number = intval(substr($last_invoice, 7)) + 1;
            return 'INV-GB-' . sprintf('%03d', $number);
        } else {
            return 'INV-GB-001';
        }
    }

    public function insert_order($order_data, $items_data)
    {
        $this->db->trans_start();
        
        $this->db->insert('beauty_orders', $order_data);
        $order_id = $this->db->insert_id();
        
        foreach ($items_data as &$item) {
            $item['order_id'] = $order_id;
            // Update stock
            $this->db->set('stock', 'stock - ' . (int)$item['quantity'], FALSE);
            $this->db->where('product_id', $item['product_id']);
            $this->db->update('beauty_products');
        }
        
        $this->db->insert_batch('beauty_order_items', $items_data);
        
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function update_status($order_id, $status)
    {
        $this->db->where('order_id', $order_id);
        return $this->db->update('beauty_orders', array('order_status' => $status));
    }

    public function count_orders($sales_id = null)
    {
        if ($sales_id) {
            $this->db->where('sales_id', $sales_id);
        }
        return $this->db->count_all_results('beauty_orders');
    }

    public function get_total_revenue($sales_id = null)
    {
        $this->db->select_sum('grand_total');
        $this->db->where('order_status !=', 'Cancelled');
        if ($sales_id) {
            $this->db->where('sales_id', $sales_id);
        }
        $query = $this->db->get('beauty_orders')->row();
        return $query->grand_total ? $query->grand_total : 0;
    }

    public function get_latest_transactions($limit = 5, $sales_id = null)
    {
        $this->db->select('beauty_orders.*, members.member_name');
        $this->db->from('beauty_orders');
        $this->db->join('members', 'members.member_id = beauty_orders.member_id');
        if ($sales_id) {
            $this->db->where('beauty_orders.sales_id', $sales_id);
        }
        $this->db->order_by('beauty_orders.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
