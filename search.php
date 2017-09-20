<?php 
get_header(); 
wp_reset_query();
?>	
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
					<h3>Resultados obtenidos para: <?php echo wp_kses($_GET['s']); ?></h3>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
                	<div id="" class="tab-pane active" id="single">
						<div   class="tab-content">
	                		<?php
	                			postsPorBusqueda(wp_kses($_GET['s']));
	                		?>
			            </div>
                	</div>
                		<?php endwhile; ?>
					<?php endif; ?>
	            </div>
			</div>
		</div>
		<!-- content twitter -->
		<div id="container-tweets-single" class="col-sm-4">
			<h2>¿Qué hay en Twitter?</h2>
			<p>
				<?php
					obtenerTweets();
				?>
			</p>
		</div>
	</div>
</div>	
<?php get_footer(); ?>	