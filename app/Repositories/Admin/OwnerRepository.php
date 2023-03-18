<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\OwnerRepositoryInterface;
use App\Services\UploadFileService;
use Exception;

class OwnerRepository extends BaseRepository implements OwnerRepositoryInterface
{
    /**
     * @var UploadFileService
     */
    protected $_uploadFileService;

    /**
     * @var UploadFileService $uploadFileService;
     */
    public function __construct(
        UploadFileService $uploadFileService
    ) {
        parent::__construct();
        $this->_uploadFileService = $uploadFileService;
    }

    public function getModel()
    {
        return \App\Models\Owner::class;
    }

    /**
     * Get table
     */
    public function getTable()
    {
        return 'dtb_owner';
    }

    /**
     * Get Join Table
     */
    public function getJoinTable()
    {
        return [];
    }

    public function setOwnerAttributes($attr)
    {
        $base_64  = $this->_uploadFileService->getBase64Image($attr['avatar']);
        try {
            $setField = array(
                'avatar' => $base_64,
                'name' => $attr['name'],
                'introduce' => $attr['description'],
                'gmail_url' => @$attr['gmail'],
                'fb_url' => @$attr['facebook'],
                'twitter_url' => @$attr['twitter'],
                'linkin_url' => @$attr['linkin'],
                'zalo_url' => @$attr['zalo'],
                'github_url' => @$attr['github']
            );

            return $this->create($setField);
        } catch (Exception $ex) {
            throw new \RuntimeException($ex->getMessage());
        }
    }

    public function getFirstRecord()
    {
        return $this->model->all()->first();
    }

    public function update($id, $attributes = [])
    {
        if (isset($attributes['avatar'])) {
            $base_64 = $this->_uploadFileService->getBase64Image($attributes['avatar']);
        }

        $result = $this->find($id);
        $setField = array(
            'avatar' => $base_64 ?? $result->avatar,
            'name' => $attributes['name'],
            'introduce' => $attributes['description'],
            'gmail_url' => @$attributes['gmail'],
            'fb_url' => @$attributes['facebook'],
            'twitter_url' => @$attributes['twitter'],
            'linkin_url' => @$attributes['linkin'] ?? '',
            'zalo_url' => @$attributes['zalo'],
            'github_url' => @$attributes['github']
        );

        if ($result) {
            $result->update($setField);
            return $result;
        }

        return false;
    }
}
