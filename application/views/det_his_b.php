<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
    <ul class="menuwis">
      <li><a href="<?php echo base_url('history/barang/'.$idp) ?>" class="active">Gudang</a></li>
      <li><a href="<?php echo base_url('history/pelanggan/'.$idp) ?>">Pelanggan</a></li>
    </ul>
</div>

<div class="row">
	<form method="post" action="<?php echo base_url('history/cari/'.$idp) ?>">
		<div class="input-group no-print" style="float: left;margin-left: 1.4%">
			<select name="nama_barang" class="form-control">
				<option selected>-- Nama Barang --</option>
				<?php foreach ($benda as $a) { ?>
				<option value="<?php echo $a->id ?>"><?php echo $a->nama ?></option>			
				<?php } ?>
			</select>
		</div>
		<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	</form>

	<form method="post" action="<?php echo base_url('history/barang/'.$idp) ?>">
		<button type="submit" class="btn btn-warning no-print" style="float: left;margin-right: 10px;">Kembali</button>
	</form>
</div>		
	    <br>
	    <div class="print-area">
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

	    	<?php if ($id == $ku) { ?>
	    		<?php $no=1; foreach ($stok as $u){ ?>
	    		<table class="table table-bordered">
	    			<thead>
	    				<tr class="active">
							<td style="text-align: center;"><strong>No.</strong></td>
							<td style="text-align: center;"><strong>Nama Item</strong></td>
							<td style="text-align: center;"><strong>Tanggal</strong></td>
							<td style="text-align: center;"><strong>Masuk</strong></td>
							<td style="text-align: center;"><strong>Keluar</strong></td>
							<td style="text-align: center;"><strong>Keterangan</strong></td>
						</tr>
	    			</thead>
	    			<tbody>
	    				<tr>
	    					<td align="center"><?php echo $no; ?></td>
	    					<td align="center"><?php echo $u->nama ?></td>
	    					<td align="center"><?php echo indo_date($u->tgl) ?></td>
	    					<td align="center"><?php echo $u->jml ?></td>
	    					<td align="center"></td>
	    					<td><?php echo $u->ket ?></td>
	    				</tr>
	    				
					<?php
						if(isset($query)){
							$no = 2;
							$mutasi = $u->jml;
							foreach($query as $idmaster=>$isi){
								if(isset($list_cc[$idmaster])){

										$ccname = $list_cc[$idmaster];
									
										foreach($isi as $tgl => $row){
											$tgl = "";
											$masuk = "";
											$pinjam = "";
												if(isset($row['terima'])){
													$masuk = $row['terima'];
													$tgl = $row['tgl'];
													$mutasi += $masuk; 	 	
												}

												if(isset($row['kembali'])){
													$masuk = $row['kembali'];
													$tgl = $row['tgl'];
													$mutasi += $masuk; 	 	
												}

												if(isset($row['pinjam'])){
													$pinjam = $row['pinjam'];
													$tgl = $row['tgl']; 	 
													$mutasi -= $pinjam;	
												}											

											$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";									
										?>

								<tr>
		    						<td align="center"><?php echo $no++ ?></td>
		    						<td align="center"><?php echo $ccname ?></td>
		    						<td align="center"><?php echo indo_date($tgl) ?></td>
		    						<td align="center"><?php echo $masuk ?></td>
		    						<td align="center"><?php echo $pinjam ?></td>
		    						<td><?php echo $ket ?></td>
		    					</tr>
	    					<?php } } } } ?>
	    					<tr class="active">
	    						<td colspan="6"><b>Stok Akhir : <?php echo $mutasi ?></b></td>
	    					</tr>
	    			</tbody>
	    		</table>
	    	<?php }}elseif ($id == $ten || $id == $twel) { ?>
	    		<?php $no=1; foreach ($stok as $u){ ?>
	    		<table class="table table-bordered">
	   				<thead>
	    				<tr class="active"> 
							<td style="text-align: center;"><strong>No.</strong></td>
							<td style="text-align: center;"><strong>Nama Item</strong></td>
							<td style="text-align: center;"><strong>Tanggal</strong></td>
							<td style="text-align: center;"><strong>Masuk</strong></td>
							<td style="text-align: center;"><strong>Keluar</strong></td>
							<td style="text-align: center;"><strong>Keterangan</strong></td>
						</tr>
						<tr>
	    					<td align="center"><?php echo $no; ?></td>
	    					<td align="center"><?php echo $u->nama ?></td>
	    					<td align="center"><?php echo indo_date($u->tgl) ?></td>
	    					<td align="center"><?php echo $u->jml ?></td>
	    					<td align="center"></td>
	    					<td><?php echo $u->ket ?></td>
	    				</tr>
	    			</thead>
	    			<tbody>	
					<?php
						if(isset($query)){
							$no = 2;
							$mutasi = $u->jml;
							foreach($query as $idmaster=>$isi){
								if(isset($list_cc[$idmaster])){

										$ccname = $list_cc[$idmaster];
									
										foreach($isi as $tgl => $row){
											$tgl = "";
											$masuk = "";
											$keluar = "";
												if(isset($row['keluar'])){
													$keluar = $row['keluar'];
													$tgl = $row['tgl'];
													$mutasi -= $keluar; 	 	
												}

												if(isset($row['terima'])){
													$masuk = $row['terima'];
													$tgl = $row['tgl'];
													$mutasi += $masuk; 	 	
												}
										
											$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";						
					?>

								<tr>
		    						<td align="center"><?php echo $no++ ?></td>
		    						<td align="center"><?php echo $ccname ?></td>
		    						<td align="center"><?php echo indo_date($tgl) ?></td>
		    						<td align="center"><?php echo $masuk ?></td>
		    						<td align="center"><?php echo $keluar ?></td>
		    						<td><?php echo $ket ?></td>
		    					</tr>
		    					
	    					<?php } } } } ?>
	    					<tr class="active">
		    					<td colspan="6"><b>Stok Akhir : <?php echo $mutasi ?></b></td>		    					
		    				</tr>
	    			</tbody>
	    		</table>
	    	<?php } }else{ ?>
	    		<table class="table table-bordered">
	    			<thead>
	    				<tr class="active">
							<td style="text-align: center;" width="5%"><strong>No.</strong></td>
							<td style="text-align: center;"><strong>Nama Item</strong></td>
							<td style="text-align: center;"><strong>Stok</strong></td>
						</tr>
	    			</thead>
	    			<tbody>
	    				<?php $no=1; foreach ($query as $key) { ?>
	    					<tr align="center">
	    						<td><?php echo $no++ ?></td>
	    						<td><?php echo $key->nama ?></td>
	    						<td><?php echo $key->stok ?></td>
	    					</tr>
	    				<?php } ?>
	    			</tbody>
	    		</table>
	    	<?php } ?>