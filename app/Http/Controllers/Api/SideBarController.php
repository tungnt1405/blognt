<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\SideBarResource;
use App\Services\Interfaces\Api\OwnerInfoServiceInterface;
use App\Services\Interfaces\Api\OwnerServiceInterface;
use App\Utils\CommonUtil;
use Illuminate\Http\Response;

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
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        $owner = $this->ownerService->getOwner();
        if (gettype($owner) === 'string') {
            return CommonUtil::responeJson([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
                'data' => $owner
            ], Response::HTTP_OK);
        }
        if (empty($owner)) {
            return CommonUtil::responeJson($owner);
        }

        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'data' => new SideBarResource($owner)
        ]);
    }

    /**
     * Display about me.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function about()
    {
        $owner = $this->ownerService->getOwner();
        if (gettype($owner) === 'string') {
            return CommonUtil::responeJson([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
                'data' => $owner
            ], Response::HTTP_OK);
        }

        if (empty($owner)) {
            return CommonUtil::responeJson($owner);
        }

        return CommonUtil::responeJson([
            'code' => Response::HTTP_OK,
            'data' => new AboutResource($owner)
        ]);
    }
}
