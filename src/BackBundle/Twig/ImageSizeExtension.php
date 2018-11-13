<?php 

namespace BackBundle\Twig;

class ImageSizeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('image_width', array($this, 'imageWidth')),
            new \Twig_SimpleFilter('image_height', array($this, 'imageHeight')),
        );
    }

    public function imageWidth($path)
    {
        $sizes = getimagesize($path);

        return $sizes[0];
    }
    
    public function imageHeight($path)
    {
        $sizes = getimagesize($path);

        return $sizes[1];
    }
    
    public function getName(){
        return "back.imagesize";
    }
}