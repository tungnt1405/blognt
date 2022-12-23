<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\Admin\CountryRepositoryInterface;

class CountryController extends SettingsController
{
    /**
     * @var CountryRepositoryInterface|\App\Repositories\Repository
     */
    protected $countryRepo;

    public function __construct(CountryRepositoryInterface $country)
    {
        $this->countryRepo = $country;
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $country = $this->countryRepo->getAll();

        return view('', ['country' => $country]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        //... Validation here

        $country = $this->countryRepo->create($data);

        return redirect()->route('');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = $this->countryRepo->find($id);

        return view('', ['country' => $country]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $country = $this->countryRepo->update($id, $data);

        return redirect()->route('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->countryRepo->delete($id);
        
        return redirect()->route('');
    }
}
