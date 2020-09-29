<div class="page-wrapper">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">List barcode</h4>
			<p class="text-muted mb-0">Find list barcode</p>
		</div>
		<!--end card-header-->
		<div class="card-body bootstrap-select-1">
			<form action="<?php echo $action; ?>" method="GET">
				<input type="hidden" name="route" value="barcode/listGroup">
				<div class="row">
					<div class="col-3">
						<label class="mb-3">Find by genarater date</label>
						<div class="input-group">
							<input type="text" class="form-control datepicker" 
							id="date" 
							name="date" 
							value="<?php echo $date; ?>">
							<div class="input-group-append">
								<span class="input-group-text"><i class="dripicons-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="col-6">
						<label class="mb-3">&nbsp;</label>
						<div class="input-group">
							<button type="submit" class="btn btn-primary">Search</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php if(!empty($date)){ ?>
	<div class="card">
		<div class="card-header">
			<span class="float-left">
				<div>
					<a href="#" id="import_excel" class="btn btn-warning">Import Excel</a>
				</div>
				<hr>
				<div>
					<div>
						<input type="radio" name="rdo" value="rdo" value="" id="rdo1" checked><label for="rdo1">Duratack-PG</label>
						<input type="radio" name="rdo" value="rdo" value="" id="rdo2"><label for="rdo2">Duratack-PG</label>
					</div>
					<a href="<?php echo route('barcode/PPDOrder'); ?>" class="btn btn-info">Export PDF</a>
					<a href="<?php echo route('barcode/export_excel_range_barcode&date='.$date); ?>" class="btn btn-success">Export Excel</a>
				</div>
			</span>
			<span class="float-right">
				<a href="<?php echo route('purchase'); ?>" class="btn btn-danger">Add Barcode</a>
			</span>
		</div>
		<!--end card-header-->
		<div class="card-body">
			<?php if(get('result')=='success'){?>
				<div class="alert alert-success"><b>Success</b></div>
			<?php } ?>
			<div class="table-responsive">
				<table class="table table-bordered" id="makeEditable">
					<thead>
						<tr>
							<th style="width:150px;">Group prefix</th>
							<th style="width:150px;">Start</th>
							<th style="width:150px;">End</th>
							<th>Qty</th>
							<th>Status</th>
							<th>Create date</th>
							<th>Create by</th>
							<th name="buttons" style="width:50px;"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($list_group as $val){ ?>
						<tr>
							<td><?php echo $val['group_code']; ?></td>
							<td><?php echo number_format($val['start'],0); ?></td>
							<td><?php echo number_format($val['end'],0); ?></td>
							<td><?php echo number_format($val['remaining_qty'],0); ?></td>
							<td>
								<?php if($val['barcode_use']==0){?>
									<span class="text-danger">Waiting</span>
								<?php }else{ ?>
									<span class="text-success">Received</span>
								<?php } ?>
							</td>
							<td><?php echo $val['date_added']; ?></td>
							<td><?php echo $val['username']; ?></td>
							<td name="buttons">
								<div class=" pull-right">
									<button type="button" 
									class="btn btn-sm btn-soft-danger btn-circle btn-del" 
									id_group="<?php echo $val['id_group'];?>">
										<i class="dripicons-trash" aria-hidden="true"></i>
									</button>
								</div>
							</td>
						</tr>
						<?php } ?>
						<?php /*<tr>
							<td>105</td>
							<td>10500001</td>
							<td>10512300</td>
							<td>99,999</td>
							<td><span class="text-success">waiting</span></td>
							<td>2020-08-04 12:12:12</td>
							<td>Admin</td>
							<td name="buttons">
								<div class=" pull-right">
									<button id="bElim" type="button" class="btn btn-sm btn-soft-danger btn-circle" onclick="rowElim(this);">
									<i class="dripicons-trash" aria-hidden="true">
									</i>
									</button>
									<button id="bAcep" type="button" class="btn btn-sm btn-soft-purple mr-2 btn-circle" style="display:none;" onclick="rowAcep(this);">
									<i class="dripicons-checkmark">
									</i>
									</button>
									<button id="bCanc" type="button" class="btn btn-sm btn-soft-info btn-circle" style="display:none;" onclick="rowCancel(this);">
									<i class="dripicons-cross" aria-hidden="true">
									</i>
									</button>
								</div>
							</td>
						</tr>*/ ?>
					</tbody>
				</table>
			</div>
			<!--end table-->
		</div>
		<!--end card-body-->
	</div>
	<!--end card-->
	<?php } ?>
</div>
<form 
	action="<?php echo $action_import_excel;?>" 
	method="POST" 
	id="form-import-excel" 
	enctype="multipart/form-data"
	style="display:none;"
>

	<input type="file" name="file_import" id="import_file" 
	accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
	<input type="text" class="form-control" name="date" value="<?php echo $date; ?>">
</form>
<script>
	$(document).on('click','.btn-del',function(e){
		var id_group = $(this).attr('id_group');
		$.ajax({
			url: 'index.php?route=barcode/deleteGroup',
			type: 'POST',
			dataType: 'json',
			data: {
				id_group:id_group
			},
		})
		.done(function(a) {
			location.reload();
			console.log("success");
		})
		.fail(function(a,b,c) {
			console.log(a);
			console.log(b);
			console.log(c);
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	$(document).on('click','#import_excel',function(e){
		$('#import_file').trigger('click');
	});
	$(document).on('change','#import_file',function(e){
		var ele = $(this);
		var date = $('#date').val();

		var file_data = $('#import_file').prop('files')[0];   
	    var form_data = new FormData();                  
	    form_data.append('file_import', file_data);
	    form_data.append('date', date);
		$.ajax({
			url: 'index.php?route=barcode/listGroup',
			cache: false,
	        contentType: false,
	        processData: false,
	        dataType: 'text',
			type: 'POST',
			dataType: 'json',
			data: form_data,
		})
		.done(function(e) { 
			location.reload();
			// window.location = 'index.php?route=barcode/listGroup&date='+date+'&result=success';
			console.log(e);
			console.log("success");
		})
		.fail(function(a,b,c) {
			console.log(a);
			console.log(b);
			console.log(c);
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		// location.reload();
	});
</script>