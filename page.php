<?php get_header(); ?>			
	<div class="container sin-padding">	
		<div id="container-single" class="col-md-12 sin-padding">
			<?php if (have_posts()) : while (have_posts()) : the_post();?>
			<h2 class="titulo-page"><?php echo get_the_title();?></h2>
			<span class="barra-azul"></span>
            <div class='col-sm-8 contenido-page'>
                <p><?php the_content(); ?></p>
            </div>
             <div class='col-sm-4 '></div>
            <div class="clearfix"></div>
            <?php endwhile; endif; ?>
		</div>
	</div>	
<?php get_footer(); ?>