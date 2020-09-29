<div class="page-wrapper">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Add group</h4>
			<p class="text-muted mb-0">Add group</p>
		</div>
		<div class="card-body bootstrap-select-1">
			<form action="" id="formresult">
				<div class="row">
					<div class="col-3">
						<label class="mb-2">Group name</label>
						<div class="">
							<input type="text" class="form-control" name="group_name" value="">
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-12">
						<div class="float-left">
							<a href="<?php echo route('user/group'); ?>" class="btn btn-default">back</a>
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
