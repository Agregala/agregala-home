<?php get_header('twitter'); ?>
<?php
require "vendor/twitter/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'k0vc2j5aTUAUrJvx1Ok2jsSEI');
define('CONSUMER_SECRET', 'HFUS2SBqTIhxzb0yLPdNwJiWvM61Nt3afjlQK11PTlcq8PEMrn');
define('ACCESS_TOKEN', '586215587-G9jY3ptrQUanpPoYd9PVsfdNu1RWl1Vvf3C3TC15');
define('ACCESS_TOKEN_SECRET', 'NbQI8XACRBBdT2MKfP1Qi0xIXoH4nBMDFQWqFvh8z1Nsk');
$fullby_hashtag = get_option('fullby_hashtag');

function search(array $query)
{
  $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
  return $toa->get('search/tweets', $query);
}
 
  $query = array(
    "q" => $fullby_hashtag,
    "count" => 10,
    "result_type" => "recent",
    "lang" => "es",

  );
 
  $results = search($query);
  //echo "<pre>"; print_r($results); echo "</pre>";
  //var_dump($results);
    $nombre = "";
    $tweet  = "";
    $dia    = "";
    $foto   = "";
    $imagen = "";
    $link   = "";
    borrarTweet();
  foreach ($results->statuses as $result) {
  // echo $result->text."<br>"; // Set max_id for the next search page
  // echo $result->created_at."<br>";
  // echo "@".$result->user->screen_name."<br>";
  // echo $result->user->profile_image_url."<br>";
   //echo $result->entities->media['0']->media_url."mdiae<br>";
   //echo $result->entities->media['0']->url."<br>";
   // echo $result->entities->media->media_url."<br>";https://t.co/YS8cNqO26d
    //echo "<pre>"; print_r($result->entities->media['0']); echo "</pre>";
    $nombre = "@".$result->user->screen_name;
    $tweet  = $result->text;
    $dia    = $result->created_at;
    $foto   = $result->user->name;
    $imagen = $result->user->profile_image_url;
    $link   = $result->entities->media->media_url;
    //$imagen = $result->entities->media['0']->url;profile_image_url

    $findme   = 'http://pbs.twimg.com/profile_images/';
    $pos = strpos($imagen, $findme);
    if ($pos === false) {
      $mandar = "https://goo.gl/lCTfvB";
    } else {
        $mandar = substr($imagen, 36);
    }
    $contar = strlen($mandar);
    if($contar >= 50){
      $mandar = "https://goo.gl/lCTfvB";
    }
    if($nombre==""){
      $mensaje = "Twitter no actualizado";
      exit();
    }else{
      enviarDatos($nombre,$tweet,$dia,$foto,$mandar,$link);
      $mensaje = "Twitter actualizado";
      }

  }
  
echo $mensaje;
?>