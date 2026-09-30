<?php $role_id = $this->session->userdata('user_role_id'); ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <?php if (!empty($faq_list)) {
            $count = count($faq_list);
        } else {
            $count = 0;
        } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
                    <span class="caption-subject font-red-mint sbold float-right">( Total - <?php echo $count; ?>
                        )</span>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet-body">
                                <div class="col-md-6">
                                    <?php
                                    $this->load->helper('form');
                                    $error = $this->session->flashdata('error');
                                    if ($error) {
                                        ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">Ã—</button>
                                            <?php echo $this->session->flashdata('error'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    $success = $this->session->flashdata('success');
                                    if ($success) {
                                        ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">Ã—</button>
                                            <?php echo $this->session->flashdata('success'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-12">
                                    <form action="<?php echo get_module_path() . 'masters/faq_report'; ?>" method="get"
                                        autocomplete="off">
                                        <div class="form-group col-md-3">
                                            <select class="form-control" id="faq_m_id" name="faq_m_id"
                                                onchange="this.form.submit();">
                                                <option value=""> Select Module</option>
                                                <?php if (!empty($faq_module_list)) {
                                                    foreach ($faq_module_list as $faq_module) {
                                                        $selected = $faq_m_id == $faq_module['faq_m_id'] ? "selected" : "";
                                                        ?>
                                                        <option value="<?php echo $faq_module['faq_m_id']; ?>" <?php echo $selected; ?>>
                                                            <?php echo $faq_module['faq_module']; ?>
                                                        </option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        
                                        <!-- <div class="form-group col-md-3">
                                            <select class="form-control" id="status" name="status" onchange="this.form.submit();">
                                                <option value=""> Select Status</option>
                                                <?php if (!empty($status_list)) {
                                                    foreach ($status_list as $stat) {
                                                        $selected = $stat == $status ? "selected" : "";
                                                        ?>
                                                        <option value="<?php echo $stat ?>" <?php echo $selected; ?>><?php echo $stat; ?></option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </div> -->
                                        <!-- <div class="form-group col-md-3 hidden">
                                            <button class="btn green btn-outline" type="submit"><i
                                                    class="fa fa-search"></i>Search</button>
                                        </div> -->
                                        
                                    </form>
                                    <div class="form-group col-md-3">
                                        <input class="form-control" id="searchStr" name="searchStr" type="text" placeholder="Search..." maxlength="100" value="<?php echo isset($searchStr) ? $searchStr : ""; ?>">
                                    </div>
                                    
                                    </div>
                                <br>
                                <br>
                                <div class="col-md-12">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"
                                        style="background-color: #f9f9f9;">
                                        <?php
                                        if (!empty($faq_list)) {
                                            foreach ($faq_list as $key => $faq) {
                                                $faq_det_mstr_name = $faq['faq_det_mstr_name'];
                                                $faq_det_questn = $faq['faq_det_questn'];
                                                $faq_det_answers = $faq['faq_answers'];
                                                $id = "collapse" . $key;
                                                ?>
                                                <div class="panel panel-default" id="panel-default">
                                                    <div class="panel-heading" role="tab" id="heading<?php echo $key; ?>">
                                                        <h1 class="panel-title">
                                                            <a role="button" data-toggle="collapse" href="#<?php echo $id; ?>"
                                                                aria-expanded="false" aria-controls="<?php echo $id; ?>"
                                                                class="accordion-toggle">
                                                                <i class="fa fa-plus"></i>
                                                                <?php echo html_escape($faq_det_questn); ?>
                                                            </a>
                                                        </h1>
                                                    </div>
                                                    <div id="<?php echo $id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $key; ?>">
    <div class="panel-body">
        <?php
        // Load CodeIgniter URL helper if not already loaded
        $this->load->helper('url');

        $answers = isset($faq['faq_answers']) ? $faq['faq_answers'] : [];

        if (!empty($answers)) {
            echo '<ul>';
            foreach ($answers as $ans) {
                if (!empty($ans['faq_ans_det_answers'])) {
                    // Escape and auto-link URLs with target="_blank"
                    $safeText = html_escape($ans['faq_ans_det_answers']);
                    $linkedText = auto_link($safeText, 'both', true);
                    echo '<li>' . $linkedText . '</li>';
                }
            }
            echo '</ul>';
        } else {
            echo '<i>No answers available.</i>';
        }
        ?>
    </div>
</div>

                                                </div>
                                            <?php }
                                        } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.panel-title a').click(function (e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling

            var target = $($(this).attr('href'));
            var icon = $(this).find('i');

            setTimeout(function () { // Delay the check
                if (target.hasClass('in')) {
                    target.collapse('hide');
                } else {
                    $('.panel-collapse.in').collapse('hide');
                    target.collapse('show');
                }
            }, 10); // 10 millisecond delay
        });

        $('.panel-collapse').on('shown.bs.collapse', function () {
            $(this).prev('.panel-heading').find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        });

        $('.panel-collapse').on('hidden.bs.collapse', function () {
            $(this).prev('.panel-heading').find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        });
    });

</script>
<script>

    let search = document.getElementById('searchStr');
    console.log(search.value);
    
    search.addEventListener('keyup', function () {
    const searchText = this.value.toLowerCase();
    const panels = document.querySelectorAll('.panel-default');

    panels.forEach(panel => {
        const question = panel.querySelector('.panel-title')?.innerText.toLowerCase() || '';
        const answers = panel.querySelector('.panel-body')?.innerText.toLowerCase() || '';

        if (question.includes(searchText) || answers.includes(searchText)) {
            panel.style.display = '';
        } else {
            panel.style.display = 'none';
        }
    });
});
</script>
<style>
    .panel-group {
        font-size: 14px;
        font-weight: 400;
    }

    .panel-title a {
        font-size: 14px;
        font-weight: 400;
    }

    .panel-body {
        font-size: 15px;
        font-weight: 400;
    }
</style>