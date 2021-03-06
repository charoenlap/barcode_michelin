<div class="page-wrapper">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Setting</h4>
			<p class="text-muted mb-0">Setting</p>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<p class="text-muted mb-0">ตั้งค่าล่วงหน้า</p>
		</div>
		<div class="card-body bootstrap-select-1">
			<form action="" id="formresult">
				<div class="row mb-3">
					<div class="col-12">
						<label class="mb-2">ตั้งค่าให้ข้ามได้กี่ดวง ถึงจะแจ้งเตือน</label>
						<div class="">
							<input type="text" class="form-control" name="" value="0">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Size</th>
									<th>Prefix</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($listPrefixBarcode as $val) { ?>
								<tr>
									<td><input type="text" class="form-control" name="barcode_size" value="<?php echo $val['size_product_code']; ?>"></td>
									<td><input type="text" class="form-control" name="barcode_end" value="<?php echo $val['group_code']; ?>"></td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" class="text-left">
										<a href="#" class="btn btn-primary">Add</a>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				
				<div class="row mt-4">
					<div class="col-12">
						<div class="float-left">
							<a href="<?php echo route('barcode'); ?>" class="btn btn-default">back</a>
						</div>
						<div class="float-right">
							<input type="submit" value="Save" class="btn btn-primary">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
