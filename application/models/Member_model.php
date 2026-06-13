<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

    public function get_all_members()
    {
        $this->db->order_by('member_name', 'ASC');
        return $this->db->get('members')->result();
    }

    public function get_member_by_id($id)
    {
        $this->db->where('member_id', $id);
        return $this->db->get('members')->row();
    }

    public function insert_member($data)
    {
        return $this->db->insert('members', $data);
    }

    public function update_member($id, $data)
    {
        $this->db->where('member_id', $id);
        return $this->db->update('members', $data);
    }

    public function delete_member($id)
    {
        $this->db->where('member_id', $id);
        return $this->db->delete('members');
    }

    public function count_all_members()
    {
        return $this->db->count_all('members');
    }
}
