<div class="magazine">
    <div class="name">
        <?php echo html_escape($publication->publication_name); ?>
        #<?php echo html_escape($issue->issue_number); ?>
    </div>
    <div class="date">
        <?php 
            $this->load->helper('date');
            $unix_publication_date = human_to_unix($issue->issue_date_publication . ' 00:00:00');
            echo standard_date('DATE_COOKIE', $unix_publication_date);
        ?>
    </div>
    <?php if ($issue->issue_cover){ ?>
        <div>
            <?php echo img('upload/' . $issue->issue_cover);?>
        </div>
    <?php } ?>
</div>