<h2>All Users</h2>
<?php 
$template = array('table_open' => '<table class="table table-striped tablesorter" id="myTable">');
$this->table->set_template($template);
$this->table->set_heading('id', 'username', 'Frist Name', 'Last Name', 'Actions'); 
echo $this->table->generate($users);