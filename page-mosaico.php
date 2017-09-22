<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>mosaico</title> 
    </head>
    <body>
		<div class="container">
            <section class="main">
				<div id="ri-grid" class="ri-grid ri-grid-size-3">
					<ul></ul>
				</div>
            </section>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript">	
            $( document ).ready(function() {
                $.get("http://agrega.la/api/", function(data, status){
                    var arr_from_json = JSON.parse( data );
                    for (var i = 0; i < arr_from_json.length; i++){
                        var obj = arr_from_json[i];
                        //console.log(obj);
                        for (var j = 0; j < obj.posts.length; j++){
                            console.log(obj.sitio+': '+j+': '+obj.posts[j].url_image);
                            $('#ri-grid > ul').append('<li><a href="#"><img src="images/medium/2.jpg" onerror="this.src="https://a3-images.myspacecdn.com/images03/3/9f4d23883f3f48deb6b4a9d5aa54a212/300x300.jpg";"/></a></li>');
                        }
                    }
                   
                });
            });
		</script>
    </body>
</html>