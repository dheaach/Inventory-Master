	<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
	    <ul class="menuwis">
	      <li><a href="<?php echo base_url('laporan/barang') ?>">Gudang</a></li>
	      <li><a href="<?php echo base_url('laporan/pelanggan') ?>" class="active">Pelanggan</a></li>
	    </ul>
	</div>



<div class="print-area">

	<div class="row">
		<div class="col-md-12">
			<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	    </div>
	</div>

		<br>
			<?php 
				if($bulin == date('m')) {	
					if($bulin = date('m')) {
						$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
					}
				}
			?>
<div class="row">
	<div class="col-sm-9" style="margin-right: 1.3%">
		<p style="line-height: 35px;"> Bulan :  <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>
	</div>
		<form method="post" action="<?php echo base_url('laporan/cari_pelanggan') ?>">
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

	<table class="data table table-bordered table-responsive">
		<thead>
			<tr align="center" class="active">
				<td><b>No.</b></td>
				<td><b>Nama Pelanggan</b></td>
				<td><b>Nama Inventory</b></td>
				<td><b>Pinjam</b></td>
				<td><b>Kembali</b></td>
				<td><b>Sisa Pinjam</b></td>
				<td class="no-print"><b>Detail</b></td>
			</tr>
		</thead>		
		<tbody>
		<?php
		if($query == TRUE){
			$n = 1;
			$tot = 0;
			foreach($query as $iddivisi=>$isi){
				if(isset($listdiv[$iddivisi])){

					$divisi = $listdiv[$iddivisi];
					$id_pelanggan = $listdah[$iddivisi];

					foreach($isi as $idmaster => $isis){
						$ccname = $list_cc[$idmaster];
						$id_master = $list_dd[$idmaster];
						$mutasi = 0;
						$masuk = $keluar = 0;

						foreach($isis as $tgl => $row){

						$kirim = "";
							if(isset($row['kirim'])){
								$kirim = $row['kirim'];
								$mutasi += $kirim;
							}

						$jual = "";
							if(isset($row['jual'])){
								$jual = $row['jual'];
								$mutasi -= $jual;
							}

							$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";
							$masuk += intval($kirim);
							$keluar += intval($jual);
							
						}
						?>

							<tr>
								<?php								  
									if($masuk == 0 && $keluar == 0){
										$masuk = " ";
										$keluar = " ";
									}
									if($mutasi == 0) {
										$mutasi = "0"; 
									}
								?>
								<td  align=center><?php echo $n ?>.</td>
								<td><?php echo $divisi ?></td>
								<td><?php echo $ccname ?></td>
								<td align="center"><?php echo $masuk ?></td>
								<td align="center"><?php echo $keluar ?></td>
								<td align="center"><strong><?php echo $mutasi ?></strong></td>
								<td align="center" class="no-print">
									<form method="post" action="<?php echo base_url('laporan/detail'); ?>">
										<input type="hidden" name="idpelanggan" value="<?php echo $id_pelanggan ?>">
										<input type="hidden" name="pelanggan" value="<?php echo $divisi ?>">
										<input type="hidden" name="idmaster" value="<?php echo $id_master ?>">
										<input type="hidden" name="moon" value="<?php echo $bulin ?>">
				    					<input type="hidden" name="taun" value="<?php echo $tahun ?>">
										<button class="btn btn-sm btn-primary" type="submit">Detail</button>
									</form>
								</td>
							</tr>
		<?php
							$n++;
							$tot += $mutasi;
					}
				} 
			}
		}else{ ?>
				<tr>
					<td colspan="6" align="center">Data Tidak Ada!</td>
				</tr>
		<?php } ?>
		</tbody>
	</table>

	<?php if($tot > 0){?>
	<p><b>Total Sisa Peminjaman : <?php echo $tot ?></b></p>
	<?php }else{?>
	<p><b>Total Sisa Peminjaman : <?php echo "0"; ?></b></p>
	<?php } ?>
</div>
