	<form method="post" action="<?php echo base_url('history/pelanggan/'.$id) ?>">
		<button type="submit" class="btn btn-warning no-print" style="float: left;margin-right: 10px;">Kembali</button>
	</form>

	<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-bottom: 20px;" align="center"><span class='fa fa-print fa-fw'></span> Print</a>

		    <?php foreach ($dat as $h) { ?>
	    	<?php
				$bul= $h['bul'];
				if($bul == 1){
					$bln = "Januari";
				}else if($bul == 2){
					$bln = "Februari";
				}else if($bul == 3){
					$bln = "Maret";
				}else if($bul == 4){
					$bln = "April";
				}else if($bul == 5){
					$bln = "Mei";
				}else if($bul == 6){
					$bln = "Juni";
				}else if($bul == 7){
					$bln = "Juli";
				}else if($bul == 8){
					$bln = "Agustus";
				}else if($bul == 9){
					$bln = "September";
				}else if($bul == 10){
					$bln = "Oktober";
				}else if($bul == 11){
					$bln = "November";
				}else{
					$bln = "Desember";
				}
			?>
	    	<p> Bulan :  <?php echo $bln ?> <?php echo $h['hun'] ?></p>
	    <?php } ?>


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
			$sql = query("SELECT * FROM cc_temp WHERE tb = 'cc_pinjam_ambil' AND id_project = '$id' AND id_pelanggan = ".quote($id_p)." AND id_master = ".quote($id_master)."");
			$row = $sql->num_rows();

			$sql1 = query("SELECT * FROM CC_TEMP WHERE tb = 'cc_kembali' AND id_project = '$id' AND id_pelanggan = ".quote($id_p)." AND id_master = ".quote($id_master)."");
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