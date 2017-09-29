<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agrega.la | Contando voces comunitarias</title>
	<meta name="description" content="Contando voces comunitarias" />
	<meta name="keywords" content="agrega.la, voces, comunitarias, medios, medios independientes, noticias, blog, facebook, twitter, rss" />
	<meta name="author" content="Team Agrega.la" />
    <link rel="icon" href="http://agrega.la/wp-content/themes/agregala-site/img/favicon.png" type="image/x-icon">
    
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/freelancer.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/css/normalize.css" />
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/css/demo.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/css/style2.css" />
	<script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/modernizr-custom.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory'); ?>/mosaico/js/odometer.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/mosaico/fonts/font-awesome-4.3.0/css/font-awesome.min.css" />
    <script>
        $( document ).ready(function() {
            $.getJSON('http://agrega.la/api', function(data) {
                var json = jQuery.parseJSON(JSON.stringify(data));
                console.log(json.length);
                var totoa = json.length-1;
                setTimeout(function(){
                    var post = json[totoa].totalNot;
                    $('#noticiasTotales').html(post);

                    var colec = json[totoa].totalCol;
                    $('#colectivosTotales').html(colec);
                }, 1000);
            });
        });
    </script>
</head>

<body>
	<div class="container">
        <div class="col-xs-12">
            <div id="left-div-mos" class="col-xs-12">
                <img class="logo-header" src="<?php bloginfo('stylesheet_directory'); ?>/img/logo.png" alt="Logo agregala"/>
                <div id="mobile-sile" style="text-align: center;margin: 20px auto;">
                    <span id="noticiasTotales" class="odometer">00</span> <span class="deslizar desliz">noticias agregadas de </span><span id="colectivosTotales" class="odometer">00</span> <span class="deslizar roat">medios libres.</span>
                </div>
                <div id="bajartop" class="col-xs-12">
                    <?php 
                        wp_reset_query();
                        global $switched;

                        $blog_id = get_current_blog_id();


                        $geturl = "http://agrega.la/api";
                        $obj = json_decode(file_get_contents($geturl), true);
                        $totalobjetos = count($obj)-1; 

                        $nuevototales = count($obj[$totalobjetos]['totalsitio']);

                        for($r=0;$r<$nuevototales;$r++){
                            //echo "sitio actual: ".$blog_id."<br>";
                            //echo "otro sitio: ".$obj[$totalobjetos]['totalsitio'][$r];
                            if($blog_id!=$obj[$totalobjetos]['totalsitio'][$r]){

                                    switch_to_blog($obj[$totalobjetos]['totalsitio'][$r]); //switched to blog id 2

                                    $blog_details = get_blog_details($obj[$totalobjetos]['totalsitio'][$r]);
                                    $url_site = $blog_details->siteurl;
                                    $blogname = $blog_details->blogname;
                                    //echo '<div class="col-sm-4 sitio-cont"><h3><a href="'.$url_site.'"><img src="http://agrega.la/wp-content/themes/agregala-home/img/flat_'.$blogname.'" /><span class="span-mosaico ">'.$blogname.'</span></a></h3></div>;'
                                    //echo '<div class="col-sm-6 sitio-cont"><h3><a href="'.$url_site.'">'.$blogname.'</a></h3></div>';
                                    echo '<div class="backing1 col-sm-4 sitio-cont" style="background-image: url(http://agrega.la/wp-content/themes/agregala-home/img/back_'.$blogname.'.jpg);">';
                                        echo '<div class="cover-sombra"></div>';
                                        echo '<div class="mandar-arriba">';
                                            echo '<h3>';
                                                echo '<a href="#">';
                                                    echo '<img src="http://agrega.la/wp-content/themes/agregala-home/img/flat_'.$blogname.'.png" />';
                                                    echo '<span class="span-mosaico ">'.$blogname.'</span>';
                                                echo '</a>';
                                            echo '</h3>';
                                        echo '</div>';
                                    echo '</div>';
                                    restore_current_blog();
                                }
                        }
                        wp_reset_query();
                    ?>
                    
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
	</div>
<div id="mosaico-mobile" class="container" style="width: 75%;    margin: 0 auto;   ">
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
                            $blogname = $blog_details->blogname;
                            $args = array(
                                'orderby'          => ID,
                                'order'            => 'DESC',
                                'post_type'        => 'attachment',
                                'post_status'      => 'inherit',
                                'numberposts'      => 40
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
                                if( ($url_meta != "") and ($contador_posts<43) )
                                {
                                    $generaUrl = "http://agrega.la/wp-content/uploads/sites/".$blog["blog_id"]."\/".$url_meta;
                                    //$generaUrl = "http://agrega.la/wp-content/uploads/sites/5\/2017/09/fb_image_tmp-32391.jpg";
                                ?>
                                <div class="grid__item" data-size="1280x857">
                                    <div class="overlay"></div>
                                    <a href="<?php echo $generaUrl; ?>" class="img-wrap"><img src="<?php echo $generaUrl; ?>" alt="image noticia" />
                                        <div class="description description--grid">
                                            <h3><?php the_title(); ?></h3>
                                            <p><?php echo $url_site; ?> <em>&mdash; <?php echo $blogname;?></em></p>
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
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
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
