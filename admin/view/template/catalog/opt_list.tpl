<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-review').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <!--  -->
        <div class="well">
          <div class="row">
            <div class="col-sm-12">
            <div class="form-group">
              <label class="control-label" for="input-status">Тип страницы</label>
              <select name="filter_type" id="input-status" class="form-control">
                <option value="*">Все типы</option>
                <option value="1" <?php if ($filter_type == 1) echo 'selected="selected"';?> >Товары из категории</option> 
                <option value="2" <?php if ($filter_type == 2) echo 'selected="selected"';?> >Товары производителя X</option> 
                <option value="3" <?php if ($filter_type == 3) echo 'selected="selected"';?> >Товары производителя X из категории Y</option> 
              </select>
            </div>

            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        
        <!--  -->
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-review">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left">Категория</td>
                  <td class="text-left">Title</td>
                  <td class="text-right">H1</td>
                  <td class="text-left">Meta</td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($items)) { ?>
                <?php foreach ($items as $item) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($item['page_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $item['page_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $item['page_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $item['cname']; ?></td>
                  <td class="text-left"><?php echo $item['title']; ?></td>
                  <td class="text-right"><?php echo $item['h1']; ?></td>
                  <td class="text-left"><?php echo $item['meta_description']; ?></td>
                  <td class="text-right">
                    <a href="/index.php?route=module/reviews&path=<?php echo $item['category_id']; ?>" data-toggle="tooltip" title="Просмотр" class="btn btn-primary"><i class="fa fa-eye"></i></a> <a href="<?php echo $item['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $item['delete']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=catalog/opt&token=<?php echo $token; ?>';


  var filter_type = $('select[name=\'filter_type\']').val();

  if (filter_type != '*') {
    url += '&filter_type=' + encodeURIComponent(filter_type);
  }

  location = url;
});
//--></script>

  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>