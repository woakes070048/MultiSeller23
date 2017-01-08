<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-badge-class" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="form-badge-class">
                  <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <?php if (true) { ?>
			<li><a href="#tab-sellerbadge" data-toggle="tab"><?php echo $tab_sellerbadge; ?></a></li>
           <?php } ?>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">

          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="badge_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($badge_description[$language['language_id']]) ? $badge_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
              </div>
              <?php if (isset($error_title[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
           <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                </div>
              </div>



                    </div>


            <?php if ($badge_id) { ?>
	           <div class="tab-pane" id="tab-sellerbadge">
              <div id="sellerbadge"></div>
              <br />
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sellerbadge-seller"><?php echo $entry_seller; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="seller" value="" placeholder="<?php echo $entry_seller; ?>" id="input-sellerbadge-seller" class="form-control" />
                <input type="hidden" name="seller_id" value="" />
                </div>
              </div>
                <div class="text-right">
                <button type="button" id="button-sellerbadge" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_seller_add; ?></button>
                <button type="button" id="button-sellerbadgedelete" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-remove"></i> <?php echo $button_seller_delete; ?></button>
              </div>
            </div>

            <?php } else { ?>

                   <div class="tab-pane" id="tab-sellerbadge">

              <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>    <?php echo $text_badge ?>

    </div>

                <?php } ?>
         </div>
         </form>
      </div>
    </div>
  </div>
</div>
 <script type="text/javascript"><!--
$('#sellerbadge').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#sellerbadge').load(this.href);
});

$('#sellerbadge').load('index.php?route=badge/badge/sellerbadge&token=<?php echo $token; ?>&badge_id=<?php echo $badge_id; ?>');

$('#button-sellerbadge').on('click', function(e) {
  e.preventDefault();

	$.ajax({
		url: 'index.php?route=badge/badge/sellerbadge&token=<?php echo $token; ?>&badge_id=<?php echo $badge_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'seller_id=' + encodeURIComponent($('#tab-sellerbadge input[name=\'seller_id\']').val())+ '&badge_id=<?php echo $badge_id; ?>',
		beforeSend: function() {
			$('#button-sellerbadge').button('loading');
		},
		complete: function() {
			$('#button-sellerbadge').button('reset');
		},
		success: function(html) {
			$('.alert').remove();

			$('#sellerbadge').html(html);

			$('#tab-sellerbadge input[name=\'seller\']').val('');
		}
	});
});

$('#button-sellerbadgedelete').on('click', function(e) {
	if(confirm('<?php echo $text_confirm; ?>')){

  e.preventDefault();

	$.ajax({
		url: 'index.php?route=badge/badge/sellerbadgedelete&token=<?php echo $token; ?>&badge_id=<?php echo $badge_id; ?>',
		type: 'post',
		dataType: 'html',
		data:  $('#tab-sellerbadge input[name=\'selected[]\']').serialize()+ '&badge_id=<?php echo $badge_id; ?>',
		beforeSend: function() {
			$('#button-sellerbadgedelete').button('loading');
		},
		complete: function() {
			$('#button-sellerbadgedelete').button('reset');
		},
		success: function(html) {
			$('.alert').remove();

			$('#sellerbadge').html(html);

			$('#tab-sellerbadge textarea[name=\'comment\']').val('');
		}
	});
}else{
	 return false;
 }

});

$('#tab-sellerbadge input[name=\'seller\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('#tab-sellerbadge input[name=\'seller\']').val(item['label']);
		$('#tab-sellerbadge input[name=\'seller_id\']').val(item['value']);

	}
});
//--></script>
 <?php echo $footer; ?>
