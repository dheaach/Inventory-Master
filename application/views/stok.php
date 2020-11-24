<table class="data table">
	<thead>
		<tr>
			<th>#</th>
			<th>Nama Barang</th>
			<th>Jumlah</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	foreach($list as $row){
	?>
		<tr>
			<td><?=$no?></td>
			<td><a href="javascript:;" data-fancybox data-src="mutasi/see/<?=$row['id']?>"><?=$row['nama']?></a></td>
			<td><?=$row['stok']?> pcs</td>
			<td>
				<a href="javascript:;" data-fancybox data-src="mutasi/see/<?=$row['id']?>" class="btn btn-sm btn-primary"><span class="fa fa-eye"></span> Detail</a>
				<?php
					$prev = $this->session->userdata('prev');
					if($prev == 1){
				?>
				<a data-fancybox data-src="mutasi/plus/<?=$row['id']?>" class="btn btn-sm btn-info"><span class="fa fa-plus"></span> Tambah Stok</a> 
				<?php
					}else{
				?>
				<a class="btn btn-sm btn-info" disabled><span class="fa fa-plus"></span> Tambah Stok</a> 
				<?php
					}
				?>
			</td>
		</tr>
	<?php
		$no++;
	}
	?>
	</tbody>
</table>