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


		       <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
             
                  <td class="text-left"><?php echo $column_name; ?></td>
                 
                  <td class="text-left"><?php echo $column_status; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($sellers)) { ?>
                <?php foreach ($sellers as $seller) { ?>
                <tr>
                  <td class="text-center">
                    
                    <input type="checkbox" name="selected[]" value="<?php echo $seller['seller_id']; ?>" />
                    </td>
                <td class="text-left"><?php echo $seller['name']; ?></td>
      <td class="text-left"><?php echo $seller['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $seller['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
