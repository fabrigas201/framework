{extends 'admin/main.php'}
{block 'content'}
<div class="col-xs-12">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Список пользователей</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<table id="list-users" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Имя</th>
						<th>Статус</th>
					  <th>Группа</th>
					  <th>Действия</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Trident</td>
						<td>Internet
						Explorer 4.0
						</td>
						<td>Win 95+</td>
						<td> 4</td>
						<td>X</td>
					</tr>
					<tr>
						<td>Trident</td>
						<td>Internet
						Explorer 5.0
						</td>
						<td>Win 95+</td>
						<td>5</td>
						<td>C</td>
					</tr>
					<tr>
						<td>Trident</td>
						<td>Internet
						Explorer 5.5
						</td>
						<td>Win 95+</td>
						<td>5.5</td>
						<td>A</td>
					</tr>
					<tr>
						<td>Trident</td>
						<td>Internet
						Explorer 6
						</td>
						<td>Win 98+</td>
						<td>6</td>
						<td>A</td>
					</tr>
				</tbody>
			<tfoot>
			<tr>
				<td colspan="4"></td>
				<td class="text-right"><a title="Добавить пользователя" class="btn btn-success" href="{get_url('admin/users/add')}"><i class="fa fa-plus"></i></a></td>
			</tr>
			</tfoot>
		  </table>
		</div>
	<!-- /.box-body -->
	</div>
  <!-- /.box -->
</div>
{/block}