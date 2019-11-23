<?php

namespace App\Controller\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait UploadableFile
{
    protected function uploadPicture(UploadedFile $imgFile)
    {
        $imgFileName =
            pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME)
            . '-' . uniqid()
            . '.' . $imgFile->guessClientExtension();

        $imgFile->move(dirname(__FILE__) . "/../../../public/uploads/", $imgFileName);

        return $imgFileName;
    }
}
