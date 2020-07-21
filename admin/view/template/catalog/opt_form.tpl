<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-review" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">

          <input type="text" name="page_id" value="<?php echo isset($page_id) ? $page_id : ''; ?>" class="hidden" />
          
          <div class="form-group required" id="type-row">
            <label class="col-sm-2 control-label" for="input-category">Показать товары</label>
            <div class="col-sm-10">

              <select name="type" class="form-control" id="type">
                
                <option value="1" <?php if ($type == 1) echo 'selected="selected"';?> >Товары из категории</option>
                <option value="2" <?php if ($type == 2) echo 'selected="selected"';?> >Товары выбранного производитлея</option>
                <option value="3" <?php if ($type == 3) echo 'selected="selected"';?> >Товары производителя из категории</option>
                
              </select>
            </div>
          </div>
          
          <?php if ($type == 1 OR $type == 3) {?>
          <div class="form-group required" id="category-row">
            <label class="col-sm-2 control-label" for="input-category">Категория</label>
            <div class="col-sm-10">

              <select name="category_id" class="form-control" >
                <option value="">--</option>
                <?php foreach ($categories as $category) { ?>
                <?php if (isset($category_id) && ($category['category_id'] == $category_id)) { ?>
                <option value="<?php echo $category['category_id']; ?>"  selected="selected"><?php echo $category['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <? } ?>

          <?php if ($type == 2 OR $type == 3) {?>
          <div class="form-group required" id="manufacturer-row">
            <label class="col-sm-2 control-label" for="input-category">Производитель</label>
            <div class="col-sm-10">
              <select name="manufacturer_id" class="form-control">
              <option value="">--</option>
              <?php foreach ($manufacturers as $manufacturer) { ?>
              <?php if (isset($manufacturer_id) && ($manufacturer['manufacturer_id'] == $manufacturer_id)) { ?>
              <option value="<?php echo $manufacturer['manufacturer_id']; ?>"  selected="selected"><?php echo $manufacturer['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
              <?php } ?>
              <?php } ?>
              </select>
            </div>
          </div>
          <? } ?>



          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title"><span data-toggle="tooltip" title="Имя вкладки браузера, отображается в поисковой выдаче">Тег title</span></label>
            <div class="col-sm-10">
              <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>" placeholder="Введите тег title" id="input-title" class="form-control" />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-h1"><span data-toggle="tooltip" title="Заголовок страницы, должен быть уникальным для всего сайта">Тег H1</span></label>
            <div class="col-sm-10">
              <input type="text" name="h1" value="<?php echo isset($h1) ? $h1 : ''; ?>" placeholder="Введите заголовок" id="input-h1" class="form-control" />
            </div>
          </div>


          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-keywords"><span data-toggle="tooltip" title="Ключевые слова через запятую, необязательное поле">Мета keywords</span></label>
            <div class="col-sm-10">
              <textarea name="meta_keywords" cols="60" rows="8" placeholder="Ключевое слово, другое ключевое слово, просто слово" id="input-keywords" class="form-control"><?php echo isset($meta_keywords) ? $meta_keywords : ''; ?></textarea>
            </div>
          </div>


          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-meta_description"><span data-toggle="tooltip" title="Выводится на странице">Описание meta</span></label>
            <div class="col-sm-10">
              <textarea name="meta_description" cols="60" rows="8" placeholder="Введите описание" id="input-meta_description" class="form-control"><?php echo isset($meta_description) ? $meta_description : ''; ?></textarea>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-description"><span data-toggle="tooltip" title="Выводится на странице">Описание</span></label>
            <div class="col-sm-10">
              <textarea name="description" cols="60" rows="8" placeholder="Введите описание" id="input-description" class="form-control"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="Замените пробелы на тире. Должно быть уникальным на всю систему.">SEO URL:</span></label>
            <div class="col-sm-10">
              <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="SEO url" id="input-keyword" class="form-control" />
              <?php if ($error_keyword) { ?>
              <div class="text-danger"><?php echo $error_keyword; ?></div>
              <?php } ?>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    
    $('#type').on('change', function() {
      $('#manufacturer-row').remove();
      $('#category-row').remove();

      if(this.value == 1) {
        
        html = '<div class="form-group required" id="category-row"><label class="col-sm-2 control-label" for="input-category">Категория</label><div class="col-sm-10">';
        html += '<select name="category_id" class="form-control" >';
        html += '<option value="">--</option>';
        html += '<?php foreach ($categories as $category) { ?>';
        html += '<?php if (isset($category_id) && ($category['category_id'] == $category_id)) { ?>';
        html += '<option value="<?php echo $category['category_id']; ?>"  selected="selected"><?php echo $category['name']; ?></option>';
        html += '<?php } else { ?>';
        html += '<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>';
        html += '<?php } ?><?php } ?>';
        html += '</select></div></div>';

        $(html).insertAfter('#type-row');
      }

      if(this.value == 2) {
        
        html = '<div class="form-group required" id="manufacturer-row"><label class="col-sm-2 control-label" for="input-category">Производитель</label><div class="col-sm-10">';
        html += '<select name="manufacturer_id" class="form-control">';
        html += '<option value="">--</option>';
        html += '<?php foreach ($manufacturers as $manufacturer) { ?>';
        html += '<?php if (isset($manufacturer_id) && ($manufacturer['manufacturer_id'] == $manufacturer_id)) { ?>';
        html += '<option value="<?php echo $manufacturer['manufacturer_id']; ?>"  selected="selected"><?php echo $manufacturer['name']; ?></option>';
        html += '<?php } else { ?>';
        html += '<option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>';
        html += '<?php } ?><?php } ?>';
        html += '</select></div></div>';

        $(html).insertAfter('#type-row');
      }

      if(this.value == 3) {
        html = '<div class="form-group required" id="category-row"><label class="col-sm-2 control-label" for="input-category">Категория</label><div class="col-sm-10">';
        html += '<select name="category_id" class="form-control" >';
        html += '<option value="">--</option>';
        html += '<?php foreach ($categories as $category) { ?>';
        html += '<?php if (isset($category_id) && ($category['category_id'] == $category_id)) { ?>';
        html += '<option value="<?php echo $category['category_id']; ?>"  selected="selected"><?php echo $category['name']; ?></option>';
        html += '<?php } else { ?>';
        html += '<option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>';
        html += '<?php } ?><?php } ?>';
        html += '</select></div></div>';


        html += '<div class="form-group required" id="manufacturer-row"><label class="col-sm-2 control-label" for="input-category">Производитель</label><div class="col-sm-10">';
        html += '<select name="manufacturer_id" class="form-control">';
        html += '<option value="">--</option>';
        html += '<?php foreach ($manufacturers as $manufacturer) { ?>';
        html += '<?php if (isset($manufacturer_id) && ($manufacturer['manufacturer_id'] == $manufacturer_id)) { ?>';
        html += '<option value="<?php echo $manufacturer['manufacturer_id']; ?>"  selected="selected"><?php echo $manufacturer['name']; ?></option>';
        html += '<?php } else { ?>';
        html += '<option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>';
        html += '<?php } ?><?php } ?>';
        html += '</select></div></div>';

        $(html).insertAfter('#type-row');
      }
    });




      $('#input-description').summernote({height: 200, lang:'ru-RU'});
      //--></script>

  <script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val(item['label']);
		$('input[name=\'product_id\']').val(item['value']);		
	}	
});

// Отключаем атрибут disabled, иначе все сломается :)
$('form').submit(function () { $('[disabled]').removeAttr('disabled'); })
// Добавляем атрибут disabled если мы редактируем существующую запись
$("#disabled").attr("disabled", "disabled");
//--></script></div>
<?php echo $footer; ?>
