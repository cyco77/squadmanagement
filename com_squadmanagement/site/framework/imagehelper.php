<?php

class ImageHelper
{
	public static function getImageHeight($imgUrl, $width)
	{
		list($orgWidth, $orgHeight, $type, $attr) = getimagesize($imgUrl);
		
		$factor = $orgWidth / $width;
		return round($orgHeight / $factor);	
	}	
	
	public static function getImageWidth($imgUrl, $height)
	{
		list($orgWidth, $orgHeight, $type, $attr) = getimagesize($imgUrl);
		
		$factor = $orgHeight / $height;
		return round($orgWidth / $factor);	
	}
}