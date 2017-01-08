<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-seller-group" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-seller-group" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="seller_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($seller_group_description[$language['language_id']]) ? $seller_group_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <textarea name="seller_group_description[<?php echo $language['language_id']; ?>][description]" rows="5" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($seller_group_description[$language['language_id']]) ? $seller_group_description[$language['language_id']]['description'] : ''; ?></textarea>
              </div>
            </div>
          </div>
          <?php } ?>
                        <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                  <div id="seller-group-category" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($seller_group_categories as $seller_group_category) { ?>
                    <div id="seller-group-category<?php echo $seller_group_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $seller_group_category['name']; ?>
                      <input type="hidden" name="seller_group_category[]" value="<?php echo $seller_group_category['category_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <table class="table table-bordered">
  <thead>

  </thead>
  <tbody>

		         <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_commission; ?></label>
            <div class="col-sm-10">
              <input type="text" name="commission" value="<?php echo $commission; ?>" placeholder="" size="3" id="input-sort-order" /> +
              <input type="text" name="fee" value="<?php echo $fee; ?>" placeholder="" size="3" id="input-sort-order" /> %
            </div>

          </div>


  </tbody>
</table>
     <div class="form-group">
            <label class="col-sm-2 control-label" for="input-product-limit"><?php echo $entry_product_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="product_limit" value="<?php echo $product_limit; ?>" placeholder="<?php echo $entry_product_limit; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-subscription-duration"><?php echo $entry_subscription_duration; ?></label>
            <div class="col-sm-10">
              <input type="text" name="subscription_duration" value="<?php echo $subscription_duration; ?>" placeholder="<?php echo $entry_subscription_duration; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-product-limit"><?php echo $entry_subscription_price; ?></label>
            <div class="col-sm-10">
              <input type="text" name="subscription_price" value="<?php echo $subscription_price; ?>" placeholder="<?php echo $entry_subscription_price; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-product_status"><span data-toggle="tooltip" title="<?php echo $help_product_status; ?>"><?php echo $entry_product_status; ?></span></label>
            <div class="col-sm-10">
              <select name="product_status" id="input-product_status" class="form-control">
                <?php if ($product_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
                         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

   <script type="text/javascript"><!--
// Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category\']').val('');

		$('#seller-group-category' + item['value']).remove();

		$('#seller-group-category').append('<div id="seller-group-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="seller_group_category[]" value="' + item['value'] + '" /></div>');
	}
});

$('#seller-group-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

//--></script>
  <script type="text/javascript"><!--

// the selector will match all input controls of type :checkbox
// and attach a click event handler
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});


//--></script> </div>
<?php echo $footer; ?>
