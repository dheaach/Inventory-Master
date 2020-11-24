	<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
	    <ul class="menuwis">
	      <li><a href="<?php echo base_url('history/barang/'.$id) ?>">Gudang</a></li>
	      <li><a href="<?php echo base_url('history/pelanggan/'.$id) ?>" class="active">Pelanggan</a></li>
	    </ul>
	</div>



<div class="print-area">

		<div class="row">

			<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
		</div>

		<br>

<div class="row">
	<div class="col-sm-9" style="margin-right: 1.3%">
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
		<p style="line-height: 35px;"> Bulan :  <?php echo $bln ?> <?php echo $h['hun'] ?></p>
		<?php } ?>
	</div>
		<form method="post" action="<?php echo base_url('history/cari_pelanggan/'.$id) ?>">
				<div class="input-group no-print" style="float:left">
					<input type="text" class="form-control" name="golek" placeholder="Cari Pelanggan">
					<?php foreach ($dat as $h) { ?>
	    				<input type="hidden" name="bln" value="<?php echo $h['bul'] ?>">
	    				<input type="hidden" name="thn" value="<?php echo $h['hun'] ?>">
	    				<?php } ?>
				</div>
				<div class="input-group no-print">
					<button class="btn btn-info no-print form-control" type="submit" name="lihat" style="text-align: center;border-top-right-radius: 5px;border-bottom-right-radius: 5px"> Cari</button>
				</div>
		</form>
</div>

	<table class="data table">
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
										$mutasi = "-"; 
									}
								?>
								<td  align=center><?php echo $n ?>.</td>
								<td><?php echo $divisi ?></td>
								<td><?php echo $ccname ?></td>
								<td align="center"><?php echo $masuk ?></td>
								<td align="center"><?php echo $keluar ?></td>
								<td align="center"><strong><?php echo $mutasi ?></strong></td>
								<td align="center" class="no-print">
									<form method="post" action="<?php echo base_url('history/detail/'.$id); ?>">
										<input type="hidden" name="idpelanggan" value="<?php echo $id_pelanggan ?>">
										<input type="hidden" name="pelanggan" value="<?php echo $divisi ?>">
										<input type="hidden" name="idmaster" value="<?php echo $id_master ?>">
										<?php foreach ($dat as $h) { ?>
	    								<input type="hidden" name="bln" value="<?php echo $h['bul'] ?>">
	    								<input type="hidden" name="thn" value="<?php echo $h['hun'] ?>">
	    								<?php } ?>
										<button class="btn btn-sm btn-primary" type="submit">Detail</button>
									</form>
								</td>
							</tr>
						
						<?php
							$n++;
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
</div>
