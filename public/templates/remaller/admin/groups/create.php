{extends 'admin/main.php'}
{block 'content'}
<div class="col-xs-12">
	<div class="box">
		<!-- /.box-header -->
		<form class="form-horizontal" action="{get_url('admin/groups/create')}" method="POST">
			<div class="box-body">
				<div class="form-group">
					<label for="addGroup" class="col-sm-2 control-label">Название группы</label>
					<div class="col-sm-10">
						<input name="groupName" type="text" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label for="addGroup" class="col-sm-2 control-label">Alias Группы</label>
					<div class="col-sm-10">
						<input name="groupAlias" type="text" class="form-control" />
						<small class="help-block">Необязательно вводить. Если поле пусто то генерируется автоматически. Например: Пользователи -> polzovateli</small>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn pull-right btn-info btn-flat">Добавить группу</button>
			</div>
		</form>
	<!-- /.box-body -->
	</div>
  <!-- /.box -->
</div>
{/block}