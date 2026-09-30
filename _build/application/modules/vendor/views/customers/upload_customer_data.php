<div class="page-content-wrapper">
    <div class="page-content upload-data-page">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered upload-data-portlet">
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo base_url(get_module() . '/dashboard'); ?>">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li><span class="active">Upload Data</span></li>
                    </ul>
<!--- commmnetd by anjalli on 17-07-2026--->
                    <!-- 
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-cloud-upload font-red-mint"></i>
                            <span class="caption-subject font-red-mint bold">Upload Data</span>
                        </div>
                    </div>
                    -->

                    <div class="portlet-body">
                        <div class="upload-intro">
                            <div class="upload-intro-copy">
                                <h2>Bulk import your business data</h2>
                                <p>Download the matching sample, keep its column headings unchanged, then select your completed file.</p>
                            </div>
                            <div class="upload-format-list" aria-label="Upload requirements">
                                <span><i class="fa fa-file-excel-o" aria-hidden="true"></i> CSV, XLS or XLSX</span>
                                <span><i class="fa fa-file-text-o" aria-hidden="true"></i> One file at a time</span>
                            </div>
                        </div>

                        <!-- Added by Anjali 14/07/26: Displays the shared upload requirements above all import cards. -->
                        <section class="upload-common-instructions" aria-labelledby="common-upload-instructions-title">
                            <div class="upload-common-instructions-header">
                                <span class="upload-common-instructions-icon">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                </span>
                                <div>
                                    <h3 id="common-upload-instructions-title">Common Upload Instructions</h3>
                                    <p>Follow these requirements before uploading any data file.</p>
                                </div>
                            </div>
                            <ul>
                                <?php foreach ($common_instructions as $instruction): ?>
                                    <li>
                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                        <span><?php echo html_escape($instruction); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </section>

                        <?php if ($success_message !== ''): ?>
                            <div class="alert alert-success alert-dismissable upload-page-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                <span><?php echo html_escape($success_message); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($upload_error_message !== ''): ?>
                            <div class="alert alert-danger alert-dismissable upload-page-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                <span><?php echo html_escape($upload_error_message); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($import_error_count > 0): ?>
                            <section class="upload-error-panel" aria-labelledby="upload-error-title">
                                <div class="upload-error-heading">
                                    <div>
                                        <span class="upload-error-icon">
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        </span>
                                        <div class="upload-error-copy">
                                            <h3 id="upload-error-title">Data File not Uploaded. Check Following Errors.</h3>
                                            <p><?php echo html_escape($error_import_title); ?> has row issues. Correct the rows listed below and upload the file again.</p>
                                        </div>
                                    </div>
                                    <span class="upload-error-count">
                                        <?php echo $import_error_count; ?> issue<?php echo $import_error_count === 1 ? '' : 's'; ?>
                                    </span>
                                </div>

                                <div class="table-responsive upload-error-table-wrap">
                                    <table class="table table-striped table-hover upload-error-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sr.No</th>
                                                <th scope="col">Record</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Message</th>
                                                <th scope="col">Line</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($import_errors as $error): ?>
                                                <tr>
                                                    <td><?php echo $error['number']; ?></td>
                                                    <td><?php echo html_escape($error['record_name']); ?></td>
                                                    <td>
                                                        <span class="label label-danger upload-error-type">
                                                            <?php echo html_escape($error['error_type']); ?>
                                                        </span>
                                                    </td>
                                                    <td class="upload-error-message"><?php echo html_escape($error['error_text']); ?></td>
                                                    <td>
                                                        <span class="badge badge-info"><?php echo html_escape($error['line_number']); ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        <?php endif; ?>

                        <div class="row upload-card-row">
                            <?php foreach ($imports as $import): ?>
                                <div class="col-lg-6 col-md-6 col-sm-12 upload-card-column">
                                    <section
                                        class="upload-card<?php echo $import['has_error'] ? ' has-import-error' : ''; ?>"
                                        id="upload-<?php echo html_escape($import['key']); ?>"
                                        data-import="<?php echo html_escape($import['key']); ?>"
                                    >
                                        <div class="upload-card-header">
                                            <span class="upload-card-icon">
                                                <i class="fa <?php echo html_escape($import['icon']); ?>" aria-hidden="true"></i>
                                            </span>
                                            <div>
                                                <h3><?php echo html_escape($import['title']); ?></h3>
                                                <p><?php echo html_escape($import['description']); ?></p>
                                            </div>
                                        </div>

                                        <?php if (!empty($import['instructions'])): ?>
                                            <div class="upload-instruction-block">
                                                <button
                                                    type="button"
                                                    class="upload-instruction-toggle"
                                                    aria-expanded="false"
                                                    aria-controls="<?php echo html_escape($import['instruction_id']); ?>"
                                                >
                                                    <span>
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        View instructions
                                                    </span>
                                                    <i class="fa fa-chevron-down upload-instruction-arrow" aria-hidden="true"></i>
                                                </button>
                                                <div
                                                    class="upload-instruction-panel"
                                                    id="<?php echo html_escape($import['instruction_id']); ?>"
                                                    hidden
                                                >
                                                    <ul>
                                                        <?php foreach ($import['instructions'] as $instruction): ?>
                                                            <li><?php echo html_escape($instruction); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php echo form_open_multipart($import['action'], $import['form_attributes'], $form_hidden); ?>
                                            <div class="upload-file-control">
                                                <input
                                                    type="file"
                                                    name="data_file"
                                                    id="<?php echo html_escape($import['input_id']); ?>"
                                                    class="upload-file-input"
                                                    accept=".csv,.xls,.xlsx"
                                                    data-max-size="<?php echo $max_upload_bytes; ?>"
                                                    data-max-size-label="<?php echo html_escape($max_upload_label); ?>"
                                                    aria-describedby="<?php echo html_escape($import['help_id'] . ' ' . $import['error_id']); ?>"
                                                    required
                                                >
                                                <label
                                                    class="upload-drop-zone"
                                                    for="<?php echo html_escape($import['input_id']); ?>"
                                                    tabindex="0"
                                                >
                                                    <span class="upload-drop-icon">
                                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                                    </span>
                                                    <span class="upload-file-copy">
                                                        <strong class="upload-file-name">Choose a file</strong>
                                                        <small
                                                            id="<?php echo html_escape($import['help_id']); ?>"
                                                            class="upload-file-help"
                                                        >or drag and drop it here</small>
                                                    </span>
                                                    <span class="upload-browse-text">Browse</span>
                                                </label>
                                                <p
                                                    class="upload-file-error"
                                                    id="<?php echo html_escape($import['error_id']); ?>"
                                                    role="alert"
                                                    aria-live="polite"
                                                ></p>
                                            </div>

                                            <div class="upload-card-actions">
                                                <a
                                                    class="btn btn-default upload-sample-btn"
                                                    href="<?php echo html_escape($import['sample']); ?>"
                                                    title="Download <?php echo html_escape($import['title']); ?> sample"
                                                >
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                    Download Sample
                                                </a>
                                                <button class="btn btn-success upload-submit-btn" type="submit">
                                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                                    <span>Upload File</span>
                                                </button>
                                            </div>
                                        <?php echo form_close(); ?>
                                    </section>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
