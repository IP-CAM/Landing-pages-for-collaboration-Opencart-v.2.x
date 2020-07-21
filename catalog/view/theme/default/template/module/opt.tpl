<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row">
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <!-- content -->
      <h1><?php echo $h1; ?></h1>
      <?php echo $description; ?>
      <?php echo $content_bottom; ?>
      <!-- content -->


      <!-- button -->
      <div class="col-md text-center">
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#fastErderModal">Оставить заявку</button> 
      </div>
      <!-- button end -->
      

      
      
      <?php if (isset($optlinks)) { ?>
      <!--  -->
      <div class="row">
        <?php foreach ($optlinks as $type => $value) { ?>
          <?php if ($type == 1) $h2 = 'По категория';
          if ($type == 2) $h2 = 'По брендам';
          if ($type == 3) $h2 = 'По категории в бренде'; ?>
          <div class="col-sm-4">
          <h2><?php echo $h2; ?></h2>
          <ul id="<?php echo $type; ?>">
            <?php foreach($value as $optlink) { ?>
            <li><a href="<?php echo $optlink['href']; ?>"><?php echo $optlink['title']; ?></a></li>
            <?php } ?>
          </ul>
          </div>
        <?php } ?>
      </div>
      <!--  -->
      <?php } ?>
      
      <?php if ($products) { ?>
      <!--  -->
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                <p><?php echo $product['description']; ?></p>
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
                <?php if ($product['price']) { ?>
                <p class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>
                </p>
                <?php } ?>
              </div>
              <div class="button-group">
                <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <!--  -->
      <?php } ?>

    </div>
  </div>
</div>
<!-- Modal -->
        <div class="modal fade" id="fastErderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $h1; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
               <div class="fast-alert"></div>
                <form action="" id="optsend">
                  <input type="hidden" name="url" value="<?php echo $thisurl; ?>">
                  <input type="hidden" name="title" value="<?php echo $h1; ?>">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Ваше имя</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="name" placeholder="Ваше имя" required="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone" id="phone" placeholder="+7 (999) 123-45-67" required="">
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary btn-block" id="button-send">Отправить</button>
                </form>
              </div>
              <div class="modal-footer">
                
              </div>
            </div>
          </div>
        </div>
        <!-- Modal end -->

        
        <script type="text/javascript"><!--
        $('#button-send').on('click', function() {
          $.ajax({
            url: 'index.php?route=module/optpage/send',
            type: 'post',
            data: $('#optsend input[type=\'text\'], #optsend input[type=\'hidden\']'),
            dataType: 'json',
            beforeSend: function() {
              $('#button-fastorder').button('loading');
            },
            complete: function() {
              $('#button-fastorder').button('reset');
            },
            success: function(json) {
              $('.alert, .text-danger').remove();
              $('.form-group').removeClass('has-error');
              
              if (json['success']) {
               $('.fast-alert').before('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
              }

              if (json['error']['name']) {
                $('.fast-alert').after('<div class="alert alert-danger">' + json['error']['name'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
              }

              if (json['error']['phone']) {
                $('.fast-alert').after('<div class="alert alert-danger">' + json['error']['phone'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
               
              }


            },
            
            error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }

          });
        });
        </script>
<?php echo $footer; ?>