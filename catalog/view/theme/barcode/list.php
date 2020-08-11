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
						<input type="text" class="form-control" name="dates">
						<div class="input-group-append">
							<span class="input-group-text"><i class="dripicons-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-3">
					<label class="mb-3">Factory</label> 
					<select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;">
						<option>Select All Factory</option>
						<optgroup label="Bangkok">
						<option value="">Phra Pradaeng</option>
						<option value=""></option>
					</optgroup>
					</select>
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
				<button type="button" class="btn btn-success">Export Excel</button>
				<button type="button" class="btn btn-warning">Import Excel</button>
			</span>
			<span class="float-right">
				<a href="<?php echo route('barcode/add'); ?>" class="btn btn-danger">Add Barcode</a>
			</span>
		</div>
		<!--end card-header-->
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="makeEditable">
					<thead>
						<tr>
							<th style="width:150px;">Barcode Start</th>
							<th style="width:150px;">Barcode End</th>
							<th>Factory</th>
							<th>Create date</th>
							<th>Create by</th>
							<th name="buttons" style="width:50px;"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>PRA000000</td>
							<td>PRA100000</td>
							<td>Phra Pradaeng</td>
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