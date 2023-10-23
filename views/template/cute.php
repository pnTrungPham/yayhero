<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="text-slide">
	Hãy nhấn và di chuyển chuột :))))
</div>

<div id="drag-container">
	<div id="spin-container">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh.jpeg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh2.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh3.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh4.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh5.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh6.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh7.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh9.jpg')?>" alt="">
		<img class="img-slide" src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/image/thanh_thanh10.jpg')?>" alt="">
		<p>Thanh Thanh</p>
	</div>
	<div id="ground"></div>
	</div>
	
	<div id="music-container"></div>
	<div id="canva">
	<canvas id="canvas">
	
	</canvas>
</div>
<audio id="autoplay" controls autoplay>
	<source src="<?php echo  ( YAYMAIL_ADDON_PLUGIN_NAME_PLUGIN_URL . 'assets/frontend/music.mp3')?>" >
</audio>