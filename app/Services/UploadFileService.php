<?php

namespace App\Services;

use App\Utils\CommonUtil;
use Illuminate\Support\Str;

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

    /**
     * using Storage:disk() of laravel to upload image
     * @param File $image = image choose,
     * @param Storage $disk = public, s3, local (check filesystems.php)
     *
     * docs: https://laravel.com/docs/10.x/filesystem#the-local-driver
     */
    public function moveFileImage($image, $disk = 'public')
    {
        $upload = $image->storeAs($disk."\/images\/".$this->getPathUpload(), $this->getHashNameImage($image));
        if($upload) {
            return $this->getPathUpload() . $this->getHashNameImage($image);
        }

        return '';
    }

    public function moveFileImagePublic($image)
    {
        return $image->move($this->getPathUploadPublic(), $this->getHashNameImage($image));
    }

    public function getPathUpload()
    {
        return CommonUtil::createFolderByDate();
    }

    public function getPathUploadPublic()
    {
        return CommonUtil::createFolderInPublicByDate('images');
    }

    public function getHashNameImage($image){
        return $image->hashName();
    }

    public function getExtension($file)
    {
        if ($file && $file->isValid()) return parent::getExtension($file);
        abort(404);
    }
}
