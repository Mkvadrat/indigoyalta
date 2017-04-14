<?php
$this->load->helper('text');

?>
<div class="core-container">

	<?php
	
	$adduserbtn = array(
		'link' => admin_url('requests/edit/'),
		'icon' => 'plus-circle',
		'text' => 'добавить запрос',
	);

	
	$headblock = array(
		'header' => 'Запросы в СП',
		'subheader' => 'общение с клиентами',
		'headicon' => 'envelope-o fa-2x color-grapefruit',
		'linkback'	=> false,
		'btngroup'	=> false,
		'lgactive'	=> false,
		'linkgroup' => array(
			'1' => $adduserbtn,
		),
	);
	
	$breadcrumbs = array(
		admin_url() => 'Главная',
		'last' => 'Запросы в СП',
	);
	
	include(PARTSPATH.'layout/headblock.php'); ?>

	<div class="units-container control-wrapper">

	<?php echo $this->view->get_messages(); ?>


		<div class="table-container well-container">
		<table class="width-100 table-multihead">

			<thead>
				<tr>
					<th class="text-centered td-identifier" data-sorter="false">ID</th>
					<th>Тип / Раздел</th>
					<th>Клиент</th>
					<th>Контакты</th>
					<th>Дата обращения</th>
					<th>Менеджер</th>
					<th>Статус</th>
				</tr>
			</thead>
      <tfoot>
      	<tr>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        	<td></td>
        </tr>
      </tfoot>

			<tbody>
      
	<?php foreach ($requests as $request) { ?>
  <?php
		$statuses = array(
			'n' => '<span class="label label-orange">Новый',
			'c' => '<span class="label label-green">Закрытый',
			'p' => '<span class="label label-blue">Назначен исполнитель',
		);
		$answers = array(
			'0' => 'Ожидание ответа</span>',
			'1' => 'Ответ выслан</span>',
		);
		$dealtypes = array(
			'b' => 'Покупка',
			's' => 'Продажа',
			'e' => 'Обмен',
			'r' => 'Съем',
			'o' => 'Аренда',
			'n' => 'не указан',
		);
		$sections = array(
			'qso' => 'Срочный выкуп',
			'fdb' => 'Обратная связь',
			'aeo' => 'Объявления',
			'olz' => 'Онлайн-заявка',
		);
  	$requesttype = $request->type;
  	$requestsection = $request->section;
		$requeststatus = $request->status;
		$requestanswer = $request->has_answer;
	?>
		<tr>

			<td class="text-centered td-identifier"><code><?php echo $request->id_request; ?></code></td>
			<td><span class="label"><?php echo $dealtypes[$requesttype]; ?></span> / <span class="label"><?php echo $sections[$requestsection]; ?></span></td>
			<td><a class="color-blue" href="<?php echo admin_url('requests/editrequest/'.$request->id_request) ?>"><i class="fa fa-pencil-square"></i> <?php echo $request->author; ?></a> <?php echo($request->city ? '<em class="color-gray">('.$request->city.')</em>': ''); ?></td>
      
			<td><div class="request-contacts"><i class="fa fa-envelope-o"></i> <kbd><?php echo($request->email ? $request->email: 'email не указан'); ?></kbd></div> <div><i class="fa fa-mobile"></i> <kbd><?php echo $request->phone; ?></kbd></div></td>
			<td><i class="fa fa-clock-o"></i> <small><?php echo date(LOCAL_DATE_FORMAT . ' H:i', $request->date_insert); ?></small></td>
			<td><?php echo($request->manager ? '<i class="fa fa-user"></i> '.$request->manager : '<a class="color-blue" href="'.admin_url('requests/editrequest/'.$request->id_request).'"><i class="fa fa-pencil-square"></i> назначить исполнителя</a>' ); ?> </td>
			<td><?php echo $statuses[$requeststatus]; ?> / <?php echo $answers[$requestanswer]; ?></td>

		</tr>
	<?php } ?>

			</tbody>
		</table>
		</div>
    


	</div>
	</div>
