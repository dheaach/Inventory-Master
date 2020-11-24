<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
    <ul class="menuwis">
      <li><a href="<?php echo base_url('laporan/barang') ?>" class="active">Gudang</a></li>
      <li><a href="<?php echo base_url('laporan/langganan') ?>">Pelanggan</a></li>
    </ul>
</div>

<div class="row">
	<form method="post" action="<?php echo base_url('laporan/cari') ?>">
		<div class="input-group no-print" style="float: left;margin-left: 1.4%">
			<select name="nama_barang" class="form-control">
				<option selected>-- Nama Barang --</option>
				<?php foreach ($benda as $a) { ?>
				<option value="<?php echo $a->id ?>"><?php echo $a->nama ?></option>			
				<?php } ?>
			</select>
		</div>
		
		<!--<div class="input-group no-print" style="float: left;margin-left: 1.4%">
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
		</div>-->
		<button class="btn btn-info no-print" type="submit" name="lihat" style="text-align: center;float: left;margin-right: 10px;"><span class="fa fa-eye"></span> Lihat</button>
				

		<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	</form>

	<form method="post" action="<?php echo base_url('laporan/barang1') ?>">
		<input type="hidden" name="bulan" value="<?php echo $bulin ?>">
		<input type="hidden" name="tahun" value="<?php echo $tahun ?>">
		<button type="submit" class="btn btn-warning no-print" style="float: left;margin-right: 10px;">Kembali</button>
	</form>
</div>		
	    <br>
	    <div class="print-area">
	    <?php 
			if($bulin == date('m')) {	
				if($bulin = date('m')) {
					$bln = array(01=>'Januari',02=>'Februari',03=>'Maret',04=>'April',05=>'Mei',06=>'Juni',07=>'Juli','08'=>"Agustus",'09'=>"September",'10'=>"Oktober",'11'=>"November",'12'=>"Desember");
				}
			}else{
				$bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			}
		?>

	    <p> Bulan : <?php echo $bln[$bulin] ?> <?php echo $tahun ?></p>
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
	    	<?php if ($id == $ku) { ?>
	    		<?php $no=1; foreach ($stok as $u){ ?>
	    			
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
	    					
	    	<?php }}else{ ?>
	    		<?php $no=1; foreach ($stok as $u){ ?>
	    		
	    		
	    		
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
	    					
	    	<?php }} ?>
	    			<?php foreach($akhiran as $a): ?>
	    					<tr class="active">
	    						<td colspan="6"><b>Stok Akhir : <?php echo $a->stok; ?></b></td>
	    					</tr>
	    			<?php endforeach; ?>
	    			</tbody>
	    		</table>