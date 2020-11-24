<?php
defined("BASEPATH") or exit();

Class Laporan2 extends CI_Controller{

	public function liporan()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['title'] = "Laporan ";
		$data['menu'] = 5;
		$data['submenu'] = 51;
		$data['curr'] = $curr;
		$key = $this->input->post('tanggal');
		
		$data['quer'] = $this->mdlaporan->celuk();
		$data['keluar'] = $this->mdlaporan->pengeluaran();
		$data['title'] .= "Pendapatan Harian";
		
		$data['query'] = $this->mdlaporan->njupuk_brg();

		$data['tinggil'] = date("Y-m-d");

		$this->load->view("header",$data);
		$this->load->view("laporan2");
		$this->load->view("footer");	
	}

	public function search()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$this->load->library("session");
		$data['title'] = "Laporan ";
		$data['menu'] = 5;
		$data['submenu'] = 51;
		$data['curr'] = $curr;
		$data['query'] = $this->mdlaporan->njupuk_brg();
		$key = $this->input->post('tanggal');
		$hem = $this->input->post('tgl');
		$golek = $this->input->post('golek');
		if(!empty($key)) {
			$data['tinggil'] = $this->input->post('tanggal');
			$data['quer'] = $this->mdlaporan->celuks($key);
			$data['keluar'] = $this->mdlaporan->pengeluarans($key);
		}elseif(!empty($hem)){
			$data['tinggil'] = $hem;
			$key = $hem;
			$data['quer'] = $this->mdlaporan->panggil($golek,$hem);
			$data['keluar'] = $this->mdlaporan->pengeluarans($key);
		}
		else{
			$key = $data['tinggil'] = $this->mdlaporan->ambil_tanggal();
			$data['quer'] = $this->mdlaporan->celuks($key);
			$data['keluar'] = $this->mdlaporan->pengeluarans($key);
		}
		
		$data['title'] .= "Pendapatan Harian";

		$data['date'] = date("Y-m-d");

		$this->load->view("header",$data);
		$this->load->view("laporan2");
		$this->load->view("footer");	
	}

	public function lap_bulan()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['title'] = "Laporan ";
		$data['menu'] = 5;
		$data['submenu'] = 51;
		$data['curr'] = $curr;
				
		$data['quer'] = $this->mdlaporan->abc();
		$data['keluar'] = $this->mdlaporan->keluaran();
		$data['title'] .= "Pendapatan Bulanan";
		$data['query'] = $this->mdlaporan->njupuk_brg();

		$data['bulin'] = date('m');
		$data['tahun'] = date("Y");

		$this->load->view("header",$data);
		$this->load->view("bulanan");
		$this->load->view("footer");	
	}


	public function cari()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['title'] = "Laporan ";
		$data['menu'] = 5;
		$data['submenu'] = 51;
		$data['curr'] = $curr;
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
			
		$data['quer'] = $this->mdlaporan->abcs($bulan,$tahun);
		$data['keluar'] = $this->mdlaporan->keluarans($bulan,$tahun);
		$data['title'] .= "Pendapatan Bulanan";
		$data['query'] = $this->mdlaporan->njupuk_brg();

		$data['bulin'] = $bulan;
		$data['tahun'] = $tahun;

		$this->load->view("header",$data);
		$this->load->view("bulanan");
		$this->load->view("footer");	

	}

/*-------------------------------------------------------------------------------------------------------------------------*/

	public function pengambilan()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['title'] = "Laporan Pengambilan Bulanan";
		$data['menu'] = 5;
		$data['submenu'] = 52;
		$data['curr'] = $curr;
		$data['bulin'] = date('m');
		$data['tahun'] = date("Y");

		$data['kuer'] = $this->mdlaporan->ambil();

		$this->load->view("header",$data);
		$this->load->view("pengambilan");
		$this->load->view("footer");	

	}

	public function cari_pengambilan()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['title'] = "Laporan Pengambilan Bulanan";
		$data['menu'] = 5;
		$data['submenu'] = 52;
		$data['curr'] = $curr;
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$data['bulin'] = $bulan;
		$data['tahun'] = $tahun;

		$data['kuer'] = $this->mdlaporan->ambil_lainnya($bulan,$tahun);

		$this->load->view("header",$data);
		$this->load->view("pengambilan");
		$this->load->view("footer");	

	}

	public function cari_pelanggan()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['title'] = "Laporan Pengambilan Bulanan";
		$data['menu'] = 5;
		$data['submenu'] = 52;
		$data['curr'] = $curr;
		$bulan = $this->input->post('sasi');
		$tahun = $this->input->post('tahin');
		$golek = $this->input->post('golek');
		$data['bulin'] = $bulan;
		$data['tahun'] = $tahun;

		$data['kuer'] = $this->mdlaporan->ambil_terus($bulan,$tahun,$golek);

		$this->load->view("header",$data);
		$this->load->view("pengambilan");
		$this->load->view("footer");	

	}
	
	public function detail_pengambilan()
	{
		$curr = shortcode_login();
		$this->load->model("mdlaporan");
		$data['menu'] = 5;
		$data['submenu'] = 52;
		$data['curr'] = $curr;
		$id_pelanggan = $this->input->post('id_p');
		$nama = $this->input->post('nama');
		$bulan = $this->input->post('moon');
		$tahun = $this->input->post('taun');

		$data['title'] = "Detail Pengambilan Oleh : ".$nama."";
		$data['bulin'] = $bulan;
		$data['tahun'] = $tahun;
		$data['id_p']  = $id_pelanggan;

		$data['kuer'] = $this->mdlaporan->ambil_maneh($bulan,$tahun,$id_pelanggan);

		$this->load->view("header",$data);
		$this->load->view("detail_pengambilan");
		$this->load->view("footer");	
	}
}	