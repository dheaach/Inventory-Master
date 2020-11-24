<?php
defined("BASEPATH") or exit();

Class Mdlaporan extends CI_Model{

	public function listdiv($ret="obj"){
		$sql = query("SELECT * FROM cc_divisi WHERE stat <> 9 ORDER BY nama_divisi");
		if($ret == "array"){
			$r = array();
			foreach($sql->result_array() as $row){
				$r[$row['id']] = $row['nama_divisi'];
			}
			return $r;
		}
		else{
			return $sql->result_array();
		}
	}

	public function list_cc(){
		$sql = query("SELECT * FROM cc_pelanggan");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id_p']] = $row['nama_p'];
		}
		return $arr;
	}



	public function report_master($detail=0){
		$arr = array();
		$sql = query("SELECT id_p FROM cc_pelanggan ORDER BY nama_p");
		foreach($sql->result_array() as $row){
			$arr[$row['id_p']] = array();
		}

		$id1 = $this->njupuk();
		$id2 = $this->njupuk2();
		$tgl = date("Y-m-d");

		$sql2 = query("SELECT * FROM cc_terjual WHERE id_master = '$id1' AND tgl = '$tgl'");
		$n = 0;
		foreach($sql2->result_array() as $row2){
			$tgl = strtotime($row2['tgl']) + $n;
			$arr[$row2['id_master']][$tgl]["terjual"] = $row2['jml'];
			$n++;
		}

		$sql3 = query("SELECT * FROM cc_terjual WHERE id_master = '$id2' AND tgl = '$tgl'");
		foreach($sql3->result_array() as $row3){
			$tgl = strtotime($row3['tgl']) + $n;
			$arr[$row3['id_master']][$tgl]["kirim"] = $row3['jml'];
			$n++;
		}

		return $arr;
	}






	public function report_divisi($detail=0, $filter=""){
		$arr = array();

		$addq = "";
		if(strlen($filter) > 0){
			$addq = " AND id = ".quote($filter);
		}
		$dv = query("SELECT * FROM cc_divisi WHERE stat <> 9 $addq");
		$n = 0;
		foreach($dv->result_array() as $row){

			$sql = query("SELECT * FROM cc_kirim WHERE id_divisi = ".quote($row['id'])." AND stat <> 9 ORDER BY tgl");
			foreach($sql->result_array() as $r){
				$tgll = strtotime($r['tgl']) + $n;
				$arr[$row['id']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['ket']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_terjual WHERE id_divisi = ".quote($row['id'])." AND stat <> 9 ORDER BY tgl");
			foreach($sql2->result_array() as $r2){
				$tgll = strtotime($r2['tgl']) + $n;
				$arr[$row['id']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['ket']
				);
				$n++;
			}


		}


		return $arr;

	}
//-----------------------------------------------------------------------------------------------------------------------------

	public function njupuk_brg()
	{
		$sql = query("SELECT * FROM cc_master WHERE harga > 0");
		return $sql;
	}

	public function celuk()
	{
		$tgl = date("Y-m-d");
		$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE tgl= '$tgl'");
		return $sql;
	}

	public function ambil()
	{
		$bulan = date("m");
		$tahun = date("Y");
		$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl ASC");
		return $sql;
	}

	public function ambil_lainnya($bulan,$tahun)
	{
		$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl ASC");
		return $sql;
	}

	public function ambil_maneh($bulan,$tahun,$id_pelanggan)
	{
		$sql = query("SELECT * FROM cc_pelanggan JOIN cc_terjual ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' AND id_pelanggan = '$id_pelanggan' ORDER BY tgl ASC");
		return $sql;
	}

	public function ambil_terus($bulan,$tahun,$golek)
	{
		if($golek != '') {
			$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' AND nama_p LIKE '%$golek%' ORDER BY tgl ASC");
			return $sql;
		}else{
			$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl ASC");
			return $sql;
		}
	}

	public function celuks($key)
	{
		$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE tgl = '$key'");
		return $sql;
	}

	public function panggil($golek,$hem)
	{
		if($golek != '') {
			$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE tgl = '$hem' AND nama_p LIKE '%$golek%'");
			return $sql;
		}
		else{
			$sql = query("SELECT DISTINCT(id_p) FROM cc_terjual JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_terjual.id_pelanggan WHERE tgl = '$hem'");
			return $sql;
		}
	}

	public function abc()
	{
		$bulan = date('m');
		$tahun = date('Y');
		$sql = query("SELECT DISTINCT(tgl) FROM cc_terjual WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl ASC");
		return $sql;
	}

	public function abcs($bulan,$tahun)
	{
		$sql = query("SELECT DISTINCT(tgl) FROM cc_terjual WHERE month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl ASC");
		return $sql;
	}


	public function pengeluaran()
	{
		$tgl = date('Y-m-d');
		$sql = $this->db->query("SELECT * FROM cc_keluar WHERE tanggal ='$tgl' ");
		return $sql;
	}

	public function pengeluarans($key)
	{
		$sql = $this->db->query("SELECT * FROM cc_keluar WHERE tanggal = '$key' ");
		return $sql;
	}

	public function keluaran()
	{
		$bulan = date('m');
		$tahun = date('Y');
		$sql = $this->db->query("SELECT * FROM cc_keluar WHERE month(tanggal) ='$bulan' AND year(tanggal) = '$tahun' ORDER BY tanggal ASC ");
		return $sql;
	}

	public function keluarans($bulan,$tahun)
	{
		$sql = $this->db->query("SELECT * FROM cc_keluar WHERE month(tanggal) = '$bulan' AND year(tanggal) = '$tahun' ORDER BY tanggal ASC ");
		return $sql;
	}

	public function ambil_tanggal()
	{
		$sql = query("SELECT tgl FROM cc_laporan ORDER BY waktu DESC LIMIT 1");
		$row = $sql->row_array();
		return $row["tgl"];
	}

	public function cek_ada($date)
	{
		$sql = query("SELECT * FROM cc_laporan WHERE tgl = '$date'");
		if($sql->num_rows() > 0) {
			return $sql->num_rows();
		}else{
			return 0;
		}
	}

	public function update($tablename,$dat,$where)
	{
		$update = $this->db->update($tablename,$dat,$where);
		return $update;
	}
}