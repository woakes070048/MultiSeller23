<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <link href="catalog/view/theme/default/stylesheet/alkod_stylesheet.css" rel="stylesheet">
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>


    <div class="card-seller-info hovercard well">
        <div class="card-seller-info-background">
            <img class="card-seller-info-bkimg" alt="" src="<?php echo $seller_banner; ?>">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
            <img alt="" src="<?php echo $seller_image; ?>">
        </div>
        <div class="card-seller-info-info"> <span class="card-seller-info-title"><?php echo $seller_name; ?></span>
       <div>    <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($seller_rating < $i) { ?>
          <div class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></div>
          <?php } else { ?>
          <div class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></div>
          <?php } ?>
          <?php } ?>
</div>
        </div>
    </div>
    <div class="stats cf">
			<div class="stat">
				<strong><?php echo $seller_products_total; ?></strong>
				<?php echo $text_products_number; ?>
			</div>
			<div class="stat">
				<strong><?php echo $seller_date_added; ?></strong>
				<?php echo $text_seller_years; ?>
			</div>
      <div class="stat">
        <div class="status-upload">
                  	<ul>

                      <li><a title="" href="<?php echo $sellertwitter; ?>" target="_blank" data-placement="bottom" data-original-title="Audio"><i class="fa fa-twitter"></i></a></li>


                  </ul>
                  </div>

			</div>
      <div class="stat">
        <div class="status-upload">
                  	<ul>

                      <li><a title="" href="<?php echo $sellergoogleplus; ?>" target="_blank" data-placement="bottom" data-original-title="Audio"><i class="fa fa-google-plus"></i></a></li>


                  </ul>
                  </div>

			</div>
      <div class="stat">
        <div class="status-upload">
                  	<ul>

                      <li><a title="" href="<?php echo $sellerfacebook; ?>" target="_blank" data-placement="bottom" data-original-title="Audio"><i class="fa fa-facebook"></i></a></li>


                  </ul>
                  </div>

			</div>
      <div class="stat">
        <div class="status-upload">
                  	<ul>

                      <li><a title="" href="<?php echo $sellerinstagram; ?>" target="_blank" data-placement="bottom" data-original-title="Audio"><i class="fa fa-instagram"></i></a></li>


                  </ul>
                  </div>

			</div>

		</div>
    <div class="well">
      <?php echo $seller_description; ?>
       </div>

      <?php if ($products) { ?>
      <p><a href="<?php echo $compare; ?>" id="compare-total"> <?php echo $text_compare; ?></a></p>
      <div class="row">
        <div class="col-sm-3">
          <div class="btn-group hidden-xs">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-sm-1 col-sm-offset-2 text-right">
          <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
        </div>
        <div class="col-sm-3 text-right">
          <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-1 text-right">
          <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
        </div>
        <div class="col-sm-2 text-right">
          <select id="input-limit" class="form-control" onchange="location = this.value;">
            <?php foreach ($limits as $limits) { ?>
            <?php if ($limits['value'] == $limit) { ?>
            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
      </div>
      <br />
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
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
              <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <ul class="nav nav-tabs">

      <li class="active"><a href="#tab-sellerreview" data-toggle="tab"><?php echo $tab_sellerreview; ?></a></li>

    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab-sellerreview">
        <form class="form-horizontal" id="form-sellerreview">
          <div id="sellerreview"></div>
          <?php if ($sellerreviewstatus){ ?>
         <h2><?php echo $text_write; ?></h2>
           <?php if ($sellerreviewguest){ ?>
         <div class="form-group required">
           <div class="col-sm-12">
             <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
             <input type="text" name="name" value="" id="input-name" class="form-control" />
           </div>
         </div>
         <div class="form-group required">
           <div class="col-sm-12">
             <label class="control-label" for="input-sellerreview"><?php echo $entry_sellerreview; ?></label>
             <textarea name="text" rows="5" id="input-sellerreview" class="form-control"></textarea>
             <div class="help-block"><?php echo $text_note; ?></div>
           </div>
         </div>
         <div class="form-group required">
           <div class="col-sm-12">
             <label class="control-label"><?php echo $entry_rating; ?></label>
             &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
             <input type="radio" name="rating" value="1" />
             &nbsp;
             <input type="radio" name="rating" value="2" />
             &nbsp;
             <input type="radio" name="rating" value="3" />
             &nbsp;
             <input type="radio" name="rating" value="4" />
             &nbsp;
             <input type="radio" name="rating" value="5" />
             &nbsp;<?php echo $entry_good; ?></div>
         </div>
   <?php echo $captcha; ?>
         <div class="buttons clearfix">
           <div class="pull-right">
             <button type="button" id="button-sellerreview" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
           </div>
         </div>
            <?php } else { ?>
         <?php echo $text_seller_login; ?>
         <?php } ?>
<?php }?>
        </form>
            </div>
          </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?>

    </div>
</div>
<script type="text/javascript"><!--
$('#sellerreview').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#sellerreview').fadeOut('slow');

    $('#sellerreview').load(this.href);

    $('#sellerreview').fadeIn('slow');
});

$('#sellerreview').load('index.php?route=seller/seller/sellerreview&seller_id=<?php echo $seller_id; ?>');

$('#button-sellerreview').on('click', function() {
	$.ajax({
		url: 'index.php?route=seller/seller/write&seller_id=<?php echo $seller_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-sellerreview").serialize(),
		beforeSend: function() {
			$('#button-sellerreview').button('loading');
		},
		complete: function() {
			$('#button-sellerreview').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#sellerreview').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#sellerreview').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//--></script>
<?php echo $footer; ?>
