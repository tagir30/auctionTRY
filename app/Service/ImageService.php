<?php


namespace App\Service;


class ImageService
{
    /**
     * @param $image
     * @return string
     */
    public function handleUploadedImage($image): string
    {
        if (!is_null($image)) {
            $path = $image->store('uploads', 'public');
        } else {
            $path = config('constants.PATH_DEFAULT_IMAGE');//Как-то это поправить надо...
        }
        return $path;
    }
}
