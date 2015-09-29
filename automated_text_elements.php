<?php

/* Get content from json file */
$json_obj = file_get_contents("stuff.json");
$json_a = json_decode($json_obj, true);

/* Counter for filename */
$i = 0;

/* Set width and height for object */
$width = 1000;
$height = 400;

foreach ($json_a as $text_elements => $text_element) {

	/* Set variables from json */
	$text_content = $text_element['text_content'];
	$text_align = $text_element['text_align'];
	$text_color = $text_element['text_color'];
	$font = $text_element['font'];
	$font_size = $text_element['font_size'];
	$line_height = $text_element['line_height'];
	$img_width = $text_element['width'];
	$img_height = $text_element['height'];

	/* Create object with transparent canvas */
	$img = new Imagick();
	$img->newImage($width, $height, new ImagickPixel('transparent'));

	/* New ImagickDraw instance */
	$draw = new ImagickDraw();

	/* Fill color black for text */
	$draw->setFillColor($text_color);

	/* Set font and font size */
	$draw->setFont($font);
	$draw->setFontSize($font_size);

	/* Set text alignment */
	if ($text_align == "left") {
		$draw->setGravity( Imagick::GRAVITY_WEST );
	} elseif ($text_align == "center") {
		$draw->setGravity( Imagick::GRAVITY_CENTER );
	} elseif ($text_align == "right") {
		$draw->setGravity( Imagick::GRAVITY_EAST );
	}

	/* Set line height */
	$draw->setTextInterlineSpacing($line_height);

	/* Add text to canvas */
	$img->annotateImage($draw, 10, 60, 0, $text_content);

	/* Set image type */
	$img->setImageFormat('png');

	/* Trim the image */
	$img->trimImage(0);

	/* Resize if specified */
	if ($img_width) {
		$img->resizeImage($img_width, 0, Imagick::FILTER_LANCZOS, 1, FALSE);
	} elseif ($img_height) {
		$img->resizeImage(0, $img_height, Imagick::FILTER_LANCZOS, 1, FALSE);
	}

	/* Save image with name via iteration */
	$i++;
	file_put_contents ("src/text_element_" . $i . ".png", $img);

}

/* Show all images from dir */
$dirname = "src/";
$images = glob($dirname . "*.png");
foreach($images as $image) {
	echo "<img src='" . $image . "' /><br />";
}

?>