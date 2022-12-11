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
    ){
        parent::__construct();
        $this->_uploadFileService = $uploadFileService;
    }

    public function getModel()
    {
        return \App\Models\Owner::class;
    }

    public function setOwnerAttributes($attr)
    {
        $base_64  = $this->_uploadFileService->getBase64Image($attr['avatar']);
        echo "<img src=\"$base_64\" width=\"180px\" height=\"auto\" />";
        try {
            $setField = array(
                array('meta_key' => 'avatar', 'meta_value' => $base_64),
                array('meta_key' => 'name', 'meta_value' => $attr['name']),
                array('meta_key' => 'description', 'meta_value' => $attr['description']),
                array('meta_key' => 'facebook', 'meta_value' => $attr['facebook'] ?? ''),
                array('meta_key' => 'twitter', 'meta_value' => $attr['twitter'] ?? ''),
                array('meta_key' => 'linkin', 'meta_value' => $attr['linkin'] ?? ''),
                array('meta_key' => 'zalo', 'meta_value' => $attr['zalo'] ?? '' ),
                array('meta_key' => 'github', 'meta_value' => $attr['github'] ?? '' ),
                array('meta_key' => 'gmail', 'meta_value' => $attr['gmail'] ?? '')
            );

            $this->model->insert($setField);
        } catch (Exception $ex) {
            throw new \RuntimeException($ex->getMessage());
        }
    }
}
