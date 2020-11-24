<?php
defined("BASEPATH") or exit();

Class Mdsetting extends CI_Model{

	public function get_last_id($nm){
		$arr = array(
			"id" => null,
			"nama_project" => $nm,
			"tgl" => date("Y-m-d H:i:s"),
			"stat" => 1
			);
		$this->db->insert("cc_project",$arr);
		$id = $this->db->insert_id();


		return $id;
	}

	public function load_project(){
		$sql = query("SELECT * FROM cc_project WHERE stat <> 9 ");
		return $sql->result_array();
	}

	public function project_detail($id){
		$sql = query("SELECT * FROM cc_project WHERE id = ".quote(intval($id)));
		$row = $sql->row_array();
		return $row;
	}




	public function report_master($idproj, $detail=0){
		$arr = array();
		$sql = query("SELECT * FROM cc_master WHERE stat <> 9 ORDER BY nama");
		foreach($sql->result_array() as $row){
			$arr[$row['id']] = array();
		}

		$sql2 = query("SELECT * FROM cc_temp WHERE tb = 'cc_kembali' AND id_project = ".quote($idproj)." AND stat <> 9 ORDER BY tgl");
		$n = 0;
		foreach($sql2->result_array() as $row2){
			$tgl = strtotime($row2['tgl']) + $n;
			$arr[$row2['id_master']][$tgl]["terima"] = $row2['jml'];
			$arr[$row2['id_master']][$tgl]["ket"] = $row2['ket'];
			$n++;
		}

		$sql3 = query("SELECT * FROM cc_temp WHERE tb = 'cc_pinjam_ambil' AND id_project = ".quote($idproj)." AND stat <> 9 ORDER BY tgl");
		foreach($sql3->result_array() as $row3){
			$tgl = strtotime($row3['tgl']) + $n;
			$arr[$row3['id_master']][$tgl]["kirim"] = $row3['jml'];
			$arr[$row3['id_master']][$tgl]["ket"] = $row3['ket'];
			$n++;
		}

		return $arr;
	}


	public function report_divisi1($idproj){
		$arr = array();

		$dv = query("SELECT * FROM cc_pelanggan");
		$n = 0;
		foreach($dv->result_array() as $row){

			$sql = query("SELECT * FROM cc_temp WHERE tb = 'cc_pinjam_ambil' AND id_project = '$idproj'  AND id_pelanggan = ".quote($row['id_p'])." AND id_pelanggan > 1 AND stat <> 9 ORDER BY tgl");
			foreach($sql->result_array() as $r){
				$tgll = strtotime($r['tgl']) + $n;
				$arr[$row['id_p']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['ket']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_temp WHERE tb = 'cc_kembali' AND id_project = '$idproj' AND id_pelanggan = ".quote($row['id_p'])." AND id_pelanggan > 1 AND stat <> 9 ORDER BY tgl");
			foreach($sql2->result_array() as $r2){
				$tgll = strtotime($r2['tgl']) + $n;
				$arr[$row['id_p']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['ket']
				);
				$n++;
			}


		}


		return $arr;

	}

	public function baku()
	{
		$sql = query("SELECT id FROM cc_master WHERE id = 1 AND harga = 0");
		$row = $sql->row_array();
		return $a = $row["id"];
	}

	public function getAll($id_project)
	{
		$sql = query("SELECT * FROM cc_temp JOIN cc_master ON cc_master.id  = cc_temp.id_master WHERE tb = 'cc_terima' AND id_project = '$id_project' AND ket != 'Restok Gudang' ORDER BY nama");
		//$sql = query("SELECT * FROM cc_master ORDER BY nama");
		return $sql->result();
	}

	public function get_id($id_project)
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%10 rb%' OR nama LIKE '%12 rb%' OR nama LIKE '%Baku%' OR nama LIKE '%Tutup Galon%' OR nama LIKE  '%Tissue%' OR nama LIKE  '%Segel%' OR nama LIKE  '%Stiker%'");
		return $sql;
	}

	public function galon_kosong()
	{
		$sql = query("SELECT id FROM cc_master WHERE id = 1");
		$row = $sql->row_array();
		return $row["id"];
	}

	public function sepuluh()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%10 rb%' AND harga > 0");
		$row = $sql->row_array();
		return $a = $row["id"];
	}

	public function duabelas()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%12 rb%' AND harga > 0");
		$row = $sql->row_array();
		return $a = $row["id"];
	}

	public function detail($id_pelanggan,$id_master,$id_project)
	{
		
		$n = 0;
		
		$kosong = $this->galon_kosong();
		$save = array();
		$n = 0;

			$sql = query("SELECT * FROM cc_temp JOIN cc_master ON cc_master.id = cc_temp.id_master WHERE tb = 'cc_pinjam_ambil' AND id_project = '$id_project' AND id_pelanggan = ".quote($id_pelanggan)." AND id_master = ".quote($kosong)."");
			foreach($sql->result_array() as $row){
				$tgl = strtotime($row['tgl']) + $n;

				$save[$tgl]['pinjam'] = $row['jml'];
				$save[$tgl]['barang'] = $row['nama'];
				$save[$tgl]['tanggal'] = $row['tgl'];
				$save[$tgl]['ket'] = $row['ket'];
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_temp JOIN cc_master ON cc_master.id = cc_temp.id_master WHERE tb = 'cc_kembali' AND id_project = '$id_project' AND id_pelanggan = ".quote($id_pelanggan)." AND id_master = ".quote($kosong)."");
			foreach($sql2->result_array() as $row){
				$tgl = strtotime($row['tgl']) + $n; //tweak untuk menampilkan data dengan tanggal yg sama. limit = 86399 data.
				$save[$tgl]['kembali'] = $row['jml'];
				$save[$tgl]['barang'] = $row['nama'];
				$save[$tgl]['tanggal'] = $row['tgl'];
				$save[$tgl]['ket'] = $row['ket'];
				$n++;
			}

		ksort($save);
		return $save;
	}

	public function get_stok($id,$id_project)
	{
		$sql = query("SELECT * FROM cc_temp JOIN cc_master ON cc_master.id=cc_temp.id_master WHERE id_master = '$id' AND id_project = '$id_project' AND ket LIKE '%stok awal%' OR ket LIKE '%stok sebelumnya%'");
		return $sql->result();
	}

	public function report_op($id,$id_project)
	{
		$arr = array();
		
		$n = 0;
			$sql5 = query("SELECT * FROM cc_temp WHERE tb = 'cc_terima' AND id_project = '$id_project' AND id_master = ".quote($id)." AND ket NOT LIKE '%STOK AWAL%' ORDER BY tgl");
			foreach($sql5->result_array() as $row5){
				$tgl = strtotime($row5['tgl']) + $n;
				$arr[$row5['id_master']][$tgl]["terima"] = $row5['jml'];
				$arr[$row5['id_master']][$tgl]["tgl"] = $row5['tgl'];
				$arr[$row5['id_master']][$tgl]["ket"] = $row5['ket'];
				$n++;
			}

			$sql6 = query("SELECT * FROM cc_temp WHERE tb = 'cc_terjual' AND id_project = '$id_project' AND id_master = ".quote($id)." ORDER BY tgl");
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

	public function report_semua($id_project)
	{
		$arr = array();
		
		$n = 0;
			$sql5 = query("SELECT * FROM cc_temp WHERE tb = 'cc_terima' AND id_project = '$id_project' AND ket <> 'Stok awal' ORDER BY tgl");
			foreach($sql5->result_array() as $row5){
				$tgl = strtotime($row5['tgl']) + $n;
				$arr[$row5['id_master']][$tgl]["terima"] = $row5['jml'];
				$arr[$row5['id_master']][$tgl]["tgl"] = $row5['tgl'];
				$arr[$row5['id_master']][$tgl]["ket"] = $row5['ket'];
				$n++;
			}

			$sql6 = query("SELECT * FROM cc_temp WHERE tb = 'cc_terjual' AND id_project = '$id_project' ORDER BY tgl");
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
	public function hem($id,$id_project)
	{
		$sql = query("SELECT * FROM cc_temp JOIN cc_master ON cc_master.id = cc_temp.id_master WHERE tb= 'cc_terima' AND  id_master = '$id' AND id_project = '$id_project'");
		return $sql->result();
	}

	public function report_master1($id,$id_project){
		$arr = array();
		
		$sepuluh = $this->sepuluh();
		$rolas = $this->duabelas();
		$baku = $this->baku();
		
		$sql2 = query("SELECT * FROM cc_temp WHERE tb = 'cc_pinjam_ambil' AND id_project = '$id_project' AND id_master = ".quote($id)." ORDER BY tgl");
		$n = 0;
		foreach($sql2->result_array() as $row2){
			$tgl = strtotime($row2['tgl']) + $n;
			$arr[$row2['id_master']][$tgl]["pinjam"] = $row2['jml'];
			$arr[$row2['id_master']][$tgl]["tgl"] = $row2['tgl'];
			$arr[$row2['id_master']][$tgl]["ket"] = $row2['ket'];
			$n++;
		}

		$sql3 = query("SELECT * FROM cc_temp WHERE tb = 'cc_kembali' AND id_project = '$id_project' AND id_master = ".quote($id)." ORDER BY tgl");
		foreach($sql3->result_array() as $row3){
			$tgl = strtotime($row3['tgl']) + $n;
			$arr[$row3['id_master']][$tgl]["kembali"] = $row3['jml'];
			$arr[$row3['id_master']][$tgl]["tgl"] = $row3['tgl'];
			$arr[$row3['id_master']][$tgl]["ket"] = $row3['ket'];
			$n++;
		}

		$sql4 = query("SELECT * FROM cc_temp WHERE tb = 'cc_terima' AND id_project = '$id_project' AND id_master = ".quote($id)." AND ket NOT LIKE '%STOK AWAL%' ORDER BY tgl");
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

	public function report_pelanggan($id_project){
		$arr = array();
		$dv = query("SELECT * FROM cc_pelanggan");
		$n = 0;
		foreach($dv->result_array() as $row){
			$sql3 = query("SELECT * FROM cc_temp WHERE tb = 'cc_kembali' AND id_project = '$id_project' AND id_master = ".quote($id)." ORDER BY tgl");

			$sql = query("SELECT * FROM cc_temp WHERE tb = 'cc_pinjam_ambil' AND id_project = '$id_project' AND id_pelanggan = ".quote($row['id_p'])." ORDER BY tgl");
			foreach($sql->result_array() as $r){
				$tgll = strtotime($r['tgl']) + $n;
				$arr[$row['id_p']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['ket']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_temp WHERE tb = 'cc_kembali' AND id_project = '$id_project' AND  id_pelanggan = ".quote($row['id_p'])." ORDER BY tgl");
			foreach($sql2->result_array() as $r2){
				$tgll = strtotime($r2['tgl']) + $n;
				$arr[$row['id_p']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['ket']
				);
				$n++;
			}
		}
		return $arr;
	}

	public function report_pelanggan1($id_project,$golek){
		$arr = array();
		$n = 0;

			$sql = query("SELECT * FROM cc_temp JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_temp.id_pelanggan WHERE tb = 'cc_pinjam_ambil' AND id_project = '$id_project' AND  nama_p LIKE '%$golek%' ORDER BY tgl");
			
			foreach($sql->result_array() as $r){
				$tgll = strtotime($r['tgl']) + $n;
				$arr[$r['id_p']][$r['id_master']][$tgll] = array(
					"kirim" => $r['jml'],
					"ket" => $r['ket']
				);
				$n++;
			}

			$sql2 = query("SELECT * FROM cc_temp JOIN cc_pelanggan ON cc_pelanggan.id_p = cc_temp.id_pelanggan WHERE tb = 'cc_kembali' AND id_project = '$id_project' AND nama_p LIKE '%$golek%' ORDER BY tgl");
			
			foreach($sql2->result_array() as $r2){
				$tgll = strtotime($r2['tgl']) + $n;
				$arr[$r2['id_p']][$r2['id_master']][$tgll] = array(
					"jual" => $r2['jml'],
					"ket" => $r2['ket']
				);
				$n++;
			}

		return $arr;
	}

	public function get_tgl($id_project)
	{
		$sql = query("SELECT month(tgl) AS bul, year(tgl) AS hun FROM cc_project WHERE id = '$id_project'");
		return $sql->result_array();
	}
	public function jupukambil()
	{
		$sql = query("SELECT * FROM cc_kembali");
		return $sql->result();
	}
	public function jupukpinjam()
	{
		$sql = query("SELECT * FROM cc_pinjam_ambil");
		return $sql->result();	
	}
	public function delambil()
	{
		$sql = query("DELETE a,b FROM cc_pinjam_ambil AS a JOIN cc_kembali AS b ON b.id_pelanggan = a.id_pelanggan AND b.id_master = a.id_master WHERE a.id_master = b.id_master AND a.id_pelanggan = b.id_pelanggan AND a.jml = b.jml AND a.tgl = b.tgl");
		return $sql;
	}
	public function cek_pinjaman()
	{
		$query = query("SELECT total_pinjam FROM cc_pelanggan");
		return $query->result();
	}	
	
}