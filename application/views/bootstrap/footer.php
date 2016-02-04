<?php
//$parent_dots = "";
//for($i=0; $i<$this->uri->total_segments(); $i++){
//    $parent_dots .= "../";
//}
?>
<hr>

            <footer style="text-align: center; font-weight: bold;">
                <p>&copy; Yahia Allam 2015</p>
            </footer>

        </div> <!-- /container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-2.1.3.min.js"><\/script>')</script>

        <script src="<?php echo base_url(); ?>js/vendor\bootstrap.min.js"></script>

        <script src="<?php echo base_url(); ?>js/main.js"></script>
        
        <script src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
        <?php
        /**
         * This script is used with magazines view to sort magazines table
         */
        ?>
        <script type="text/javascript">
    
            $(document).ready(function() 
            { 
                $("#myTable").tablesorter({sortList:[[1,0]], widgets: ['zebra']}); 
            } 
            ); 
        </script>
    </body>
</html>
