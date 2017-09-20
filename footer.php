    <!-- Footer -->
    <footer  class="text-center">
        <div class="footer-above">
            <div class="container sin-padding">
                <div class="col-xs-12 sin-padding">
                    
                    
                </div>
            </div>
        </div>
        <div id="page-bottom" class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <?php echo get_option('fullby_derechos');?>
                    </div>
                </div>
            </div>
        </div>
    </footer>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>


    <?php wp_footer();?>
    <script>
    // A $( document ).ready() block.
    $( document ).ready(function() {
        $( "#target" ).click(function() {
            var myselect = $( "#myselect option:selected" ).val();
            if(myselect!="Selecciona una región"){
                $(location).attr('href',myselect);
            }
        });
        $( "#myselect" ).change(function() {
            var barks = $(this).children('option:selected').data('back');
            $(this).css('background', 'url(' + barks + ')');
        });
    });
    </script>
    
  </body>
</html>

        