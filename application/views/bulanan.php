<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
    <ul class="menuwis">
      <li><a href="<?php echo base_url('laporan2/liporan') ?>">Harian</a></li>
      <li><a href="<?php echo base_url('laporan2/lap_bulan') ?>" class="active">Bulanan</a></li>
    </ul>
</div>	

	<form method="post" action="<?php echo base_url('laporan2/cari') ?>">
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
			<button class="btn btn-info no-print" type="submit" name="lihat" style="text-align: center;float: left;margin-right: 10px;"><span class="fa fa-eye"></span> Lihat</button>

			<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	</div>
	</form>
<br>
	<div class="print-area">
			<?php 
				if($bulin == date('m')) {	
					if($bulin = date('m')) {
						$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
					}
				}
			?>
		<p> Bulan :  <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>
		<div class="table-responsive">

			<table class="table table-bordered">
				<thead style="text-align: center;">
					<tr class="active">
						<td rowspan="2"><strong>No.</strong></td>
						<td rowspan="2" width="14%"><strong>Tanggal</strong></td>
						<?php $baris = $query->num_rows() ?>
						<td colspan="<?php echo $baris ?>"><strong>Jumlah</strong></td>
						<td colspan="<?php echo $baris ?>"><strong>Sub Total</strong></td>
						<td rowspan="2" width="12%"><strong>Total</strong></td>
						<td rowspan="2" class="no-print"><strong>Detail</strong></td>
					</tr>
					<tr class="active">
						<?php foreach ($query->result() as $u) { ?>
							<td><?php echo $u->nama ?></td>
						<?php } ?>
						<?php foreach ($query->result() as $u) { ?>
							<td><?php echo $u->nama ?></td>
						<?php } ?>
					</tr>
					</strong>
				</thead>
				<tbody>
				<?php 
					$no=1;if($quer->num_rows() > 0) { $tot = 0;
					foreach ($quer->result_array() as $p) { 
				?>
						<tr>
							<td align="center"><?php echo $no++ ?>.</td>
							<td><?php echo indo_date($p['tgl'],"half"); ?></td>	

						<?php 
							foreach ($query->result() as $ku) {
							$dolarku = 0;
								$sepuluh = $this->db->query("SELECT jml FROM cc_terjual WHERE id_master = '$ku->id'AND tgl = '$p[tgl]'");
								if($sepuluh->num_rows() > 0) {
								 	$row = $sepuluh->result();
								 	foreach ($row as $key) {
										$dolar = $key->jml;
									 	$dolarku += $dolar;
								 	}
								}else{
									$dolar = 0;
								} 
						?>

							<td><?php echo $dolarku ?></td>

						<?php } ?>

						<?php 
							$total = 0;
							foreach ($query->result() as $ku) {
							$rupeku = 0;
								$sedoso = $this->db->query("SELECT total FROM cc_terjual WHERE id_master = '$ku->id' AND tgl = '$p[tgl]'");
								if($sedoso->num_rows() > 0) {
								 	$row2 = $sedoso->result();
								 	foreach ($row2 as $key1) {
								 		$rupe = $key1->total;
										$rupeku += $rupe;
								 	}
								}else{
									$rupe = 0;
								} 
								$total += $rupeku;
						?>

							<td>Rp. <?php echo number_format($rupeku,0,",",".") ?></td>

						<?php } ?>

							<td>Rp. <?php echo number_format($total,0,",",".") ?></td>
							<form method="post" action="<?php echo base_url('laporan2/search'); ?>">
								<input type="hidden" name="tanggal" value="<?php echo $p['tgl'] ?>">
								<td class="text-center no-print"><button type="submit" class="btn btn-sm btn-primary"><span class="fa fa-eye"></span> Detail</button></td>
							</form>
						</tr>			

				<?php $tot += $total; } $colspan = $baris * 2 + 2;?> 
				
					<tr class="active">
						<td colspan="<?php echo $colspan ?>" align="right"><b>Total :</b></td>
						<td colspan="2"><b>Rp. <?php echo number_format($tot,0,",",".");?></b></td>
					</tr>

				<?php }else{ $tot = 0; $colspan1 = $baris * 2 + 4;?>
					<tr>
						<td colspan="<?php echo $colspan1 ?>" align="center">Tidak Ada Pemasukan Hari Ini !</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	<br>	
		<h4><strong>Data Pengeluaran Bulanan</strong></h4>	
		<table class="table table-bordered">
			<thead>
				<tr align="center" class="active">
					<td width="5%"><strong>No.</strong></td>
					<td width="20%"><strong>Tanggal</strong></td>
					<td><strong>Pengeluaran</strong></td>
					<td width="19.3%"><strong>Total</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php 	
					if($keluar->num_rows() > 0) { 
					
					$metu = 0;$no = 1;
					foreach ($keluar->result_array() as $k) { 
					$met = $k['total'];
				?>
					<tr>
						<td align="center"><?php echo $no++ ?>.</td>
						<td align="center"><?php echo indo_date($k['tanggal'],"half") ?></td>
						<td><?php echo $k['keterangan'] ?></td>
						<td>Rp. <?php echo number_format($met,0,",",".") ?></td>
					</tr>

				<?php $metu += $met; }?>

					<tr class="active">
						<td colspan="3" align="right"><b>Total :</b></td>
						<td><b>Rp. <?php echo number_format($metu,0,",",".");?></b></td>
					</tr>

				<?php }else{ $metu = 0; ?>

					<tr>
						<td colspan="4" align="center">Tidak Ada Data Pengeluaran !</td>
					</tr>

				<?php } ?>	
			</tbody>
		</table>
		
		<?php 
		$laba = $tot - $metu; ?>
		<?php if($metu > $tot){ 
			$ket = 'Rugi';
			$laba = $metu - $tot;
		}else{ 
			$ket = 'Laba';
		} ?>
		<br>

		<?php if($laba != 0) { ?>
			<p><b>Keterangan : <?php echo $ket ?>&nbsp; Rp. <?php echo number_format($laba,0,",",".");?></b></p>
		<?php } ?>
	</div>
