<?php
if ($objects instanceof Record){
	$objects = array($objects);
}
if (!$objects || !count($objects)){ ?>

<div class="message-well-static">
	в этом разделе нет дочерних для текущей страницы
</div>

<?php return;}

$tipo = $this->content->type($objects[0]->_tipo);
?>
<div class="well-table-container">

<table class="width-100 end">
	<thead>
		<tr>
			<th class="width-70">Заголовок</th>
			<th class="width-20">Тип страниц</th>
			<th class="width-10">Добавлена</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($objects as $relation) {
	$url = admin_url(
			($tipo['tree'] ? 'pages' : 'contents') . '/edit_record/'
			. $tipo['name'] . '/'.$relation->id
		);
?>
<tr class="relation">
	<td>
		
		 <a href="<?php echo $url; ?>"><i class="fa fa-pencil-square fa-fw"></i> <?php echo $relation->get($tipo['edit_link']); ?></a>
	</td>
	<td><?php echo $tipo['description']; ?></td>
	<td><?php echo date(LOCAL_DATE_FORMAT, $relation->get('date_insert')); ?></td>
</tr>
 
 
<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
</table>
</div>
