<?php get_header(); ?>
<div id="container-home">		
	<div class="container sin-padding">
		<div class="content-img">
			<img class="logo-home" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" alt="Logo header">
			<p>Agrega.la es una plataforma digital libre y abierta que reúne y difunde los contenidos de medios de comunicación independientes y de colectivos de diferentes puntos de Latinoamérica.
				<br><span>¡ Entra y entérate !</span></p>	
			<select name="myselect" id="myselect">
			  <option selected>Selecciona una región</option>
              <?php
			  function limpiarCaracteresEspeciales($string ){
				 $string = htmlentities($string);
				 $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
				 return $string;
				}
				$subsites = get_sites();
				$count = 0;
				foreach( $subsites as $subsite ) {
					$count = $count+1;
					//echo "<pre>"; print_r($subsite); echo "</pre>";
					if($count>1){
				  		//$subsite_id = get_object_vars($subsite)["blog_id"];
						$caena = $subsite->path;
						$resultado = str_replace("/", "", $caena);
				 		?>
						<option label="<?php echo "$resultado" ?>" data-back="<?php echo bloginfo('url')."/wp-content/themes/agrega.la/img/flat_".$resultado.".png" ?>" value="<?php echo bloginfo('url').$subsite->path; ?>">
                        	<?php echo $resultado; ?><span></span>
                        </option>
				 	<?php }
				} 
				?>
			</select>
            <br /><div class="clearfix"></div>
            <button id="target" type="button" class="btn btn-default entrrar-site">Entrar</button>
           
		</div>
		<!-- content facebook -->
	</div>
</div>
<?php get_footer(); ?>	