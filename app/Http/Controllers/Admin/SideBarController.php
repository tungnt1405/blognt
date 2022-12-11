<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSideBarRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Owner;
use App\Repositories\Admin\OwnerRepository;

class SideBarController extends Controller
{
    /**
     * @var OwnerRepository
     */
    protected $ownerRepository;

    /**
     * SideBarController construct
     * @param OwnerRepository $ownerRepository
     */
    public function __construct(
        OwnerRepository $ownerRepository
    ) {
        $this->ownerRepository = $ownerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owner = $this->ownerRepository->getAll();
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
        $datas = $req->all();
        $this->ownerRepository->setOwnerAttributes($datas);
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
