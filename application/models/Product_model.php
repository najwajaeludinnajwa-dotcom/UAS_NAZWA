<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function get_all_products()
    {
        $this->db->order_by('product_name', 'ASC');
        return $this->db->get('beauty_products')->result();
    }

    public function get_product_by_id($id)
    {
        $this->db->where('product_id', $id);
        return $this->db->get('beauty_products')->row();
    }

    public function insert_product($data)
    {
        return $this->db->insert('beauty_products', $data);
    }

    public function update_product($id, $data)
    {
        $this->db->where('product_id', $id);
        return $this->db->update('beauty_products', $data);
    }

    public function delete_product($id)
    {
        $this->db->where('product_id', $id);
        return $this->db->delete('beauty_products');
    }

    public function count_all_products()
    {
        return $this->db->count_all('beauty_products');
    }
}
