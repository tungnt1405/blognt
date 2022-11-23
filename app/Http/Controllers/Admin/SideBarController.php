<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\StoreSideBarRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Owner;
use App\Services\UploadFileService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SideBarController extends Controller
{
    /**
     * @var UploadFileService
     */
    protected $_uploadFileService;

    /**
     * =SideBarController construct
     * @param UploadFileService $uploadFileService
     */
    public function __construct(
        UploadFileService $uploadFileService
    ) {
        $this->_uploadFileService = $uploadFileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owner = 1;
        // dd($owner);
        return view('admin.side-bar.show')->with(['owner' => $owner]);
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
        $owner = new Owner();
        $b64_img = $this->_uploadFileService->getBase64Image($req->file('avatar'));
        $data = array(
            'thumbnail' => $b64_img,
            'name_owner' => $req->get('name'),
            'description' => '',
            'link_1' => '',
            'link_2' => '',
            'link_3' => '',
            'link_4' => '',
            'link_5' => '',
            'link_6' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );

        $owner->createOwner($data);

        return redirect()->route('admin.side-bar');
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
    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        //
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
}
