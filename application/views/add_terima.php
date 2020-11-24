<form action="mutasi/addproses/<?=$wor?>" method="post">
	<div class="form-group">
		<label class="control-label col-sm-3">
			Tanggal Peminjaman
		</label>
		<div class="col-sm-9">
			<input type="date" class="form-control" name="cc_tgl" value="<?=$tgl?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Barang
		</label>
		<div class="col-sm-9">
			<!--<select name="cc_divisi" class="form-control">
			<?php 
			$list = $this->mdmutasi->list_divisi();
			foreach($list as $iddiv=>$nmdiv){
				$sel = "";
				if(isset($def)){
					if($def == $iddiv){
						$sel = "selected";
					}
				}
				echo "
				<option $sel value='$iddiv'>$nmdiv</option>
				";
			}
			?> 
			<option value="Galon Baku">Galon Baku</option>
			</select>-->
			<?php 
				$list = $this->mdmutasi->galon();
				foreach($list as $iddiv=>$nmdiv){
			?>
				<input type="text" name="cc_barang" class="form-control" readonly value="<?php echo $nmdiv ?>">
				<input type="hidden" name="cc_idbarang" class="form-control" readonly value="<?php echo $iddiv ?>">
			<?php } ?>
			
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Jumlah Item Dipinjam
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" name="cc_jml" class="form-control">
				<span class="input-group-addon">pcs</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Keterangan
		</label>
		<div class="col-sm-9">
			<?php if($row == 1){ ?>
				<select name="cc_ket" class="form-control">
					<option value="Pinjaman Tambahan">Pinjaman Tambahan</option>
					<option value="Pinjaman Sementara">Pinjaman Sementara</option>
				</select>
			<?php }else{ ?>
				<input type="text" name="cc_ket" class="form-control" readonly value="Pinjaman Awal">
			<?php } ?>	
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			
		</label>
		<div class="col-sm-9">
			<button class="btn btn-primary" type="submit"><span class="fa fa-save"></span> Simpan</button>
		</div>
	</div>

</form>