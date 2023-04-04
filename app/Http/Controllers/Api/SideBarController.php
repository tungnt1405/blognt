<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SideBarResource;
use App\Services\Interfaces\Api\OwnerInfoServiceInterface;
use App\Services\Interfaces\Api\OwnerServiceInterface;
use Illuminate\Http\Request;

class SideBarController extends Controller
{
    /**
     * @var OwnerServiceInterface
     */
    protected $ownerService;

    /**
     * @var OwnerInfoServiceInterface
     */
    protected $ownerInfoService;

    public function __construct(
        OwnerServiceInterface $ownerService,
        OwnerInfoServiceInterface $ownerInfoService
    ) {
        $this->ownerService = $ownerService;
        $this->ownerInfoService = $ownerInfoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owner = $this->ownerService->getOwner();
        return new SideBarResource($owner);
    }
}
