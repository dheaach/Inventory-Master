<?php
defined("BASEPATH") or exit();

Class Mdmutasi extends CI_Model{
	public function update($table,$data,$where)
	{
		$update = $this->db->update($table,$data,$where);
		return $update;
	}

	public function load_cc($ord = "nama"){
		$sql = query("SELECT * FROM cc_master WHERE stat <> 9 ORDER BY $ord");
		return $sql->result_array();
	}

	public function get_current_mutasi($list, $iddiv=0){
		$save = array();
		foreach($list as $r){
			array_push($save, $r['id']);
		}
		$imp = "";
		if(count($save) > 0){
			$imp = "WHERE id_master IN (".implode(",",$save).")";
			if($iddiv > 0){
				$imp .= " AND id_pelanggan = ".quote($iddiv);
			}
		}

		$arr = array();
		$sql = query("SELECT id_master, id_pelanggan,SUM(jml) AS jml_terima FROM cc_kembali $imp GROUP BY id_master");
		foreach($sql->result_array() as $row){
			if($iddiv == 0){
				if(isset($arr[$row['id_master']])){
					$arr[$row['id_master']] -= $row['jml_terima'];
				}
			}
			else{
				$arr[$row['id_master']] = $row['jml_terima'];
			}

		}

		$sql2 = query("SELECT id_master, id_pelanggan, SUM(jml) AS jml_kirim FROM cc_pinjam_ambil $imp GROUP BY id_master, id_pelanggan");
		foreach($sql2->result_array() as $row){
			if($iddiv == 0){
				if(isset($arr[$row['id_master']])){
					$arr[$row['id_master']] -= $row['jml_kirim'];
				}
			}
			else{
				$arr[$row['id_master']] = $row['jml_kirim'];
			}

		}


		return $arr;
	}

	public function get_current_mutasi2($list, $iddiv=0){
		$save = array();
		foreach($list as $r){
			array_push($save, $r['id']);
		}
		$imp = "";
		if(count($save) > 0){
			$imp = "WHERE id_master IN (".implode(",",$save).")";
			if($iddiv > 0){
				$imp .= " AND id_pelanggan = ".quote($iddiv);
			}
		}

		$arr = array();
		$sql = query("SELECT id_master, id_pelanggan,SUM(jml) AS jml_terima FROM cc_kembali $imp GROUP BY id_master");
		foreach($sql->result_array() as $row){
			if($iddiv == 0){
				if(isset($arr[$row['id_master']])){
					$arr[$row['id_master']] -= $row['jml_terima'];
				}
			}
			else{
				$arr[$row['id_master']] = $row['jml_terima'];
			}

		}

		return $arr;
	}

	public function get_current_mutasi4(){

		$sql = query("SELECT * FROM cc_pelanggan WHERE total_pinjam > 0 ");
		return $sql->result();	
	}
	
	public function real_stok($idmaster, $tgl=null){
		if(empty($tgl))
			$tgl = date("Y-m-d");

		$dapat = query("SELECT SUM(jml) AS total_terima FROM cc_kembali WHERE tgl <= ".quote($tgl)." AND id_master = ".quote($idmaster));
		$row = $dapat->row_array();
		$a = $row['total_terima'];

		$kirim = query("SELECT SUM(jml) AS total_kirim FROM cc_pinjam_ambil WHERE tgl <= ".quote($tgl)." AND id_master = ".quote($idmaster));
		$row2 = $kirim->row_array();
		$b = $row2['total_kirim'];

		$real_stok = $a - $b;
		return $real_stok;
	}

	public function real_stok_div($idmaster, $iddiv, $tgl=null){
		if(empty($tgl))
			$tgl = date("Y-m-d");
		$sql = query("SELECT SUM(jml) AS total_kirim FROM cc_pinjam_ambil WHERE id_master = ".quote($idmaster)." AND id_pelanggan = ".quote($iddiv)." AND tgl <= ".quote($tgl));
		$row = $sql->row_array();
		$a = $row['total_kirim'];

		$sql2 = query("SELECT SUM(jml) AS total_penyesuaian FROM cc_kembali WHERE id_master = ".quote($idmaster)." AND id_pelanggan = ".quote($iddiv)." AND tgl <= ".quote($tgl));
		$row2 = $sql2->row_array();
		$b = $row2['total_penyesuaian'];

		$real_stok = $a - $b;
		return $real_stok;
	}



	public function item_mutasi($idmaster){
		$save = array();
		$n = 0;

		$sql = query("SELECT * FROM cc_pinjam_ambil WHERE id_pelanggan = ".quote($idmaster)."");
		foreach($sql->result_array() as $row){
			$tgl = strtotime($row['tgl']) + $n; 

			$save[$tgl]['pinjam'] = $row['jml'];
			$save[$tgl]['ket'] = $row['keterangan'];
			$n++;
		}

		$sql2 = query("SELECT * FROM cc_kembali WHERE id_pelanggan = ".quote($idmaster)."");
		foreach($sql2->result_array() as $row){
			$tgl = strtotime($row['tgl']) + $n; //tweak untuk menampilkan data dengan tanggal yg sama. limit = 86399 data.
			$save[$tgl]['kembali'] = $row['jml'];
			$save[$tgl]['ket'] = $row['keterangan'];
			$n++;
		}
		
		$mboh = $this->mbohlahwes();
		foreach ($mboh as $des) {
			$idib = $des['id'];

		}
		$sql3 = query("SELECT * FROM cc_terjual WHERE id_pelanggan = ".quote($idmaster)." AND id_master = ".quote($idib)."");
		foreach($sql3->result_array() as $row){
			$tgl = strtotime($row['tgl']) + $n; //tweak untuk menampilkan data dengan tanggal yg sama. limit = 86399 data.
			$save[$tgl]['ambil'] = $row['jml'];
			$save[$tgl]['ket'] = $row['ket'];
			$n++;
		}
		ksort($save);
		return $save;
	}

	public function item_mutasi_divisi($idmaster, $iddivisi){
		$save = array();
		$sql2 = query("SELECT * FROM cc_pinjam_ambil WHERE id_master = ".quote($idmaster)." AND id_pelanggan = ".quote($iddivisi)." AND stat <> 9");
		$n = 0;
		foreach($sql2->result_array() as $row){
			$tgl = strtotime($row['tgl']) + $n; 

			$save[$tgl]['kirim'] = $row['jml'];
			$save[$tgl]['ket'] = $row['ket'];
			$n++;
		}

		$sql3 = query("SELECT * FROM cc_kembali WHERE id_master = ".quote($idmaster)." AND id_pelanggan = ".quote($iddivisi)." AND stat <> 9");
		foreach($sql3->result_array() as $row2){
			$tgl = strtotime($row2['tgl']) + $n;
			$save[$tgl]['terjual'] = $row2['jml'];
			$save[$tgl]['ket'] = $row2['ket'];
			$n++;
		}

		ksort($save);
		return $save;
	}

	public function list_divisi(){
		$sql = query("SELECT * FROM cc_pelanggan ORDER BY nama_p");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id_p']] = $row['nama_p'];
		}
		return $arr;
	}


	public function cek_stok_cc($idmaster, $tgl){

	}
	public function lihat()
	{
		$sql = query("SELECT * FROM cc_pelanggan ORDER BY id DESC");
		return $sql->result_array();
	}
	public function keluar()
	{
		$sql = query("SELECT * FROM cc_keluar ORDER BY tanggal DESC");
		return $sql->result_array();
	}
	public function tambah($ket,$tot,$datedb)
	{
		$hasil=$this->db->query("INSERT INTO cc_keluar (keterangan,total,tanggal) VALUES ('$ket','$tot','$datedb')");
		return $hasil;
	}
	public function edit($id,$ket,$tot)
	{
		$hasil=$this->db->query("UPDATE cc_keluar SET keterangan='$ket', total='$tot' WHERE id = '$id'");
		return $hasil;
	}
	public function hapus($id)
	{
		$hasil=$this->db->query("DELETE FROM cc_keluar WHERE id = '$id'");
		return $hasil;	
	}
	public function cek_pelanggan($idmaster)
	{
		$query = $this->db->query("SELECT * FROM cc_pinjam_ambil WHERE id_pelanggan = '$idmaster' AND keterangan LIKE '%Pinjaman%'");
		if($query->num_rows() == 1){
			return $query->num_rows();
		}else{
			return 0;
		}
	}

	public function load_pelinggin($idmaster)
	{
		$ambil = query("SELECT * FROM cc_pelanggan WHERE id_p = '$idmaster'");
		return $ambil->result_array();
	}

	public function mbohlahwes()
	{
		$mboh = query("SELECT id FROM cc_master WHERE harga > 0 AND id <> 1");
		return $mboh->result_array();
	}

	public function cek_pinjaman($id_pelanggan)
	{
		$query = query("SELECT total_pinjam FROM cc_pelanggan WHERE id_p = '$id_pelanggan'")->result();
		foreach ($query as $qu) {
			return $qu->total_pinjam;
		}
	}

	public function cek_pinjaman1($id_pelanggan,$idib)
	{
			$query = query("SELECT SUM(jml) AS cekcok FROM cc_terjual WHERE id_pelanggan = '$id_pelanggan' AND id_master = '$idib'");
			$row = $query->row_array();
			return $a = $row["cekcok"];
	}

	public function galon()
	{
		$sql = query("SELECT * FROM cc_master WHERE id = 1");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id']] = $row['nama'];
		}
		return $arr;	
	}

	public function galonop()
	{
		$sql = query("SELECT * FROM cc_master WHERE harga > 0");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id']] = $row['nama'];
		}
		return $arr;	
	}

	public function ambil($idmaster)
	{
		$sikil = query("SELECT id_master FROM cc_pinjam_ambil WHERE id_pelanggan = '$idmaster'")->result();
		foreach ($sikil as $kaki) {
			$master = $kaki->id_master;
			$sql = query("SELECT * FROM cc_master WHERE id = '$master'");
			
			$arr = array();
			foreach($sql->result_array() as $row){
				$arr[] = $row['nama'];
			}
			return $arr;
		}
		
	}

	public function anu()
	{
		$anu = query("SELECT * FROM cc_master WHERE id = 1 AND harga = 0")->result();
		foreach ($anu as $una) {
			$ina = $una->nama;
			return $ina;
		}
	}

	public function sentolop()
	{
		$sentolop = query("SELECT id FROM cc_master WHERE harga = 0 AND id <> 1");
		return $sentolop->result_array();
	}

	function multi_insert($table = null, $arr = array())
	{
	      $jumlah = count($arr);
	 
	      if ($jumlah > 0)
	      {
	         $this->db->insert_batch($table, $arr);
	      }
	}

	public function load_detail($idmaster)
	{
		$sql = query("SELECT * FROM cc_pinjam_ambil WHERE id_pelanggan = '$idmaster'");
	}

	public function langgan($id)
	{
		$query=$this->db->query("SELECT * FROM cc_pelanggan JOIN cc_kembali ON cc_kembali.id_pelanggan = cc_pelanggan.id JOIN cc_pinjam_ambil ON cc_pinjam_ambil.id_pelanggan = cc_pelanggan.id WHERE cc_pelanggan.id = '$id'");
		return $query->result_array();
	}
	public function cek_data($id_pelanggan)
	{
		$tgl = date("Y-m-d");
		$query = query("SELECT * FROM cc_terjual WHERE id_pelanggan = '$id_pelanggan' AND tgl = '$tgl'");
		if($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}

	public function rekapgudang()
	{
		$sql = query("SELECT * FROM cc_master ORDER BY nama ASC");
		return $sql->result_array();
	}
	public function hmhm($stk1)
	{	
		$sql = query("UPDATE cc_master SET stok = stok -'$stk1' WHERE id = 1");
		return $sql;
	}
	public function detstok($idmaster)
	{
		$sql = query("SELECT * FROM cc_terima JOIN cc_master ON cc_master.id = cc_terima.id_master JOIN cms_admin ON cms_admin.id = cc_terima.id_admin WHERE id_master = '$idmaster' ORDER BY cc_terima.id_t ASC");
		return $sql->result_array();
	}
	public function cs($idmaster)
	{
		$sql = query("SELECT stok FROM cc_master WHERE id ='$idmaster' ");
		return $sql->result_array();
	}
	public function harga($id_galon)
	{
		$sql = query("SELECT * FROM cc_master WHERE id = '$id_galon'");
		return $sql;
	}
	
	public function load_pelanggan($cari)
	{
		if($cari != '') {
			$sql = query("SELECT * FROM cc_pelanggan WHERE nama_p LIKE '%$cari%' AND id_p >1 ORDER BY nama_p ASC");
			return $sql->result_array();
		}else{
			$sql = query("SELECT * FROM cc_pelanggan WHERE id_p >1 ORDER BY nama_p ASC");
			return $sql->result_array();
		}
	}

	public function celuk_pelanggan()
	{
		$sql = query("SELECT * FROM cc_pelanggan");
			return $sql->result_array();
	}
	public function get_master()
	{
		$sql = query("SELECT * FROM cc_master");
		return $sql->result();
	}

	public function get_total_pinjam($idmaster)
	{
		$sql = query("SELECT total_pinjam FROM cc_pelanggan WHERE id_p = '$idmaster'");
		$row = $sql->row_array();
		return $row["total_pinjam"];
	}

	public function get_stok_master(){
		$this->load->model("mdreport");
		$kosong = $this->mdreport->galon_kosong();
		$sql = query("SELECT stok FROM cc_master WHERE id = '$kosong'")->row_array();
		return $sql["stok"];
	}

	public function nama10($id10rb)
	{
		$sql = query("SELECT nama FROM cc_master WHERE id = '$id10rb'")->row_array();
		return $sql["nama"];
	}

	public function nama12($id12rb)
	{
		$sql = query("SELECT nama FROM cc_master WHERE id = '$id12rb'")->row_array();
		return $sql["nama"];
	}
	public function galonkos()
	{
		$sql = query("SELECT id FROM cc_master WHERE id = 1");
		return $sql->result();	
	}
	public function galon_op()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%Galon%' AND id != 1");
		return $sql->result_array();
	}
}