<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
    <ul class="menuwis">
      <li><a href="<?php echo base_url('laporan2/liporan') ?>" class="active">Harian</a></li>
      <li><a href="<?php echo base_url('laporan2/lap_bulan') ?>">Bulanan</a></li>
    </ul>
</div>
		<div class="row">
			<form name="f2" method="post" action="<?php echo base_url('laporan2/search'); ?>" align="left">
				<div class="col-sm-1">
					<div class="input-group no-print">
					    <input type="date" class="form-control" name="tanggal" style="display: inline-table" value="<?php echo $tinggil ?>">
					</div>
				</div>
				<div class="col-sm-2" align="right">
					<button class="btn btn-info no-print" type="submit" name="lihat" style="text-align: center;"><span class="fa fa-eye"></span> Lihat</button>
				</div>
			</form>
				<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
				
	    </div>
	    <br>
	    <div class="print-area">
	<div class="table-responsive">
	    <div class="row">
			<div class="col-sm-9" style="margin-right: 1.2%">
				<p style="line-height: 35px;"><p>Tanggal : <?php echo indo_date($tinggil,"half"); ?></p>
			</div>
			
			<form method="post" action="<?php echo base_url('laporan2/search') ?>">
					<div class="input-group no-print" style="float:left">
						<input type="text" class="form-control" name="golek" placeholder="Cari Pelanggan">
					</div>
					<div class="input-group no-print">
						<input type="hidden" name="tgl" value="<?php echo $tinggil ?>">
						<button class="btn btn-info no-print form-control" type="submit" name="lihat" style="text-align: center;border-top-right-radius: 5px;border-bottom-right-radius: 5px"> Cari</button>
					</div>
			</form>
		</div>	
		<table class="table table-bordered" width="1000%">
			<thead style="text-align: center;">
				<tr class="active">
					<td rowspan="2" width="5%"><strong>No.</strong></td>
					<td rowspan="2"><strong>Nama <br> Pelanggan</strong></td>
					<?php $baris = $query->num_rows() ?>
					<td colspan="<?php echo $baris ?>"><strong>Jumlah</strong></td>
					<td colspan="<?php echo $baris ?>"><strong>Sub Total</strong></td>

					<td rowspan="2" width="15%"><strong>Total</strong></td>
				</tr>
				<tr class="active">
					<?php foreach ($query->result() as $u) { ?>
						<td width=""><?php echo $u->nama ?></td>
					<?php } ?>
					<?php foreach ($query->result() as $u) { ?>
						<td width=""><?php echo $u->nama ?></td>
					<?php } ?>
				</tr>
				</strong>
			</thead>
			<tbody>
		<?php if($quer->num_rows() > 0){ 
			$tot = 0;
			$jum1 = 0;
			$jum2 = 0;
			$sub1 = 0;
			$sub2 = 0;
		?>
		<?php 
			$no = 1;foreach ($quer->result() as $y) { 
			$sql = $this->db->query("SELECT * FROM cc_pelanggan WHERE id_p = '$y->id_p' ")->result();
				foreach ($sql as $i) {
		?>
				
			<tr>
				<td align="center"><?php echo $no++ ?>.</td>
				<td><?php echo $i->nama_p ?></td>

					<?php 
						foreach ($query->result() as $ku) {
						$dolarku = 0;
							$sepuluh = $this->db->query("SELECT jml FROM cc_terjual WHERE id_master = '$ku->id' AND id_pelanggan = '$y->id_p' AND tgl = '$tinggil'");
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
							$sedoso = $this->db->query("SELECT total FROM cc_terjual WHERE id_master = '$ku->id' AND id_pelanggan = '$i->id_p' AND tgl = '$tinggil'");
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
			</tr>

				<?php
				 	$tot += $total; $jum1 += $dolarku;; $sub1 += $rupeku; } } 
					$halah = $baris * 2 + 2;
				?>

			<tr class="active">
				<td colspan="<?php echo $halah ?>" align="right"><b>Total :</b></td>
				<td><b>Rp. <?php echo number_format($tot,0,",",".");?></b></td>
			</tr>

		<?php }else{ $tot = 0;$ahay = $baris * 2 + 3;?>

			<tr>
				<td colspan="<?php echo $ahay ?>" align="center">Tidak Ada Data!</td>
			</tr>

		<?php } ?>

			</tbody>
		</table>
 	</div>
		<br>
	<!--</form>-->
		<h4><strong>Data Pengeluaran</strong></h4>	
		<table class="table table-bordered"> 
			<thead>
				<tr align="center" class="active">
					<td width="5%"><strong>No.</strong></td>
					<td><strong>Pengeluaran</strong></td>
					<td width="19.5%"><strong>Total</strong></td>
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
						<td><?php echo $k['keterangan'] ?></td>
						<td>Rp. <?php echo number_format($met,0,",",".") ?></td>
					</tr>
					
				<?php } $metu += $met; ?>

					<tr class="active">
						<td colspan="2" align="right"><b>Total :</b></td>
						<td><b>Rp. <?php echo number_format($metu,0,",",".");?></b></td>
					</tr>

				<?php }else{ $metu = 0; ?>

					<tr>
						<td colspan="3" align="center">Tidak Ada Data Pengeluaran !</td>
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
			<p><b>Keterangan : <?php echo $ket ?>&nbsp;&nbsp; Rp. <?php echo number_format($laba,0,",",".");?></b></p>
		<?php } ?>
	</div>
</form>
</div>

