<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('mduser');
	}

	public function index(){
		redirect("add_user/cc");
	}

	public function cc(){
		$curr = shortcode_login();
		$data['title'] = "Data User";
		$data['menu'] = 7;
		$data['curr'] = $curr;
		$data['tb'] = "cms_admin";

		$this->load->model("mduser");
		$data['query'] = $this->mduser->load_cc();

		$this->load->view("header",$data);
		$this->load->view("user");
		$this->load->view("footer");
	}

	public function registration()
	{
        $username   = $this->input->post('username'); 
		$nama       = $this->input->post('nama');
        $email       = $this->input->post('email'); 
        $password      = password_hash($this->input->post('password'), PASSWORD_DEFAULT);	

        $data = array(
            'username'  => $username,
            'name'      => $nama,
            'email'      => $email,
            'password'     => $password,
            'priviledge' => '2'
        );

        $ok = $this->mduser->tambah($data, 'cms_admin');
        if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil Ditambah');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal Ditambah');
    	}
        redirect('add_user/cc');
	}

	public function update()
	{
        $id=$this->input->post('id');
        $user=$this->input->post('user');
        $nama=$this->input->post('nama');
        $email=$this->input->post('email');

		$ok = $this->mduser->update($id,$user,$nama,$email);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil Diupdate');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal Diupdate');
    	}
		
		redirect('add_user/cc/'. $a);
	}

	public function hapus($id)
    {
        $where = array('id' => $id);
        $hapus = $this->mduser->delete('cms_admin',$where);
        if($hapus > 0){
     		$this->session->set_flashdata('success', 'Berhasil Dihapus');
    	}if(!$hapus){
    		$this->session->set_flashdata('danger', 'Gagal Dihapus : Data Masih Diperlukan');
    	}
        redirect('add_user/cc');
        
    }
}