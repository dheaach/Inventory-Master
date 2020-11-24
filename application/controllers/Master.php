<?php
defined("BASEPATH") or exit();

Class Master extends CI_Controller{
	public function __construct()
    {
        parent::__construct();

        $this->load->model("mdmaster");
    }
	public function index(){
		redirect("master/cc");
	}

	public function cc(){
		$curr = shortcode_login();
		$data['title'] = "Data Master Gudang";
		$data['menu'] = 2;
		$data['submenu'] = 21;
		$data['curr'] = $curr;
		$data['tb'] = "master";

		$this->load->model("mdmaster");

		$data['date'] = date("Y-m-d");
		$data['query'] = $this->mdmaster->load_cc();
		$data['idku'] = rand()%100;
		$data['idku'] = $this->mdmaster->kode();

		$this->load->view("header",$data);
		$this->load->view("master");
		$this->load->view("footer");
	}
	public function add()
	{
		$nama=$this->input->post('cc_nama');
		$harga=$this->input->post('cc_harga');
		$stok=$this->input->post('cc_stok');
		$id=$this->input->post('cc_id');
		$id_admin = $this->session->userdata('user_id');
		$tgl = date('Y-m-d');

		$this->load->model('mdmaster');
		$ok = $this->mdmaster->add($id,$nama,$harga,$stok);
		if($ok > 0){
			$eko = array(
				'id_t' 		=> '',
				'id_master' => $id,
				'id_admin' 	=> $id_admin,
				'tgl'		=> $tgl,
				'jml'		=> $stok,
				'ket'		=> 'Stok Awal',
				'stat'		=>	1
			);
			$this->db->insert('cc_terima',$eko);
     		$this->session->set_flashdata('success', 'Berhasil disimpan');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal disimpan');
    	}
		redirect('master/cc');
	}
	public function divisi(){
		$curr = shortcode_login();
		$data['title'] = "Data Master Divisi";
		$data['menu'] = 2;
		$data['submenu'] = 22;
		$data['curr'] = $curr;
		$data['tb'] = "master";

		$this->load->model("mdmaster");

		$data['date'] = date("Y-m-d");
		$data['query'] = $this->mdmaster->load_divisi();

		$this->load->view("header",$data);
		$this->load->view("divisi");
		$this->load->view("footer");
	}


	public function delete($id,$type="master"){
		$curr = shortcode_login();

		if($type=="master"){
			$tb = "cc_master";
			$target = "cc";
		}
		else if($type=="divisi"){
			$tb = "cc_divisi";
			$target = "divisi";
		}

		$sql = query("UPDATE $tb SET stat = 9 WHERE id = ".quote($id));
		create_alert("Success","Berhasil menghapus data $type","master/$target");
	}

	public function edit($inf,$id=0){
		$curr = shortcode_login();
		$data['title'] = "Edit Data";
		$data['curr'] = $curr;

		if($inf == "master"){
			$data['menu'] = 2;
			$data['submenu'] = 21;
			$data['tb'] = "master";
			$data['row'] = $this->cms->get_page("cc_master",$id);
			$load = "crud_master";
		}
		else if($inf == "divisi"){
			$data['menu'] = 2;
			$data['submenu'] = 22;
			$data['tb'] = "divisi";
			$data['row'] = $this->cms->get_page("cc_divisi",$id);
			$load = "crud_divisi";
		}

		$this->load->model("mdmaster");

		$this->load->view("header_box",$data);
		$this->load->view($load);
		$this->load->view("footer");
	}

	public function pelanggan()
	{
		$curr = shortcode_login();
		$data['title'] = "Data Pelanggan";
		$data['menu'] = 22;
		$data['curr'] = $curr;
		$data['tb'] = "master";

		$this->load->model("mdmaster");

		$data['query'] = $this->mdmaster->pelanggan();
		$data['product'] = $this->mdmaster->produk();
		$this->load->view("header",$data);
		$this->load->view("pelanggan");
		$this->load->view("footer");
	}
	public function search()
	{
		
        $curr = shortcode_login();
		$data['title'] = "Data Pelanggan";
		$data['menu'] = 22;
		$data['curr'] = $curr;
		$data['tb'] = "master";

		$key=$this->input->post('search');
        $this->mdmaster->search($key);

		$data['query'] = $this->mdmaster->search($key); 
		$data['product'] = $this->mdmaster->produk();
		$this->load->view("header",$data);
		$this->load->view("pelanggan");
		$this->load->view("footer");
	}
	public function tambah()
	{
		
		$nama=$this->input->post('cc_nama');
		$alamat=$this->input->post('cc_alamat');
		$no=$this->input->post('cc_no');
		$brg='';
        $tot=0;
        $ket=$this->input->post('cc_ket');

		$this->load->model('mdmaster');
		$ok = $this->mdmaster->tambah($brg,$nama,$alamat,$no,$tot,$ket);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil disimpan');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal disimpan');
    	}
		redirect('master/pelanggan');
	}
	public function update()
	{
		$id=$this->input->post('id');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$no=$this->input->post('no');
		$brg=$this->input->post('brg');
		$tot=$this->input->post('tot');
		$ket=$this->input->post('ket');
		$this->load->model('mdmaster');
		$ok = $this->mdmaster->edit($id,$brg,$nama,$alamat,$no,$tot,$ket);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil Diupdate');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal Diupdate');
    	}
		redirect('master/pelanggan');
	}
	public function hapus()
	{
		$id=$this->input->post('id');
		$this->load->model('mdmaster');
		$ok = $this->mdmaster->hapus($id);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil Dihapus');
    	}if(!$ok){
    		$this->session->set_flashdata('danger', 'Gagal Dihapus : Data Masih Diperlukan');
    	}
		redirect('master/pelanggan');
	}
	public function delete2(){
		$this->load->model('mdmaster');
		$id=$this->input->post('id');
		$ok = $this->mdmaster->delete($id);
		if($ok > 0){
			$this->session->set_flashdata('success','Berhasil Dihapus');
		}if(!$ok){
			$this->session->set_flashdata('danger','Gagal Dihapus : Data Masih Diperlukan');
		}

		redirect('master/cc');
	}
}