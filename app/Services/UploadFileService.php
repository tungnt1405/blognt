<?php

namespace App\Services;

use App\Utils\CommonUtil;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $upload = $image->storeAs($disk . "\/images\/" . $this->getPathUpload(), $this->getHashNameImage($image));
        if ($upload) {
            return $this->getPathUpload() . $this->getHashNameImage($image);
        }

        return '';
    }

    public function copyImage($image)
    {
        // tham khảo: https://stackoverflow.com/questions/30191330/laravel-5-how-to-access-image-uploaded-in-storage-within-view
        try {
            if (Storage::fileExists('public/images/' . $image)) {
                $arrayImg = explode('/', $image);
                $fileName = explode('.', end($arrayImg));
                $fileName[0] = Str::random(40);
                $newFile = implode('.', $fileName);

                Log::info('Copy Image >> ' . $image);
                $upload = Storage::copy('public/images/' . $image, 'public/images/' . $this->getPathUpload() . $newFile);
                Log::info('New Image >> ' . $this->getPathUpload() . $newFile);
                if ($upload) {
                    return $this->getPathUpload() . $newFile;
                }
            }

            return '';
        } catch (\Exception $e) {
            Log::error('Copy image', $e->getMessage());
            abort(500);
        }
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

    public function getHashNameImage($image)
    {
        return $image->hashName();
    }

    public function getExtension($file)
    {
        if ($file && $file->isValid()) return parent::getExtension($file);
        abort(404);
    }
}
