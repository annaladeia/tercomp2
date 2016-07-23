<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ParcelType;
use Session;

class ParcelTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ParcelType::orderBy('name', 'asc')->get();

        return view('parceltypes.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parceltypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $input = $request->all();
        
        $parceltype = ParcelType::create($input);
        
        Session::flash('flash_message', 'Nature successfully added.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('parceltypes.edit', $parceltype);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('parceltypes.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ParcelType::findOrFail($id);
        
        return view('parceltypes.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ParcelType::findOrFail($id);
        
        return view('parceltypes.edit', compact('data'));
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
        $parceltype = ParcelType::findOrFail($id);

        $this->validate($request, [
            'name' => 'required'
        ]);
    
        $input = $request->all();
    
        $parceltype->fill($input)->save();
    
        Session::flash('flash_message', 'Nature successfully modified.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('parceltypes.edit', $id);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('parceltypes.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ParcelType::findOrFail($id);

        $data->delete();
    
        Session::flash('flash_message', 'Nature successfully deleted.');
    
        return redirect()->route('parceltypes.index');
    }

}
