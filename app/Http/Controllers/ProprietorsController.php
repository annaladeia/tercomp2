<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Libraries\DocumentSession;

use App\Proprietor;
use App\FamilyRelation;
use App\Profession;
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
        
        $document = DocumentSession::get();
        
        if ($document) {
            
            $data = $document->proprietors;
            
        }

        return view('proprietors.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = \App\Document::with('proprietors.relatedProprietors')->where('id', DocumentSession::getID())->get();
        foreach ($documents as $d) {
            $proprietors = $d->proprietors->lists('field_display', 'id');
        }
        
        $familyRelations = FamilyRelation::orderBy('name_masc', 'asc')->get()->lists('field_display', 'id');
        $professions = Profession::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        
        $data = new Proprietor;
        $data->page = Session::get('page');
        
        return view('proprietors.create', compact('data', 'proprietors', 'familyRelations', 'professions'));
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
            
        ]);

        $input = $request->all();
        
        if ($document = DocumentSession::get()) {
        
            $proprietor = Proprietor::create($input);
            
            $this->storeRelations($proprietor, $input);
            
            $document->proprietors()->save($proprietor);
            
            Session::flash('flash_message', 'Propriétaire successfully added.');
        }
            
        switch ($input['redirect']) {
            case 'edit':
                return redirect()->route('proprietors.edit', $proprietor);
                break;
            case 'new':
                return redirect()->route('proprietors.create');
                break;
            case 'new_page':
                Session::flash('page', $input['page']);
                return redirect()->route('proprietors.create');
                break;
            case 'new_page_plus1':
                Session::flash('page', $input['page'] + 1);
                return redirect()->route('proprietors.create');
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Proprietor::with('professions')->findOrFail($id);
        
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
        
        if ($documentID = DocumentSession::checkActiveDocument($data->document)) {
            
            $documents = \App\Document::with('proprietors.relatedProprietors')->where('id', $documentID)->get();
            
            foreach ($documents as $d) {
                $proprietors = $d->proprietors->lists('field_display', 'id');
            }
            
            $professions = Profession::orderBy('name', 'asc')->get()->lists('field_display', 'id');
            
            switch ($data->sex) {
                case 1:
                    $familyRelations = FamilyRelation::orderBy('name_masc', 'asc')->get()->lists('name_masc_display', 'id');
                    break;
                case 2:
                    $familyRelations = FamilyRelation::orderBy('name_fem', 'asc')->get()->lists('name_fem_display', 'id');
                    break;
                default:
                    $familyRelations = FamilyRelation::orderBy('name_masc', 'asc')->get()->lists('field_display', 'id');
            }
        
        }
        
        return view('proprietors.edit', compact('data', 'proprietors', 'familyRelations', 'professions'));
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
        
        ]);
    
        $input = $request->all();
    
        $proprietor->fill($input)->save();
        
        $this->storeRelations($proprietor, $input);
    
        Session::flash('flash_message', 'Propriétaire successfully modified.');
        switch ($input['redirect']) {
            case 'edit':
                return redirect()->route('proprietors.edit', $id);
                break;
            case 'new':
                return redirect()->route('proprietors.create');
                break;
            case 'new_page':
                Session::flash('page', $input['page']);
                return redirect()->route('proprietors.create');
                break;
            case 'new_page_plus1':
                Session::flash('page', $input['page'] + 1);
                return redirect()->route('proprietors.create');
                break;
        }
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
     * @param  obj $proprietor, array $input
     * @return bool
     */
    private function storeRelations($proprietor, $input)
    {
        if (isset($input['profession']))
            $proprietor->professions()->sync($input['profession']);
        else
            $proprietor->professions()->sync(array());
            
        $professionsSyncArray = [];
        
        if (array_key_exists('profession_type', $input)) {
            foreach ($input['profession_type'] as $i => $connectionType) {
                
                if ($connectionType == 1) { //existing profession
                
                    if (array_key_exists('profession', $input) && array_key_exists($i, $input['profession'])) {
                    
                        $professionsSyncArray[] = $input['profession'][$i];
                    }
                    
                } elseif ($connectionType == 2) { //new profession
                
                    if ($input['profession_name'][$i]) {
                        
                        $profession = new Profession;
                        $profession->name = trim($input['profession_name'][$i]);
                        $profession->save();
                        
                        $professionsSyncArray[] = $profession->id;
                    }
                }
            }
        }
        
        $proprietor->professions()->sync($professionsSyncArray);
        
        $relProprietorsSyncArray = [];
        
        if (array_key_exists('related_connection_type', $input)) {
            
            foreach ($input['related_connection_type'] as $i => $connectionType) {
                
                if (array_key_exists('related_type', $input) && array_key_exists($i, $input['related_type'])) { //has a relation type been choosen?
                
                    if ($connectionType == 1) { //existing proprietor
                    
                        if (array_key_exists('related_proprietor', $input) && array_key_exists($i, $input['related_proprietor'])) {
                        
                            $relProprietorsSyncArray[$input['related_proprietor'][$i]] = array('family_relation_id' => $input['related_type'][$i]);
                        }
                        
                    } elseif ($connectionType == 2) { //new proprietor
                    
                        if ($input['related_proprietor_name'][$i] || $input['related_proprietor_first_name'][$i] || $input['related_proprietor_differential'][$i]) {
                            
                            $relProprietor = new Proprietor;
                            $relProprietor->name = trim($input['related_proprietor_name'][$i]);
                            $relProprietor->first_name = trim($input['related_proprietor_first_name'][$i]);
                            $relProprietor->differential = trim($input['related_proprietor_differential'][$i]);
                            $relProprietor->save();
                            
                            if ($document = DocumentSession::get()) {
                                $document->proprietors()->save($relProprietor);
                            }
                            
                            $relProprietorsSyncArray[$relProprietor->id] = array('family_relation_id' => $input['related_type'][$i]);
                        }
                    }
                }
            }
        
        }
        
        $proprietor->relatedProprietors()->sync($relProprietorsSyncArray);
        
        //get all proprietors that are currently related to this proprietor
        foreach ($proprietor->inverseRelatedProprietors()->get() as $relatedProprietor) {
            //check if proprietors are still related
            if (array_key_exists($relatedProprietor->id, $relProprietorsSyncArray)) {
                //is relation still of the same type?
                if ($relProprietorsSyncArray[$relatedProprietor->id]['family_relation_id'] == $relatedProprietor->family_relation_opposite_id) {
                    //remove key from syncArray 
                    unset($relProprietorsSyncArray[$relatedProprietor->id]);
                }
            } else {
                //remove relation
                $relatedProprietor->relatedProprietors()->detach($proprietor->id);
            }
        }
        
        //loop through (remainder of) $relProprietorsSyncArray
        foreach ($relProprietorsSyncArray as $proprietorID => $relation) {
            //get proprietor
            $relatedProprietor = Proprietor::find($proprietorID);
            
            if ($relatedProprietor) {
                //get opposite ID
                $oppositeID = FamilyRelation::find($relation['family_relation_id'])->opposite_id;
                
                if ($oppositeID) {
                    //set relation
                    $relatedProprietor->relatedProprietors()->sync([$proprietor->id => ['family_relation_id' => $oppositeID]], false);
                } else {
                    $relatedProprietor->relatedProprietors()->detach($proprietor->id);
                }
            }
        }
        
    }    
}
