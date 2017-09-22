<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>mosaico</title> 
        <link rel="stylesheet" type="text/css" href="http://agrega.la/wp-content/themes/agrega.la-home/mosaico/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="http://agrega.la/wp-content/themes/agrega.la-home/mosaico/css/style.css" />
		<script type="text/javascript" src="mosaico/js/modernizr.custom.26633.js"></script>
		<noscript>
			<link rel="stylesheet" type="text/css" href="http://agrega.la/wp-content/themes/agrega.la-home/mosaico/css/fallback.css" />
		</noscript>
		<!--[if lt IE 9]>
			<link rel="stylesheet" type="text/css" href="http://agrega.la/wp-content/themes/agrega.la-home/mosaico/css/fallback.css" />
		<![endif]-->
    </head>
    <body>
		<div class="container">
			
			
			
			<section class="main">

				<div id="ri-grid" class="ri-grid ri-grid-size-3">
					<img class="ri-loading-image" src="http://agrega.la/wp-content/themes/agrega.la-home/mosaico/images/loading.gif"/>
					<ul>
						<?php 
                            $json = file_get_contents('http://agrega.la/api/');
                            $array = json_decode($json);
                            $contador = 0;
                            foreach ($array as $value) { 
                                $arrayInt = $value->posts;
                                foreach ($arrayInt as $valueInt) {
                                    $contador = $contador+1;
                                    if($contador<56){
                                        $file_headers = @get_headers($valueInt->url_image);
                                        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
                                            $exists = false;
                                        }
                                        else {
                                            $exists = true;
                                        }
                                        if($exists==1){ ?>
                                            <li style='width: 180px; height: 180px;'><a href='#'><img src='<?php echo $valueInt->url_image; ?>' /></a></li>
                                       <?php }
                                    }
                                    
                                }
                            }
                        ?>
                    </ul>
				</div>
				
				

			</section>
			
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://agrega.la/wp-content/themes/agrega.la-home/mosaico/js/jquery.gridrotator.js"></script>
		<script type="text/javascript">	
            $( document ).ready(function() {
			$(function() {
			
				$( '#ri-grid' ).gridrotator( {
					rows : 4,
					columns : 8,
					maxStep : 2,
					interval : 2000,
					w1024 : {
						rows : 5,
						columns : 6
					},
					w768 : {
						rows : 5,
						columns : 5
					},
					w480 : {
						rows : 6,
						columns : 4
					},
					w320 : {
						rows : 7,
						columns : 4
					},
					w240 : {
						rows : 7,
						columns : 3
					},
				} );
			
			});
            });
		</script>
    </body>
</html>