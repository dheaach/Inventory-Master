<form onsubmit="cc_edit_master(); return false;">
	<div class="form-group">
		<label for="" class="control-label col-sm-3">
			Nama Barang
		</label>
		<div class="col-sm-9">
			<input type="text" name="cc_nama" class="form-control" value="<?=$row['nama']?>">
		</div>
	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-3">
			Harga
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<span class="input-group-addon">Rp.</span>
				<input type="number" name="cc_harga" class="form-control" value="<?=$row['harga']?>">
			</div>
			<i style="color:red;">*harus diisi dengan angka</i>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-3">
			Stok
		</label>
		<div class="col-sm-9">
			<div class="input-group">
				<input type="number" name="cc_stok" class="form-control" value="<?=$row['stok']?>" readonly>
				<span class="input-group-addon">pcs</span>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label for="" class="control-label col-sm-3">
			
		</label>
		<div class="col-sm-9">
			<button class="btn btn-primary"><span class="fa fa-save"></span> Update</button>
		</div>
	</div>
</form>

<script>
/*
$("form input").on("keypress",function(e){
	if(e.which == 13){
		cc_master();
	}
});

$(".btn-primary").on("click",function(){
	cc_master();
});
*/

function cc_edit_master(){
    $.ajax({
        dataType : "json",
        url : "ajax/edit_master/<?=$row['id']?>",
        type : "POST",
        data : {
            cc_nama : $("[name=cc_nama]").val(),
           
            cc_harga : $("[name=cc_harga]").val(),
            cc_stok : $("[name=cc_stok]").val(),
        }
    }).done(function (data){
        if(data['error'] > 0){
        	//gagal
        	alertify.alert("Error",data['message']);
        }
        else{
        	//sukses
        	alertify.alert("Success","Berhasil mengupdate data barang");
        }
    }
	);
}
</script>