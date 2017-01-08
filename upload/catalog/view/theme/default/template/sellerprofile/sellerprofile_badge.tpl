<?php if ($error_warning) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
  <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>

    <?php if (true) { ?>
			 <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-bookmark"></i> <?php echo $entry_badge; ?></h3>
          </div>
          <table class="table">
            <tbody>
              <?php foreach ($badges as $badge) { ?>
        
      
              <tr>
                <td style="width: 1%;"> <img src="<?php echo $badge['image']; ?>"/></td>
                <td><?php echo $badge['title']; ?></td>
              </tr>
        
              
          
    
              <?php } ?>
         
            
     
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="2"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
   </tbody>
          </table>
        </div>
      </div>
	

