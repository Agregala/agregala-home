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
            var reg = $('#colec').val();
            $('#colectivosTotales').html(reg);
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
                                    $totalPosts = 0;
                                    $totalsitios = 0;
                                    foreach ($blogs AS $blog)
                                    {   
                                        $totalsitios++;
                                        switch_to_blog($blog["blog_id"]);
                                        
                                        $blog_details = get_blog_details($blog["blog_id"]);
                                        
                                        if($blog_details->blog_id >1) //entrar a cada sitio menos al principal
                                        {
                                            // get_categories args
                                            $args = array(
                                                'hide_empty' => true
                                            );

                                            $categories = get_categories( $args );

                                            foreach ( $categories as $category ) {
                                                $totalColectivos++;
                                            }
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
                global $wpdb; // var global para hacer queries

                $blogs          = get_last_updated(); // listar todos los hijos del multisitio
                $data           = array();
                $dataCate       = array();
                $nestedDataCate = array();
                $nestedData     = array();
                $json_data      = array();

                foreach ($blogs AS $blog)
                {   
                    switch_to_blog($blog["blog_id"]);

                    $blog_details = get_blog_details($blog["blog_id"]);
                    if($blog_details->blog_id >1) //entrar a cada sitio menos al principal
                    {
                        //echo $blog_details->blog_id."<br>";
                        $ide = $blog_details->blog_id;
                        $url_site = $blog_details->siteurl;
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
                            $url_meta = $wpdb->get_var( $wpdb->prepare( 
                                "
                                    SELECT meta_value 
                                    FROM $wpdb->postmeta 
                                    WHERE meta_key = '_wp_attached_file' and post_id = %s
                                ", 
                                $meta_key
                            ) );
                            //echo $featured_img_url = get_post_meta( $posty, 'syndication_permalink', true );
                            if($url_meta != "")
                            {
                                //$url_site.
                                //echo $meta_key.esc_url_raw($generaUrl)."<br>";
                                // aqui va el loop
                            }
                        endforeach;
                    }
                    restore_current_blog(); // fin del recorrido de los sitios del multisitio 
                }
                /** crear json final **/
                echo json_encode($json_data);  // send data as json format
            ?>
                <!-- end posts -->
				<div class="grid__item" data-size="1280x857">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/6.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/6.jpg" alt="img06" />
						<div class="description description--grid">
							<h3>Mother's Love</h3>
							<p>Every time you drink a glass of milk or eat a piece of cheese, you harm a mother. Please go vegan. <em>&mdash; Gary L. Francione</em></p>
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
				<div class="grid__item" data-size="1280x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/7.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/7.jpg" alt="img07" />
						<div class="description description--grid">
							<h3>Silent Killer</h3>
							<p>Cows’ milk protein may be the single most significant chemical carcinogen to which humans are exposed. <em>&mdash; T. Colin Campbell</em></p>
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
				<div class="grid__item" data-size="1280x853">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/8.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/8.jpg" alt="img08" />
						<div class="description description--grid">
							<h3>Senseless Suffering</h3>
							<p>The question is not, 'Can they reason?' nor, 'Can they talk?' but rather, 'Can they suffer?' <em>&mdash; Jeremy Bentham</em></p>
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
				<div class="grid__item" data-size="865x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/9.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/9.jpg" alt="img09" />
						<div class="description description--grid">
							<h3>Rabbit Intelligence</h3>
							<p>If a rabbit defined intelligence the way man does, then the most intelligent animal would be a rabbit, followed by the animal most willing to obey the commands of a rabbit. <em>&mdash; Robert Brault</em></p>
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
				<div class="grid__item" data-size="1280x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/10.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/10.jpg" alt="img10" />
						<div class="description description--grid">
							<h3>Friendly Terms</h3>
							<p>Man is the only animal that can remain on friendly terms with the victims he intends to eat until he eats them. <em>&mdash; Samuel Butler</em></p>
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
				<div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
				<div class="grid__item" data-size="1280x853">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/1.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/1.jpg" alt="img01" />
						<div class="description description--grid">
							<h3>Highest Ethics</h3>
							<p>Non-violence leads to the highest ethics, which is the goal of all evolution. Until we stop harming all other living beings, we are still savages <em>&mdash; Thomas Edison</em></p>
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
				<div class="grid__item" data-size="958x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/2.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/2.jpg" alt="img02" />
						<div class="description description--grid">
							<h3>Pleasure, Amusement &amp; Convenience</h3>
							<p>We do not need to eat animals, wear animals, or use animals for entertainment purposes, and our only defense of these uses is our pleasure, amusement, and convenience.<em>&mdash; Gary L. Francione</em></p>
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
				<div class="grid__item" data-size="837x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/3.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/3.jpg" alt="img03" />
						<div class="description description--grid">
							<h3>Dinner</h3>
							<p>We all love animals. Why do we call some 'pets' and others 'dinner'? <em>&mdash; K.D. Lang</em></p>
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
				<div class="grid__item" data-size="1280x961">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/4.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/4.jpg" alt="img04" />
						<div class="description description--grid">
							<h3>Appetite or Suffering?</h3>
							<p>Could you look an animal in the eyes and say to it, 'My appetite is more important than your suffering'? <em>&mdash; Moby</em></p>
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
				<div class="grid__item" data-size="1280x1131">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/5.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/5.jpg" alt="img05" />
						<div class="description description--grid">
							<h3>The Corpse</h3>
							<p>Recognize meat for what it really is: the antibiotic- and pesticide-laden corpse of a tortured animal. <em>&mdash; Ingrid Newkirk</em></p>
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
				<div class="grid__item" data-size="1280x857">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/6.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/6.jpg" alt="img06" />
						<div class="description description--grid">
							<h3>Mother's Love</h3>
							<p>Every time you drink a glass of milk or eat a piece of cheese, you harm a mother. Please go vegan. <em>&mdash; Gary L. Francione</em></p>
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
				<div class="grid__item" data-size="1280x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/7.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/7.jpg" alt="img07" />
						<div class="description description--grid">
							<h3>Silent Killer</h3>
							<p>Cows’ milk protein may be the single most significant chemical carcinogen to which humans are exposed. <em>&mdash; T. Colin Campbell</em></p>
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
				<div class="grid__item" data-size="1280x853">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/8.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/8.jpg" alt="img08" />
						<div class="description description--grid">
							<h3>Senseless Suffering</h3>
							<p>The question is not, 'Can they reason?' nor, 'Can they talk?' but rather, 'Can they suffer?' <em>&mdash; Jeremy Bentham</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
                <div class="grid__item" data-size="1280x850">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/11.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/11.jpg" alt="img11" />
						<div class="description description--grid">
							<h3>Murder of Men</h3>
							<p>The time will come when men such as I will look upon the murder of animals as they now look upon the murder of men.<em>&mdash; Leonardo Da Vinci</em></p>
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
				<div class="grid__item" data-size="865x1280">
					<a href="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/original/9.jpg" class="img-wrap"><img src="<?php echo get_stylesheet_directory_uri(); ?>/mosaico/img/thumbs/9.jpg" alt="img09" />
						<div class="description description--grid">
							<h3>Rabbit Intelligence</h3>
							<p>If a rabbit defined intelligence the way man does, then the most intelligent animal would be a rabbit, followed by the animal most willing to obey the commands of a rabbit. <em>&mdash; Robert Brault</em></p>
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
