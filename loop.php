<?php 
if(have_posts()) :     
	/** Loop through each post for this month... */
	while(have_posts()) : the_post();

		$link =  get_permalink(get_the_ID());
		echo '<div class="content-noticias" data-link="'.$link.'">';
			echo '<div class="triangulo-equilatero-top-right"><span></span></div>';
	            /** Output each article for this month */
	        	echo '<span class="icon-colectivo"></span><h3 class="titulo-note">'.setCategory(get_the_ID()).'</h3>';  
	        	echo '<p class="lugar-fecha">Caribe / <span class="entry-date"> '.get_the_date().'</span></p>';  	
	            echo the_excerpt_max_charlength(200);
	            echo '<a class="read-more" href="'.get_permalink(get_the_ID()).'">Leer más</a>';
	    echo '</div>';
	endwhile;
	/** FINALIZA LOOP DE NOTICIAS **/
  	
endif;
?>