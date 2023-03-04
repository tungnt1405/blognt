<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\RepositoryInterface;

interface PostInfomationRepositoryInterface extends RepositoryInterface
{
    public function getInfomationByPostId($postId, $postStatus);
}
