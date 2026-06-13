<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return false;
    }

    public function get_user_by_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->get('users')->row();
    }

    public function get_all_sales()
    {
        $this->db->where('role', 'sales');
        return $this->db->get('users')->result();
    }
}
