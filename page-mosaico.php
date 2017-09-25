<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agrega.la | mosaico</title>
	<meta name="description" content="Contando voces comunitarias" />
	<meta name="keywords" content="agrega.la, voces, comunitarias, medios, medios independientes, noticias, blog, facebook, twitter, rss" />
	<meta name="author" content="Team Agrega.la" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/fonts/font-awesome-4.3.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/css/demo.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/css/style2.css" />
	<script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/modernizr-custom.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/odometer.min.js"></script>
    <script>
        setTimeout(function(){
            var reg = $('#reg').val();
            $('#regionesTotales').html(reg);
            
            var post = $('#post').val();
            $('#noticiasTotales').html(post);
            
            var colec = $('#colec').val();
            $('#colectivosTotales').html(colec);
        }, 1000);
    </script>
</head>

<body class="demo-2">
	<div class="container">
		<div class="content">
            <header>
                <img class="logo-header" src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/img/logo.png" alt="Logo agregala"/>
                <h1>Contando voces comunitarias</h1>
                <div>
                    <div class="container">
                        <div class="row">
                            <div class="numerologia text-center">
                                <?php
                                    global $wpdb; // var global para hacer queries
                                
                                    $blogs = get_last_updated(); // listar todos los hijos del multisitio
                                    $totalColectivos = 0;
                                    $total_osts = 0;
                                    $totalsitios = 0;
                                    foreach ($blogs AS $blog)
                                    {   
                                        switch_to_blog($blog["blog_id"]);
                                        
                                        $blog_details = get_blog_details($blog["blog_id"]);
                                        
                                        if($blog_details->blog_id >1) //entrar a cada sitio menos al principal
                                        {
                                            $totalsitios++;
                                            // get_categories args
                                            $args = array(
                                                'hide_empty' => true
                                            );

                                            $categories = get_categories( $args );

                                            foreach ( $categories as $category ) {
                                                $totalColectivos++;
                                            }
                                            // end categories
                                            
                                            $args = array(
                                                'orderby'          => ID,
                                                'order'            => 'DESC',
                                                'post_type'        => 'attachment',
                                                'post_status'      => 'inherit',
                                                'numberposts'      => -1
                                            );
                                            $lastposts = get_posts($args); //obtener los posts del sitio hijo

                                            /** recorrido para indexar posts **/
                                            foreach($lastposts as $post) :
                                                $meta_key = get_the_ID();
                                                $total_osts++;
                                            endforeach;
                                        }  
                                    }
                                    
                                    // end total de colectivo
                                    restore_current_blog(); // fin del recorrido de los sitios del multisitio 
                                ?>
                                <section id="content">
                                    <h2>Regiones agregadas</h2>
                                    <div id="regionesTotales" class="odometer">00</div>
                                    <input class="escondido" name="reg" id="reg" value="<?php echo $totalsitios;?>" />
                                </section>

                                <section id="middle">
                                    <h2>Número de noticas</h2>
                                    <div id="noticiasTotales" class="odometer">00</div>
                                    <input class="escondido" name="post" id="post" value="<?php echo $total_osts;?>" />
                                </section>

                                <section id="sidebar">
                                    <h2>Colectivos agregados</h2>
                                    <div id="colectivosTotales" class="odometer">00</div>
                                    <input class="escondido" name="colec" id="colec" value="<?php echo $totalColectivos;?>" />
                                </section>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </header>
			<div class="grid">
                <!-- Obtener posts -->
                <?php
                wp_reset_query();
                wp_reset_postdata();
                rewind_posts();
                global $wpdb; // var global para hacer queries
                
                $contador_posts = 0;
                
                $blogsie = get_last_updated(); // listar todos los hijos del multisitio

                foreach ($blogsie AS $blog)
                {   
                    switch_to_blog($blog["blog_id"]);

                    $blog_details = get_blog_details($blog["blog_id"]);
                    if($blog_details->blog_id >1) //entrar a cada sitio menos al principal
                    {
                        //echo $blog_details->blog_id."<br>";
                        $ide = $blog_details->blog_id;
                        $url_site = $blog_details->siteurl;
                        $args = array(
                            'orderby'          => 'rand',
                            'post_type'        => 'attachment',
                            'post_status'      => 'inherit',
                            'numberposts'      => 32
                        );
                        $lastposts = get_posts($args); //obtener los posts del sitio hijo
                       
                        /** recorrido para indexar posts **/
                        foreach($lastposts as $post) :
                            $meta_key = get_the_ID();
                            $url_meta = $wpdb->get_var( $wpdb->prepare( 
                                "
                                    SELECT meta_value 
                                    FROM $wpdb->postmeta 
                                    WHERE meta_key = '_wp_attached_file' and post_id = %s
                                ", 
                                $meta_key
                            ) );
                            $contador_posts ++;
                            //echo $featured_img_url = get_post_meta( $posty, 'syndication_permalink', true );
                            if( ($url_meta != "") and ($contador_posts<32) )
                            {
                                $generaUrl = "http://agrega.la/wp-content/uploads/sites/".$blog["blog_id"]."\/".$url_meta;
                            ?>
                            <div class="grid__item" data-size="1280x857">
                                <a href="<?php echo $generaUrl; ?>" class="img-wrap"><img src="<?php echo $generaUrl; ?>" alt="image noticia" />
                                    <div class="description description--grid">
                                        <h3>Título</h3>
                                        <p>resumen <em>&mdash; Gsitio</em></p>
                                        <div class="details">
                                            <ul>
                                                <li><i class="icon icon-camera"></i><span>Canon PowerShot S95</span></li>
                                                <li><i class="icon icon-focal_length"></i><span>22.5mm</span></li>
                                                <li><i class="icon icon-aperture"></i><span>&fnof;/5.6</span></li>
                                                <li><i class="icon icon-exposure_time"></i><span>1/1000</span></li>
                                                <li><i class="icon icon-iso"></i><span>80</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php }
                        endforeach;
                    }
                    restore_current_blog(); // fin del recorrido de los sitios del multisitio 
                }
            ?>
                <!-- end posts -->
			</div>
			<!-- /grid -->
			<div class="preview">
				<button class="action action--close"><i class="fa fa-times"></i><span class="text-hidden">Close</span></button>
				<div class="description description--preview"></div>
			</div>
			<!-- /preview -->
		</div>
        <div id="temario">
            <div class="container no-padding">
                <div class="container-temario-interno">
                    <h2>Sitios <span>agregados:</span></h2>
                </div>
            </div>
        </div>
        <footer class="text-center">
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
                            Todos los contenidos encontrados en esta página son propiedad de cada medio/ colectivo.                    </div>
                    </div>
                </div>
            </div>
        </footer>
		<!-- /content -->
	</div>
    
	<!-- /container -->
	<script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/imagesloaded.pkgd.min.js"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/masonry.pkgd.min.js"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/classie.js"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/main.js"></script>
	<script>
		(function() {
			var support = { transitions: Modernizr.csstransitions },
				// transition end event name
				transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
				transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
				onEndTransition = function( el, callback ) {
					var onEndCallbackFn = function( ev ) {
						if( support.transitions ) {
							if( ev.target != this ) return;
							this.removeEventListener( transEndEventName, onEndCallbackFn );
						}
						if( callback && typeof callback === 'function' ) { callback.call(this); }
					};
					if( support.transitions ) {
						el.addEventListener( transEndEventName, onEndCallbackFn );
					}
					else {
						onEndCallbackFn();
					}
				};

			new GridFx(document.querySelector('.grid'), {
				imgPosition : {
					x : -0.5,
					y : 1
				},
				onOpenItem : function(instance, item) {
					instance.items.forEach(function(el) {
						if(item != el) {
							var delay = Math.floor(Math.random() * 50);
							el.style.WebkitTransition = 'opacity .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1), -webkit-transform .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1)';
							el.style.transition = 'opacity .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1), transform .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1)';
							el.style.WebkitTransform = 'scale3d(0.1,0.1,1)';
							el.style.transform = 'scale3d(0.1,0.1,1)';
							el.style.opacity = 0;
						}
					});
				},
				onCloseItem : function(instance, item) {
					instance.items.forEach(function(el) {
						if(item != el) {
							el.style.WebkitTransition = 'opacity .4s, -webkit-transform .4s';
							el.style.transition = 'opacity .4s, transform .4s';
							el.style.WebkitTransform = 'scale3d(1,1,1)';
							el.style.transform = 'scale3d(1,1,1)';
							el.style.opacity = 1;

							onEndTransition(el, function() {
								el.style.transition = 'none';
								el.style.WebkitTransform = 'none';
							});
						}
					});
				}
			});
		})();
	</script>
</body>

</html>
