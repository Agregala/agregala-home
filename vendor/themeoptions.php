<!-- Bootstrap Core CSS -->
<link href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>

<h2>Theme Agrega.la</h2>
<form method="post" action="">
<div class="col-md-12">
  <div class="panel with-nav-tabs panel-default">
  <div class="panel-heading">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1default" data-toggle="tab">HEADER</a></li>
      <li><a href="#tab2default" data-toggle="tab">FOOTER</a></li>
      <li><a href="#tab3default" data-toggle="tab">TWITTER</a></li>
      <li><a href="#tab4default" data-toggle="tab">SEO</a></li>
    </ul>
  </div>
  <div class="panel-body">
    <div class="tab-content">
          <div class="tab-pane fade in active" id="tab1default">
            <fieldset style="border:1px solid #ddd; padding:20px; margin-top:20px;">
            <legend style="margin-left:5px; color:#2481C6;text-transform:uppercase;"><strong>HEADER</strong></legend>
              <table class="form-table">
                  
                  <tr>
                <th><label for="description">URL LOGO</label></th>
                <td>
                  <input name="url" id="url" class="col-xs-12" style=" width: 100%;height: 50px;box-sizing: border-box;-webkit-box-sizing:border-box;-moz-box-sizing: border-box;" value="<?php echo get_option('fullby_url'); ?>"></input>
                </td>
              </tr>
              <tr>
                <th><label for="description">TEXTO BOTÓN agrega.te</label></th>
                <td>
                  <input name="mensaje" id="mensaje" class="col-xs-12" style=" width: 100%;height: 50px;box-sizing: border-box;-webkit-box-sizing:border-box;-moz-box-sizing: border-box;" value="<?php echo get_option('fullby_mensaje'); ?>"></input>
                </td>
              </tr>
              <tr>
                <th><label for="description">URL IMAGEN HEADER</label></th>
                <td>
                  <input name="imagen-header" id="imagen-header" class="col-xs-12" style=" width: 100%;height: 50px;box-sizing: border-box;-webkit-box-sizing:border-box;-moz-box-sizing: border-box;" value="<?php echo get_option('fullby_imagen-header'); ?>"></input>
                </td>
              </tr>
                  
            </table>
            </fieldset>
          </div>
          <div class="tab-pane fade" id="tab2default">
              <fieldset style="border:1px solid #ddd; padding:20px; margin-top:20px;">
              <legend style="margin-left:5px; color:#2481C6;text-transform:uppercase;"><strong>FOOTER</strong></legend>
                <table class="form-table">
                    
                    <tr>
                  <th><label for="description">Footer Descripción</label></th>
                  <td>
                    <textarea name="footer-desc" id="footer-desc" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('fullby_footer-desc'); ?></textarea>
                  </td>
                </tr>
                <tr>
                  <th><label for="ads">Derechos</label></th>
                  <td>
                    <textarea name="derechos" id="derechos" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('fullby_derechos')); ?></textarea>
                  </td>
                </tr>
                <tr>
                  <th><label for="description">URL IMAGEN FOOTER</label></th>
                  <td>
                    <input name="footer-logo" id="footer-logo" class="col-xs-12" style=" width: 100%;height: 50px;box-sizing: border-box;-webkit-box-sizing:border-box;-moz-box-sizing: border-box;" value="<?php echo get_option('fullby_footer-logo'); ?>"></input>
                  </td>
                </tr>
                    
              </table>
              </fieldset>
          </div>

          <div class="tab-pane fade" id="tab3default">
           
              <fieldset style="border:1px solid #ddd; padding:20px; margin-top:20px;">
              <legend style="margin-left:5px; color:#2481C6;text-transform:uppercase;"><strong>TWITTER</strong></legend>
                <table class="form-table">
                    
                    <tr>
                      <th><label for="description">HASHTAG NOTICIAS</label></th>
                      <td>
                        <input name="hashtag" id="hashtag" class="col-xs-12" style=" width: 100%;height: 50px;box-sizing: border-box;-webkit-box-sizing:border-box;-moz-box-sizing: border-box;" value="<?php echo get_option('fullby_hashtag'); ?>"></input>
                    </td>
                    </tr>

                    <tr>
                      <th><label for="description">ACTUALIZAR NOTICIAS</label></th>
                      <td>
                          <input type="button" data-link="<?php echo bloginfo(url)."/twitter/"; ?>" id="mandar" name="actualiza" class="button-primary" value="ACTUALIZAR TWEETS" />
                          <div id="capa"></div>
                          <br>***** Debes tener una Page creada con el nombre de Twitter.
                    </td>
                    </tr>
                    
              </table>
              </fieldset>


                
                
          </div>

          <div class="tab-pane fade" id="tab4default">
         
              <fieldset style="border:1px solid #ddd; padding:20px; margin-top:20px;">
              <legend style="margin-left:5px; color:#2481C6;text-transform:uppercase;"><strong>SEO</strong></legend>
                <table class="form-table">
                    
                    <tr>
                  <th><label for="description">Meta Description</label></th>
                  <td>
                    <textarea name="description" id="description" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('fullby_description'); ?></textarea>
                  </td>
                </tr>
                <tr>
                  <th><label for="ads">Google Analytics code:</label></th>
                  <td>
                    <textarea name="analytics" id="analytics" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('fullby_analytics')); ?></textarea>
                  </td>
                </tr>
                    
              </table>
              </fieldset>
      
          </div>
    </div>
  </div>
  </div>
    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
      <input type="hidden" name="fullby_settings" value="save" style="display:none;" />
    </p>

</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $("#mandar").click(function(event) {
    $("#capa").load($("#mandar").attr("data-link"));
    setTimeout(function() {
        $("#capa").empty();
    },5000);
  });
});

</script>