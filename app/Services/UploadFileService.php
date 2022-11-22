<?php

namespace App\Services;


class UploadFileService extends GetBase64ExtensionService
{
    public function getBase64Image($image)
    {
        $ext = $this->getExtension($image);

        return 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($image->path()));
    }

    public function getBase64File($file)
    {
        $ext = $this->getExtension($file);

        return $file->getClientOriginalName() . '+end+data:@file/' . $ext . ';base64,' . base64_encode(file_get_contents($file->path()));
    }

    public function getBase64Audio($audio)
    {
        return $audio->getClientOriginalName() . '.wav+end+data:audio/wav;base64,' . base64_encode(file_get_contents($audio->path()));
    }

    public function getExtension($file)
    {
        if ($file && $file->isValid()) return parent::getExtension($file);
        abort(404);
    }
}
