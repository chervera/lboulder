<?php

namespace BackBundle\EventListener;

use Vich\UploaderBundle\Event\Event;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageResizerListener {

    public function onVichUploaderPreUpload(Event $event) {
        $object = $event->getObject();
        $mapping = $event->getMapping();
        $image = $object->getImageFile();
        
        $width = 1000;
        $height = 0;
        
        // do your stuff with $object and/or $mapping...
        // Get current dimensions
        $ImageDetails = $this->getImageDetails($image);
        $name = $ImageDetails->name;
        $height_orig = $ImageDetails->height;
        $width_orig = $ImageDetails->width;
        $fileExtention = $ImageDetails->extension;
        $ratio = $ImageDetails->ratio;
        $jpegQuality = 75;

        //Resize dimensions are bigger than original image, stop processing
        if ($width > $width_orig && $height > $height_orig) {
            return false;
        }

        if ($height > 0) {
            $width = $height * $ratio;
        } else if ($width > 0) {
            $height = $width / $ratio;
        }
        $width = round($width);
        $height = round($height);

        $gd_image_dest = imagecreatetruecolor($width, $height);
        $gd_image_src = null;
        switch ($fileExtention) {
            case 'png' :
                $gd_image_src = imagecreatefrompng($image);
                imagealphablending($gd_image_dest, false);
                imagesavealpha($gd_image_dest, true);
                break;
            case 'jpeg': case 'jpg': $gd_image_src = imagecreatefromjpeg($image);
                break;
            case 'gif' : $gd_image_src = imagecreatefromgif($image);
                break;
            default: break;
        }

        imagecopyresampled($gd_image_dest, $gd_image_src, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        $newPath = "/usr/home/lboulder.com" . sys_get_temp_dir();
        $newFileName = $newPath . "/" . $name;

        switch ($fileExtention) {
            case 'png' : imagepng($gd_image_dest, $newFileName);
                break;
            case 'jpeg' : case 'jpg' : imagejpeg($gd_image_dest, $newFileName, $jpegQuality);
                break;
            case 'gif' : imagegif($gd_image_dest, $newFileName);
                break;
            default: break;
        }
        
        $size = filesize($newFileName);
        
        $newFile = new UploadedFile($newPath . "/" . $name, $name, $image->getClientMimeType(), $size, 0 , true);

        $object->setImageFile($newFile);
    }

    /**
     *
     * Gets image details such as the extension, sizes and filename and returns them as a standard object.
     *
     * @param $imageWithPath
     * @return \stdClass
     */
    private function getImageDetails($imageWithPath) {
        $size = getimagesize($imageWithPath);

        $Details = new \stdClass();
        $Details->height = $size[1];
        $Details->width = $size[0];
        $Details->ratio = $size[0] / $size[1];
        $Details->extension = $imageWithPath->guessClientExtension();
        $Details->name = $imageWithPath->getClientOriginalName();

        return $Details;
    }

}
