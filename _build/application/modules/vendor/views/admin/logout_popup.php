<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="font-red icon-logout"></i>
                        <span class="caption-subject font-red sbold">Logout Time Entry</span>
                    </div>
                    <div class="actions">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="row">
                    <div class="portlet-body form">
                        <div class="col-md-12">
                            <form action="<?php echo get_module_path().'admin/save_logout_entry/?id='.($id); ?>" id="logout_form" method="post" autocomplete="off">
                                <input type="hidden" name="user_id" id="logout_user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>" />
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="logout_date">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="logout_date" name="logout_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="logout_time">Time <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="logout_time" name="logout_time" required>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                    <button type="button" class="btn default btn-outline" data-dismiss="modal">Cancel</button>
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
    $("#logout_form").validate({
        rules: {
            logout_date: {
                required: true
            },
            logout_time: {
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