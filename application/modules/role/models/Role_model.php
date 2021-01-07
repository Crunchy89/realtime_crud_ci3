<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
    function __construct()
    {
        $this->table = "role";
        $this->id = "id_role";
    }
    public function tambah()
    {
        $post = $this->input->post();
        $role = htmlspecialchars($post['role']);
        $data = [
            'role' => $role
        ];
        $this->db->insert($this->table, $data);

        $return = $this->db->get($this->table)->result();
        $json = [
            'status' => true,
            'pesan' => 'Role Berhasil ditambah',
            'data' => $return,
        ];

        return $json;
    }
    public function edit()
    {
        $post = $this->input->post();
        $role = htmlspecialchars($post['role']);
        $id = htmlspecialchars($post['id']);
        $data = [
            'role' => $role
        ];
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);

        $return = $this->db->get($this->table)->result();
        $json = [
            'status' => true,
            'pesan' => 'Role Berhasil diubah',
            'data' => $return,
        ];

        return $json;
    }
    public function hapus()
    {
        $post = $this->input->post();
        $id = htmlspecialchars($post['id']);
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);

        $return = $this->db->get($this->table)->result();
        $json = [
            'status' => true,
            'pesan' => 'Role Berhasil dihapus',
            'data' => $return,
        ];

        return $json;
    }
}
