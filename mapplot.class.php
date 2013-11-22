<?php
error_reporting(E_ALL);

class MapPlot {
	private $left_longitude;
	private $right_longitude;
	private $top_latitude;
	private $bottom_latitude;
	
	private $width; // width in decimal degrees (longitude)
	private $height; // height in decimal degrees (latitude)
	
	private $image;
	private $image_width;
	private $image_height;

	public function __construct($image_path, $left_longitude, $right_longitude, $top_latitude, $bottom_latitude) {
		// set the variables
		$this->left_longitude = $left_longitude;
		$this->right_longitude = $right_longitude;
		$this->top_latitude = $top_latitude;
		$this->bottom_latitude = $bottom_latitude;
		
		$this->width = $this->right_longitude - $this->left_longitude;
		$this->height = $this->bottom_latitude - $this->top_latitude;
		
		$image_data = file_get_contents($image_path);
		
		if (!$image_data) {
			die("Unable to open image file");
		} else {
			// create the image
			$this->image = imagecreatefromstring($image_data);
			
			if (!$this->image) {
				die("Unable to load image to memory");
			} else {
				// get the width and height of our image.
				$this->image_width = imagesx($this->image);
				$this->image_height = imagesy($this->image);
			}
				
		}
		
		return true;
	}
	
	function plot($lat, $lon) {
		$color = imagecolorallocate($this->image, 255, 0, 0);
		$pixelsy = ($this->image_width / $this->width) * ($lat + 180);
		$pixelsx = ($this->image_height / $this->height) * ($lon - ($lon * 2) + 90);
		imagefilledellipse($this->image, $pixelsy, $pixelsx, 20, 20, $color);
	}
	
	function output() {
		imagejpeg($this->image, 'out.jpg');
		return true;
	}
}
?>