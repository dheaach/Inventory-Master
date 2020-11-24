<form action="mutasi/simpan_edit/<?php echo $id_terjual ?>" method="post">
	<input type="hidden" name="cc_pelanggan" value="<?php echo $idmaster ?>">
	<div class="form-group">
		<label class="control-label col-sm-3">
			Barang
		</label>
		<div class="col-sm-9">
			<input type="text" name="cc_barang" class="form-control" readonly value="<?php echo $nama_master ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Harga
		</label>
		<div class="col-sm-9">
				<input type="text" name="cc_harga" class="form-control" value="<?php echo $harga ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Jumlah Item Dipinjam
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="text" name="cc_jml" class="form-control" value="<?php echo $jml ?>">
				<span class="input-group-addon">pcs</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			Keterangan
		</label>
		<div class="col-sm-9">
			<input type="text" name="cc_ket" class="form-control" value="<?php echo $ket ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-3">
			
		</label>
		<div class="col-sm-9">
			<button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
		</div>
	</div>

</form>