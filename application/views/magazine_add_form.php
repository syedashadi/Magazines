<?php echo validation_errors(); ?>
<?php echo $this->upload->display_errors('<div class="alert alert-error">', '</div>'); ?>
<?php echo form_open_multipart(); ?>
    <div class="form-group<?php echo form_error('publication_id') ? ' has-error' : ''; ?>">
        <?php echo form_label('Publication Name', 'publication_id'); ?>
        <?php echo form_dropdown('publication_id', $publication_form_options, set_value('publication_id')); ?>
    </div>
    <div class="form-group<?php echo form_error('issue_number') ? ' has-error' : ''; ?>">
        <?php echo form_label('Issue Number', 'issue_number', array('class' => 'control-label')); ?>
        <?php echo form_input('issue_number', set_value('issue_number'), 'class="form-control"'); ?>
    </div>
    <div class="form-group<?php echo form_error('issue_number') ? ' has-error' : ''; ?>">
        <?php echo form_label('Publication Date', 'issue_date_publication', array('class' => 'control-label')); ?>
        <?php echo form_input('issue_date_publication', set_value('issue_date_publication'), 'class="form-control"'); ?>
    </div>
    <div class="form-group<?php echo form_error('issue_number') ? ' has-error' : ''; ?>">
        <?php echo form_label('Select Cover', 'issue_cover', array('class' => 'control-label')); ?>
        <?php echo form_upload('issue_cover'); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Save'); ?>
    </div>
<?php echo form_close(); ?>