<table class="data table">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Pelanggan</th>
			<th>Total Pinjaman</th>
			<td align="right">
				<a href="<?php echo base_url('master/pelanggan') ?>" class="btn btn-sm btn-primary" style="line-height: 22px;"><i class="fa fa-plus"></i> Tambah Pelanggan</a>
			</td>
			<td style="padding-left: 1.4%" width="25%">
				<form method="post" action="<?php echo base_url('mutasi/rekap_pelanggan') ?>" class="ml-2">
					<div class="input-group no-print" style="float:left">
						<input type="text" class="form-control" name="golek" placeholder="Cari Pelanggan">
					</div>
					<div class="input-group no-print">
						<input type="hidden" name="tgl">
						<button class="btn btn-info no-print form-control" type="submit" name="lihat" style="text-align: center;border-top-right-radius: 5px;border-bottom-right-radius: 5px"> Cari</button>
					</div>
				</form>
			</td>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	foreach($list as $row){
	?>
		<tr>
			<td><?=$no?>.</td>
			<td><a href="javascript:;" data-fancybox data-src="mutasi/view/<?=$row['id_p']?>"><?=$row['nama_p']?></a></td>
			<td><?php echo $row['total_pinjam'] ?> pcs</td>
			<td class="text-right" colspan="2">
				<a href="javascript:;" data-fancybox data-src="mutasi/view/<?=$row['id_p']?>" class="btn btn-sm btn-primary"><span class="fa fa-eye"></span> Detail</a>
				<a data-fancybox data-src="mutasi/add/<?=$row['id_p']?>" class="btn btn-sm btn-info"><span class="fa fa-download"></span> Tambah Pinjaman</a> 
				<a data-fancybox href="javascript:;" data-src="mutasi/kirim/<?=$row['id_p']?>" class="btn btn-sm btn-warning"><span class="fa fa-paper-plane"></span> Kembalikan Pinjaman</a>
				<?php 
					$cek2 = query("SELECT total_pinjam FROM cc_pelanggan WHERE id_p = ".$row['id_p']."")->row_array();
					$nganu = $cek2['total_pinjam'];

				?>
				<?php if($nganu == 0){ ?>
					<button class="btn btn-sm btn-success" disabled><span class="fa fa-truck"></span> Pengambilan</button>
				<?php }else{ ?>
					<a data-fancybox href="javascript:;" data-src="mutasi/ambil/<?=$row['id_p']?>" class="btn btn-sm btn-success"><span class="fa fa-truck"></span> Pengambilan</a>
				<?php } ?>
			</td>
		</tr>
	<?php
		$no++;
	}
	?>
	</tbody>
</table>