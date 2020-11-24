<form action="mutasi/kirimproses/<?=$wor?>" method="post">
	<div class="form-group">
		<label class="control-label col-sm-3">
			Tanggal
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
				<?php foreach($nganu as $ungan) { ?>
					<input type="text" name="" class="form-control" readonly value="<?php echo $ungan['total_pinjam'] ?>">
				<?php } ?>
				<span class="input-group-addon">pcs</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Jumlah Item Dikembalikan
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
			<input type="text" name="cc_ket" class="form-control" value="Pinjaman Kembali" readonly>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			
		</label>
		<div class="col-sm-9">
			<button class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
		</div>
	</div>

</form>