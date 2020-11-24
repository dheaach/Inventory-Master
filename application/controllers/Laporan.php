<?php
defined("BASEPATH") or exit();

Class Laporan extends CI_Controller{

	public function pelanggan(){
		$curr = shortcode_login();
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;
		$data['bulin'] = date('m');
		$data['tahun'] = date("Y");
		$bulan = date('m');
		$tahun = date("Y");

		$this->load->model("mdreport");
		$data['list_cc'] = $this->mdreport->list_cc();
		$data['list_dd'] = $this->mdreport->list_cc1();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['listdah'] = $this->mdreport->listdiv1("array");

		$data['title'] .= " Inventory Pelanggan";
		$data['query'] = $this->mdreport->report_pelanggan($bulan,$tahun);

		$this->load->view("header",$data);
		$this->load->view("laporan");
		$this->load->view("footer");
	}

	public function cari_pelanggan(){
		$curr = shortcode_login();
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;
		$bulan = $this->input->post('sasi');
		$tahun = $this->input->post('tahin');
		$data['bulin'] = $bulan;
		$data['tahun'] = $tahun;
		$golek = $this->input->post('golek');

		$this->load->model("mdreport");
		$data['list_cc'] = $this->mdreport->list_cc();
		$data['list_dd'] = $this->mdreport->list_cc1();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['listdah'] = $this->mdreport->listdiv1("array");

		$data['title'] .= " Inventory Pelanggan";
		if(empty($golek)) {
			$data['query'] = $this->mdreport->report_pelanggan($bulan,$tahun);
		}else{
			$data['query'] = $this->mdreport->report_pelanggan1($bulan,$tahun,$golek);
		}

		$this->load->view("header",$data);
		$this->load->view("laporan");
		$this->load->view("footer");
	}

	public function langganan(){
		$curr = shortcode_login();
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;

		$this->load->model("mdreport");
		$data['list_cc'] = $this->mdreport->list_cc();
		$data['list_dd'] = $this->mdreport->list_cc1();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['listdah'] = $this->mdreport->listdiv1("array");

		$data['title'] .= " Inventory Pelanggan";
		$data['query'] = $this->mdreport->report_divisi();

		$data['bulin'] = date('m');
		$data['tahun'] = date('Y');

		$this->load->view("header",$data);
		$this->load->view("laporan");
		$this->load->view("footer");

	}

	public function detail(){
		$curr = shortcode_login();
		$data['title'] = "Detail";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;

		$this->load->model("mdreport");
		$kosong = $this->mdreport->galon_kosong();
		$id_pelanggan = $this->input->post('idpelanggan');
		$nama = $this->input->post('pelanggan');
		$id_master = $this->input->post('idmaster');
		$bulan = $this->input->post('moon');
		$tahun = $this->input->post('taun');

		$data['bulin'] = $bulan;
		$data['tahun'] = $tahun;
		$data['id_p'] = $id_pelanggan;
		$data['id_master'] = $id_master;
		//$data['jumlah'] = $this->mdreport->jumlah_detail($id_pelanggan,$id_master,$bulan,$tahun);

		$data['list_cc'] = $this->mdreport->list_cc();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['title'] .= " Inventory Pelanggan : ".$nama."";

		$data['query'] = $this->mdreport->detail($id_pelanggan,$id_master,$bulan,$tahun);

		$this->load->view("header",$data);
		$this->load->view("detail_kosong");
		$this->load->view("footer");

	}

//-----------------------------------------ANYAR------------------------------------------------------------------------//



	public function barang()
	{
		$curr = shortcode_login();
		$this->load->model("mdreport");
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;
		$data['bulin'] = date('m');
		$data['tahun'] = date("Y");


		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		$data['iyo'] = $this->mdreport->baku();
		$data['id'] = $this->mdreport->get_id();
		$data['benda'] = $this->mdreport->getAll();

		$data['title'] .= " Stok Data Gudang";

		$data['tinggil'] = date("Y-m-d");

		$this->load->view("header",$data);
		$this->load->view("lap_gudang");
		$this->load->view("footer");
	}

	public function barang1()
	{
		$curr = shortcode_login();
		$this->load->model("mdreport");
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;

		$data['bulin'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');

		$data['iyo'] = $this->mdreport->baku();
		$data['id'] = $this->mdreport->get_id();
		$data['benda'] = $this->mdreport->getAll();

		$data['title'] .= " Stok Data Gudang";

		$data['tinggil'] = date("Y-m-d");

		$this->load->view("header",$data);
		$this->load->view("lap_gudang");
		$this->load->view("footer");
	}

	public function cari()
	{
		$curr = shortcode_login();
		$this->load->model("mdreport");
		$data['title'] = "Laporan ";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;
		$data['ku'] = $this->mdreport->baku();
		$id = $this->input->post('nama_barang');
		$nama = $this->db->query("SELECT nama FROM cc_master WHERE id='$id'")->row_array();

		$data['ten'] = $this->mdreport->sepuluh();
		$data['twel'] = $this->mdreport->duabelas();
		$data['id'] = $id;
		$data['benda'] = $this->mdreport->getAll();
		$data['stok'] = $this->mdreport->get_stok($id);

		$data['akhiran'] = $this->mdreport->akhir($id);

		$data['bulin'] = date('m');
		$data['tahun'] = date("Y");

		$op10 = $this->mdreport->galon_10rb();
		$op12 = $this->mdreport->galon_12rb();
		$kosong = $this->mdreport->galon_kosong();

		if($id == $kosong){
			$data['query'] = $this->mdreport->report_master($id);
		}else{
			$data['query'] = $this->mdreport->report_op($id);
		}

		$data['list_cc'] = $this->mdreport->list_cc2();
		$data['title'] = "Stok Data Gudang : ".$nama["nama"];

		$this->load->view("header",$data);
		$this->load->view("laporan_gud");
		$this->load->view("footer");
	}
}