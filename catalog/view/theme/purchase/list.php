<div class="page-wrapper">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">List Purchase</h4>
			<p class="text-muted mb-0">Find list Purchase</p>
		</div>
		<!--end card-header-->
		<div class="card-body bootstrap-select-1">
			<form action="<?php echo $action; ?>" method="GET">
				<input type="hidden" name="route" value="purchase">
				<div class="row">
					<div class="col-2">
						<label class="mb-3">Find Group</label>
						<div class="input-group">
							<select name="start_group" class="form-control">
								<?php foreach ($result_group as $val) { ?>
								<option value="<?php echo $val['group_code']; ?>" <?php echo ($start_group==$val['group_code']?'selected':''); ?>>
									<?php echo $val['group_code']; ?>
								</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-2">
						<label class="mb-3">To Group</label>
						<div class="input-group">
							<select name="end_group" class="form-control" >
								<?php foreach ($result_group as $val) { ?>
								<option value="<?php echo $val['group_code']; ?>" <?php echo ($end_group==$val['group_code']?'selected':''); ?>>
									<?php echo $val['group_code']; ?>
								</option>
								<?php } ?>
							</select>
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
	<?php if(!empty($start_group)){ ?>
	<div class="card">
		<div class="card-header">
			<span class="float-left">
				<!-- <a href="<?php echo route('barcode/add'); ?>" class="btn btn-danger">Add Barcode</a> -->
				<h3>Today : <?php echo date('Y-m-d'); ?></h3>
			</span>
			<span class="float-right">
				<a href="<?php echo route('barcode/PPDOrder&start_group='.$start_group.'&end_group='.$end_group); ?>" class="btn btn-danger">Export PDF</a>
				<a href="<?php echo route('barcode/export_excel_range_barcode&start_group='.$start_group.'&end_group='.$end_group); ?>" class="btn btn-danger mr-2">Export Excel</a>
				<a href="#" class="btn btn-warning" id="import_excel">Import Excel</a>
				
			</span>
		</div>
		<!--end card-header-->
		<div class="card-body">
			<?php if($result){ ?>
				<div class="alert alert-success">
					<b>Update success</b>
				</div>
			<?php } ?>
			<form action="<?php echo $action; ?>" method="POST">
				<input type="hidden" name="start_group" value="<?php echo $start_group; ?>">
				<input type="hidden" name="end_group" value="<?php echo $end_group; ?>">
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-bordered" id="makeEditable">
								<thead>
									<tr>
										<th></th>
										<th>Group</th>
										<th>Start</th>
										<th>End</th>
										<th>Qty</th>
										<th><?php echo $date_first_3_year; ?><br>Start<br>(First NB from oldest order)</th>
										<th><?php echo $date_lasted_order; ?><br>End<br>(Last NB from lastest order)</th>
										<th>Start</th>
										<th>End</th>
										<th>Range</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($getMapping as $key => $val){ ?>
									<tr>
										<td></td>
										<td><?php echo $val['group_code']; ?></td>
										<td><label for="" class="start"><?php echo sprintf('%06d', $val['start']); ?></label></td>
										<td><label for="" class="end"><?php echo sprintf('%06d', $val['end']); ?></label></td>
										<td>
											<input 
												type="text" 
												class="form-control qty_group" 
												placeholder="QTY." 
												end = "<?php echo $val['start'];?>" 
												name = "qty[<?php echo $val['group_code']; ?>]"
											>
										</td>
										<td></td>
										<td></td>
										<td>
											<input type="text" class="form-control default_start" 
											id_group="<?php echo $val['id_group'];?>" value="<?php echo $val['default_start'];?>">
										</td>
										<td>
											<input type="text" class="form-control default_end" 
											id_group="<?php echo $val['id_group'];?>" value="<?php echo $val['default_end'];?>">
										</td>
										<td>
											<input type="text" class="form-control default_range" 
											id_group="<?php echo $val['id_group'];?>" value="<?php echo $val['default_range'];?>">
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 text-right">
						<input type="submit" class="btn btn-primary" value="Save">
					</div>
				</div>
			</form>
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
	$(document).on('keyup','.default_start',function(e){
		var val = $(this).val();
		var id_group = $(this).attr('id_group');
		$.ajax({
			url: 'index.php?route=purchase/updateDefaultGroup',
			type: 'GET',
			dataType: 'json',
			data: {
				value: val,
				id_group: id_group,
				type: 'default_start'
			},
		})
		.done(function() {
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
	$(document).on('keyup','.default_end',function(e){
		var val = $(this).val();
		var id_group = $(this).attr('id_group');
		$.ajax({
			url: 'index.php?route=purchase/updateDefaultGroup',
			type: 'GET',
			dataType: 'json',
			data: {
				value: val,
				id_group: id_group,
				type: 'default_end'
			},
		})
		.done(function() {
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
	$(document).on('keyup','.default_range',function(e){
		var val = $(this).val();
		var id_group = $(this).attr('id_group');
		$.ajax({
			url: 'index.php?route=purchase/updateDefaultGroup',
			type: 'GET',
			dataType: 'json',
			data: {
				value: val,
				id_group: id_group,
				type: 'default_range'
			},
		})
		.done(function() {
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
	//
	$(document).on('keyup','.qty_group',function(e){
		var ele = $(this);
		var qty = parseInt(ele.val());
		var start = ele.attr('start');
		var end = ele.attr('end');

		var ele_end_parent = parseInt(end);

		var sum_end_qty = (ele_end_parent + qty);

		ele_end_parent = pad(  sum_end_qty,6);

		ele.parents('tr').find('.end').text(ele_end_parent);
	});
	function pad(num, size) {
	    var s = num+"";
	    while (s.length < size) s = "0" + s;
	    return s;
	}
</script>
