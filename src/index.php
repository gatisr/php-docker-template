<?php
function gdImgToHTML( $gdImg, $format='png' ) {
    // Validate Format
    if( in_array( $format, array( 'jpg', 'jpeg', 'png', 'gif' ) ) ) {
        ob_start();
        if( $format == 'jpg' || $format == 'jpeg' ) {
            imagejpeg( $gdImg );
        } elseif( $format == 'png' ) {
            imagepng( $gdImg );
        } elseif( $format == 'gif' ) {
            imagegif( $gdImg );
        }
        $data = ob_get_contents();
        ob_end_clean();
        // Check for gd errors / buffer errors
        if( !empty( $data ) ) {
            $data = base64_encode( $data );
            // Check for base64 errors
            if ( $data !== false ) {
                // Success
                return "<img src='data:image/$format;base64,$data'>";
            }
        }
    }
    // Failure
    return '<img>';
}

function create_image($width, $height, $text)
{
	$image = ImageCreate($width, $height);
	$white = ImageColorAllocate($image, 255, 255, 255);//white
	$grey = imagecolorallocate($image, 128, 128, 128);//grey
	$black = imagecolorallocate($image, 0, 0, 0);//black
	ImageFill($image, 0, 0, $white);
	$font = 'Roboto-Regular.ttf';//make sure chosen font is in the directory!!
	imagettftext($image, 36, 0, 96, 46, $grey, $font, $text);//text shadow
	imagettftext($image, 36, 0, 95, 45, $black, $font, $text);//text
	return gdImgToHTML($image);
}
echo create_image(600, 200, 'Sample text for image');