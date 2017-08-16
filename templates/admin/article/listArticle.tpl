
{PAGINATION}
<div id="adminList" class="box-shadow">
	<table class="big_table" frame="box" rules="all">
		<thead>
			<tr>
				<th style="text-align: center; width: 20px;"><span>ID</span></th>
				<th><span>CONTENT</span></th>
				<th><span>DATE</span></th>
				<th width="300px"><span>Action</span></th>
			</tr>
		</thead>
		<tbody>
		<!-- BEGIN list_article -->
			<tr>
				<td style="text-align: center;">{ID}</td>
				<td><a href ="{SITE_URL}/admin/article/show/id/{ID}">{CONTENT}</a></td>
				<td>{DATE}</td>
				<td>
					<table class="action_table">
						<tr>
							<td width="20%"><a href="{SITE_URL}/admin/article/edit/id/{ID}" title="Edit/Update" class="edit_state">Edit</a></td>
							<td width="25%"><a href="{SITE_URL}/admin/article/delete/id/{ID}/" title="Delete" class="delete_state">Delete</a></td>
							</tr>
					</table>
				</td>
			</tr>
		<!-- END list_article -->
		</tbody>
	</table>
</div>

