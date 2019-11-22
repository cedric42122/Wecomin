<?php

namespace App\Controller\Traits;

trait UploadableFile
{
    protected function uploadPicture($imgFile)
    {
        $imgFileName =
            pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME)
            . '-' . uniqid()
            . '.' . $imgFile->guessClientExtension();

        $imgFile->move(dirname(__FILE__) . "/../../../public/uploads/", $imgFileName);

        return $imgFileName;
    }
}
