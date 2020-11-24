	<form method="post" action="<?php echo base_url('laporan2/cari_pengambilan') ?>">
	<div class="row">
		
			<div class="input-group no-print" style="float: left;margin-left: 1.4%">
				<select name="bulan" class="form-control">
					<?php
						$bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
						for($bulan=1; $bulan<=12; $bulan++){
							$sel = $bulan == $bulin ? ' selected="selected"' : '';
							echo "<option value='$bulan' ".$sel.">$bln[$bulan]</option>"; 

						}
					?>
				</select>
			</div>
			<div class="input-group no-print" style="float: left">
				<select name="tahun" class="form-control">
					<?php
						$mulai= date('Y') - 10;
						for($i = $mulai;$i<$mulai + 21;$i++){
						    $sel = $i == $tahun ? ' selected="selected"' : '';
						    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
						}
					?>
				</select>
			</div>
			<button class="btn btn-info no-print input-group" type="submit" name="lihat" style="text-align: center;float: left;margin-right: 10px;"><span class="fa fa-eye"></span> Lihat</button>

			<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	</div>
	<br>
	</form>

<div class="print-area">
			<?php 
				if($bulin == date('m')) {	
					if($bulin = date('m')) {
						$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
					}
				}
			?>
	
<div class="row">
	<div class="col-sm-9" style="margin-right: 1.5%">
		<p style="line-height: 35px;"> Bulan :  <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>
	</div>
		<form method="post" action="<?php echo base_url('laporan2/cari_pelanggan') ?>">
				<div class="input-group no-print" style="float:left">
					<input type="text" class="form-control" name="golek" placeholder="Cari Pelanggan">
				</div>
				<div class="input-group no-print">
					<input type="hidden" name="sasi" value="<?php echo $bulin ?>">
					<input type="hidden" name="tahin" value="<?php echo $tahun ?>">
					<button class="btn btn-info no-print form-control" type="submit" name="lihat" style="text-align: center;border-top-right-radius: 5px;border-bottom-right-radius: 5px"> Cari</button>
				</div>
		</form>
</div>			

	<table class="table	table-bordered">
		<thead>
			<tr align="center" class="active">
				<td><strong>No.</strong></td>
				<td><strong>Nama Pelanggan</strong></td>
				<td><strong>Jumlah Pinjaman Galon</strong></td>
				<td><strong>Jumlah Pengambilan</strong></td>
				<td><strong>Rata-Rata Diambil</strong></td>	
				<td class="no-print"><strong>Detail</strong></td>
			</tr>	
		</thead>
		<tbody>
		<?php 
			if($kuer->num_rows() > 0) {

				$no=1;
				foreach ($kuer->result() as $q) { 
				$sql = $this->db->query("SELECT * FROM cc_pelanggan WHERE id_p = '$q->id_p' ")->result_array();
					foreach ($sql as $i) {
		?>
				<tr>
					<td align="center"><?php echo $no++ ?>.</td>
					<td><?php echo $i['nama_p'] ?></td>
				    <td align="center"><?php echo $i['total_pinjam'] ?> pcs</td>

					    <?php  
						    $y = query("SELECT * FROM cc_terjual WHERE month(tgl) = '$bulin' AND year(tgl) = '$tahun' AND id_pelanggan = ".$i['id_p']." ORDER BY tgl ASC");
						    $yey = $y->num_rows();
						    $rata = query("SELECT SUM(jml) AS ukowe FROM cc_terjual WHERE month(tgl) = '$bulin' AND year(tgl) = '$tahun' AND id_pelanggan = ".$i['id_p']."");
						    $row = $rata->row_array();
						    $ooo = $row['ukowe'];
						    $opq = $ooo / $yey;
						?>

				    <td align="center"><?php echo $yey; ?> kali</td>
				    <td align="center"><?php echo floor($opq); ?> pcs</td>
				    <form method="post" action="<?php echo base_url('laporan2/detail_pengambilan'); ?>">
				    	<input type="hidden" name="id_p" value="<?php echo $i['id_p'] ?>">
				    	<input type="hidden" name="nama" value="<?php echo $i['nama_p'] ?>">
				    	<input type="hidden" name="moon" value="<?php echo $bulin ?>">
				    	<input type="hidden" name="taun" value="<?php echo $tahun ?>">
						<td class="text-center no-print">
							<button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-eye"></span> Detail</button>
						</td>
					</form>
				</tr>
		<?php }}}else{ ?>
			 	<tr>
					<td colspan="6" align="center">Tidak Ada Pengambilan di Bulan Ini !</td>
				</tr>
		<?php } ?>
		</tbody>
	</table>
</div>

