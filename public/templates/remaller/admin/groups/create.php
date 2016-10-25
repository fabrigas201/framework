{extends 'admin/main.php'}
{block 'content'}
<div class="col-xs-12">
	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<div class="form-group">
				<form action="{get_url('admin/groups/create')}" method="POST">
					<label for="addGroup" class="col-sm-2 control-label">Добавить группу</label>

					<div class="col-sm-10">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" />
							<span class="input-group-btn">
							  <button type="submit" class="btn btn-info btn-flat">Добавить группу</button>
							</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	<!-- /.box-body -->
	</div>
  <!-- /.box -->
</div>
{/block}