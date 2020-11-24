<?php
defined("BASEPATH") or exit();

Class Mdmaster extends CI_Model{

	public function load_cc($ord="nama"){
		$sql = query("SELECT * FROM cc_master WHERE stat <> 9 ORDER BY $ord ASC");
		return $sql;
	}

	public function load_divisi($ord="nama_divisi"){
		$sql = query("SELECT * FROM cc_divisi WHERE stat <> 9 ORDER BY $ord ASC");
		return $sql;
	}

	public function cek_exists($nm,$except=0){
		$add="";
		if($except <> 0){
			$add = "AND id <> ".$except;
		}

		$qry = "SELECT * FROM cc_master WHERE nama = ".quote($nm)." $add AND stat <> 9";
		$sql = query($qry);
		if($sql->num_rows() == 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function cek_dv_exists($nm,$except=0){
		$add="";
		if($except <> 0){
			$add = "AND id <> ".$except;
		}

		$qry = "SELECT * FROM cc_divisi WHERE nama_divisi = ".quote($nm)." $add AND stat <> 9";
		$sql = query($qry);
		if($sql->num_rows() == 0){
			return true;
		}
		else{
			return false;
		}
	}
	public function pelanggan()
	{
		$sql = query("SELECT * FROM cc_pelanggan WHERE id_p > 1 ORDER BY id_p DESC");
		return $sql;
	}

	public function tambah($brg,$nama,$alamat,$no,$tot,$ket)
	{
		$hasil=$this->db->query("INSERT INTO cc_pelanggan (nama_p,alamat,no_hp,total_pinjam,ket) VALUES ('$nama','$alamat','$no','$tot','$ket')");
		return $hasil;
	}
	public function edit($id,$brg,$nama,$alamat,$no,$tot,$ket)
	{
		$hasil=$this->db->query("UPDATE cc_pelanggan SET nama_p='$nama', alamat='$alamat', no_hp='$no',total_pinjam='$tot',ket = '$ket' WHERE id_p = '$id'");
		return $hasil;
	}
	public function hapus($id)
	{
		$hasil=$this->db->query("DELETE FROM cc_pelanggan WHERE id_p = '$id'");
		return $hasil;	
	}
	public function hapusdata($where,$table)
		{
			$this->db->where($where);
			$this->db->delete($table);
		}	

	public function delete($id){
		$hasil=$this->db->query("DELETE FROM cc_master WHERE id='$id'");
		return $hasil;
	}
	public function produk()
	{
		$query = $this->db->query('SELECT * FROM cc_master');
        return $query->result();
	}
	public function search($key)
	{
		if($key != ''){
			$sql = query("SELECT * FROM cc_pelanggan  WHERE nama_p LIKE '%$key%' OR id_p LIKE '%$key%' ORDER BY id_p DESC ");
			return $sql;
		}else{
			$sql = query("SELECT * FROM cc_pelanggan ORDER BY id_p DESC");
			return $sql;
		}

	}

	public function kosong()
	{
		$sql = query("SELECT id FROM cc_master WHERE id = 1 AND harga = 0");
		$row = $sql->row_array();
		return $row["id"];
	}

	public function operasional()
	{
		$sql = query("SELECT id FROM cc_master WHERE nama LIKE '%Galon Op%' AND harga > 0");
		return $sql->result_array();
	}

	public function hmhm($hs)
	{	
		$id = $this->kosong();
		$sql = query("UPDATE cc_master SET stok = stok -'$hs' WHERE id = '$id'");
	}

	public function haem($hos,$di)
	{	
		$sql = query("UPDATE cc_master SET stok = stok -'$hos' WHERE id = '$di'");
	}
	public function add($id,$nama,$harga,$stok)
	{
		$hasil=$this->db->query("INSERT INTO cc_master (id,nama,stat,stok,harga) VALUES ('$id','$nama','-','$stok','$harga')");
		return $hasil;		
	}
	public function kode()
	{
		$this->db->select("MAX(id)+1 AS kode");
		$this->db->from("cc_master");
		$query = $this->db->get();

		return $query->row()->kode;
	}
}