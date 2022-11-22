<?php

namespace App\Services;


class GetBase64ExtensionService
{
    protected function getExtension($file)
    {
        $ext = $file->extension();

        $base64_type = [
            'png' => 'png',
            'jpg' => 'jpeg',
            'jpeg' => 'jpeg',
            'webp' => 'octet-stream',
            'gif' => 'gif',
            'bmp' => 'bmp',
            'doc' => 'msword',
            'docx' => 'vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt' => 'vnd.ms-powerpoint',
            'pptx' => 'vnd.openxmlformats-officedocument.presentationml.presentation',
            'pdf' => 'pdf',
            'txt' => 'plain',
            'zip' => 'zip',
        ];

        if (array_key_exists($ext, $base64_type)) {
            $ext = $base64_type[$ext];
        }

        return $ext;
    }
}
