<?php
defined("BASEPATH") or exit();

Class Mdreport extends CI_Model{

	private $_table = "cc_master";
	
	public function listdiv($ret="obj"){
		$sql = query("SELECT * FROM cc_pelanggan ORDER BY nama_p");
		if($ret == "array"){
			$r = array();
			foreach($sql->result_array() as $row){
				$r[$row['id_p']] = $row['nama_p'];
			}
			return $r;
		}
		else{
			return $sql->result_array();
		}
	}

	public function listdiv1($ret="obj"){
		$sql = query("SELECT * FROM cc_pelanggan ORDER BY nama_p");
		if($ret == "array"){
			$r = array();
			foreach($sql->result_array() as $row){
				$r[$row['id_p']] = $row['id_p'];
			}
			return $r;
		}
		else{
			return $sql->result_array();
		}
	}

	public function list_cc(){
		$sql = query("SELECT * FROM cc_master WHERE nama LIKE '%Galon%'");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id']] = $row['nama'];
		}
		return $arr;
	}
	public function list_cc2(){
		$sql = query("SELECT * FROM cc_master");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id']] = $row['nama'];
		}
		return $arr;
	}

	public function list_cc1(){
		$sql = query("SELECT * FROM cc_master WHERE nama LIKE '%Galon%'");
		$arr = array();
		foreach($sql->result_array() as $row){
			$arr[$row['id']] = $row['id'];
		}
		return $arr;
	}
	
	public function galon_kosong()
	{
		$sql = query("SELECT id FROM cc_master WHERE id = 1");
		$row = $sql->row_array();
		return $row["id"];
	}

	public function galon_10rb()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%Op%' AND harga = 10000");
		$row = $sql->row_array();
		return $row["id"];
	}

	public function galon_12rb()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%Op%' AND harga = 12000");
		$row = $sql->row_array();
		return $row["id"];
	}

	public function report_divisi(){
		$arr = array();
		$dv = query("SELECT * FROM cc_pelanggan");
		$n = 0;
		$tgl = date('m');$tgl = date('Y');
		$bulan = date('m');$tahun = date('Y');
		foreach($dv->result_array() as $row){

			$sql = query("SELECT * FROM cc_pinjam_ambil WHERE id_pelanggan = ".quote($row['id_p'])." AND id_pelanggan > 1 AND month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl");
			foreach($sql->result_array() as $r){
				$tgll = $tgl + $n;
				$arr[$row['id_p']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['keterangan']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_kembali WHERE id_pelanggan = ".quote($row['id_p'])." AND month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl");
			foreach($sql2->result_array() as $r2){
				$tgll = $tgl + $n;
				$arr[$row['id_p']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['keterangan']
				);
				$n++;
			}
		}


		return $arr;

	}

	public function report_pelanggan($bulan,$tahun){
		$arr = array();
		$dv = query("SELECT * FROM cc_pelanggan");
		$n = 0;
		$tgl = $bulan;$tgl = $tahun;
		foreach($dv->result_array() as $row){

			$sql = query("SELECT * FROM cc_pinjam_ambil WHERE id_pelanggan = ".quote($row['id_p'])." AND id_pelanggan > 1 AND month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl");
			foreach($sql->result_array() as $r){
				$tgll = $tgl + $n;
				$arr[$row['id_p']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['keterangan']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_kembali WHERE id_pelanggan = ".quote($row['id_p'])." AND month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl");
			foreach($sql2->result_array() as $r2){
				$tgll = $tgl + $n;
				$arr[$row['id_p']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['keterangan']
				);
				$n++;
			}
		}
		return $arr;
	}

	public function report_pelanggan1($bulan,$tahun,$golek){
		$arr = array();
		$n = 0;
		$tgl = $bulan;$tgl = $tahun;

			$sql = query("SELECT * FROM cc_pinjam_ambil JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_pinjam_ambil.id_pelanggan WHERE nama_p LIKE '%$golek%' AND month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl");
			
			foreach($sql->result_array() as $r){
				$tgll = $tgl + $n;
				$arr[$r['id_p']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['keterangan']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_kembali JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_kembali.id_pelanggan WHERE nama_p LIKE '%$golek%' AND month(tgl) = '$bulan' AND year(tgl) = '$tahun' ORDER BY tgl");
			
			foreach($sql2->result_array() as $r2){
				$tgll = $tgl + $n;
				$arr[$r2['id_p']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['keterangan']
				);
				$n++;
			}

		return $arr;
	}

	public function detail($id_pelanggan,$id_master,$bulan,$tahun)
	{
		$tanggal = $bulan;$tanggal = $tahun;
		$kosong = $this->galon_kosong();
		$save = array();
		$n = 0;
			
			$sql = query("SELECT * FROM cc_pinjam_ambil JOIN cc_master ON cc_master.id = cc_pinjam_ambil.id_master WHERE id_pelanggan = ".quote($id_pelanggan)." AND id_master = ".quote($kosong)." AND month(cc_pinjam_ambil.tgl) = ".$bulan." AND year(cc_pinjam_ambil.tgl) = ".$tahun."");
			foreach($sql->result_array() as $row){
				$tgl = strtotime($tanggal) + $n; 

				$save[$tgl]['pinjam'] = $row['jml'];
				$save[$tgl]['barang'] = $row['nama'];
				$save[$tgl]['tanggal'] = $row['tgl'];
				$save[$tgl]['ket'] = $row['keterangan'];
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_kembali JOIN cc_master ON cc_master.id = cc_kembali.id_master WHERE id_pelanggan = ".quote($id_pelanggan)." AND id_master = ".quote($kosong)." AND month(cc_kembali.tgl) = ".$bulan." AND year(cc_kembali.tgl) = ".$tahun."");
			foreach($sql2->result_array() as $row){
				$tgl = strtotime($tanggal) + $n; //tweak untuk menampilkan data dengan tanggal yg sama. limit = 86399 data.
				$save[$tgl]['kembali'] = $row['jml'];
				$save[$tgl]['barang'] = $row['nama'];
				$save[$tgl]['tanggal'] = $row['tgl'];
				$save[$tgl]['ket'] = $row['keterangan'];
				$n++;
			}

		ksort($save);
		return $save;
	}

//---------------------------------------------------------------------------------------------------------------------------

	public function report_master($id){
		$arr = array();
		
		// $sepuluh = $this->sepuluh();
		// $rolas = $this->duabelas();
		// $baku = $this->baku();
	
		$sql2 = query("SELECT * FROM cc_pinjam_ambil WHERE id_master = ".quote($id)." AND keterangan != 'Sisa Pinjaman' ORDER BY tgl");
		$n = 0;
		foreach($sql2->result_array() as $row2){
			$tgl = strtotime($row2['tgl']) + $n;
			$arr[$row2['id_master']][$tgl]["pinjam"] = $row2['jml'];
			$arr[$row2['id_master']][$tgl]["tgl"] = $row2['tgl'];
			$arr[$row2['id_master']][$tgl]["ket"] = $row2['keterangan'];
			$n++;
		}

		$sql3 = query("SELECT * FROM cc_kembali WHERE id_master = ".quote($id)." ORDER BY tgl");
		foreach($sql3->result_array() as $row3){
			$tgl = strtotime($row3['tgl']) + $n;
			$arr[$row3['id_master']][$tgl]["kembali"] = $row3['jml'];
			$arr[$row3['id_master']][$tgl]["tgl"] = $row3['tgl'];
			$arr[$row3['id_master']][$tgl]["ket"] = $row3['keterangan'];
			$n++;
		}

		$sql4 = query("SELECT * FROM cc_terima WHERE id_master = ".quote($id)." AND ket LIKE '%RESTOK%' ORDER BY tgl");
		foreach($sql4->result_array() as $row4){
			$tgl = strtotime($row4['tgl']) + $n;
			$arr[$row4['id_master']][$tgl]["terima"] = $row4['jml'];
			$arr[$row4['id_master']][$tgl]["tgl"] = $row4['tgl'];
			$arr[$row4['id_master']][$tgl]["ket"] = $row4['ket'];
			$n++;
		}

		ksort($arr);
		return $arr;
	}

	public function report_op($id)
	{
		$arr = array();
		
		$n = 0;
			$sql5 = query("SELECT * FROM cc_terima WHERE id_master = ".quote($id)." AND ket LIKE '%RESTOK%' ORDER BY tgl");
			foreach($sql5->result_array() as $row5){
				$tgl = strtotime($row5['tgl']) + $n;
				$arr[$row5['id_master']][$tgl]["terima"] = $row5['jml'];
				$arr[$row5['id_master']][$tgl]["tgl"] = $row5['tgl'];
				$arr[$row5['id_master']][$tgl]["ket"] = $row5['ket'];
				$n++;
			}

			$sql6 = query("SELECT * FROM cc_terjual WHERE id_master = ".quote($id)." ORDER BY tgl");
			foreach($sql6->result_array() as $row6){
				$tgl = strtotime($row6['tgl']) + $n;
				$arr[$row6['id_master']][$tgl]["keluar"] = $row6['jml'];
				$arr[$row6['id_master']][$tgl]["tgl"] = $row6['tgl'];
				$arr[$row6['id_master']][$tgl]["ket"] = $row6['ket'];
				$n++;
			}

		ksort($arr);
		return $arr;
	}

//---------------------------------------------------------------------------------------------------------------------------//

	public function sepuluh()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%10%' AND harga > 0");
		$row = $sql->row_array();
		return $a = $row["id"];
	}

	public function duabelas()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%12%' AND harga > 0");
		$row = $sql->row_array();
		return $a = $row["id"];
	}

	public function baku()
	{
		$sql = query("SELECT id FROM cc_master WHERE id = 1 AND harga = 0");
		$row = $sql->row_array();
		return $a = $row["id"];
	}

	
//--------------------------------------------------NGGAE MANEH-------------------------------------------------------//



	public function getAll()
	{
		$sql = query("SELECT * FROM cc_master ORDER BY nama");
		return $sql->result();
	}

	public function get_id()
	{
		$sql = query("SELECT id FROM cc_master WHERE id != 1");
		return $sql;
	}

	public function hem($id)
	{
		$sql = query("SELECT * FROM cc_master WHERE id = '$id'");
		return $sql->result();
	}

	public function get_stok($id)
	{
		$sql = query("SELECT * FROM cc_terima JOIN cc_master ON cc_master.id=cc_terima.id_master WHERE id_master = '$id' AND ket NOT LIKE '%RESTOK%' ");
		return $sql->result();
	}
	public function akhir($id)
	{
		$sql = query("SELECT stok FROM cc_master WHERE id = '$id'");
		return $sql->result();		
	}
	public function galon_op()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%Galon%' AND id != 1");
		return $sql->result();
	}
} 