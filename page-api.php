<?php
    global $wpdb; // var global para hacer queries
    
    $blogs          = get_last_updated(); // listar todos los hijos del multisitio
    $data           = array();
    $dataCate       = array();
    $nestedDataCate = array();
    $nestedData     = array();
    $json_data      = array();

    $totalColectivos = 0;
    $total_osts = 0;
    $totalsitios = 0;
    $post_count = 0;

    foreach ($blogs AS $blog)
    {   
        switch_to_blog($blog["blog_id"]);
        
        $blog_details = get_blog_details($blog["blog_id"]);
        
        if($blog_details->blog_id >1) //entrar a cada sitio menos al principal
        {
            $post_count += $blog_details->post_count;
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
                    $generaUrl = "http://agrega.la/wp-content/uploads/sites/".$blog["blog_id"]."\/".$url_meta;
                    $nestedData['id_image'] = $meta_key;
		            $nestedData['url_image'] = esc_url_raw($generaUrl);
                    $data[] = $nestedData;
                }
            endforeach;
            
            /** recorrido para colectivos **/
            $args = array(
                'orderby'            => 'name',
                'order'              => 'ASC',
                'parent'             => 0
            );
            
            $categories = get_categories( $args );
            foreach( $categories as $category ) 
            {
                $nestedDataCate['nombre_colectivo'] = esc_html( $category->name );
                $nestedDataCate['desc_colectivo'] = esc_html( $category->description );
                $nestedDataCate['slug_colectivo'] = esc_html( $category->slug );
                $nestedDataCate['count_colectivo'] = esc_html( $category->count );
                $dataCate[] = $nestedDataCate;
            }  
            $json_data[] = array(
                "sitio"           => $blog_details->blogname,
                "url_sitio"       => $blog_details->siteurl,
                "id_sitio"        => $blog["blog_id"],
                "colectivos"      => $dataCate,
                "posts"           => $data   // total data array
            );
        }
        restore_current_blog(); // fin del recorrido de los sitios del multisitio 
    }
    /** crear json final **/
    $json_data[] = array(
        "totalNot"       => $post_count,
        "totalSit"       => $totalsitios,
        "totalCol"       => $totalColectivos
    );

    echo json_encode($json_data);  // send data as json format
?>