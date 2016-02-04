<?php
// Quick and dirty navigation.
$menu_item_default = 'magazine';
$menu_items = array(
  'magazine' => array(
    'label' => 'Manage Magazines',
    'segments' => 'magazine/index',
    'desc' => 'Manage all magazines',
  ),
  'user' => array(
    'label' => 'Manage Users',
    'segments' => 'user/manage',
    'desc' => 'Mangae all of site\'s users',
  ),
);

// Determine the current menu item.
$menu_current = $menu_item_default;
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($this->uri->segment(1), $menu_items)) {
  $menu_current = $this->uri->segment(1);
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>My Magazines | <?php echo html_escape($menu_items[$menu_current]['label']); ?></title>
        <meta name="description" content="<?php echo html_escape($menu_items[$menu_current]['desc']); ?>">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css">

        <script src="<?php echo base_url(); ?>js/vendor/modernizr-2.6.2.min.js"></script>
        
    </head>
    <body>
        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="collapse navbar-collapse">
                        <a class="navbar-brand" href="/Magazines">Magazine Collection</a>
                        <ul class="nav navbar-nav">
                          <?php
                          if($this->session->userdata('logged_type') === My_User::USER_TYPE_ADMIN){
                            foreach ($menu_items as $item => $item_data) {
                              echo '<li' . ($item == $menu_current ? ' class="active"' : '') . '>';
                              echo '<a href="'. base_url() .'index.php/' . $item_data['segments'] . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                              echo '</li>';
                            }
                          }
                          ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
                <?php echo $this->session->userdata('logged_id') ? '<p class="pull-right">Hello ' . $this->session->userdata('logged_username') . '<a href="'. base_url() .'index.php/user/logout/">, Logout</a>' . '</p>' : ''; ?>
            </div>
            
        </nav>

        <div class="container">