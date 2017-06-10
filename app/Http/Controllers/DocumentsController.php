<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Document;
use Session;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Document::orderBy('name', 'asc')->get();

        return view('documents.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
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
            'name' => 'required',
            'year' => 'required',
            'type' => 'required'
        ]);

        $input = $request->all();
        
        $document = Document::create($input);
        
        Session::flash('flash_message', 'Document successfully added.');
            
        return redirect()->route('documents.edit', $document);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Document::findOrFail($id);
        
        return view('documents.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Document::findOrFail($id);
        
        return view('documents.edit', compact('data'));
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
        $document = Document::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'year' => 'required',
            'type' => 'required'
        ]);
    
        $input = $request->all();
    
        $document->fill($input)->save();
    
        Session::flash('flash_message', 'Document successfully modified.');
            
        return redirect()->route('documents.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Document::findOrFail($id);
        
        if ($data->proprietors()->count() == 0 || $data->parcels()->count() == 0) {

            $data->delete();
        
            Session::flash('flash_message', 'Document successfully deleted.');
            
        } else {
            Session::flash('flash_message', 'Document not deleted. Proprietors and/or parcels are still atached to this document.');
        }
        
        return redirect()->route('documents.index');
    }
    
    public function changeActiveDocument($id = false)
    {
        if ($id) {
            \App\Libraries\DocumentSession::setDocument($id);
            Session::flash('flash_document_changed', true);
        }
        
        return redirect()->route('home');
    }

}
