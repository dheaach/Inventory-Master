<div class="wisata mt-4 no-print" style="margin-bottom: 3%">
    <ul class="menuwis">
      <li><a href="<?php echo base_url('history/barang/'.$idp) ?>" class="active">Gudang</a></li>
	      <li><a href="<?php echo base_url('history/pelanggan/'.$idp) ?>">Pelanggan</a></li>
    </ul>
</div>
	<form method="post" action="<?php echo base_url('history/cari/'.$idp) ?>">
<div class="row">
	<div class="input-group no-print" style="float: left;margin-left: 1.4%">
		<select name="nama_barang" class="form-control">
			<option selected>-- Nama Barang --</option>
			<?php foreach ($benda as $a) { ?>
			<option value="<?php echo $a->id ?>"><?php echo $a->nama ?></option>			
			<?php } ?>
		</select>
		<?php foreach ($dat as $h) { ?>
	    <input type="hidden" name="bln" value="<?php echo $h['bul'] ?>">
	    <input type="hidden" name="thn" value="<?php echo $h['hun'] ?>">
	    <?php } ?>
	</div>
			<button class="btn btn-info no-print" type="submit" name="lihat" style="text-align: center;float: left;margin-right: 10px;"><span class="fa fa-eye"></span> Lihat</button>

			<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print'style="margin-right: 5px;float: left" align="center"><span class='fa fa-print fa-fw'></span> Print</a>
	    	</form>
	    </div>
	    <br>
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
	    <table class="table table-bordered">	
	    	<thead>	
	    		<thead>
	    			<tr class="active">
						<td style="text-align: center;" width="5%"><strong>No.</strong></td>
						<td style="text-align: center;"><strong>Nama Item</strong></td>
						<td style="text-align: center;"><strong>Stok Awal</strong></td>
						<td style="text-align: center;"><strong>Detail</strong></td>
					</tr>
	    	</thead>
	    	<tbody>	
	    		<?php $no=1; foreach ($benda as $key) { ?>
	    			<tr>
	    				<td style="text-align: center;"><?php echo $no++ ?></td>
	    				<td><?php echo $key->nama ?></td>
	    				<td style="text-align: center;"><?php echo $key->jml ?></td>
	    				<form method="POST" action="<?php echo base_url('history/cari/'.$idp) ?>">
	    				<input type="hidden" name="nama_barang" value="<?php echo $key->id ?>">
	    				<?php foreach ($dat as $h) { ?>
	    				<input type="hidden" name="bln" value="<?php echo $h['bul'] ?>">
	    				<input type="hidden" name="thn" value="<?php echo $h['hun'] ?>">
	    				<?php } ?>
	    				<td style="text-align: center;" width="10%"><button type="submit" class="btn btn-sm btn-primary">Detail</button></td>
	    				</form>
	    			</tr>
	    		<?php } ?>
	    	</tbody>
	    </table>	
</div>