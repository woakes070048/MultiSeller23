<?php if ($seller_request['seller_changegroup']=='0' && $seller_request['seller_approved']=='0' && $seller_request['seller_group_id']=='0') { ?>

				   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
				  <?php echo $text_not_seller; ?>
				  </div>
  <?php } elseif ($seller_request['seller_changegroup']!='0' && $seller_request['seller_approved']=='0' && $seller_request['seller_group_id']=='0') { ?>
					 <div class="alert alert-success"><i class="fa fa-check-circle"></i>
		       <?php echo $text_request; ?>
		       </div>
<?php } elseif ($seller_request['seller_changegroup']=='0' && $seller_request['seller_approved']=='0' && $seller_request['seller_group_id']!='0') { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
		       <?php echo $text_seller_no_approved; ?>
		       </div>
<?php } elseif ($seller_request['seller_changegroup']!='0' && $seller_request['seller_approved']!='0' && $seller_request['seller_group_id']!='0') { ?>
					  <div class="alert alert-success"><i class="fa fa-check-circle"></i>
		       <?php echo $text_seller; ?>
		       </div>

		           <?php } ?>

<?php  if ($seller_request['seller_changegroup']!= $seller_request['seller_group_id'] && $seller_request['seller_changegroup']!='0') { ?>
					  <div class="alert alert-danger" id="hidealert"><i class="fa fa-check-circle"></i>
		       <?php echo $text_seller_change_group; ?>
		         </div>

		           <?php } ?>
<script type="text/javascript"><!--
$('#cancelrequest').bind('click', function() {

	$.ajax({
		url: 'index.php?route=sellerprofile/sellerprofile/cancelrequest',
		type: 'post',
		data: '',
		dataType: 'json',
		success: function(json) {

			if (json['error']) {
				$('.alert').html('<i class="fa fa-exclamation-circle"></i> ' + json['error']);
			}

			if (json['success']) {
				$('#hidealert').hide();

			}
		}
	});
});
//--></script>
