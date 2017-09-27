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
            $blogname = $blog_details->blogname;
            $nombre = strtolower($blogname);
            $url = "http://agrega.la/".$nombre."/?fb2wp_type=all"
            $.ajax({
                type: "GET",
                url: $url,
                success: function (data) {
                    console.log(data);
                }
            });

        }
        restore_current_blog(); // fin del recorrido de los sitios del multisitio 
    }
?>