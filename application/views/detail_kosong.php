	<?php 
		if($bulin == date('m')) {	
			if($bulin = date('m')) {
				$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
			}
		}else{
			$bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		}
	?>	
	
	<form method="post" action="<?php echo base_url('laporan/pelanggan') ?>">
		<input type="hidden" name="bulan" value="<?php echo $bulin ?>">
		<input type="hidden" name="tahun" value="<?php echo $tahun ?>">
		<button type="submit" class="btn btn-warning no-print" style="float: left;margin-right: 10px;">Kembali</button>
	</form>

	<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-bottom: 20px;" align="center"><span class='fa fa-print fa-fw'></span> Print</a>

	<p> Bulan :  <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>

	<table class="table	table-bordered">
		<thead>
			<tr align="center" class="active">
				<td><strong>No.</strong></td>
				<td><strong>Nama Pelanggan</strong></td>
				<td><strong>Nama Inventory</strong></td>
				<td><strong>Tanggal</strong></td>
				<td><strong>Pinjam</strong></td>
				<td><strong>Kembali</strong></td>
				<td><strong>Keterangan</strong></td>
			</tr>	
		</thead>
		<tbody>
		<?php  
			$sql = query("SELECT * FROM cc_pinjam_ambil WHERE id_pelanggan = ".quote($id_p)." AND id_master = ".quote($id_master)." AND month(tgl) = ".$bulin." AND year(tgl) = ".$tahun."");
			$row = $sql->num_rows();

			$sql1 = query("SELECT * FROM cc_kembali WHERE id_pelanggan = ".quote($id_p)." AND id_master = ".quote($id_master)." AND month(tgl) = ".$bulin." AND year(tgl) = ".$tahun."");
			$row1 = $sql1->num_rows();

			$jumlah = $row + $row1;
			$n = 1;
			$sql = $this->db->query("SELECT DISTINCT(nama_p) AS nama FROM cc_pelanggan WHERE id_p = '$id_p'");
						$asma = $sql->row_array();
						$jeneng = $asma['nama'];
		?>
							
			<tr>
				<td align="center" width="5%" rowspan="<?php echo $jumlah ?>"><?php echo $n ?>.</td>
				<td align="center" rowspan="<?php echo $jumlah ?>"><?php echo $jeneng ?></td>
				
				<?php
					$mutasi = 0;
					foreach($query as $tgl=>$data){
					$nama = "";
					$kirim = "";

					if(isset($data['pinjam'])){
						$kirim = $data['pinjam'];
						$tgl = $data['tanggal'];
						$nama = $data['barang']; 
						$mutasi += $kirim;
					}
					$terima = "";
					if(isset($data['kembali'])){
						$terima = $data['kembali'];
						$tgl = $data['tanggal']; 
						$nama = $data['barang'];
						$mutasi -= $terima;
					}
					$ket = isset($data['ket']) ? "<em>$data[ket]</em>" : "";		  
				?>
								
					<td align="center"><?php echo $nama ?></td>	
					<td align="center"><?php echo indo_date($tgl) ?></td>
					<td align="center"><?php echo $kirim ?></td>
					<td align="center"><?php echo $terima ?></td>
					<td><?php echo $ket ?></td>
			</tr>
						
				<?php $n++; } ?>

			<tr class="active">
				<td colspan="6" align="right"><b>Sisa Peminjaman :</b></td>
				<td align="center"><em><strong><?php echo $mutasi ?> pcs</strong></em></td>
			</tr>
			
		</tbody>
	</table>