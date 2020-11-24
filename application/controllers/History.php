<?php
defined("BASEPATH") or exit();

Class History extends CI_Controller{

	public function index(){
		$curr = shortcode_login();
		$data['title'] = "Arsip Data Bulanan";
		$data['menu'] = 6;
		$data['curr'] = $curr;

		$this->load->model("mdsetting");

		$data['date'] = date("Y-m-d");
		$data['query'] = $this->mdsetting->load_project();

		$this->load->view("header",$data);
		$this->load->view("setting");
		$this->load->view("footer");
	}

	public function pelanggan($id_project){
		$curr = shortcode_login();
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;

		$this->load->model("mdreport");
		$this->load->model("mdsetting");
		$data['list_cc'] = $this->mdreport->list_cc();
		$data['list_dd'] = $this->mdreport->list_cc1();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['listdah'] = $this->mdreport->listdiv1("array");
		$data['id'] = $id_project;

		$data['title'] .= " Inventory Pelanggan";
		$data['query'] = $this->mdsetting->report_divisi1($id_project);

		$data['dat'] = $this->mdsetting->get_tgl($id_project);

		$data['bulin'] = date('m');
		$data['tahun'] = date('Y');

		$this->load->view("header",$data);
		$this->load->view("history");
		$this->load->view("footer");

	}

	public function detail($id_project){
		$curr = shortcode_login();
		$data['title'] = "Detail";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;

		$this->load->model("mdreport");
		$this->load->model("mdsetting");
		$kosong = $this->mdreport->galon_kosong();
		$id_pelanggan = $this->input->post('idpelanggan');
		$nama = $this->input->post('pelanggan');
		$id_master = $this->input->post('idmaster');
		
		$bln= $this->input->post('bln');
		$thn= $this->input->post('thn');

		$data['id_p'] = $id_pelanggan;
		$data['id_master'] = $id_master;
		$data['id'] = $id_project;
		
		$data['dat'] = $this->mdsetting->get_tgl($id_project);
		//$data['jumlah'] = $this->mdreport->jumlah_detail($id_pelanggan,$id_master,$bulan,$tahun);

		$data['list_cc'] = $this->mdreport->list_cc();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['title'] .= " Inventory Pelanggan : ".$nama."";

		$data['query'] = $this->mdsetting->detail($id_pelanggan,$id_master,$id_project);

		$this->load->view("header",$data);
		$this->load->view("det_his");
		$this->load->view("footer");

	}

	public function cari_pelanggan($id_project){
		$curr = shortcode_login();
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;
		$golek = $this->input->post('golek');
		$data['id'] = $id_project;
		$this->load->model("mdreport");
		$this->load->model("mdsetting");

		$data['dat'] = $this->mdsetting->get_tgl($id_project);

		$data['list_cc'] = $this->mdreport->list_cc();
		$data['list_dd'] = $this->mdreport->list_cc1();
		$data['listdiv'] = $this->mdreport->listdiv("array");
		$data['listdah'] = $this->mdreport->listdiv1("array");

		$data['title'] .= " Inventory Pelanggan";
		if(empty($golek)) {
			$data['query'] = $this->mdsetting->report_pelanggan($id_project);
		}else{
			$data['query'] = $this->mdsetting->report_pelanggan1($id_project,$golek);
		}

		$this->load->view("header",$data);
		$this->load->view("history");
		$this->load->view("footer");
	}

//-----------------------------------------ANYAR------------------------------------------------------------------------//



	public function barang($id_project)
	{
		$curr = shortcode_login();
		$this->load->model("mdreport");
		$this->load->model("mdsetting");
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;

		$data['iyo'] = $this->mdsetting->baku();
		$data['id'] = $this->mdsetting->get_id($id_project);
		$data['benda'] = $this->mdsetting->getAll($id_project);
		$data['idp'] = $id_project;

		$data['dat'] = $this->mdsetting->get_tgl($id_project);

		$data['title'] .= " Stok Data Gudang";

		$data['tinggil'] = date("Y-m-d");

		$this->load->view("header",$data);
		$this->load->view("history_b");
		$this->load->view("footer");
	}

	public function barang1($id_project)
	{
		$curr = shortcode_login();
		$this->load->model("mdsetting");
		$data['title'] = "Laporan";
		$data['menu'] = 5;
		$data['submenu'] = 54;
		$data['curr'] = $curr;
		$data['idp'] = $id_project;

		$data['iyo'] = $this->mdsetting->baku();
		$data['id'] = $this->mdsetting->get_id($id_project);
		$data['benda'] = $this->mdsetting->getAll($id_project);

		$data['dat'] = $this->mdsetting->get_tgl($id_project);

		$data['title'] .= " Stok Data Gudang";

		$data['tinggil'] = date("Y-m-d");

		$this->load->view("header",$data);
		$this->load->view("history_b");
		$this->load->view("footer");
	}

	public function cari($id_project)
	{
		$curr = shortcode_login();
		$this->load->model("mdreport");
		$this->load->model("mdsetting");
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
		$data['idp'] = $id_project;
		$data['benda'] = $this->mdsetting->getAll($id_project);
		$data['stok'] = $this->mdsetting->get_stok($id,$id_project);

		$data['dat'] = $this->mdsetting->get_tgl($id_project);

		$op10 = $this->mdreport->galon_10rb();
		$op12 = $this->mdreport->galon_12rb();
		$kosong = $this->mdreport->galon_kosong();

		if($id == $kosong){
			$data['query'] = $this->mdsetting->report_master1($id,$id_project);
		}else{
			$data['query'] = $this->mdsetting->report_op($id,$id_project);
		}
		$data['list_cc'] = $this->mdreport->list_cc2();
		$data['title'] = "Stok Data Gudang : ".$nama["nama"];

		$this->load->view("header",$data);
		$this->load->view("det_his_br");
		$this->load->view("footer");
	}



	public function new_periode(){
		$curr = shortcode_login();
		$this->load->model("mdsetting");
		$this->load->model("mdmutasi");
		$skrg = date("Y-m-d");
		//sebelum ke transaksi perpindahan data, lakukan perhitungan jumlah data awal untuk periode baru.
		$list = $this->mdmutasi->load_cc();
		$ldiv = $this->mdmutasi->list_divisi();

		$plus = array();
		$ples = array();
		$arr_kirim = array();
		$arr_terima = array();
		$arr_awal = array();
		$userid = $this->session->userdata('user_id');

			

		//hasil array diatas direpeat ulang utk penambahan bobot pengeluaran
		/*foreach($ldiv as $idp=>$nmp){
		$a = $this->mdmutasi->get_current_mutasi2($list,$idp);
		foreach($a as $idmaster=>$stok){
		
			$stok_akhir = $stok ;
			$arr_terima[] = array(
				"id" => null,
				"id_master" => $idmaster,
				"id_pelanggan" => $idp,
				"tgl" => $skrg, 
				"jml" => $stok_akhir,
				"keterangan" => "Total Pengembalian",
				"stat" => 1
			);
		}
	}*/
		/*$ples = array();
		foreach($arr_terima as $ted){
			if(!isset($ples[$ted['id_master']])){
				$ples[$ted['id_master']] = $ted['jml'];
			}
			else{
				$ples[$ted['id_master']] += $ted['jml'];
			}
		}*/
		
		

		//proses truncating data
		$nm = "Untitled";
		if(isset($_GET['nm'])){
			if(strlen($_GET['nm']) > 0)
			$nm = $_GET['nm'];
		}
		$id_project = $this->mdsetting->get_last_id($nm);


		//tabel translate : cc_kembali, cc_pinjam_ambil, cc_terjual
		
		$sql = query("INSERT INTO cc_temp 
			SELECT NULL, $id_project, 'cc_kembali', id_master, id_pelanggan, tgl, jml, keterangan, stat FROM cc_kembali");
		$sql = query("INSERT INTO cc_temp 
			SELECT NULL, $id_project, 'cc_pinjam_ambil', id_master, id_pelanggan, tgl, jml, keterangan, stat FROM cc_pinjam_ambil");
		$sql = query("INSERT INTO cc_temp 
			SELECT NULL, $id_project, 'cc_terima', id_master, id_admin, tgl, jml,ket, stat FROM cc_terima");
		$sql = query("INSERT INTO cc_temp 
			SELECT NULL, $id_project, 'cc_terjual', id_master, id_pelanggan, tgl, jml, ket, stat FROM cc_terjual");


		$this->db->truncate("cc_kembali");
		$this->db->truncate("cc_pinjam_ambil");
		$this->db->truncate("cc_terima");
		
		
		$x = $this->mdmutasi->get_master();
			foreach($x as $m){
				$arr_awal = array(
					array(
					"id_t" =>NULL,
					"id_master" => $m->id,
					"id_admin" => $userid,
					"tgl" => $skrg,
					"jml" => $m->stok,
					"ket" => "Stok Sebelumnya",
					"stat" => 1
					)
				);
				$this->db->insert_batch('cc_terima',$arr_awal);
			}



			$master = $this->mdmutasi->galonkos();
			foreach($master as $b){
			$y = $this->mdmutasi->get_current_mutasi4();
			foreach($y as $c){
				$arr_kirim = array(
					array(
					"id" => null,
					"id_master" => $b->id,
					"id_pelanggan" => $c->id_p,
					"tgl" => $skrg,
					"jml" => $c->total_pinjam, 
					"keterangan" => "Sisa Pinjaman",
					"stat" => 1
					)
				);
				$this->db->insert_batch('cc_pinjam_ambil',$arr_kirim);
			}
			}
		/*	if((!isset($ples[$ted['id_master']])) AND (!isset($plus[$tes['id_master']]))){
				$t = $plus[$tes['id_master']] = $tes['jml'];
				$f = $ples[$ted['id_master']] = $ted['jml'];
				if($t != $f){
						$this->db->insert_batch("cc_kembali",$arr_terima);
						$this->db->insert_batch("cc_pinjam_ambil",$arr_kirim);
				}
			}else{
				$u = $plus[$tes['id_master']] += $tes['jml'];
				$i = $ples[$ted['id_master']] += $ted['jml'];
				if($u != $i){
						$this->db->insert_batch("cc_kembali",$arr_terima);
						$this->db->insert_batch("cc_pinjam_ambil",$arr_kirim);
				}
			}*/
		
					
		//proses penyimpanan ulang data hasil olah periode baru
		/*$this->db->insert_batch("cc_kembali",$arr_terima);


		$this->db->insert_batch("cc_pinjam_ambil",$arr_kirim);
		$this->db->insert_batch("cc_kembali",$arr_terima);
		$this->db->insert_batch("cc_pinjam_ambil",$arr_kirim);
		*/

		/*$y = $this->mdsetting->jupukambil();
			$t = $this->mdsetting->jupukpinjam();
			foreach($y as $a){
				foreach($t as $d){
					$idt = $a->id;
					$idk = $d->id;
					$idmt = $a->id_master;
					$idmk = $d->id_master;
					$idpt = $a->id_pelanggan;
					$idpk = $d->id_pelanggan;
					$stt = $a->jml;
					$stk = $d->jml;
					$ttd = $stt - $stk;
					if($ttd == 0){
						$this->mdsetting->delambil();						
					}
				}
			}*/
		create_alert("Success","Berhasil pindah ke periode baru","history");
			
	}

}