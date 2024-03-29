<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ToastrHelper;
use App\Http\Requests\admin\Owner\StoreOwnerInfoRequest;
use App\Http\Requests\admin\Owner\UpdateOwnerInfoRequest;
use App\Http\Requests\StoreSideBarRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Owner;
use App\Repositories\Admin\OwnerRepository;
use App\Services\Admin\OwnerInfoService;
use Illuminate\Database\Eloquent\Model;

class SideBarController extends AdminController
{
    /**
     * @var OwnerRepository
     */
    protected $ownerRepository;

    /**
     * @var OwnerInfoService
     */
    protected $ownerInfoService;

    /**
     * SideBarController construct
     * @param OwnerRepository $ownerRepository
     */
    public function __construct(
        OwnerRepository $ownerRepository,
        OwnerInfoService $ownerInfoService,

    ) {
        $this->ownerRepository = $ownerRepository;
        $this->ownerInfoService = $ownerInfoService;
    }

    /**
     * Display a listing of the resource.
     * screen: owner for sidebar
     * method: get
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.side-bar.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSideBarRequest  $req
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSideBarRequest $req)
    {
        $datas = $req->all();
        $owner = $this->ownerRepository->setOwnerAttributes($datas);
        if ($owner instanceof Model) {
            ToastrHelper::toastrSuccess('Create successfully!');
            return redirect()->route('admin.side-bar');
        }

        ToastrHelper::toastrError('Oops! Create failed.', 'Oops!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOwnerRequest  $request
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOwnerRequest $request, Owner $side_bar)
    {
        $data = $request->all();
        $updateOwner = $this->ownerRepository->update($side_bar->id, $data);

        if ($updateOwner instanceof Model) {
            ToastrHelper::toastrSuccess('Update successfully!');
            return redirect()->route('admin.side-bar');
        }
        ToastrHelper::toastrError('An error has occurred please try again later.', 'Oops!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        //
    }

    /**
     * screen: owner information
     * method: get
     *
     * @return \Illuminate\Http\Response
     */
    public function getMoreInfo()
    {
        return view('admin.side-bar.more-info');
    }

    /**
     * screen: additional information
     * method: post
     *
     * @param \App\Http\Requests\admin\Owner\StoreOwnerInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postMoreInfo(StoreOwnerInfoRequest $request)
    {
        $data = $request->all();
        $attributes = [];
        $attributes['owner_id'] = $data['owner_id'];
        $attributes['description'] = $data['description'];
        $attributes['experience'] = $data['experience'];
        $attributes['make_project'] = $data['project'];
        $attributes['career_goals'] = $data['career_goals'];

        $results = $this->ownerInfoService->create($attributes);
        if ($results) {
            ToastrHelper::toastrSuccess('Create more info successfully!');
            return redirect()->route('admin.side-bar');
        }

        ToastrHelper::toastrError('An error has occurred please try again later.', 'Oops!');
        return redirect()->route('admin.side-bar');
    }

    /**
     * screen: update information
     * method: put
     *
     * @param \App\Http\Requests\admin\Owner\UpdateOwnerInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function putMoreInfo(UpdateOwnerInfoRequest $request, $id = null)
    {
        $data = $request->all();
        $attributes = [];
        $attributes['description'] = $data['description'];
        $attributes['experience'] = $data['experience'];
        $attributes['make_project'] = $data['project'];
        $attributes['career_goals'] = $data['career_goals'];

        $results = $this->ownerInfoService->update($id, $attributes);
        if ($results) {
            ToastrHelper::toastrSuccess('Update more info successfully!');
            return redirect()->route('admin.side-bar');
        }

        ToastrHelper::toastrError('An error has occurred please try again later.', 'Oops!');
        return redirect()->route('admin.side-bar');
    }
}
