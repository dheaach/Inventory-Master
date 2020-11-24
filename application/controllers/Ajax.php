<?php
defined("BASEPATH") or exit();

Class Ajax extends CI_Controller{

	public function index(){

	}

	public function get($identifier, $id){
		$data = array();
		if($identifier=="master"){
			$sql = query("SELECT * FROM cc_master WHERE id = ".quote($id)." AND stat <> 9");
			if($sql->num_rows() == 0){
				//data ada
				$data['error'] = 0;
				$row = $sql->row_array();
				$data['id'] = $id;
				$data['nama'] = $row['nama'];
			}
			else{
				//data tidak ada
				$data['error'] = 1;
				$data['message'] = "Data tidak ditemukan. Mohon merefresh halaman untuk memperbaiki hal tersebut";
			}
		}
		echo json_encode($data);
	}

	public function master(){
		$curr = shortcode_login();
		$data = array();
		$this->load->model("mdmaster");

		if(isset($_POST['cc_nama']) and isset($_POST['cc_stok'])){
			if(empty($_POST['cc_nama'])){
				$data['error'] = 1;
				$data['message'] = "Kolom nama belum diisi";
			}
			else if(empty($_POST['cc_stok'])){
				$data['error'] = 1;
				$data['message'] = "Kolom stok belum diisi";
			}
			else{
				//kelihatannya sudah oke
				$cek = $this->mdmaster->cek_exists($_POST['cc_nama']);
				if($cek){

					$data['nama'] = $_POST['cc_nama'];
					$data['stok'] = $_POST['cc_stok'];
					$data['harga'] = $_POST['cc_harga'];

					$arr = array(
						"id" => null,
						"nama" => $data['nama'],
						"stat" => 1,
						"stok" => $data['stok'],
						"harga" => $data['harga']
					);
					$this->db->insert("cc_master",$arr);
					$data['id'] = $this->db->insert_id();

					//langsung simpan di tabel terima
					$arr2 = array(
						"id" => null,
						"id_master" => $data['id'],
						"jml" => 0,
						"ket" => "Data awal",
						"stat" => 1
					);
					$this->db->insert("cc_terima",$arr2);

					$data['error'] = 0;
					$data['message'] = "Berhasil menyimpan data master inventory";

				}
				else{
					$data['error'] = 1;
					$data['message'] = "Data master inventory tersebut sudah ada";					
				}


			}
		}
		else{
			$data['error'] = 1;
			$data['message'] = "Mohon masukkan data di field yang sudah disediakan";
		}

		echo json_encode($data);
	}

	public function edit_master($id){
		$curr = shortcode_login();
		$data = array();
		$this->load->model("mdmaster");

		if(isset($_POST['cc_nama']) and isset($_POST['cc_stok'])){
			if(empty($_POST['cc_nama'])){
				$data['error'] = 1;
				$data['message'] = "Kolom nama belum diisi";
			}
			else{
				//kelihatannya sudah oke
				$cek = $this->mdmaster->cek_exists($_POST['cc_nama'], $id);
				if($cek){
					$data['nama'] = $_POST['cc_nama'];
					$data['stok'] = $_POST['cc_stok'];
					$data['harga'] = $_POST['cc_harga'];
					$nama = $this->input->post('cc_nama');
					$sqli = $this->mdmaster->operasional();
					foreach ($sqli as $sikil) {
						$idiw = $sikil['id'];
					
						if($id == $idiw) {
							$sql = $this->db->query("SELECT stok FROM cc_master WHERE id = '$id'");
							$cekk = $sql->num_rows();
							if ($cekk > 0) {
								foreach($sql->result_array() as $row){
									$stk=$row['stok'];
									$stk1 = $this->input->post('cc_stok');
									$hs= $stk1-$stk;
									$this->mdmaster->hmhm($hs);	
								}
								$arr = array(
								"nama" => $data['nama'],
								"stok" => $data['stok'],
								"harga" => $data['harga']
								);
							
								$this->db->where("id",$id);
								$this->db->update("cc_master",$arr);

							}
						}
					}
					$arr = array(
						 "nama" => $data['nama'],
						 "stok" => $data['stok'],
						 "harga" => $data['harga']
					);
							
					$this->db->where("id",$id);
					$this->db->update("cc_master",$arr);

					$data['error'] = 0;
					$data['message'] = "Berhasil mengupdate data master inventory";

				}
				else{
					$data['error'] = 1;
					$data['message'] = "Data master inventory tersebut sudah ada";					
				}
			}
		}
		else{
			$data['error'] = 1;
			$data['message'] = "Mohon masukkan data di field yang sudah disediakan";
		}

		echo json_encode($data);
	}















	public function divisi(){
		$curr = shortcode_login();
		$data = array();
		$this->load->model("mdmaster");

		if(isset($_POST['cc_nama'])){
			if(empty($_POST['cc_nama'])){
				$data['error'] = 1;
				$data['message'] = "Kolom nama belum diisi";
			}
			else{
				//kelihatannya sudah oke
				$cek = $this->mdmaster->cek_dv_exists($_POST['cc_nama'], 0, "cc_divisi");
				if($cek){

					$data['nama'] = $_POST['cc_nama'];

					$arr = array(
						"id" => null,
						"nama_divisi" => $data['nama'],
						"stat" => 1
					);
					$this->db->insert("cc_divisi",$arr);
					$data['id'] = $this->db->insert_id();

					$data['error'] = 0;
					$data['message'] = "Berhasil menyimpan data master divisi";

				}
				else{
					$data['error'] = 1;
					$data['message'] = "Data master divisi tersebut sudah ada";					
				}


			}
		}
		else{
			$data['error'] = 1;
			$data['message'] = "Mohon masukkan data di field yang sudah disediakan";
		}

		echo json_encode($data);
	}

	public function edit_divisi($id){
		$curr = shortcode_login();
		$data = array();
		$this->load->model("mdmaster");

		if(isset($_POST['cc_nama'])){
			if(empty($_POST['cc_nama'])){
				$data['error'] = 1;
				$data['message'] = "Kolom nama belum diisi";
			}
			else{
				//kelihatannya sudah oke
				$cek = $this->mdmaster->cek_dv_exists($_POST['cc_nama'], $id, "cc_divisi");
				if($cek){

					$data['nama'] = $_POST['cc_nama'];

					$arr = array(
						"nama_divisi" => $data['nama'],
					);
					$this->db->where("id",$id);
					$this->db->update("cc_divisi",$arr);

					$data['error'] = 0;
					$data['message'] = "Berhasil menyimpan data master divisi";

				}
				else{
					$data['error'] = 1;
					$data['message'] = "Data master divisi tersebut sudah ada";					
				}


			}
		}
		else{
			$data['error'] = 1;
			$data['message'] = "Mohon masukkan data di field yang sudah disediakan";
		}

		echo json_encode($data);
	}



public function mutasi(){
		$curr = shortcode_login();
		$data = array();
		$this->load->model("mdmutasi");

		if(isset($_POST['cc_ket']) and isset($_POST['cc_tot'])){
			if(empty($_POST['cc_ket'])){
				$data['error'] = 1;
				$data['message'] = "Kolom keterangan belum diisi";
			}
			else if(empty($_POST['cc_tot'])){
				$data['error'] = 1;
				$data['message'] = "Kolom total belum diisi";
			}
			else if(empty($_POST['cc_tgl'])){
				$data['error'] = 1;
				$data['message'] = "Kolom tanggal belum diisi";
			}
			else{
				//kelihatannya sudah oke
					$data['ket'] = $_POST['cc_ket'];
					$data['tot'] = $_POST['cc_tot'];

					$arr = array(
						"id" => null,
						"keterangan" => $data['ket'],
						"total" => $data['tot'],
						"tanggal" => $datedb
					);
					$this->db->insert("cc_keluar",$arr);
					//langsung simpan di tabel terima

					$data['error'] = 0;
					$data['message'] = "Berhasil menyimpan data master inventory";

			}
		}
		else{
			$data['error'] = 1;
			$data['message'] = "Mohon masukkan data di field yang sudah disediakan";
		}

		echo json_encode($data);
	}

}