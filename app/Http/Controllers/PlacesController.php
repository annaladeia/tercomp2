<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Libraries\DocumentSession;

use App\Place;
use Session;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $document = DocumentSession::get();
        
        if ($document) {
            
            $data = $document->places;
            
        }

        return view('places.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('places.create');
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
        
        if ($document = DocumentSession::get()) {
        
            $place = Place::create($input);
            
            $document->places()->save($place);
            
            Session::flash('flash_message', 'Toponyme successfully added.');
        }
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('places.edit', $place);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('places.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Place::findOrFail($id);
        
        return view('places.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Place::findOrFail($id);
        
        DocumentSession::checkActiveDocument($data->document);
        
        return view('places.edit', compact('data'));
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
        $place = Place::findOrFail($id);

        $this->validate($request, [
            'name' => 'required'
        ]);
    
        $input = $request->all();
    
        $place->fill($input)->save();
    
        Session::flash('flash_message', 'Toponyme successfully modified.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('places.edit', $id);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('places.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Place::findOrFail($id);

        $data->delete();
    
        Session::flash('flash_message', 'Toponyme successfully deleted.');
    
        return redirect()->route('places.index');
    }


    /**
     * Replaces one or multiple places by another place
     *
     * @return \Illuminate\Http\Response
     */
    public function replacePlace(Request $request)
    {
        $this->validate($request, [
            'replacement' => 'required',
            'items' => 'required'
        ]);

        $input = $request->all();
        
        $replacementPlace = Place::findOrFail($input['replacement']);
        
        if ($replacementPlace) {
            foreach ($input['items'] as $id) {
                if ($id != $input['replacement']) {
                    $place = Place::findOrFail($id);
                    if ($place) {
                        foreach ($place->parcels()->get() as $p) {
                            $p->places()->detach($id);
                            $p->places()->attach($input['replacement']);
                            $p->save();
                        }
                        $place->delete();
                    }
                }
            }
        }
    
        Session::flash('flash_message', 'Toponyme(s) successfully replaced.');
    
        return redirect()->route('places.index');
        
    }

}
