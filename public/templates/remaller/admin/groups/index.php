{extends 'admin/main.php'}
{block 'content'}
<div class="col-xs-12">
	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Группа</th>
						<th class="text-right">Действия</th>
					</tr>
				</thead>
				<tbody>
				{if count($ugroups)}
					{foreach $ugroups as $id => $group}
					<tr>
						<td>{$id}</td>
						<td>{$group['name']}</td>
						<td class="text-right">
							<div class="pull-right box-tools">
								<a href="{get_url('admin/permissions/edit/'~$id)}" class="btn btn-info btn-sm" title="Редактировать {$group['name']}">
									<i class="fa fa-edit"></i>
								</a>
								<a href="{get_url('admin/groups/delete/'~$id)}" class="btn btn-info btn-sm" title="Удалить {$group['name']}">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</td>
					</tr>
					{/foreach}
				{/if}
				</tbody>
			</table>
		</div>
	<!-- /.box-body -->
	</div>
  <!-- /.box -->
</div>
{/block}