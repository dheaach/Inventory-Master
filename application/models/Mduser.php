<?php defined('BASEPATH') OR exit('No direct access allowed');
class Mduser extends CI_Model
{

	private $_table = "cms_admin";

	public $nama;
	public $username;
	public $email;
	public $password;

	public function rules()
	{
		return
		[
			['field' => 'username',
			 'label' => 'username',
			 'rules' => 'required'],

			 ['field' => 'nama',
			 'label' => 'Nama',
			 'rules' => 'required'],

			 ['field' => 'email',
			 'label' => 'Email',
			 'rules' => 'required'],

			 ['field' => 'password',
			 'label' => 'Password',
			 'rules' => 'required']
		
		];
	}

	public function load_cc(){
		$sql = $this->db->query("SELECT * FROM cms_admin ");
		return $sql->result();
	}

	public function getAll()
	{
		return $this->db->get($this->_table)->result();
	}

	public function tambah($tablename,$data)
	{
		$tambah = $this->db->insert($data,$tablename);
		return $tambah;
	}

	public function update($id,$user,$nama,$email){
		
		$hasil=$this->db->query("UPDATE cms_admin SET username='$user',name='$nama',email='$email' WHERE id='$id'");
		return $hasil;
	}

	public function delete($tablename,$where)
	{
		$hapus = $this->db->delete($tablename,$where);
		return $hapus;
	}

}