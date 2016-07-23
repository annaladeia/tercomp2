<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Proprietor;
use App\FamilyRelation;
use Session;

class ProprietorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Proprietor::orderBy('name', 'asc')->orderBy('first_name', 'asc')->orderBy('nickname', 'asc')->get();

        return view('proprietors.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proprietors = Proprietor::orderBy('name', 'asc')->orderBy('first_name', 'asc')->orderBy('nickname', 'asc')->get()->lists('field_display', 'id');
        $familyRelations = FamilyRelation::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        
        return view('proprietors.create', compact('proprietors', 'familyRelations'));
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
        
        $proprietor = Proprietor::create($input);
        
        $this->storeRelatedProprietors($proprietor, $input);
        
        Session::flash('flash_message', 'Propriétaire successfully added.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('proprietors.edit', $proprietor);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('proprietors.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Proprietor::findOrFail($id);
        
        return view('proprietors.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Proprietor::with('relatedProprietors')->findOrFail($id);
        
        $proprietors = Proprietor::orderBy('name', 'asc')->orderBy('first_name', 'asc')->orderBy('nickname', 'asc')->where('id', '!=', $id)->get()->lists('field_display', 'id');
        $familyRelations = FamilyRelation::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        
        return view('proprietors.edit', compact('data', 'proprietors', 'familyRelations'));
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
        $proprietor = Proprietor::findOrFail($id);

        $this->validate($request, [
            'name' => 'required'
        ]);
    
        $input = $request->all();
    
        $proprietor->fill($input)->save();
        
        $this->storeRelatedProprietors($proprietor, $input);
    
        Session::flash('flash_message', 'Propriétaire successfully modified.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('proprietors.edit', $id);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('proprietors.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Proprietor::findOrFail($id);

        $data->delete();
    
        Session::flash('flash_message', 'Propriétaire successfully deleted.');
    
        return redirect()->route('proprietors.index');
    }

    /**
     * Store related proprietors in storage.
     *
     * @param  int $proprietor, array $input
     * @return bool
     */
    private function storeRelatedProprietors($proprietor, $input)
    {
        $syncArray = [];
        
        if (array_key_exists('related_proprietor', $input)) {
            
            foreach ($input['related_proprietor'] as $i => $relId) {
                
                if (array_key_exists('related_type', $input) && array_key_exists($i, $input['related_type'])) {
                    
                    $syncArray[$relId] = array('family_relation_id' => $input['related_type'][$i]);
                
                }
                
            }
        
        }
        
        $proprietor->relatedProprietors()->sync($syncArray);
    }    
}
