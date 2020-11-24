	<?php 
		if($bulin == date('m')) {	
			if($bulin = date('m')) {
				$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
			}
		}else{
			$bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		}
	?>	

	<form method="post" action="<?php echo base_url('laporan2/cari_pengambilan') ?>">
		<input type="hidden" name="bulan" value="<?php echo $bulin ?>">
		<input type="hidden" name="tahun" value="<?php echo $tahun ?>">
		<button type="submit" class="btn btn-warning no-print" style="float: left;margin-right: 10px;">Kembali</button>
	</form>

	<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-bottom: 20px;" align="center"><span class='fa fa-print fa-fw'></span> Print</a>

	<p> Bulan :  <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>
	<?php $no=1; 
			$sql = $this->db->query("SELECT DISTINCT(nama_p) AS nama,total_pinjam FROM cc_pelanggan JOIN cc_terjual ON cc_terjual.id_pelanggan = cc_pelanggan.id_p WHERE id_p = '$id_p'");
			$asma = $sql->row_array();
			$nami = $kuer->num_rows();
			$jeneng = $asma['nama'];
			
	?>	

	<table class="table	table-bordered">
		<thead>
			<tr align="center" class="active">
				<td><strong>No.</strong></td>
				<td><strong>Nama Pelanggan</strong></td>
				<td><strong>Nama Inventory</strong></td>
				<td><strong>Tanggal</strong></td>
				<td><strong>Jumlah Pengambilan</strong></td>
				<td><strong>Keterangan</strong></td>
			</tr>	
		</thead>
		<tbody>

		
			<tr>
				<td align="center" rowspan="<?php echo $nami ?>" width="5%"><?php echo $no ?>.</td>
				<td rowspan="<?php echo $nami ?>" align="center"><?php echo $jeneng ?></td>

				<?php foreach ($kuer->result() as $q) { 
					// echo "<pre>";
					// print_r($q);
					// echo "</pre>";
					$query = query("SELECT nama FROM cc_master WHERE id = '$q->id_master'")->row_array();
					$barang = $query["nama"];
				?>

				<td align="center"><?php echo $barang ?></td>
				<td align="center"><?php echo indo_date($q->tgl,"half") ?></td>

					<?php  
						$y = query("SELECT * FROM cc_terjual WHERE month(tgl) = '$bulin' AND year(tgl) = '$tahun' AND id_pelanggan = ".$q->id_p." ORDER BY tgl ASC");
						$yey = $y->num_rows();
						$ket = $y->row_array();
						$Keterangan = $ket["ket"];
						$rata = query("SELECT SUM(jml) AS ukowe FROM cc_terjual WHERE month(tgl) = '$bulin' AND year(tgl) = '$tahun' AND id_pelanggan = ".$q->id_p."");
						$row = $rata->row_array();
						$ooo = $row['ukowe'];
						$opq = $ooo / $yey;

					?>

				<td align="center"><?php echo $q->jml; ?> pcs</td>
				<td><em><?php echo $q->ket ?></em></td>
			
			</tr>
				<?php } ?> 

			<tr class="active">
					<td colspan="6"><b>Rata - Rata Pengambilan : <?php echo floor($opq); ?> pcs</b></td>
					<td><b></b></td>
			</tr>
		</tbody>
	</table>