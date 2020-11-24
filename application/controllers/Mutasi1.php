<?php
defined("BASEPATH") or exit();

Class Mutasi extends CI_Controller{

	public function index(){
		redirect("mutasi/penerimaan");
	}

	public function penerimaan(){
		$curr = shortcode_login();
		$data['title'] = "Rekap Pelanggan";
		$data['menu'] = 3;
		$data['curr'] = $curr;

		$this->load->model("mdmutasi");

		$data['list'] = $this->mdmutasi->lihat();

		$data['mutasi'] = $this->mdmutasi->get_current_mutasi($data['list']);

		$this->load->view("header",$data);
		$this->load->view("terima");
		$this->load->view("footer");
	}

	public function pengeluaran(){
		$curr = shortcode_login();
		$data['title'] = "Data Pengeluaran";
		$data['menu'] = 23;
		$data['curr'] = $curr;

		$this->load->model("mdmutasi");

		$data['list'] = $this->mdmutasi->keluar();
		$data['date'] = date("Y-m-d");
		//$data['mutasi'] = $this->mdmutasi->get_current_mutasi($data['list']);

		$this->load->view("header",$data);
		$this->load->view("keluar");
		$this->load->view("footer");
	}
	public function look($id)
	{
		$this->load->model("mdmutasi");
		$data['list'] = $this->mdmutasi->langgan($id);

		$this->load->view("header",$data);
		$this->load->view("terima");
		$this->load->view("footer");

	}
	public function view($idmaster){
		$curr = shortcode_login();
		$data['curr'] = $curr;

		$this->load->model("mdmutasi");
		$row = $this->cms->get_page1("cc_pelanggan",$idmaster);
		if($row){
			$data['title'] = "Detail Mutasi Item oleh : $row[nama_p]";
		}

		$data['row'] = $row;
		$data['item_mutasi'] = $this->mdmutasi->item_mutasi($idmaster);
		$vname = "rekam";

		$this->load->view("header_box",$data);
		$this->load->view($vname,$data);
		$this->load->view("footer");
	}

	public function add($idmaster){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");


		//$row = $this->cms->get_page("cc_master",$idmaster);
		$data['title'] = "Tambah Peminjaman Galon";
		$data['tgl'] = date("Y-m-d");

		$data['wor'] = $idmaster;
		$data['row'] = $this->mdmutasi->cek_pelanggan($idmaster);
		$data['galon'] = $this->mdmutasi->galon();
		$this->load->view("header_box",$data);
		$this->load->view("add_terima");
		$this->load->view("footer");
	}

	public function addproses($idmaster){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$this->load->model("mdmaster");

		$list_post = array("cc_tgl","cc_idbarang","cc_jml","cc_ket");
		$post = $_POST;
		if(empty($post['cc_tgl']) or empty($post['cc_jml'])){
			post_session($post, $list_post);
			create_alert("error","Mohon mengisi data di kolom yang sudah disediakan dengan lengkap.","mutasi/add/$idmaster");
		}
		else{
			//langsung proses
			$arr = array(
				"id" 			=> '',
				"id_pelanggan" 	=> $idmaster,
				"id_master"		=> $post['cc_idbarang'],
				"tgl" 			=> date("Y-m-d",strtotime($post['cc_tgl'])),
				"jml" 			=> $post['cc_jml'],
				"keterangan" 	=> $post['cc_ket'],
				"stat" 			=> 1
			);
			$this->db->insert("cc_pinjam_ambil",$arr);
			$hs = $this->input->post('cc_jml');
			$this->mdmaster->hmhm($hs);	

			$tot_p = $this->mdmutasi->get_total_pinjam($idmaster);
			$tot_t = $tot_p + $post['cc_jml'];
			$data = array('total_pinjam' => $tot_t);
			$where = array('id_p' => $idmaster);
			$this->mdmutasi->update('cc_pelanggan',$data,$where);

			create_alert("success","Berhasil Menyimpan Data !","mutasi/add/$idmaster");
		}
	}


	public function kirim($idmaster,$iddiv=0){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		//$row = $this->cms->get_page("cc_master",$idmaster);
		$data['title'] = "Pengembalian Pinjaman Galon";
		$data['tgl'] = date("Y-m-d");

		$data['wor'] = $idmaster;
		$data['row'] = $this->mdmutasi->cek_pelanggan($idmaster);
		$data['galon'] = $this->mdmutasi->galon();

		$id_pelanggan = $idmaster;
		$data['nganu'] = $this->mdmutasi->load_pelinggin($idmaster);
		$data['def'] = $iddiv;
		$this->load->view("header_box",$data);
		$this->load->view("add_kirim");
		$this->load->view("footer");
	}

	public function kirimproses($idmaster){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$this->load->model("mdreport");

		$listdiv = $this->mdmutasi->list_divisi();

		$list_post = array("cc_tgl","cc_idbarang","cc_jml","cc_ket");
		$post = $_POST;
		if(empty($post['cc_tgl']) or empty($post['cc_jml'])){
			post_session($post, $list_post);
			create_alert("error","Mohon mengisi data di kolom yang sudah disediakan dengan lengkap.","mutasi/kirim/$idmaster");
		}
		else{
			//sebelum kirim, cek dulu stok yang ada di master berapa
			//$stokmaster = $this->mdmutasi->real_stok($idmaster);
			$id_pelanggan = $idmaster;
			$stokmaster = $this->mdmutasi->cek_pinjaman($id_pelanggan);
			if($post['cc_jml'] > $stokmaster){
				post_session($post, $list_post);
				create_alert("error","Pengembalian Melebihi Pinjaman !. (Pengembalian : $stokmaster, Pinjaman : $post[cc_jml])","mutasi/kirim/$idmaster");
			}


			$ket = $post['cc_ket'];
			if(empty($post['cc_ket'])){
				$ket = "Dikirim ke ".$listdiv[$post['cc_divisi']];
			}


			$arr = array(
				"id" 			=> null,
				"id_pelanggan" 	=> $idmaster,
				"id_master"		=> $post['cc_idbarang'],
				"tgl" 			=> date("Y-m-d",strtotime($post['cc_tgl'])),
				"jml" 			=> $post['cc_jml'],
				"keterangan" 	=> $post['cc_ket'],
				"stat" 			=> 1
			);
			$this->db->insert("cc_kembali",$arr);

			$id_m = $this->mdreport->galon_kosong();
			$stok_l = $this->mdmutasi->get_stok_master();
			$stok_b = $stok_l + $post['cc_jml'];
			$data1 = array('stok' => $stok_b);
			$where = array('id' => $id_m);
			$this->mdmutasi->update('cc_master',$data1,$where);

			$tot_p = $this->mdmutasi->get_total_pinjam($idmaster);
			$tot_t = $tot_p - $post['cc_jml'];
			$data = array('total_pinjam' => $tot_t);
			$where = array('id_p' => $idmaster);
			$this->mdmutasi->update('cc_pelanggan',$data,$where);

			create_alert("success","Berhasil menyimpan data pengiriman inventory","mutasi/kirim/$idmaster");
		}
	}

		public function ambil($idmaster){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		//$row = $this->cms->get_page("cc_master",$idmaster);
		$data['title'] = "Pengambilan Galon Operasional";
		$data['tgl'] = date("Y-m-d");

		$data['wor'] = $idmaster;
		$data['galon'] = $this->mdmutasi->galonop();

		$id_pelanggan = $idmaster;
		$jum = $this->mdmutasi->celuk_pelanggan();
		
		$this->load->view("header_box",$data);
		$this->load->view("add_ambil");
		$this->load->view("footer");
	}

	public function ambilproses($idmaster){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$this->load->model("mdreport");

		$list_post = array("cc_tgl","cc_barang","cc_harga","cc_jml","cc_ket");
		$post = $_POST;
		if(empty($post['cc_tgl']) or empty($post['cc_jml'])){
			post_session($post, $list_post);
			create_alert("error","Mohon mengisi data di kolom yang sudah disediakan dengan lengkap.","mutasi/ambil/$idmaster");
		}
		else{

			$id_pelanggan = $idmaster;
			$stokmaster = $this->mdmutasi->cek_pinjaman($id_pelanggan);
			if($post['cc_jml'] > $stokmaster){
				post_session($post, $list_post);
				create_alert("error","Anda tidak boleh melebihi jumlah peminjaman anda!. (Peminjaman : $stokmaster, Pengambilan : $post[cc_jml])","mutasi/ambil/$idmaster");
			}
			else{	
				$id10rb = $this->mdreport->galon_10rb();
				$id12rb = $this->mdreport->galon_12rb();
				if($post['cc_barang'] == $id10rb) {
					$nama_master = $this->mdmutasi->nama10($id10rb);
					$query = query("SELECT * FROM cc_terjual WHERE id_pelanggan = '$idmaster' AND id_master = '$id10rb' AND tgl = '$post[cc_tgl]'")->num_rows();
				}
				elseif($post['cc_barang'] == $id12rb) {
					$nama_master = $this->mdmutasi->nama12($id12rb);
					$query = query("SELECT * FROM cc_terjual WHERE id_pelanggan = '$idmaster' AND id_master = '$id12rb' AND tgl = '$post[cc_tgl]'")->num_rows();
				}

				if($query > 0){
					create_alert("danger","Anda sudah tidak bisa mengambil $nama_master","mutasi/ambil/$idmaster");
				}elseif($query == 0){	

					$rego = $post['cc_jml'] * $post['cc_harga'];
					$barang = $this->input->post('cc_barang');
						$dat = array(
						"id" 			=> '',
						"id_pelanggan" 	=> $idmaster,
						"id_master"		=> $barang,
						"tgl" 			=> date("Y-m-d",strtotime($post['cc_tgl'])),
						"jml" 			=> $post['cc_jml'],
						"harga" 		=> $post['cc_harga'],
						"total"			=> $rego,
						"ket" 			=> $post['cc_ket'],
						"stat" 			=> 1
					);
					$this->db->insert('cc_terjual',$dat);

					$sentolop = $this->mdmutasi->sentolop();			
					foreach ($sentolop as $sen) {
					$idbarang = $sen['id'];
					$sql = $this->db->query("SELECT stok FROM cc_master where id = '$idbarang'")->result_array();
					foreach ($sql as $l) {
						$stok = $l['stok'];
					}
						$jml = $post['cc_jml'];
						$baru = $stok - $jml;
						$arr = array(
							array(
								"id"   => $idbarang,
								"stok" => $baru 
							)
						);
						
						$this->db->update_batch('cc_master',$arr,'id');
					}
				}
			}
			create_alert("success","Berhasil Menyimpan Data","mutasi/ambil/$idmaster");
		}
	}

	public function cek_harga()
	{
		$this->load->model("mdmutasi");
		$id_galon = $this->input->post('cc_barang');
        $cek = $this->mdmutasi->harga($id_galon);
        $nge = $cek->row();
        $data = array(
            'harga' => $nge->harga,
        );
        echo json_encode($data);
	}


	public function pengiriman(){
		$curr = shortcode_login();
		$data['title'] = "Rekap Stok Inventory per Divisi";
		$data['menu'] = 4;
		$data['curr'] = $curr;

		$this->load->model("mdmutasi");

		$data['list'] = $this->mdmutasi->list_divisi();

		$this->load->view("header",$data);
		$this->load->view("rekap_divisi");
		$this->load->view("footer");
	}

	public function detaildivisi($iddivisi){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$list = $this->mdmutasi->list_divisi();

		$data['title'] = "Detail Rekap Stok Inventory di ".$list[$iddivisi];
		$data['curr'] = $curr;
		$data['list_cc'] = $this->mdmutasi->load_cc();
		$data['mutasi'] = $this->mdmutasi->get_current_mutasi($data['list_cc'], $iddivisi);
		$data['iddiv'] = $iddivisi;

		$this->load->view("header_box",$data);
		$this->load->view("detail_divisi");
		$this->load->view("footer");
	}

	public function terjual($idmaster, $iddivisi){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$list = $this->mdmutasi->list_divisi();

		$row = $this->cms->get_page("cc_master",$idmaster);

		$data['title'] = "Stok Inventory \"$row[nama]\" Terpakai di ".$list[$iddivisi];
		$data['curr'] = $curr;
		$data['real_stok'] = $this->mdmutasi->real_stok_div($idmaster, $iddivisi);
		$data['iddiv'] = $iddivisi;
		$data['tgl'] = date("Y-m-d");
		$data['idmaster'] = $idmaster;
		$data['iddivisi'] = $iddivisi;

		$this->load->view("header_box",$data);
		$this->load->view("terjual");
		$this->load->view("footer");
	}

	public function addterjual(){
		$curr = shortcode_login();
		dump($_POST);
		$post = $_POST;
		$list_post = array("cc_tgl","cc_jml","cc_ket");
		if($post['cc_jml'] > $post['cc_terjual']){
			post_session($post, $list_post);
			create_alert("error","Jumlah yang dimasukkan melebihi stok yang ada di divisi. (Stok : $post[cc_terjual])","mutasi/terjual/$post[idmaster]/$post[iddivisi]");
		}
		else{
			if(empty($post['cc_jml']) or empty($post['cc_tgl'])){
				post_session($post, $list_post);
				create_alert("error","Mohon mengisi data di kolom yang sudah disediakan dengan tepat","mutasi/terjual/$post[idmaster]/$post[iddivisi]");

			}
			else{
				//input ke db
				$arr = array(
					"id" => null, 
					"id_master" => $post['idmaster'],
					"id_divisi" => $post['iddivisi'],
					"jml" => $post['cc_jml'],
					"tgl" => $post['cc_tgl'],
					"ket" => $post['cc_ket'],
					"stat" => 1
				);
				$this->db->insert("cc_terjual",$arr);
				create_alert("success","Berhasil Menyimpan Data","mutasi/terjual/$post[idmaster]/$post[iddivisi]");
			}
		}
	}

	public function tambah()
	{
		
		$ket=$this->input->post('cc_ket');
        $tot=$this->input->post('cc_tot');
		$data['tgl'] = indo_date($_POST['cc_tgl'],"half");
		$datedb = date("Y-m-d H:i:s",strtotime($_POST['cc_tgl']));
		$this->load->model('mdmutasi');
		$ok = $this->mdmutasi->tambah($ket,$tot,$datedb);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil disimpan');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal disimpan');
    	}
		redirect('mutasi/pengeluaran');
	}
	public function edit()
	{
		$id=$this->input->post('id');
		$ket=$this->input->post('ket');
		$tot=$this->input->post('tot');
		$this->load->model('mdmutasi');
		$ok = $this->mdmutasi->edit($id,$ket,$tot);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil Diupdate');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal Diupdate');
    	}
		redirect('mutasi/pengeluaran');
	}
	public function hapus($id){
		$this->load->model('mdmutasi');
		$ok = $this->mdmutasi->hapus($id);
		if($ok > 0){
     		$this->session->set_flashdata('success', 'Berhasil Dihapus');
    	}else{
    		$this->session->set_flashdata('danger', 'Gagal Dihapus');
    	}
		redirect('mutasi/pengeluaran');
	}

	public function rekap_gudang()
	{
		$curr = shortcode_login();
		$data['title'] = "Rekap Stok Gudang";
		$data['menu'] = 4;
		$data['curr'] = $curr;

		$this->load->model("mdmutasi");
		$data['date'] = date("Y-m-d");
		$data['list'] = $this->mdmutasi->rekapgudang();

		$this->load->view("header",$data);
		$this->load->view("stok");
		$this->load->view("footer");	
	}
	public function plus($idmaster){
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$this->load->model("mdreport");

		$row = $this->cms->get_page2("cc_master",$idmaster);
		$data['title'] = "Tambah Stok Gudang ".$row['nama'];
		$data['tgl'] = date("Y-m-d");

		$op = $this->mdmutasi->galon_op();
		$data['opel']= $op;

		$data['wor'] = $idmaster;
		$data['row'] = $row;
		$this->load->view("header_box",$data);
		$this->load->view("add_stok");
		$this->load->view("footer");
	}
	public function plusproses($id)
	{
		$curr = shortcode_login();
		$this->load->model("mdmutasi");
		$this->load->model("mdreport");
		$this->load->model("mdmaster");

		$list_post = array("cc_user","cc_tgl","cc_jml","cc_ket");
		$post = $_POST;
		$idmaster= $this->input->post('cc_id');
		if(empty($post['cc_tgl']) or empty($post['cc_jml'])){
			post_session($post, $list_post);
			create_alert("error","Mohon mengisi data di kolom yang sudah disediakan dengan lengkap.","mutasi/plus/$idmaster");
		}
		else{
			//langsung proses
					$sqli = $this->mdmaster->operasional();
					foreach ($sqli as $sikil) {
						$idiw = $sikil['id'];
					
						if($id == $idiw) {
							$sql = $this->db->query("SELECT stok FROM cc_master WHERE id = '$id'");
							$cekk = $sql->num_rows();
							if ($cekk > 0) {
								foreach($sql->result_array() as $row){
									$lama = $row["stok"];
									$hs = $this->input->post('cc_jml');
									$this->load->model("mdmaster");
									$this->mdmaster->hmhm($hs);	
								
									$arr = array(
										"id_t" 			=> '',
										"id_master" 	=> $id,
										"id_admin"		=> $post['cc_user'],
										"tgl" 			=> date("Y-m-d",strtotime($post['cc_tgl'])),
										"jml" 			=> $post['cc_jml'],
										"ket" 			=> $post['cc_ket'],
										"stat" 			=> 1
									);
									$this->db->insert("cc_terima",$arr);
									
									$kosong = $this->mdreport->galon_kosong();
									$op = $this->mdreport->galon_op();
									//$op12 = $this->mdreport->galon_12rb();
									
									$sql = query("SELECT * FROM cc_pelanggan WHERE id_p = 1")->num_rows();
									if($sql > 0) {
										
									}else{
										$array = array(
											'id_p' => 1,
											'nama_p' => 'gudang',
											'alamat' => '',
											'no_hp'  => '',
											'total_pinjam' => 0,
											'ket' => ''
										);
										$this->db->insert('cc_pelanggan',$array);
									}

									if($id == $op) {
											$id_pelanggan = '1';
									}
										$err = array(
											"id" 			=> '',
											"id_pelanggan" 	=> $id_pelanggan,
											"id_master"		=> $kosong,
											"tgl" 			=> date("Y-m-d",strtotime($post['cc_tgl'])),
											"jml" 			=> $post['cc_jml'],
											"keterangan" 	=> 'Restok Gudang',
											"stat" 			=> 1
										);
										$this->db->insert("cc_pinjam_ambil",$err);


									$baru = $lama + $hs;
									$data = array('stok' => $baru);
									$where = array('id' => $id);
									$this->mdmutasi->update('cc_master',$data,$where);

									create_alert("success","Berhasil Menambah Stok !","mutasi/plus/$idmaster");
									}
							}
						}
					}
			$arr = array(
				"id_t" 			=> '',
				"id_master" 	=> $id,
				"id_admin"		=> $post['cc_user'],
				"tgl" 			=> date("Y-m-d",strtotime($post['cc_tgl'])),
				"jml" 			=> $post['cc_jml'],
				"ket" 			=> $post['cc_ket'],
				"stat" 			=> 1
			);
			$this->db->insert("cc_terima",$arr);

			$sqlku = $this->db->query("SELECT stok FROM cc_master WHERE id = '$id'")->row_array();
			$baru = $sqlku["stok"] + $post['cc_jml'];
			$data = array('stok' => $baru);
			$where = array('id' => $id);

			$this->mdmutasi->update('cc_master',$data,$where);

			create_alert("success","Berhasil Menambah Stok !","mutasi/plus/$idmaster");
		}
	}
		public function see($idmaster){
		$curr = shortcode_login();
		$data['curr'] = $curr;

		$this->load->model("mdmutasi");
		$row = $this->cms->get_page3("cc_terima",$idmaster);
		if($row>0){
			$data['title'] = "Detail Stok Gudang : $row[nama]";
		}else{
			$r = $this->cms->get_page("cc_master",$idmaster);
			$data['title'] = "Detail Stok Gudang : $r[nama]";
		}

		$data['ri'] = $this->mdmutasi->cs($idmaster);
		$data['row'] = $this->mdmutasi->detstok($idmaster);
		$vname = "detstok";

		$this->load->view("header_box",$data);
		$this->load->view($vname,$data);
		$this->load->view("footer");
	}

	public function rekap_pelanggan()
	{
		$this->load->model("mdmutasi");
		$this->load->model("mdreport");
		$curr = shortcode_login();
		$data['title'] = "Rekap Pelanggan";
		$data['menu'] = 3;
		$data['curr'] = $curr;
		$data['op10'] = $this->mdreport->galon_10rb();
		$data['op12'] = $this->mdreport->galon_12rb();

		$cari = $this->input->post('golek');
		$data['list'] = $this->mdmutasi->load_pelanggan($cari);
	
		$this->load->view("header",$data);
		$this->load->view("terima");
		$this->load->view("footer");
	}

}