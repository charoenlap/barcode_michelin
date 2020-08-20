<div class="page-wrapper">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">List Purchase</h4>
			<p class="text-muted mb-0">Find list Purchase</p>
		</div>
		<!--end card-header-->
		<div class="card-body bootstrap-select-1">
			<div class="row">
				<div class="col-2">
					<label class="mb-3">Find Group</label>
					<div class="input-group">
						<select name="" id="" class="form-control">
							<?php for ($i=105;$i<=120;$i++) { ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-2">
					<label class="mb-3">To Group</label>
					<div class="input-group">
						<select name="" id="" class="form-control">
							<?php for ($i=105;$i<=120;$i++) { ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
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
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<span class="float-left">
				<!-- <a href="<?php echo route('barcode/add'); ?>" class="btn btn-danger">Add Barcode</a> -->
				<h3>Today : 8-Feb-22</h3>
			</span>
			<span class="float-right">
				<a href="#" class="btn btn-danger">Export PDF</a>
				<a href="#" class="btn btn-danger mr-2">Export Excel</a>
				<a href="#" class="btn btn-success">Import Excel</a>
			</span>
		</div>
		<!--end card-header-->
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="makeEditable">
					<thead>
						<tr>
							<th></th>
							<th>Group</th>
							<th>Start</th>
							<th>End</th>
							<th>Qty</th>
							<th>21-AUG-20<br>Start<br>(First NB from oldest order)</th>
							<th>25-Jan-22<br>End<br>(Last NB from lastest order)</th>
							<th>Start</th>
							<th>End</th>
							<th>Range</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td>105</td>
							<td>10512003</td>
							<td>10548002</td>
							<td><input type="text" class="form-control" placeholder="QTY."></td>
							<td>10500001</td>
							<td>10512002</td>
							<td>10500001</td>
							<td>10599999</td>
							<td>99999</td>
						</tr>
						<tr>
							<td>New</td>
							<td>105</td>
							<td>10512003</td>
							<td>10548002</td>
							<td><input type="text" class="form-control" placeholder="QTY."></td>
							<td>10500001</td>
							<td>10512002</td>
							<td>10500001</td>
							<td>10599999</td>
							<td>99999</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item">
							<a class="page-link" href="#" aria-label="Previous">
								<span aria-hidden="true">«</span> <span class="sr-only">Previous</span>
							</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">1</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">2</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">3</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#" aria-label="Next">
								<span aria-hidden="true">»</span> <span class="sr-only">Next</span>
							</a>
						</li>
					</ul>
					<!--end pagination-->
				</nav>
			</div>
			<!--end table-->
		</div>
		<!--end card-body-->
	</div>
	<!--end card-->
</div>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>