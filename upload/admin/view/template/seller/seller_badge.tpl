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
<table class="table table-bordered">
  <thead>
 
  </thead>
  <tbody>
    <?php if ($badges) { ?>
		         <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_badge; ?></label>
            <div class="col-sm-10">
              <?php foreach ($badges as $badge) { ?>
              <div class="checkbox">
                <label>
                  <?php if (in_array($badge['badge_id'], $seller_badge)) { ?>
                  <input type="checkbox" name="seller_badge[]" value="<?php echo $badge['badge_id']; ?>" checked="checked" />
                  <img src="<?php echo $badge['image']; ?>"/>
                  <?php echo $badge['title']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="seller_badge[]" value="<?php echo $badge['badge_id']; ?>" />
                  <img src="<?php echo $badge['image']; ?>"/>
                  <?php echo $badge['title']; ?>
                  
                  <?php } ?>
                </label>
              </div>
              <?php } ?>
            </div>
          </div>

    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="2"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

