<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <?php $color = "font-red-mint";
                        $icon = "ban";
                        if ($action == "deactivate_quotation") {
                            $color = "font-red-mint";
                            $icon = "ban";
                        }
                        if ($action == "reactivate_customer") {
                            $color = "font-green-sharp";
                            $icon = "check";
                        }  
                        if ($action == "confirm_quotation") {
                            $color = "font-green-sharp";
                            $icon = "check";
                        }  ?>
                        <i class=" <?php echo $color; ?> icon-<?php echo $icon; ?>"></i>
                        <span class="caption-subject <?php echo $color; ?>  sbold"><?php echo $page_title; ?></span>
                    </div>
                    <div class="actions">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="row">
                    <div class="portlet-body form">

                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form action="<?php echo get_module_path() . 'reports/' . $action . "/?ref_id=" . base64_encode($ref_id); ?>" id="confirm_form" method="post" autocomplete="off">
                                <div class="form-body">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="reason">Reason for <?php echo $input_title; ?></label><?php echo REQUIRED_STAR; ?>
                                            <textarea class="form-control" id="reason" name="reason"
                                                placeholder="Enter Reason for <?php echo $input_title; ?>" maxlength="500" cols="5" rows="7"></textarea>
                                            <?php echo form_error('reason', '<span class="text-danger">', '</span>'); ?>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-actions">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button class="btn btn-success" id="mybutton" type="submit">Submit</button>
                                        <button type="button" class="btn red btn-outline" data-dismiss="modal">Cancel</button>
                                    </div>
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
    const button = document.getElementById('mybutton');

    button.addEventListener('click', function() {
        setTimeout(() => {
            button.disabled = true;
            setTimeout(() => {
                button.disabled = false;
            }, 1000);
        });
    });
</script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#confirm_form").validate({
            rules: {
                required: {
                    required: true
                },
                reason: {
                    required: true,
                    maxlength: 500,
                },
            },

            errorClass: "help-inline text-danger",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.form-group').addClass('has-error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.form-group').removeClass('has-error');
                $(element).parents('.form-group').addClass('has-success');
            }
        });
    });
</script>