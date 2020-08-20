<div class="page-wrapper">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">List barcode</h4>
			<p class="text-muted mb-0">Find list barcode</p>
		</div>
		<!--end card-header-->
		<div class="card-body bootstrap-select-1">
			<div class="row">
				<div class="col-3">
					<label class="mb-3">Find by genarater date</label>
					<div class="input-group">
						<select name="" id="" class="form-control select2">
							<option value=""><?php echo date('d/m/Y'); ?></option>
							<?php for ($i=1;$i<=10;$i+=2) { ?>
							<option value=""><?php echo date('d/m/Y', strtotime('-'.$i.' day')); ?></option>
							<?php } ?>
						</select>
						<!-- <input type="text" class="form-control" name="dates"> -->
						<!-- <div class="input-group-append">
							<span class="input-group-text"><i class="dripicons-calendar"></i></span>
						</div> -->
					</div>
				</div>
				<div class="col-6">
					<label class="mb-3">&nbsp;</label>
					<div class="input-group">
						<!-- <button type="submit" class="btn btn-primary">Search</button> -->
						<button type="button" class="btn btn-warning">Import Excel (Qty wk) </button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			
			<span class="float-left">
				<h4 class="card-title">Result</h4>
				<p class="text-muted mb-0">Wk 178 - 223</p>
			</span>
			<span class="float-right">
				<a href="#" class="btn btn-danger">Export Excel</a>
			</span>
		</div>
		<!--end card-header-->
		<div class="card-body">
			<div class="row">
				<div class="col-6">
					<div class="table-responsive">
						<table class="table table-bordered" id="makeEditable">
							<thead>
								<tr>
									<th>Size</th>
									<th>Sum prod.</th>
									<th>Last wk mapping</th>
									<th>Remaining Qty</th>
								</tr>
							</thead>
							<tbody>
								<?php $j=178; $temp = array(); $x=0; ?>
								<?php for ($i=155; $i<=200; $i++) { ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php $temp[$x] = rand(900, 30000); echo number_format(end($temp),0); ?></td>
									<td><input type="text" class="form-control" value='<?php echo $j++;?>' style="height:19px;"></td>
									<td>
										<?php 
										$new[$x] = rand(900, 30000); 
										echo ($new[$x]<=$temp[$x]) ? '<span class="text-danger">'.number_format($new[$x],0).'</span>' : number_format($new[$x],0); 
										?>
									</td>
								</tr>
								<?php $x++; } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-6">
					<div class="table-responsive">
						<table class="table table-bordered" id="makeEditable">
							<thead>
								<tr>
									<th style="width:150px;">Propose Wk0</th>
									<th style="width:150px;">Remaining Qty</th>
									<th style="width:150px;">Validated Wk0</th>
								</tr>
							</thead>
							<tbody>
								<?php $j=178; $x=0; ?>
								<?php for ($i=155; $i<=200; $i++) { ?>
								<tr>
									<td>
										<?php echo $j++; ?>
									</td>
									<td><?php echo number_format($new[$x],0); ?></td>
									<td><input type="text" class="form-control" value='' style="height:19px;"></td>
								</tr>
								<?php $x++; } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--end card-body-->
	</div>
	<!--end card-->
</div>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>