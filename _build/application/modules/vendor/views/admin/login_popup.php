<div class="page-content-wrapper">
   <div class="page-content">
      <div class="row">
         <div class="portlet light bordered">
            <div class="portlet-title">
               <div class="caption">
                  <i class="font-green icon-clock"></i>
                  <span class="caption-subject font-green sbold">Login Time Entry</span>
               </div>
               <div class="actions">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
            </div>

            <div class="row">
               <div class="portlet-body form">
                  <div class="col-md-12">
                     <form action="<?php echo get_module_path().'admin/save_login_entry/?id='.$id; ?>" id="login_form" method="post" autocomplete="off">
                        <input type="hidden" name="user_id" id="login_user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>" />
                        <div class="form-body">
                           <div class="form-group">
                              <label for="login_date">Date <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="login_date" name="login_date" required>
                           </div>
                           <div class="form-group">
                              <label for="login_time">Time <span class="text-danger">*</span></label>
                              <input type="time" class="form-control" id="login_time" name="login_time" required>
                           </div>
                        </div>
                        <div class="form-actions">
                           <button type="submit" class="btn btn-success">Submit</button>
                           <!-- <button type="button" class="btn red btn-outline" data-dismiss="modal">Cancel</button> -->
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
$(document).ready(function () {
   $("#login_form").validate({
      rules: {
         login_date: {
            required: true
         },
         login_time: {
            required: true
         }
      },
      errorClass: "help-inline text-danger",
      errorElement: "span",
      highlight: function(element) {
         $(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element) {
         $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      }
   });
});
</script>
