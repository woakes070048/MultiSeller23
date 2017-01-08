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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $invoice; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></a> <a href="<?php echo $shipping; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></a> <a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> <?php echo $text_order_detail; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td style="width: 1%;"><button data-toggle="tooltip" title="<?php echo $text_store; ?>" class="btn btn-info btn-xs"><i class="fa fa-shopping-cart fa-fw"></i></button></td>
                <td><a href="<?php echo $store_url; ?>" target="_blank"><?php echo $store_name; ?></a></td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_date_added; ?>" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button></td>
                <td><?php echo $date_added; ?></td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_payment_method; ?>" class="btn btn-info btn-xs"><i class="fa fa-credit-card fa-fw"></i></button></td>
                <td><?php echo $payment_method; ?></td>
              </tr>
              <?php if ($shipping_method) { ?>
              <tr>
                <td><button data-toggle="tooltip" title="<?php echo $text_shipping_method; ?>" class="btn btn-info btn-xs"><i class="fa fa-truck fa-fw"></i></button></td>
                <td><?php echo $shipping_method; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_customer_detail; ?></h3>
          </div>
          <table class="table">
            <tr>
              <td style="width: 1%;"><button data-toggle="tooltip" title="<?php echo $text_customer; ?>" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button></td>
              <td><?php if ($seller) { ?>
                <a href="<?php echo $seller; ?>" target="_blank"><?php echo $firstname; ?> <?php echo $lastname; ?></a>
                <?php } else { ?>
                <?php echo $firstname; ?> <?php echo $lastname; ?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_seller_group; ?>" class="btn btn-info btn-xs"><i class="fa fa-group fa-fw"></i></button></td>
              <td><?php echo $seller_group; ?></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_email; ?>" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button></td>
              <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="<?php echo $text_telephone; ?>" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button></td>
              <td><?php echo $telephone; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cog"></i> <?php echo $text_option; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td><?php echo $text_invoice; ?></td>
                <td id="invoice" class="text-right"><?php echo $invoice_no; ?></td>
                <td style="width: 1%;" class="text-center"><?php if (!$invoice_no) { ?>
                  <button id="button-invoice" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_generate; ?>" class="btn btn-success btn-xs"><i class="fa fa-cog"></i></button>
                  <?php } else { ?>
                  <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
                  <?php } ?></td>
              </tr>
          </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> <?php echo $text_order; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width: 50%;" class="text-left"><?php echo $text_payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td style="width: 50%;" class="text-left"><?php echo $text_shipping_address; ?>
                <?php } ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?php echo $payment_address; ?></td>
              <?php if ($shipping_method) { ?>
              <td class="text-left"><?php echo $shipping_address; ?></td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
              <td class="text-right"><?php echo $column_status; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr id='table-<?php echo $product['product_id']; ?>'>
              <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                <?php if ($option['type'] != 'file') { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } else { ?>
                &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
                <?php } ?>
                <?php } ?></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right"><?php echo $product['price']; ?></td>
              <td class="text-right"><?php echo $product['total']; ?></td>
              <td class="text-right">
                <?php if($config_sellerorderstatus){ ?>

<div class="pull-left">
                <select name="order_product_status_id" id="input-product-order-status-<?php echo $product['product_id']; ?>" onchange="productorderchangestatus(<?php echo $product['product_id']; ?>,this.value); $('#button-productorderchangestatus-<?php echo $product['product_id']; ?>').show();" class="form-control">
                  <?php foreach ($order_statuses as $order_product_statuses) { ?>
                  <?php if ($order_product_statuses['order_status_id'] == $product['order_product_status']) { ?>
                  <option value="<?php echo $order_product_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_product_statuses['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_product_statuses['order_status_id']; ?>"><?php echo $order_product_statuses['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <input type="hidden" name="" value="" id="order_product_status_id-<?php echo $product['product_id']; ?>"></input>

</div>

</td>


<?php } ?>

            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
            </tr>
            <?php } ?>
            <?php if(isset($totals)) { ?>
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td colspan="4" class="text-right"><?php echo $total['title']; ?></td>
            <td class="text-right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
          <?php } ?>

             <tr>
                  <td colspan="4" class="text-right"><?php echo $column_total; ?>:</td>
                  <td class="text-right"><?php echo $seller_total; ?></td>
                </tr>
          </tbody>
        </table>
        <?php if ($comment) { ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td><?php echo $text_comment; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $comment; ?></td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comment-o"></i> <?php echo $text_sellerhistory; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-sellerhistory" data-toggle="tab"><?php echo $tab_sellerhistory; ?></a></li>

          <?php foreach ($tabs as $tab) { ?>
          <li><a href="#tab-<?php echo $tab['code']; ?>" data-toggle="tab"><?php echo $tab['title']; ?></a></li>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-sellerhistory">
            <div id="sellerhistory"></div>
            <br />
            <fieldset>
              <legend><?php echo $text_sellerhistory_add; ?></legend>
              <form class="form-horizontal">
              <?php if($config_sellerordernotifyhistory){ ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-notify"><?php echo $entry_notify; ?></label>
                  <div class="col-sm-10">
                    <input type="checkbox" name="notify" value="1" id="input-notify" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
                  <div class="col-sm-10">
                    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                  </div>
                </div>
                  <?php } ?>
              </form>
            </fieldset>
            <div class="text-right">
              <?php if(!$config_sellerordernotifyhistory && !$config_sellerorderstatus){ ?>

<?php }else{ ?>
            <button id="button-sellerhistory" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_sellerhistory_add; ?></button>
	<?php } ?>
                         <?php
if ($config_sellerordersettlement) {
                  if (isset($seller_order_info['settlement'])) {  ?>
				  <button id="button-cancelsellersettlementhistory" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-plus-circle"></i> <?php echo $button_sellersettlementhistory_cancel; ?></button>
            		  <button style="display: none;" id="button-sellersettlementhistory" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?php echo $button_sellersettlementhistory_add; ?></button>

              <?php }else{ ?>
		  <button id="button-sellersettlementhistory" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?php echo $button_sellersettlementhistory_add; ?></button>
				  <button style="display: none;" id="button-cancelsellersettlementhistory" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-plus-circle"></i> <?php echo $button_sellersettlementhistory_cancel; ?></button>

				<?php } ?>
        <?php } ?>
            </div>
          </div>
          <div class="tab-pane" id="tab-additional">
            <?php if ($account_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_account_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($account_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?php echo $custom_field['name']; ?></td>
                  <td><?php echo $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <?php if ($payment_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_payment_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($payment_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?php echo $custom_field['name']; ?></td>
                  <td><?php echo $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <?php if ($shipping_method && $shipping_custom_fields) { ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_shipping_custom_field; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($shipping_custom_fields as $custom_field) { ?>
                <tr>
                  <td><?php echo $custom_field['name']; ?></td>
                  <td><?php echo $custom_field['value']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <td colspan="2"><?php echo $text_browser; ?></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $text_ip; ?></td>
                  <td><?php echo $ip; ?></td>
                </tr>
                <?php if ($forwarded_ip) { ?>
                <tr>
                  <td><?php echo $text_forwarded_ip; ?></td>
                  <td><?php echo $forwarded_ip; ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td><?php echo $text_user_agent; ?></td>
                  <td><?php echo $user_agent; ?></td>
                </tr>
                <tr>
                  <td><?php echo $text_accept_language; ?></td>
                  <td><?php echo $accept_language; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php foreach ($tabs as $tab) { ?>
          <div class="tab-pane" id="tab-<?php echo $tab['code']; ?>"><?php echo $tab['content']; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
  <script type="text/javascript"><!--
$(document).delegate('#button-invoice', 'click', function() {
	$.ajax({
		url: 'index.php?route=order/order/createinvoiceno&order_id=<?php echo $order_id; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-invoice').button('loading');
		},
		complete: function() {
			$('#button-invoice').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['invoice_no']) {
				$('#invoice').html(json['invoice_no']);

				$('#button-invoice').replaceWith('<button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-cog"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=order/order/addreward&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-add').button('loading');
		},
		complete: function() {
			$('#button-reward-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-add').replaceWith('<button id="button-reward-remove" data-toggle="tooltip" title="<?php echo $button_reward_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-reward-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=order/order/removereward&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-reward-remove').button('loading');
		},
		complete: function() {
			$('#button-reward-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-reward-remove').replaceWith('<button id="button-reward-add" data-toggle="tooltip" title="<?php echo $button_reward_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=order/order/addcommission&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-add').button('loading');
		},
		complete: function() {
			$('#button-commission-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-add').replaceWith('<button id="button-commission-remove" data-toggle="tooltip" title="<?php echo $button_commission_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$(document).delegate('#button-commission-remove', 'click', function() {
	$.ajax({
		url: 'index.php?route=order/order/removecommission&order_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$('#button-commission-remove').button('loading');
		},
		complete: function() {
			$('#button-commission-remove').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#button-commission-remove').replaceWith('<button id="button-commission-add" data-toggle="tooltip" title="<?php echo $button_commission_add; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var token = '';

$('#sellerhistory').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#sellerhistory').load(this.href);
});

$('#sellerhistory').load('index.php?route=order/order/sellerhistory&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>');

$('#button-sellerhistory').on('click', function() {
  if(typeof verifyStatusChange == 'function'){
    if(verifyStatusChange() == false){
      return false;
    }else{
      addOrderInfo();
    }
  }else{
    addOrderInfo();
  }

	$.ajax({
		url: 'index.php?route=order/order/selleraddhistory&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-sellerhistory').button('loading');
		},
		complete: function() {
			$('#button-sellerhistory').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#sellerhistory').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {

				$('#sellerhistory').load('index.php?route=order/order/sellerhistory&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>');

				$('#sellerhistory').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');

				$('#order-status').html($('select[name=\'order_status_id\'] option:selected').text());
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#button-sellersettlementhistory').on('click', function() {
  if(typeof verifyStatusChange == 'function'){
    if(verifyStatusChange() == false){
      return false;
    }else{
      addOrderInfo();
    }
  }else{
    addOrderInfo();
  }

	$.ajax({
		url: 'index.php?route=order/order/sellerordersettlement&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&settlement=true' + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-sellersettlementhistory').button('loading');
		},
		complete: function() {
			$('#button-sellersettlementhistory').button('reset');
			$('#button-sellersettlementhistory').hide();
			$('#button-cancelsellersettlementhistory').show();
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#sellersettlementhistory').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {

				$('#sellerhistory').load('index.php?route=order/order/sellerhistory&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>');

				$('#sellersettlementhistory').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');

				$('#order-status').html($('select[name=\'order_status_id\'] option:selected').text());
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#button-cancelsellersettlementhistory').on('click', function() {
  if(typeof verifyStatusChange == 'function'){
    if(verifyStatusChange() == false){
      return false;
    }else{
      addOrderInfo();
    }
  }else{
    addOrderInfo();
  }

	$.ajax({
		url: 'index.php?route=order/order/sellerordersettlement&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&cancelsettlement=true' + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('#button-cancelsellersettlementhistory').button('loading');
		},
		complete: function() {
			$('#button-cancelsellersettlementhistory').button('reset');
			$('#button-cancelsellersettlementhistory').hide();
			$('#button-sellersettlementhistory').show();
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#cancelsellersettlementhistory').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {

$('#sellerhistory').load('index.php?route=order/order/sellerhistory&order_id=<?php echo $order_id; ?>&seller_id=<?php echo $seller_id; ?>');

				$('#cancelsellersettlementhistory').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('textarea[name=\'comment\']').val('');

				$('#order-status').html($('select[name=\'order_status_id\'] option:selected').text());
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

function changeStatus(){
	var status_id = $('select[name="order_status_id"]').val();

	$('#openbay-info').remove();

	$.ajax({
		url: 'index.php?route=extension/openbay/getorderinfo&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		dataType: 'html',
		success: function(html) {
			$('#sellerhistory').after(html);
		}
	});
}

function addOrderInfo(){
	var status_id = $('select[name="order_status_id"]').val();

	$.ajax({
		url: 'index.php?route=extension/openbay/addorderinfo&order_id=<?php echo $order_id; ?>&status_id=' + status_id,
		type: 'post',
		dataType: 'html',
		data: $(".openbay-data").serialize()
	});
}

$(document).ready(function() {
	changeStatus();
});

$('select[name="order_status_id"]').change(function(){
	changeStatus();
});

function productorderchangestatus(product_id,status_id) {



$.ajax({
  url: 'index.php?route=order/order/sellerproductorderchangestatus&order_id=<?php echo $order_id; ?>',
  type: 'post',
  dataType: 'json',
  data: 'product_id=' + encodeURIComponent(product_id) + '&status_id='+ encodeURIComponent(status_id) ,
  beforeSend: function() {

    $('#input-product-order-status-'+product_id).after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
  },
  complete: function() {

    $('#input-product-order-status-'+product_id).after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    $('.fa-spin').remove();

  },
  success: function(json) {
    $('.alert').remove();

    if (json['error']) {

    }

    if (json['success']) {





    }
  },
  error: function(xhr, ajaxOptions, thrownError) {
    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
  }
});
}

//--></script>
</div></div>
<?php echo $footer; ?>
