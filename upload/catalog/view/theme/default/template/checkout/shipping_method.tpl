<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">


<?php if ($shipping_methods) { ?>
    <div class="well" style="background-color: white;border: 1px solid #000000;box-shadow: 5px 8px 5px #353535;">
<p><?php echo $text_shipping_method; ?></p>
<?php foreach ($shipping_methods as $shipping_method) { ?>
<p><strong><?php echo $shipping_method['title']; ?></strong></p>
<?php if (!$shipping_method['error']) { ?>
<?php foreach ($shipping_method['quote'] as $quote) { ?>
  <label>
    <?php if ($quote['code'] == $code || !$code) { ?>
    <?php $code = $quote['code']; ?>
    <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" />
    <?php } ?>
    <?php echo $quote['title']; ?> - <?php echo $quote['text']; ?></label>

<?php } ?>
<?php } else { ?>
<div class="alert alert-danger"><?php echo $shipping_method['error']; ?></div>
<?php } ?>
<?php } ?>
<?php } ?>
  <?php foreach ($store as $store) { ?>


  <?php if($store['product_data']) {?>
    <div class="table-responsive">
  <table class="table table-bordered table-hover">
<thead>
      <tr>
        <td class="text-left" colspan="5"><a href="<?php echo $store['href']; ?>"><?php echo $store['seller_name']; ?></a></td>
      </tr>
    </thead>
      <tr>
        <td class="text-left"><?php echo $column_name; ?></td>

        <td class="text-right"><?php echo $column_quantity; ?></td>
        <td class="text-right"><?php echo $column_price; ?></td>



        <td class="text-right"><?php echo $column_total; ?></td>
      </tr>

    <?php foreach ($store['product_data'] as $product) { ?>
    <tbody>

      <tr>
        <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        </td>
        <td class="text-right"><?php echo $product['quantity']; ?></td>

        <td class="text-right"><?php echo $product['price']; ?></td>




          <td class="text-right" id="total_<?php echo $product['product_id']; ?>"><?php echo $product['total']; ?></td>


      </tr>
<?php } ?>

  </table>
  </div>
    <?php } ?>


</div>
  <?php } ?>

  <?php foreach ($sellers as $seller) { ?>

  <?php if($seller['seller_id']) {?>
    <div class="well" style="background-color: white;border: 1px solid #000000;box-shadow: 5px 8px 5px #ab6969;">
    <div class="table-responsive">
  <table class="table table-bordered table-hover">
<thead>
      <tr>
        <td class="text-left" colspan="5" style="background-color: antiquewhite;"><a href="<?php echo $seller['href']; ?>"><?php echo $seller['seller_name']; ?></a></td>
      </tr>
    </thead>
      <tr>
        <td class="text-left"><?php echo $column_name; ?></td>

        <td class="text-right"><?php echo $column_quantity; ?></td>
        <td class="text-right"><?php echo $column_price; ?></td>

        <td class="text-right"><?php echo $column_seller_shipping; ?></td>

        <td class="text-right"><?php echo $column_total; ?></td>
      </tr>

    <?php foreach ($seller['product_data'] as $product) { ?>
    <tbody>

      <tr>
        <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        </td>
        <td class="text-right"><?php echo $product['quantity']; ?></td>

        <td class="text-right"><?php echo $product['price']; ?></td>

        <td class="text-right">

              <select name="shipping_method_<?php echo $product['product_id']; ?>" onchange="changetotal(<?php echo $product['product_id']; ?>,<?php echo $product['total']; ?>,$('option:selected', this).attr('cost'));" class="form-control">
                <?php foreach ($seller['shipping_methods'] as $seller_shipping_method) { ?>
                  <?php if (!$seller_shipping_method['error']) { ?>
                    <?php if ($seller_shipping_method) { ?>
                      <?php foreach ($seller_shipping_method['quote'] as $quote) { ?>
                        <?php echo $code; ?>

                          <?php $code = $quote['code']; ?>
                          <option  value="<?php echo $quote['code']; ?>" cost="<?php echo $quote['cost']; ?>" selected="selected"><?php echo $quote['title']; ?> - <?php echo $quote['text']; ?></option>

                          <?php } ?>
                          <?php } ?>

                          <?php } else { ?>
                            <div class="alert alert-danger"><?php echo $seller_shipping_method['error']; ?></div>
                            <?php } ?>
                            <?php } ?>
                          </select>

      </td>

        <?php if(!empty($product['shipping_methods'])) {?>
        <td class="text-right" id="total_<?php echo $product['product_id']; ?>"><?php echo $product['total']+$quote['cost']; ?></td>
        <?php }else{ ?>
          <td class="text-right" id="total_<?php echo $product['product_id']; ?>"><?php echo $product['total']; ?></td>
          <?php } ?>

      </tr>
<?php } ?>

  </table>
</div>
</div>
    <?php } ?>

    <?php } ?>



<p><strong><?php echo $text_comments; ?></strong></p>
<p>
  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-shipping-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
</form>
  <script type="text/javascript"><!--


  function changetotal(product_id,price,cost) {
var total = +price + +cost;
    $('#total_'+product_id).html(total);
  }
//--></script>
