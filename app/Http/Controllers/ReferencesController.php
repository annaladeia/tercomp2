<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Libraries\DocumentSession;

use App\Reference;
use Session;

class ReferencesController extends Controller
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
            
            $data = $document->references;
            
        }

        return view('references.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('references.create');
    }

    /**
     * ['variable']tore a newly created resource in storage.
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
        
            $reference = Reference::create($input);
            
            $document->references()->save($reference);
            
            Session::flash('flash_message', 'Confront invariant successfully added.');
        }
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('references.edit', $reference);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('references.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Reference::findOrFail($id);
        
        return view('references.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Reference::findOrFail($id);
        
        DocumentSession::checkActiveDocument($data->document);
        
        return view('references.edit', compact('data'));
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
        $reference = Reference::findOrFail($id);

        $this->validate($request, [
            'name' => 'required'
        ]);
    
        $input = $request->all();
    
        $reference->fill($input)->save();
    
        Session::flash('flash_message', 'Confront invariant successfully modified.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('references.edit', $id);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('references.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Reference::findOrFail($id);

        $data->delete();
    
        Session::flash('flash_message', 'Confront invariant successfully deleted.');
    
        return redirect()->route('references.index');
    }

}
