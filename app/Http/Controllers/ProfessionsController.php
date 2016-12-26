<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Profession;
use Session;

class ProfessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Profession::orderBy('name', 'asc')->get();

        return view('professions.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('professions.create');
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
        
        $profession = Profession::create($input);
        
        Session::flash('flash_message', 'Métier successfully added.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('professions.edit', $profession);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('professions.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Profession::findOrFail($id);
        
        return view('professions.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Profession::findOrFail($id);
        
        return view('professions.edit', compact('data'));
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
        $profession = Profession::findOrFail($id);

        $this->validate($request, [
            'name' => 'required'
        ]);
    
        $input = $request->all();
    
        $profession->fill($input)->save();
    
        Session::flash('flash_message', 'Métier successfully modified.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('professions.edit', $id);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('professions.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Profession::findOrFail($id);

        $data->delete();
    
        Session::flash('flash_message', 'Métier successfully deleted.');
    
        return redirect()->route('professions.index');
    }

}
