<?php $this->load->helper('form'); ?>
<div class="core-container">

<?php 

$headblock = array(
	'header' => $tipo['description'].': Категории',
	'subheader' => 'управление категориями раздела',
	'headicon'	=> 'list-alt fa-2x',
	'linkback'	=> array(
		'text' => 'Отмена',
		'link' => admin_url($_section.'/type/'.$tipo['name']),
	),
	'lgactive'	=> false,
	'linkgroup' => false,
	'btngroup'	=> false,
);
$breadcrumbs = array(
	admin_url() => 'Главная',
	admin_url($_section.'/type/'.$tipo['name']) => ($tipo['tree']? 'Страницы: ' : 'Раздел: ' ).$tipo['description'],
	'last' => $tipo['description'].': Категории',
);

include(PARTSPATH.'layout/headblock.php');

?>

	<div class="units-container control-wrapper">

	<?php if (isset($message)) { ?><div class="message errormsg"><p><?php echo $message; ?></p></div><?php } ?>
	<?php if (isset($message_ok)) { ?><div class="message success"><p><?php echo $message_ok; ?></p></div><?php } ?>

	
      <div class="units-row-end">
          <div class="unit-60">

    <div class="table-container well-container">
          
            <?php if (count($categories)) { ?>
            <table class="width-100 table-striped table-stroked">
      
              <thead>
                <tr>
                  <th class="text-centered td-identifier">ID</th>
                  <th>Название категории</th>
                  <td>&nbsp;</td>
                </tr>
              </thead>
      
              <tbody>
                <?php foreach ($categories as $category) { ?>
                <tr>
                  <td class="text-centered td-identifier"><?php echo $category->id; ?></td>
                  <td><?php echo $category->name; ?></td>
                  <td class="delete width-10 text-right"><a  class="btn btn-red btn-small" href="<?php echo admin_url($_section.'/type_categories_delete/'.$tipo['name'].'/'.$category->id); ?>" onclick="return confirm('Точно удалить? отменить невозможно.');"><i class="fa fa-times"></i></a></td>
                </tr>
                <?php } ?>
              </tbody>
              <tfoot>
              	<tr>
                	<td colspan="3"></td>
                </tr>
              </tfoot>
            </table>
            <?php } else { ?>
            <div class="message-static">
              <header>Нет категорий</header>
              <p>Использование категорий для записей дает возможность более гибко и структурированно выводить содержимое вашего сайта</p>
            </div>
            <?php } ?>
          
          </div>
      </div>
          <div class="unit-40">
            <?php echo form_open(ADMIN_PUB_PATH.$_section.'/type_categories/'.$tipo['name'], array('class'=>'forms'));?>
              <h4 class="forms-section">Добавить новую категорию</h4>
              <label>
                Название категории
              <input type="text" name="category_name" class="width-100" />
              </label>
              <p class="text-right">
                <input type="submit" name="submit" value="добавить" class="btn btn-save" />
              </p>
            </form>
          
          </div>
    </div>
	</div>
  
</div>

