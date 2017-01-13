<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" id="button-save" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-multisellergeneral" data-toggle="tab"><?php echo $tab_multisellergeneral; ?></a></li>
            <li><a href="#tab-multisellerproductsetting" data-toggle="tab"><?php echo $tab_multisellerproductsetting; ?></a></li>
         <li><a href="#tab-multisellerordersetting" data-toggle="tab"><?php echo $tab_multisellerordersetting; ?></a></li>
		   <li><a href="#tab-multisellerdownloadsetting" data-toggle="tab"><?php echo $tab_multisellerdownloadsetting; ?></a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="tab-multisellergeneral">
			 <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-account"><span data-toggle="tooltip" title=""><?php echo $text_seller_agree; ?></span></label>
                  <div class="col-sm-10">
                    <select name="config_seller_agree_id" id="input-account" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($informations as $information) { ?>
                      <?php if ($information['information_id'] == $config_seller_agree_id) { ?>
                      <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <?php $chk = 'checked="checked"';?>
                						<div class="form-group">
                							<label class="col-sm-2 control-label" for="seller_add_product_alert-status"><?php echo $text_seller_add_product_alert; ?></label>
                							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_seller_add_product_alert" value="1" <?php if($config_seller_add_product_alert==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_seller_add_product_alert" value="0" <?php if($config_seller_add_product_alert==0 || !$config_seller_add_product_alert){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
                						</div>


									<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerreview-status"><?php echo $text_sellerreview; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerreview" value="1" <?php if($config_sellerreview==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerreview" value="0" <?php if($config_sellerreview==0 || !$config_sellerreview){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerreview-display-image"><?php echo $text_sellerreviewguest; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerreview_guest" value="1" <?php if($config_sellerreview_guest==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerreview_guest" value="0" <?php if($config_sellerreview_guest==0 || !$config_sellerreview_guest){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>


           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerimageupload-status"><?php echo $text_sellerimageupload; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerimageupload" value="1" <?php if($config_sellerimageupload==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerimageupload" value="0" <?php if($config_sellerimageupload==0 || !$config_sellerimageupload){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>



							           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerprofileimage-status"><?php echo $text_sellerprofileimage; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerprofileimage" value="1" <?php if($config_sellerprofileimage==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerprofileimage" value="0" <?php if($config_sellerprofileimage==0 || !$config_sellerprofileimage){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>


							           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerproductname-status"><?php echo $text_sellerproductname; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerproductname" value="1" <?php if($config_sellerproductname==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerproductname" value="0" <?php if($config_sellerproductname==0 || !$config_sellerproductname){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>
							  		           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerproductimage-status"><?php echo $text_sellerproductimage; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerproductimage" value="1" <?php if($config_sellerproductimage==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerproductimage" value="0" <?php if($config_sellerproductimage==0 || !$config_sellerproductimage){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
							  </div>

							  				           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerproductrating-status"><?php echo $text_sellerproductrating; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerproductrating" value="1" <?php if($config_sellerproductrating==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerproductrating" value="0" <?php if($config_sellerproductrating==0 || !$config_sellerproductrating){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>

							  					           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerproductcount-status"><?php echo $text_sellerproductcount; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerproductcount" value="1" <?php if($config_sellerproductcount==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerproductcount" value="0" <?php if($config_sellerproductcount==0 || !$config_sellerproductcount){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>


							           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerproductdateofcreat-status"><?php echo $text_sellerproductdateofcreat; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerproductdateofcreat" value="1" <?php if($config_sellerproductdateofcreat==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerproductdateofcreat" value="0" <?php if($config_sellerproductdateofcreat==0 || !$config_sellerproductdateofcreat){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>


							           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerproductbadge-status"><?php echo $text_sellerproductbadge; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerproductbadge" value="1" <?php if($config_sellerproductbadge==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerproductbadge" value="0" <?php if($config_sellerproductbadge==0 || !$config_sellerproductbadge){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>
						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerwebsite-status"><?php echo $text_sellerwebsite; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerwebsite" value="1" <?php if($config_sellerwebsite==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerwebsite" value="0" <?php if($config_sellerwebsite==0 || !$config_sellerwebsite){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>

							  					           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerfacebook-status"><?php echo $text_sellerfacebook; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerfacebook" value="1" <?php if($config_sellerfacebook==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerfacebook" value="0" <?php if($config_sellerfacebook==0 || !$config_sellerfacebook){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>
							  					           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellertwitter-status"><?php echo $text_sellertwitter; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellertwitter" value="1" <?php if($config_sellertwitter==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellertwitter" value="0" <?php if($config_sellertwitter==0 || !$config_sellertwitter){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>
							  					           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellergoogleplus-status"><?php echo $text_sellergoogleplus; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellergoogleplus" value="1" <?php if($config_sellergoogleplus==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellergoogleplus" value="0" <?php if($config_sellergoogleplus==0 || !$config_sellergoogleplus){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>
							  					           						<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerinstagram-status"><?php echo $text_sellerinstagram; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerinstagram" value="1" <?php if($config_sellerinstagram==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerinstagram" value="0" <?php if($config_sellerinstagram==0 || !$config_sellerinstagram){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>




						</div> <!-- // tab-multisellergeneral end // -->

							  <div class="tab-pane active" id="tab-multisellerordersetting">




									<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerorderstatus-status"><?php echo $text_sellerorderstatus; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerorderstatus" value="1" <?php if($config_sellerorderstatus==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerorderstatus" value="0" <?php if($config_sellerorderstatus==0 || !$config_sellerorderstatus){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerordernotifyhistory-status"><?php echo $text_sellerordernotifyhistory; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerordernotifyhistory" value="1" <?php if($config_sellerordernotifyhistory==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerordernotifyhistory" value="0" <?php if($config_sellerordernotifyhistory==0 || !$config_sellerordernotifyhistory){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerordersettlement-status"><?php echo $text_sellerordersettlement; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerordersettlement" value="1" <?php if($config_sellerordersettlement==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerordersettlement" value="0" <?php if($config_sellerordersettlement==0 || !$config_sellerordersettlement){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>

						</div> <!-- // tab-multisellerordersetting end // -->
							  <div class="tab-pane active" id="tab-multisellerdownloadsetting">




									<?php $chk = 'checked="checked"';?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sellerdownloadstatus-status"><?php echo $text_sellerdownloadstatus; ?></label>
							<div class="col-sm-10"><label class="radio-inline"><input type="radio" name="config_sellerdownloadstatus" value="1" <?php if($config_sellerdownloadstatus==1){echo $chk;}?> /> <?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_sellerdownloadstatus" value="0" <?php if($config_sellerdownloadstatus==0 || !$config_sellerdownloadstatus){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
						</div>



						</div> <!-- // tab-multisellerdownloadsetting end // -->


						<div class="tab-pane" id="tab-multisellerproductsetting">
		                       <ul class="nav nav-tabs">
            <li class="active"><a href="#tabM-general" data-toggle="tab">General</a></li>
            <li><a href="#tabM-data" data-toggle="tab">Data</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_data" value="1" <?php if($config_multiseller_tab_data==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_data" value="0" <?php if($config_multiseller_tab_data==0 || !$config_multiseller_tab_data){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-links" data-toggle="tab">Links</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_links" value="1" <?php if($config_multiseller_tab_links==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_links" value="0" <?php if($config_multiseller_tab_links==0 || !$config_multiseller_tab_links){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-attribute" data-toggle="tab">Attribute</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_attribute" value="1" <?php if($config_multiseller_tab_attribute==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_attribute" value="0" <?php if($config_multiseller_tab_attribute==0 || !$config_multiseller_tab_attribute){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-option" data-toggle="tab">Option</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_options" value="1" <?php if($config_multiseller_tab_options==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_options" value="0" <?php if($config_multiseller_tab_options==0 || !$config_multiseller_tab_options){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-recurring" data-toggle="tab">Recurring</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_recurring" value="1" <?php if($config_multiseller_tab_recurring==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_recurring" value="0" <?php if($config_multiseller_tab_recurring==0 || !$config_multiseller_tab_recurring){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-discount" data-toggle="tab">Discount</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_discount" value="1" <?php if($config_multiseller_tab_discount==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_discount" value="0" <?php if($config_multiseller_tab_discount==0 || !$config_multiseller_tab_discount){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-special" data-toggle="tab">Special</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_special" value="1" <?php if($config_multiseller_tab_special==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_special" value="0" <?php if($config_multiseller_tab_special==0 || !$config_multiseller_tab_special){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-image" data-toggle="tab">Image</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_image" value="1" <?php if($config_multiseller_tab_image==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_image" value="0" <?php if($config_multiseller_tab_image==0 || !$config_multiseller_tab_image){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-reward" data-toggle="tab">Reward Points</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_reward_points" value="1" <?php if($config_multiseller_tab_reward_points==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_reward_points" value="0" <?php if($config_multiseller_tab_reward_points==0 || !$config_multiseller_tab_reward_points){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
            <li><a href="#tabM-design" data-toggle="tab">Design</a>|<label class="radio-inline"><input type="radio" name="config_multiseller_tab_design" value="1" <?php if($config_multiseller_tab_design==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tab_design" value="0" <?php if($config_multiseller_tab_design==0 || !$config_multiseller_tab_design){echo $chk;}?> /> <?php echo $text_no; ?></label></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tabM-general">
              <ul class="nav nav-tabs" id="language">
                                <li class="active"><a href="#language1" data-toggle="tab" aria-expanded="true"><img src="language/en-gb/en-gb.png" title="English"> English</a></li>
                              </ul>
              <div class="tab-content">
                                <div class="tab-pane active" id="language1">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name1">Product Name</label>
                    <div class="col-sm-7">
                      <input type="text" name="product_description[1][name]" value="" placeholder="Product Name" id="input-name1" class="form-control">
                                          </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description1">Description</label>
                    <div class="col-sm-7">
                     <textarea name="product_description[1][description]" placeholder="Description" id="input-description1" class="form-control summernote" style="display: none;">
</textarea>

                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-title1">Meta Tag Title</label>
                    <div class="col-sm-7">
                      <input type="text" name="product_description[1][meta_title]" value="" placeholder="Meta Tag Title" id="input-meta-title1" class="form-control">
                                          </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description1">Meta Tag Description</label>
                    <div class="col-sm-7">
                      <textarea name="product_description[1][meta_description]" rows="5" placeholder="Meta Tag Description" id="input-meta-description1" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword1">Meta Tag Keywords</label>
                    <div class="col-sm-7">
                      <textarea name="product_description[1][meta_keyword]" rows="5" placeholder="Meta Tag Keywords" id="input-meta-keyword1" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-tag1"><span data-toggle="tooltip" title="" data-original-title="comma separated">Product Tags</span></label>
                    <div class="col-sm-7">
                      <input type="text" name="product_description[1][tag]" value="" placeholder="Product Tags" id="input-tag1" class="form-control">
                    </div>
                  </div>
                </div>
                              </div>
            </div>
            <div class="tab-pane" id="tabM-data">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image">Image</label>
                <div class="col-sm-7">
                  <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" data-original-title="" title=""><img src="http://127.0.0.1/oc23/image/cache/no_image-100x100.png" alt="" title="" data-placeholder="http://127.0.0.1/oc23/image/cache/no_image-100x100.png"></a>
                  <input type="hidden" name="image" value="" id="input-image">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_image" value="1" <?php if($config_multiseller_image==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_image" value="0" <?php if($config_multiseller_image==0 || !$config_multiseller_image){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-model">Model</label>
                <div class="col-sm-7">
                  <input type="text" name="model" value="" placeholder="Model" id="input-model" class="form-control">
                  </div>
                  <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_model" value="1" <?php if($config_multiseller_model==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_model" value="0" <?php if($config_multiseller_model==0 || !$config_multiseller_model){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sku"><span data-toggle="tooltip" title="" data-original-title="Stock Keeping Unit">SKU</span></label>
                <div class="col-sm-7">
                  <input type="text" name="sku" value="" placeholder="SKU" id="input-sku" class="form-control">
                </div>
                 <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_sku" value="1" <?php if($config_multiseller_sku==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_sku" value="0" <?php if($config_multiseller_sku==0 || !$config_multiseller_sku){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-upc"><span data-toggle="tooltip" title="" data-original-title="Universal Product Code">UPC</span></label>
                <div class="col-sm-7">
                  <input type="text" name="upc" value="" placeholder="UPC" id="input-upc" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_upc" value="1" <?php if($config_multiseller_upc==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_upc" value="0" <?php if($config_multiseller_upc==0 || !$config_multiseller_upc){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-ean"><span data-toggle="tooltip" title="" data-original-title="European Article Number">EAN</span></label>
                <div class="col-sm-7">
                  <input type="text" name="ean" value="" placeholder="EAN" id="input-ean" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_ean" value="1" <?php if($config_multiseller_ean==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_ean" value="0" <?php if($config_multiseller_ean==0 || !$config_multiseller_ean){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-jan"><span data-toggle="tooltip" title="" data-original-title="Japanese Article Number">JAN</span></label>
                <div class="col-sm-7">
                  <input type="text" name="jan" value="" placeholder="JAN" id="input-jan" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_jan" value="1" <?php if($config_multiseller_jan==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_jan" value="0" <?php if($config_multiseller_jan==0 || !$config_multiseller_jan){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-isbn"><span data-toggle="tooltip" title="" data-original-title="International Standard Book Number">ISBN</span></label>
                <div class="col-sm-7">
                  <input type="text" name="isbn" value="" placeholder="ISBN" id="input-isbn" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_isbn" value="1" <?php if($config_multiseller_isbn==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_isbn" value="0" <?php if($config_multiseller_isbn==0 || !$config_multiseller_isbn){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-mpn"><span data-toggle="tooltip" title="" data-original-title="Manufacturer Part Number">MPN</span></label>
                <div class="col-sm-7">
                  <input type="text" name="mpn" value="" placeholder="MPN" id="input-mpn" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_mpn" value="1" <?php if($config_multiseller_mpn==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_mpn" value="0" <?php if($config_multiseller_mpn==0 || !$config_multiseller_mpn){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-location">Location</label>
                <div class="col-sm-7">
                  <input type="text" name="location" value="" placeholder="Location" id="input-location" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_location" value="1" <?php if($config_multiseller_location==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_location" value="0" <?php if($config_multiseller_location==0 || !$config_multiseller_location){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-price">Price</label>
                <div class="col-sm-7">
                  <input type="text" name="price" value="" placeholder="Price" id="input-price" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_price" value="1" <?php if($config_multiseller_price==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_price" value="0" <?php if($config_multiseller_price==0 || !$config_multiseller_price){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tax-class">Tax Class</label>
                <div class="col-sm-7">
                  <select name="tax_class_id" id="input-tax-class" class="form-control">
                    <option value="0"> --- None --- </option>
                                                            <option value="9">Taxable Goods</option>
                                                                                <option value="10">Downloadable Products</option>
                                                          </select>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_tax_class" value="1" <?php if($config_multiseller_tax_class==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_tax_class" value="0" <?php if($config_multiseller_tax_class==0 || !$config_multiseller_tax_class){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-quantity">Quantity</label>
                <div class="col-sm-7">
                  <input type="text" name="quantity" value="1" placeholder="Quantity" id="input-quantity" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_quantity" value="1" <?php if($config_multiseller_quantity==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_quantity" value="0" <?php if($config_multiseller_quantity==0 || !$config_multiseller_quantity){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-minimum"><span data-toggle="tooltip" title="" data-original-title="Force a minimum ordered amount">Minimum Quantity</span></label>
                <div class="col-sm-7">
                  <input type="text" name="minimum" value="1" placeholder="Minimum Quantity" id="input-minimum" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_minimum_quantity" value="1" <?php if($config_multiseller_minimum_quantity==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_minimum_quantity" value="0" <?php if($config_multiseller_minimum_quantity==0 || !$config_multiseller_minimum_quantity){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-subtract">Subtract Stock</label>
                <div class="col-sm-7">
                  <select name="subtract" id="input-subtract" class="form-control">
                                        <option value="1" selected="selected">Yes</option>
                    <option value="0">No</option>
                                      </select>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_subtract_stok" value="1" <?php if($config_multiseller_subtract_stok==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_subtract_stok" value="0" <?php if($config_multiseller_subtract_stok==0 || !$config_multiseller_subtract_stok){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-stock-status"><span data-toggle="tooltip" title="" data-original-title="Status shown when a product is out of stock">Out Of Stock Status</span></label>
                <div class="col-sm-7">
                  <select name="stock_status_id" id="input-stock-status" class="form-control">
                                                            <option value="6">2-3 Days</option>
                                                                                <option value="7">In Stock</option>
                                                                                <option value="5">Out Of Stock</option>
                                                                                <option value="8">Pre-Order</option>
                                                          </select>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_out_of_stock_status" value="1" <?php if($config_multiseller_out_of_stock_status==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_out_of_stock_status" value="0" <?php if($config_multiseller_out_of_stock_status==0 || !$config_multiseller_out_of_stock_status){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Requires Shipping</label>
                <div class="col-sm-7">
                  <label class="radio-inline">
                                        <input type="radio" name="shipping" value="1" checked="checked">
                    Yes                                      </label>
                  <label class="radio-inline">
                                        <input type="radio" name="shipping" value="0">
                    No                                      </label>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_requires_shipping" value="1" <?php if($config_multiseller_requires_shipping==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_requires_shipping" value="0" <?php if($config_multiseller_requires_shipping==0 || !$config_multiseller_requires_shipping){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="" data-original-title="Do not use spaces, instead replace spaces with - and make sure the SEO URL is globally unique.">SEO URL</span></label>
                <div class="col-sm-7">
                  <input type="text" name="keyword" value="" placeholder="SEO URL" id="input-keyword" class="form-control">
                                  </div>
                                  <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_seo_url" value="1" <?php if($config_multiseller_seo_url==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_seo_url" value="0" <?php if($config_multiseller_seo_url==0 || !$config_multiseller_seo_url){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-date-available">Date Available</label>
                <div class="col-sm-3">
                  <div class="input-group date">
                    <input type="text" name="date_available" value="2016-02-13" placeholder="Date Available" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span></div>
                </div>
                <div class="col-sm-4"></div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_date_available" value="1" <?php if($config_multiseller_date_available==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_date_available" value="0" <?php if($config_multiseller_date_available==0 || !$config_multiseller_date_available){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-length">Dimensions (L x W x H)</label>
                <div class="col-sm-7">
                  <div class="row">
                    <div class="col-sm-4">
                      <input type="text" name="length" value="" placeholder="Length" id="input-length" class="form-control">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="width" value="" placeholder="Width" id="input-width" class="form-control">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="height" value="" placeholder="Height" id="input-height" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_dimensions" value="1" <?php if($config_multiseller_dimensions==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_dimensions" value="0" <?php if($config_multiseller_dimensions==0 || !$config_multiseller_dimensions){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-length-class">Length Class</label>
                <div class="col-sm-7">
                  <select name="length_class_id" id="input-length-class" class="form-control">
                                                            <option value="1" selected="selected">Centimeter</option>
                                                                                <option value="2">Millimeter</option>
                                                                                <option value="3">Inch</option>
                                                          </select>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_length_class" value="1" <?php if($config_multiseller_length_class==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_length_class" value="0" <?php if($config_multiseller_length_class==0 || !$config_multiseller_length_class){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-weight">Weight</label>
                <div class="col-sm-7">
                  <input type="text" name="weight" value="" placeholder="Weight" id="input-weight" class="form-control">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_weight" value="1" <?php if($config_multiseller_weight==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_weight" value="0" <?php if($config_multiseller_weight==0 || !$config_multiseller_weight){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-weight-class">Weight Class</label>
                <div class="col-sm-7">
                  <select name="weight_class_id" id="input-weight-class" class="form-control">
                                                            <option value="1" selected="selected">Kilogram</option>
                                                                                <option value="2">Gram</option>
                                                                                <option value="5">Pound </option>
                                                                                <option value="6">Ounce</option>
                                                          </select>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_weight_class" value="1" <?php if($config_multiseller_weight_class==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_weight_class" value="0" <?php if($config_multiseller_weight_class==0 || !$config_multiseller_weight_class){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status">Status</label>
                <div class="col-sm-7">
                  <select name="status" id="input-status" class="form-control">
                                        <option value="1" selected="selected">Enabled</option>
                    <option value="0">Disabled</option>
                                      </select>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_status" value="1" <?php if($config_multiseller_status==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_status" value="0" <?php if($config_multiseller_status==0 || !$config_multiseller_status){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order">Sort Order</label>
                <div class="col-sm-7">
                  <input type="text" name="sort_order" value="1" placeholder="Sort Order" id="input-sort-order" class="form-control">
                </div>
              <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_sort_order" value="1" <?php if($config_multiseller_sort_order==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_sort_order" value="0" <?php if($config_multiseller_sort_order==0 || !$config_multiseller_sort_order){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
               </div>
            </div>
            <div class="tab-pane" id="tabM-links">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="" data-original-title="(Autocomplete)">Manufacturer</span></label>
                <div class="col-sm-7">
                  <input type="text" name="manufacturer" value="" placeholder="Manufacturer" id="input-manufacturer" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                  <input type="hidden" name="manufacturer_id" value="0">
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_manufacturer" value="1" <?php if($config_multiseller_manufacturer==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_manufacturer" value="0" <?php if($config_multiseller_manufacturer==0 || !$config_multiseller_manufacturer){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="" data-original-title="(Autocomplete)">Categories</span></label>
                <div class="col-sm-7">
                  <input type="text" name="category" value="" placeholder="Categories" id="input-category" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                  <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
                                      </div>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_categories" value="1" <?php if($config_multiseller_categories==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_categories" value="0" <?php if($config_multiseller_categories==0 || !$config_multiseller_categories){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="" data-original-title="(Autocomplete)">Filters</span></label>
                <div class="col-sm-7">
                  <input type="text" name="filter" value="" placeholder="Filters" id="input-filter" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                  <div id="product-filter" class="well well-sm" style="height: 150px; overflow: auto;">
                                      </div>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_filters" value="1" <?php if($config_multiseller_filters==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_filters" value="0" <?php if($config_multiseller_filters==0 || !$config_multiseller_filters){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Stores</label>
                <div class="col-sm-7">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                                                <input type="checkbox" name="product_store[]" value="0" checked="checked">
                        Default                                              </label>
                    </div>
                                      </div>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_stors" value="1" <?php if($config_multiseller_stors==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_stors" value="0" <?php if($config_multiseller_stors==0 || !$config_multiseller_stors){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-download"><span data-toggle="tooltip" title="" data-original-title="(Autocomplete)">Downloads</span></label>
                <div class="col-sm-7">
                  <input type="text" name="download" value="" placeholder="Downloads" id="input-download" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                  <div id="product-download" class="well well-sm" style="height: 150px; overflow: auto;">
                                      </div>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_downloads" value="1" <?php if($config_multiseller_downloads==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_downloads" value="0" <?php if($config_multiseller_downloads==0 || !$config_multiseller_downloads){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-related"><span data-toggle="tooltip" title="" data-original-title="(Autocomplete)">Related Products</span></label>
                <div class="col-sm-7">
                  <input type="text" name="related" value="" placeholder="Related Products" id="input-related" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                  <div id="product-related" class="well well-sm" style="height: 150px; overflow: auto;">
                                      </div>
                </div>
                <div class="col-sm-3"><label class="radio-inline"><input type="radio" name="config_multiseller_related_products" value="1" <?php if($config_multiseller_related_products==1){echo $chk;}?> /><?php echo $text_yes; ?></label><label class="radio-inline"><input type="radio" name="config_multiseller_related_products" value="0" <?php if($config_multiseller_related_products==0 || !$config_multiseller_related_products){echo $chk;}?> /> <?php echo $text_no; ?></label></div>
              </div>
            </div>
            <div class="tab-pane" id="tabM-attribute">
              <div class="table-responsive">
                <table id="attribute" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Attribute</td>
                      <td class="text-left">Text</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                                                          </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Attribute"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tabM-option">
              <div class="row">
                <div class="col-sm-2">
                  <ul class="nav nav-pills nav-stacked" id="option">
                                                            <li>
                      <input type="text" name="option" value="" placeholder="Option" id="input-option" class="form-control" autocomplete="off"><ul class="dropdown-menu"></ul>
                    </li>
                  </ul>
                </div>
                <div class="col-sm-7">
                  <div class="tab-content">
                                                                              </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tabM-recurring">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Recurring Profile</td>
                      <td class="text-left">Customer Group</td>
                      <td class="text-left"></td>
                    </tr>
                  </thead>
                  <tbody>
                                                          </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-left"><button type="button" onclick="addRecurring()" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Recurring"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tabM-discount">
              <div class="table-responsive">
                <table id="discount" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Customer Group</td>
                      <td class="text-right">Quantity</td>
                      <td class="text-right">Priority</td>
                      <td class="text-right">Price</td>
                      <td class="text-left">Date Start</td>
                      <td class="text-left">Date End</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                                                          </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="6"></td>
                      <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Discount"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tabM-special">
              <div class="table-responsive">
                <table id="special" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Customer Group</td>
                      <td class="text-right">Priority</td>
                      <td class="text-right">Price</td>
                      <td class="text-left">Date Start</td>
                      <td class="text-left">Date End</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                                                          </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Special"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tabM-image">
              <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Image</td>
                      <td class="text-right">Sort Order</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                                                          </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2"></td>
                      <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tabM-reward">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-points"><span data-toggle="tooltip" title="" data-original-title="Number of points needed to buy this item. If you don't want this product to be purchased with points leave as 0.">Points</span></label>
                <div class="col-sm-7">
                  <input type="text" name="points" value="" placeholder="Points" id="input-points" class="form-control">
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Customer Group</td>
                      <td class="text-right">Reward Points</td>
                    </tr>
                  </thead>
                  <tbody>
                                        <tr>
                      <td class="text-left">Default</td>
                      <td class="text-right"><input type="text" name="product_reward[1][points]" value="" class="form-control"></td>
                    </tr>
                                      </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tabM-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Stores</td>
                      <td class="text-left">Layout Override</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left">Default</td>
                      <td class="text-left"><select name="product_layout[0]" class="form-control">
                          <option value=""></option>
                                                                              <option value="6">Account</option>
                                                                                                        <option value="10">Affiliate</option>
                                                                                                        <option value="3">Category</option>
                                                                                                        <option value="7">Checkout</option>
                                                                                                        <option value="12">Compare</option>
                                                                                                        <option value="8">Contact</option>
                                                                                                        <option value="4">Default</option>
                                                                                                        <option value="1">Home</option>
                                                                                                        <option value="11">Information</option>
                                                                                                        <option value="5">Manufacturer</option>
                                                                                                        <option value="2">Product</option>
                                                                                                        <option value="13">Search</option>
                                                                                                        <option value="9">Sitemap</option>
                                                                            </select></td>
                    </tr>
                                      </tbody>
                </table>
              </div>
            </div>
          </div>


</div> <!-- // tab-multisellerproductsetting end // -->
					</div> <!-- // tab-content end // -->

        </form>
      </div>
    </div>
  </div>
 </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>

<?php echo $footer; ?>
