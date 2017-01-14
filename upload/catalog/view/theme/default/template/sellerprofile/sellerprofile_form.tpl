<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
<link href="admin/view/javascript/summernote/summernote.css" rel="stylesheet">
<script type="text/javascript" src="admin/view/javascript/summernote/summernote.js"></script>

    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
    <div class="page-header">
      <div class="container-fluid">

      </div>
    </div>

    <div class="container-fluid">
      <?php if ($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
        <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
      <?php if ($error_warning_product_limit) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
        <?php echo $error_warning_product_limit; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_seller_profile; ?></h3>
        </div>
        <div class="panel-body">

          <ul class="nav nav-tabs">
            <?php if ($is_seller) { ?>
            <li class="active">
              <a href="#tab-dashboard" data-toggle="tab">
                <?php echo $tab_dashboard; ?>
              </a>
            </li>
            <li>
              <a href="#tab-more_details" data-toggle="tab">
                <?php echo $tab_more_details; ?>
              </a>
            </li>
            <li>
              <a href="#tab-badge" data-toggle="tab">
                <?php echo $tab_badge; ?>
              </a>
            </li>
            <li>
              <a href="#tab-sellerproduct" data-toggle="tab">
                <?php echo $tab_sellerproduct; ?>
              </a>
            </li>
            <li>
              <a href="#tab-bankaccount" data-toggle="tab">
                <?php echo $tab_bankaccount; ?>
              </a>
            </li>

            <?php } ?>
            <li>
              <a href="#tab-transaction" data-toggle="tab">
                <?php echo $tab_transaction; ?>
              </a>
            </li>
            <li>
              <a href="#tab-history" data-toggle="tab">
                <?php echo $tab_history; ?>
              </a>
            </li>
            <li <?php if (!$is_seller) { echo 'class="active"'; } ?>>
              <a href="#tab-request_membership" data-toggle="tab">
                <?php echo $tab_request_membership; ?>
              </a>
            </li>

          </ul>
          <div class="tab-content">
            <?php if ($is_seller) { ?>
            <div class="tab-pane active" id="tab-dashboard">
              <div class="row">

                <div class="col-sm-12">

                    <div class="tab-pane active" id="tab-seller">
                      <div class="col-md-6">
                        <blockquote>
                          <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_seller_detail; ?></h3>
                          </div>
                          <div class="table-responsive">
                          <table class="table table-condensed">
                            <tbody>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_name; ?>" class="btn btn-info btn-xs"><i class="fa fa-user fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $firstname.' '.$lastname; ?>
                                  </a>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_seller_group; ?>" class="btn btn-info btn-xs"><i class="fa fa-users fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $seller_group; ?>
                                  </a>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_date_created; ?>" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $date ; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_date_end; ?>" class="btn btn-info btn-xs"><i class="fa fa-calendar fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $date_end; ?>
                                </td>
                              </tr>

                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_email; ?>" class="btn btn-info btn-xs"><i class="fa fa-envelope-o fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $email; ?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_telephone; ?>" class="btn btn-info btn-xs"><i class="fa fa-phone fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $telephone; ?>
                                </td>
                              </tr>

                            </tbody>
                          </table>
                        </div>
                        </blockquote>
                      </div>

                      <div class="col-md-6">
                        <blockquote>
                          <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-users"></i> <?php echo $text_seller_group_detail; ?></h3>
                          </div>
                          <div class="table-responsive">
                          <table class="table table-condensed">
                            <tbody>


                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_seller_group_commission; ?>" class="btn btn-info btn-xs"><i class="fa fa-sitemap fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $commission; ?>
                                </td>

                              </tr>

                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_seller_group_subscription_price; ?>" class="btn btn-info btn-xs"><i class="fa fa-usd fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $seller_group_subscription_price; ?>
                                </td>

                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_seller_product_total; ?>" class="btn btn-info btn-xs"><i class="fa fa-battery-quarter fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $seller_product_total; ?>
                                </td>

                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_seller_group_limit; ?>" class="btn btn-info btn-xs"><i class="fa fa-battery-full fa-fw"></i></button>
                                </td>
                                <td>
                                  <?php echo $seller_group_limit; ?>
                                </td>

                              </tr>
                              <tr>
                                <td>
                                  <button data-toggle="tooltip" title="<?php echo $entry_seller_product_left; ?>" class="btn btn-info btn-xs"><i class="fa fa-exclamation-triangle fa-fw"></i></button>
                                </td>
                                <td>

                                  <div class="progress">
                                    <div class="progress-bar active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ( $seller_group_limit ? (($seller_product_total / $seller_group_limit)*100) : 100) ;?>%">
                                      <?php echo ($seller_group_limit - $seller_product_total); ?>
                                    </div>
                                  </div>
                                </td>

                              </tr>


                            </tbody>
                          </table>
                        </div>
                        </blockquote>
                      </div>
                    </div>

                </div>
              </div>
              <div class="row">
              <div class="col-sm-12">
                <div class="col-md-6"><?php echo $map; ?></div>
                <div class="col-md-6"><?php echo $chart; ?></div>
              </div>
            </div>
            </div>
            <div class="tab-pane" id="tab-more_details">
              <form action="" method="post" enctype="multipart/form-data" id="form-profile" class="form-horizontal">


                    <button type="button" id="button-profile-save" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary pull-right">
                      <?php echo $button_save; ?>
                    </button>

                    <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-nickname">
                    <?php echo $entry_nickname; ?>
                  </label>

                  <div class="input-group">
                    <input type="text" name="nickname" placeholder="<?php echo $entry_nickname; ?>" value="<?php echo $nickname; ?>" id="input-nickname" class="form-control" />
                    <span class="input-group-btn">

                      </span></div>

                </div>


                <div class="form-group">
                  <div class="buttons">
                    <label class="col-sm-2 control-label">
                      <?php echo $entry_seller_avatar; ?>
                    </label>
                    <div class="col-sm-10">
                      <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                      <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                    </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="buttons">
                    <label class="col-sm-2 control-label">
                      <?php echo $entry_seller_banner; ?>
                    </label>
                    <div class="col-sm-10">
                      <a href="" id="thumb-banner" data-toggle="banner" class="img-thumbnail"><img src="<?php echo $thumb_banner; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                      <input type="hidden" name="banner" value="<?php echo $banner; ?>" id="input-banner" />
                    </div>
                  </div>
                </div>



                <div class="form-group">
                  <label class="col-sm-2 control-label">
                    <?php echo $entry_description; ?>
                  </label>
                  <div class="col-sm-10">
                    <textarea name="seller_description" rows="5" placeholder="<?php echo $entry_description; ?>" id="input-description" class="form-control summernote">


                      <?php echo isset($seller_description) ? $seller_description : ''; ?>
                    </textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-website">
                    <?php echo $entry_website; ?>
                  </label>

                  <div class="input-group">
                    <input type="text" name="website" placeholder="http://www.example.com" value="<?php echo $website; ?>" id="input-website" class="form-control" />
                    <span class="input-group-btn">

                      </span></div>

                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-facebook">
                    <?php echo $entry_facebook; ?>
                  </label>

                  <div class="input-group">
                    <input type="text" name="facebook" placeholder="http://www.facebook.com/youraccount" value="<?php echo $facebook; ?>" id="input-facebook" class="form-control" />
                    <span class="input-group-btn">

                      </span></div>

                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-twitter">
                    <?php echo $entry_twitter; ?>
                  </label>

                  <div class="input-group">
                    <input type="text" name="twitter" placeholder="http://twitter.com/youraccount" value="<?php echo $twitter; ?>" id="input-twitter" class="form-control" />
                    <span class="input-group-btn">

                      </span></div>

                </div>


                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-googleplus">
                    <?php echo $entry_googleplus; ?>
                  </label>

                  <div class="input-group">
                    <input type="text" name="googleplus" placeholder="http://plus.google.com/youraccount" value="<?php echo $googleplus; ?>" id="input-googleplus" class="form-control" />
                    <span class="input-group-btn">

                      </span></div>

                </div>


                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-instagram">
                    <?php echo $entry_instagram; ?>
                  </label>

                  <div class="input-group">
                    <input type="text" name="instagram" placeholder="http://www.instagram.com/youraccount" value="<?php echo $instagram; ?>" id="input-instagram" class="form-control" />
                    <span class="input-group-btn">

                      </span></div>

                </div>




              </form>
            </div>


            <div class="tab-pane" id="tab-badge">
              <div id="badge"></div>
              <br />

            </div>
            <div class="tab-pane" id="tab-bankaccount">
              <div id="bankaccount"></div>
              <br />

            </div>
            <div class="tab-pane" id="tab-sellerproduct">
              <div id="sellerproduct"></div>
              <br />

            </div>
            <?php } ?>
            <div class="tab-pane" id="tab-transaction">
              <div id="transaction"></div>
              <br />
            </div>

            <div class="tab-pane" id="tab-history">
              <div class="text-right">
                <button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i>
                  <?php echo $button_history_add; ?>
                </button>
              </div>
              <div id="history"></div>
              <br />

            </div>

            <div <?php if (!$is_seller) { echo 'class="tab-pane active"'; }else{echo 'class="tab-pane"';} ?> id="tab-request_membership">
              <div id="request_membership"></div>
              <br />
              <div class="form-group">

                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td style="width: 1px;" class="text-center"></td>
                        <td class="text-left">
                          <?php echo $column_name; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $column_product_limit; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $column_subscription_price; ?>
                        </td>

                        <td class="text-center">
                          <?php echo $column_commission_rate; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $column_subscription_duration; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $column_group_categories; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $column_categories; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $column_seller_group_description; ?>
                        </td>

                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($seller_groups) { ?>
                      <?php foreach ($seller_groups as $seller_group) { ?>
                      <tr>
                        <td class="text-center">
                          <input type="checkbox" name="selected" value="<?php echo $seller_group['seller_group_id']; ?>" id="<?php echo $seller_group['name']; ?>" />

                        </td>
                        <td class="text-left">
                          <?php echo $seller_group['name']; ?>

                          <?php if (in_array($seller_group['seller_group_id'], $seller_group_id)) { ?> ( <i class="fa fa-check-circle fa-2x" style="color: green;"></i> )
                          <?php } ?>

                        </td>
                        <td class="text-center">
                          <?php echo $seller_group['product_limit']; ?>
                        </td>
                        <td class="text-center">
                          <?php echo $seller_group['subscription_price']; ?>
                        </td>


                        <td class="text-center">

                          <?php echo $seller_group['commission']; ?>
                        </td>
                        <?php if ($seller_group['subscription_duration']) { ?>
                        <td class="text-center">
                          <?php echo $seller_group['text_subscription_duration']; ?>
                        </td>
                        <?php } else { ?>
                        <td class="text-center">
                          <?php echo $text_unlimited; ?>
                        </td>
                        <?php } ?>





                        <td class="left">

                          <div id="seller-group-category" class="well well-sm" style="height: 150px; overflow: auto;">
                            <?php if (!empty($seller_group['categories'])) { ?>
                            <?php foreach ($seller_group['seller_categories'] as $category) { ?>
                              <?php if (in_array($category['category_id'], $seller_group['categories'])) { ?>

                            <div><i class="fa fa-check"></i> <?php echo $category['name']; ?>

                            </div>



                            <?php } ?>

                            <?php } ?>
                            <?php } else { ?>
                          <div><i class="fa fa-check"></i>  <?php echo $entry_all_categories; ?></div>
                              <?php } ?>

                          </div>
                        </td>
                        <td class="left">
                          <?php if (!empty($seller_group['categories'])) { ?>
                          <div class="scrollbox scrollbox<?php echo '-' .  $seller_group['seller_group_id'];?>" style="border: 1px solid #CCCCCC; width: 350px; height: 150px; background: #FFFFFF; overflow-y: scroll;">
                            <?php foreach ($seller_group['seller_categories'] as $category) { ?>
                            <div class="checkbox">
                              <label>

                                <?php if (in_array($category['category_id'], $seller_group['categories'])) { ?>
                                <input type="checkbox" name="seller_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />

                                <?php echo $category['name']; ?>
                                <?php } else { ?>
                                <input type="checkbox" name="seller_category[]" value="<?php echo $category['category_id']; ?>" />

                                <?php echo $category['name']; ?>

                                <?php } ?>

                              </label>
                            </div>
                            <?php } ?>

                          </div>
                          <?php } ?>
                        </td>




                        <td class="text-center">
                          <?php echo $seller_group['description']; ?>
                        </td>

                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="4">
                          <?php echo $text_no_results; ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>

              </div>

              <div class="pull-right" style="margin-top: 15px;">
                <?php echo $text_agree; ?>

                <input type="checkbox" name="agree" value="1" /> &nbsp;
                <button type="button" id="button-request_membership" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                  <?php echo $button_request_membership_add; ?>
                </button>

              </div>

            </div>

          </div>

        </div>
      </div>
    </div>
</div>
    </div>
    <script type="text/javascript">
      <!--
      $('#badge').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#badge').load(this.href);
      });

      $('#badge').load('index.php?route=sellerprofile/sellerprofile/badge&seller_id=<?php echo $seller_id; ?>');

      $('#button-badge').on('click', function(e) {
        e.preventDefault();

        $.ajax({
          url: 'index.php?route=sellerprofile/sellerprofile/badge&seller_id=<?php echo $seller_id; ?>',
          type: 'post',
          dataType: 'html',
          data: 'comment=' + encodeURIComponent($('#tab-badge textarea[name=\'comment\']').val()),
          beforeSend: function() {
            $('#button-badge').button('loading');
          },
          complete: function() {
            $('#button-badge').button('reset');
          },
          success: function(html) {
            $('.alert').remove();

            $('#badge').html(html);

            $('#tab-badge textarea[name=\'comment\']').val('');
          }
        });
      });
      //-->
    </script>
    <script type="text/javascript">
      <!--
      $('#sellerproduct').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#sellerproduct').load(this.href);
      });

      $('#sellerproduct').load('index.php?route=sellerprofile/sellerprofile/sellerproduct&seller_id=<?php echo $seller_id; ?>');

      $('#button-sellerproduct').on('click', function(e) {
        e.preventDefault();

        $.ajax({
          url: 'index.php?route=sellerprofile/sellerprofile/sellerproduct&seller_id=<?php echo $seller_id; ?>',
          type: 'post',
          dataType: 'html',
          data: 'comment=' + encodeURIComponent($('#tab-sellerproduct textarea[name=\'comment\']').val()),
          beforeSend: function() {
            $('#button-sellerproduct').button('loading');
          },
          complete: function() {
            $('#button-sellerproduct').button('reset');
          },
          success: function(html) {
            $('.alert').remove();

            $('#sellerproduct').html(html);

            $('#tab-sellerproduct textarea[name=\'comment\']').val('');
          }
        });
      });
      //-->
    </script>
    <script type="text/javascript">
      <!--
      $('#bankaccount').load('index.php?route=bankaccount/bankaccount&profile=<?php echo $seller_id; ?>');
      $('#history').load('index.php?route=sellerprofile/sellerprofile/history&seller_id=<?php echo $seller_id; ?>');

      $('#button-history').on('click', function(e) {
        e.preventDefault();

        $.ajax({
          url: 'index.php?route=sellerprofile/sellerprofile/history&seller_id=<?php echo $seller_id; ?>',
          type: 'post',
          dataType: 'html',
          data: 'comment=' + encodeURIComponent($('#tab-history textarea[name=\'comment\']').val()),
          beforeSend: function() {
            $('#button-history').button('loading');
          },
          complete: function() {
            $('#button-history').button('reset');
          },
          success: function(html) {
            //$('.alert').remove();

            $('#history').html(html);

            $('#tab-history textarea[name=\'comment\']').val('');
          }
        });
      });
      //-->
    </script>
    <script type="text/javascript">
      <!--
      $('#transaction').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#transaction').load(this.href);
      });

      $('#transaction').load('index.php?route=sellerprofile/sellerprofile/transaction&seller_id=<?php echo $seller_id; ?>');

      $('#button-transaction').on('click', function(e) {
        e.preventDefault();

        $.ajax({
          url: 'index.php?route=sellerprofile/sellerprofile/transaction&seller_id=<?php echo $seller_id; ?>',
          type: 'post',
          dataType: 'html',
          data: 'seller_group_id=' + encodeURIComponent($('#tab-transaction select[name=\'seller_group_id\']').val()) + '&amount=' + encodeURIComponent($('#tab-transaction input[name=\'amount\']').val()),
          beforeSend: function() {
            $('#button-transaction').button('loading');
          },
          complete: function() {
            $('#button-transaction').button('reset');
          },
          success: function(html) {
            $('.alert').remove();

            $('#transaction').html(html);

            $('#tab-transaction input[name=\'amount\']').val('');
            $('#tab-transaction input[name=\'description\']').val('');
          }
        });
      });
      //-->
    </script>
    <script type="text/javascript">
      <!--
      $('#request_membership').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#request_membership').load(this.href);
      });

      $('#request_membership').load('index.php?route=sellerprofile/sellerprofile/request_membership&seller_id=<?php echo $seller_id; ?>');

      $('#button-request_membership').on('click', function(e) {
        e.preventDefault();
        if ($('#tab-request_membership input[name=\'agree\']').prop('checked')) {
          var seller_group_id = $('#tab-request_membership input[name=\'selected\']:checkbox:checked').val();
          $.ajax({
            url: 'index.php?route=sellerprofile/sellerprofile/request_membership&seller_id=<?php echo $seller_id; ?>',
            type: 'POST',
            dataType: 'html',
            data: $('#tab-request_membership .scrollbox-' + seller_group_id + ' input[name=\'seller_category[]\']').serialize() + '&seller_group_name=' + encodeURIComponent($(
                '#tab-request_membership input[name=\'selected\']:checkbox:checked').attr("id")) + '&description=' + encodeURIComponent($('#tab-request_membership input[name=\'description\']').val()) + '&seller_group_id=' +
              encodeURIComponent($('#tab-request_membership input[name=\'selected\']:checkbox:checked').val()),
            beforeSend: function() {
              $('#button-request_membership').button('loading');
            },
            complete: function() {
              $('#button-request_membership').button('reset');
            },
            success: function(html) {

              $('#request_membership').html(html);

              $('#tab-request_membership input[name=\'points\']').val('');
              $('#tab-request_membership input[name=\'description\']').val('');
            }
          });



        } else {
          var text_seller_agree = '<?php echo $text_seller_agree; ?>';

          $('#request_membership').prepend('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + text_seller_agree + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }
      });

      //-->
    </script>
    <script type="text/javascript">
      <!--
      $('#button-request_membership').attr("disabled", "disabled");
      // the selector will match all input controls of type :checkbox
      // and attach a click event handler
      $(".text-center input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
          $('#button-request_membership').removeAttr('disabled');
          // the name of the box is retrieved using the .attr() method
          // as it is assumed and expected to be immutable
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          // the checked state of the group/box on the other hand will change
          // and the current value is retrieved using .prop() method
          $(group).prop("checked", false);
          $box.prop("checked", true);
        } else {
          $('#button-request_membership').attr("disabled", "disabled");
          $box.prop("checked", false);
        }
      });

      // Image Manager
      $(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
        e.preventDefault();

        var element = this;

        $(element).popover({
          html: true,
          placement: 'right',
          trigger: 'manual',
          content: function() {
            return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
          }
        });

        $(element).popover('toggle');

        $('#button-image').on('click', function() {
          $('#modal-image').remove();

          $.ajax({
            url: 'index.php?route=sellerproduct/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
            dataType: 'html',
            beforeSend: function() {
              $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
              $('#button-image').prop('disabled', true);
            },
            complete: function() {
              $('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
              $('#button-image').prop('disabled', false);
            },
            success: function(html) {
              $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

              $('#modal-image').modal('show');
            }
          });

          $(element).popover('hide');
        });

        $('#button-clear').on('click', function() {
          $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

          $(element).parent().find('input').attr('value', '');

          $(element).popover('hide');
        });
      });

      // banner Manager
      $(document).delegate('a[data-toggle=\'banner\']', 'click', function(e) {
        e.preventDefault();

        var element = this;

        $(element).popover({
          html: true,
          placement: 'right',
          trigger: 'manual',
          content: function() {
            return '<button type="button" id="button-banner" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
          }
        });

        $(element).popover('toggle');

        $('#button-banner').on('click', function() {
          $('#modal-image').remove();

          $.ajax({
            url: 'index.php?route=sellerproduct/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
            dataType: 'html',
            beforeSend: function() {
              $('#button-banner i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
              $('#button-banner').prop('disabled', true);
            },
            complete: function() {
              $('#button-banner i').replaceWith('<i class="fa fa-upload"></i>');
              $('#button-banner').prop('disabled', false);
            },
            success: function(html) {
              $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

              $('#modal-image').modal('show');
            }
          });

          $(element).popover('hide');
        });

        $('#button-clear').on('click', function() {
          $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

          $(element).parent().find('input').attr('value', '');

          $(element).popover('hide');
        });
      });

      //-->
    </script>
    <script type="text/javascript">
      <!--
      $(document).delegate('#button-profile-save', 'click', function() {
        $.ajax({
          url: 'index.php?route=sellerprofile/sellerprofile/profile&seller_id=<?php echo $seller_id; ?>',
          dataType: 'json',
          data: $('#form-profile').serialize(),
          beforeSend: function() {
            $('#button-profile-save').button('loading');
          },
          complete: function() {
            $('#button-profile-save').button('reset');

            $('#button-profile-save').addClass('btn-success');
            $('#button-profile-save').removeClass('btn-primary');


          },
          success: function(json) {
            $('.alert').remove();

            if (json['error']) {
              $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }

          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      });
      //-->
    </script>
    <script type="text/javascript">
      <!--
      $('#input-description').summernote({
        height: 300,

      });

      $('#button-clear').on('click', function() {
        $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

        $(element).parent().find('input').attr('value', '');

        $(element).popover('hide');
      });
      //-->
    </script>
  </div>
</div>
<?php echo $footer; ?>
