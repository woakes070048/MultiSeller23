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
    <div id="content" class="<?php echo $class; ?>"> <?php echo $content_top; ?>
      <h2><?php echo $text_edit_bankaccount; ?></h2>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <div class="text-danger"><?php echo $error_firstname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <div class="text-danger"><?php echo $error_lastname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
			  <label class="control-label col-sm-2" for="input-bank_id"><?php echo $entry_bank; ?></label>
			  <div class="col-sm-10">
				  <select name="bank_id" id="input-bank_id" class="form-control">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($banks as $bank) { ?>
              <?php if ($bank['bank_id'] == $bank_id) { ?>
              <option value="<?php echo $bank['bank_id']; ?>" selected="selected"><?php echo $bank['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $bank['bank_id']; ?>"><?php echo $bank['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            </div>
            </div>
                   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-branch_id"><?php echo $entry_branch_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="branch_id" value="<?php echo $branch_id; ?>" placeholder="<?php echo $entry_branch_id; ?>" id="input-branch_id" class="form-control" />
            </div>
          </div>
               <div class="form-group">
            <label class="col-sm-2 control-label" for="input-company_id"><?php echo $entry_company_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="company_id" value="<?php echo $company_id; ?>" placeholder="<?php echo $entry_company_id; ?>" id="input-company_id" class="form-control" />
            <?php if ($error_company_id) { ?>
              <div class="text-danger"><?php echo $error_company_id; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-bankaccount-1"><?php echo $entry_bankaccount_1; ?></label>
            <div class="col-sm-10">
              <input type="text" name="bankaccount_1" value="<?php echo $bankaccount_1; ?>" placeholder="<?php echo $entry_bankaccount_1; ?>" id="input-bankaccount-1" class="form-control" />
              <?php if ($error_bankaccount_1) { ?>
              <div class="text-danger"><?php echo $error_bankaccount_1; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-bankaccount-2"><?php echo $entry_bankaccount_2; ?></label>
            <div class="col-sm-10">
              <input type="text" name="bankaccount_2" value="<?php echo $bankaccount_2; ?>" placeholder="<?php echo $entry_bankaccount_2; ?>" id="input-bankaccount-2" class="form-control" />
            </div>
          </div>
          <div class="form-group">
           <label class="col-sm-2 control-label"><?php echo $entry_default; ?></label>
           <div class="col-sm-10">
             <?php if ($default) { ?>
             <label class="radio-inline">
               <input type="radio" name="default" value="1" checked="checked" />
               <?php echo $text_yes; ?></label>
             <label class="radio-inline">
               <input type="radio" name="default" value="0" />
               <?php echo $text_no; ?></label>
             <?php } else { ?>
             <label class="radio-inline">
               <input type="radio" name="default" value="1" />
               <?php echo $text_yes; ?></label>
             <label class="radio-inline">
               <input type="radio" name="default" value="0" checked="checked" />
               <?php echo $text_no; ?></label>
             <?php } ?>
           </div>
         </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length) {
		$('.form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length) {
		$('.form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	$('#form-upload input[name=\'file\']').on('change', function() {
		$.ajax({
			url: 'index.php?route=tool/upload',
			type: 'post',
			dataType: 'json',
			data: new FormData($(this).parent()[0]),
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$(node).button('loading');
			},
			complete: function() {
				$(node).button('reset');
			},
			success: function(json) {
				$('.text-danger').remove();

				if (json['error']) {
					$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
				}

				if (json['success']) {
					alert(json['success']);

					$(node).parent().find('input').attr('value', json['file']);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
//--></script>

<?php echo $footer; ?>
