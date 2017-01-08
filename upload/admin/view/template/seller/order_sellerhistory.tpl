<table class="table table-bordered">
  <thead>
    <tr>
      <td class="text-left"><?php echo $column_date_added; ?></td>
      <td class="text-left"><?php echo $column_comment; ?></td>
      <td class="text-left"><?php echo $column_status; ?></td>
      <td class="text-left"><?php echo $column_sellernotify; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($histories) { ?>
    <?php foreach ($histories as $sellerhistory) { ?>
    <tr>
      <td class="text-left"><?php echo $sellerhistory['date_added']; ?></td>
      <td class="text-left"><?php echo $sellerhistory['comment']; ?></td>
      <td class="text-left"><?php echo $sellerhistory['status']; ?></td>
      <td class="text-left"><?php echo $sellerhistory['notify']; ?></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>
