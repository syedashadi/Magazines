<div id="add_containter" class="btn btn-default pull-right" role="button">
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  <?php echo anchor('magazine/add', 'Add new magazine'); ?>
</div>

<h2>My Magazines</h2>

<?php 
$template = array('table_open' => '<table class="table table-striped tablesorter" id="myTable">');
$this->table->set_template($template);
$this->table->set_heading('Issue id', 'Publication', 'Issue Number', 'Issue Date', 'Cover', 'Actions'); 
echo $this->table->generate($magazines);

?>


<ul class="pagination">
  <li><a href="#"><?php echo $this->pagination->create_links();?></a></li>
</ul>



