<?php get_header(); ?>	
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
<div class="container sin-padding">
	<div id="container-single" class="col-xs-12">
		<!-- content facebook -->
		<div class="col-sm-8 sin-padding">
			<div class="col-sm-1 sin-padding">
				
				<a class="btn btn-primary circulo" href="<?php echo bloginfo('url'); ?>">
		            <i class="glyphicon glyphicon-chevron-left"></i>
		        </a>
			</div>
			<div class="col-sm-11">
				<div class="tab-content">
                	<div class="tab-pane active" id="single">
                		<div class="content-noticias-single">
							 	<div class="contenido">
							 		<span class="icon-colectivo"></span><h3 class="titulo-note"><?php echo setCategory(get_the_ID()); ?></h3> 
			            			<p class="lugar-fecha">Caribe / <span class="entry-date"><?php echo get_the_date(); ?></span></p>
							 		<div class="entry"><?php the_content(); ?></div>
						 		</div>
							<div class="footer-singel">
								<span class="icon-faces"></span><a href="#">Ver en fuente original</a>
							</div>
                		</div>
                	</div>
	            </div>
			</div>
		</div>
		<!-- content twitter -->
		<div id="container-tweets-single" class="col-sm-4">
			<h2>Publicaciones relacionadas</h2>
			<?php
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
					  $first_tag = $tags[0]->term_id;
					  $cat = the_category_ID(FALSE) ;
					  $args=array(
					    'cat'=>$cat,
					    'post__not_in' => array($post->ID),
					    'showposts'=>3,
					    'caller_get_posts'=>1
					   );
					  $my_query = new WP_Query($args);
					  if( $my_query->have_posts() ) {
					    while ($my_query->have_posts()) : $my_query->the_post(); ?>
					    	<?php $link =  get_permalink(get_the_ID()); ?>
					    	<div class="content-noticias-single paddin-contenido" data-link="<?php echo $link; ?>">
					      		<span class="icon-colectivo"></span><h3 class="titulo-note"><?php echo setCategory(get_the_ID()); ?></h3> 
		            			<p class="lugar-fecha">Caribe / <span class="entry-date"><?php echo get_the_date(); ?></span></p>
					      		<?php echo the_excerpt_max_charlength(200);?>	
					      	</div>
					      <?php
					    endwhile;
					  }
					}
				?>
		</div>
	</div>
</div>	
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>	