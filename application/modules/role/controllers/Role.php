<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('role_model', 'model');
	}

	public function index()
	{
		$this->load->view('index');
	}
	public function getData()
	{
		$data = [
			'status' => true,
			'pesan' => 'Data berhasil diambil',
			'data' => $this->db->get('role')->result()
		];
		echo json_encode($data);
	}
	public function aksi()
	{
		$aksi = htmlspecialchars($this->input->post('aksi'));
		if ($aksi == 'tambah') {
			$data = $this->model->tambah();
			echo json_encode($data);
		} else if ($aksi == 'edit') {
			$data = $this->model->edit();
			echo json_encode($data);
		} else if ($aksi == 'hapus') {
			$data = $this->model->hapus();
			echo json_encode($data);
		}
	}
}
