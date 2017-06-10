<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Libraries\DocumentSession;
use App\Libraries\Calculator;

use App\Parcel;
use App\Proprietor;
use App\Place;
use App\ParcelType;
use App\Reference;
use App\ParcelConnection;
use Session;

class ParcelsController extends Controller
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
            
            $data = $document->parcels;
            
        }

        return view('parcels.index')->withData($data);
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
            $proprietorsExtended = $d->proprietors->lists('field_extended_display', 'id');
            $places = $d->places->lists('field_display', 'id');
            $references = $d->references->lists('field_display', 'id');
        }
        
        $parceltypes = ParcelType::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        
        $data = array();
        $preselectedProprietors = array();
        if ($sessionProprietors = Session::get('proprietor')) {
            foreach ($sessionProprietors as $proprietor) {
                $preselectedProprietors[] = (object) ['id' => $proprietor];
            }
        }
        
        $data = new Parcel;
        $data->proprietors = $preselectedProprietors;
        $data->page_number = Session::get('page_number');
        $data->front = Session::get('front');
        $data->parcel_number = Session::get('parcel_number');
        
        return view('parcels.create', compact('data', 'proprietors', 'proprietorsExtended', 'places', 'parceltypes', 'references'));
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
            'page_number' => 'required'
        ]);

        $input = $request->all();
        
        if ($document = DocumentSession::get()) {
        
            $parcel = Parcel::create($input);
            
            $this->storeRelations($parcel, $input);
            $this->calcValues($parcel, $input);
            
            $document->parcels()->save($parcel);
            
            Session::flash('flash_message', 'Parcelle successfully added.');
        }
        
        switch ($input['redirect']) {
            case 'edit':
                return redirect()->route('parcels.edit', $parcel->id);
                break;
            case 'new_proprietor_page':
                Session::flash('page_number', $input['page_number']);
                Session::flash('front', $input['front']);
                Session::flash('parcel_number', $input['parcel_number']+1);
                return redirect()->route('parcels.create');
                break;
            case 'new_proprietor_page_plus1':
                Session::flash('page_number', $input['front'] == 1 ? $input['page_number'] : $input['page_number']+1);
                Session::flash('front', $input['front'] == 1 ? 0 : 1);
                Session::flash('parcel_number', 1);
                return redirect()->route('parcels.create');
                break;
            case 'copy_proprietor_page':
                Session::flash('proprietor', $input['proprietor']);
                Session::flash('page_number', $input['page_number']);
                Session::flash('front', $input['front']);
                Session::flash('parcel_number', $input['parcel_number']+1);
                return redirect()->route('parcels.create');
                break;
            case 'copy_proprietor_page_plus1':
                Session::flash('proprietor', $input['proprietor']);
                Session::flash('page_number', $input['front'] == 1 ? $input['page_number'] : $input['page_number']+1);
                Session::flash('front', $input['front'] == 1 ? 0 : 1);
                Session::flash('parcel_number', 1);
                return redirect()->route('parcels.create');
                break;
            case 'new':
                return redirect()->route('parcels.create');
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
        $data = Parcel::with('proprietors')->with('parcelConnections.reference')->with('parcelConnections.proprietors.relatedProprietors')->findOrFail($id);
        
        return view('parcels.show')->withData($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Parcel::with('proprietors')->findOrFail($id);
        
        if ($documentID = DocumentSession::checkActiveDocument($data->document)) {
            
            $documents = \App\Document::with('proprietors.relatedProprietors')->where('id', $documentID)->get();
            
            foreach ($documents as $d) {
                $proprietors = $d->proprietors->lists('field_display', 'id');
                $proprietorsExtended = $d->proprietors->lists('field_extended_display', 'id');
                $places = $d->places->lists('field_display', 'id');
                $references = $d->references->lists('field_display', 'id');
            }
            $parceltypes = ParcelType::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        }
        
        return view('parcels.edit', compact('data', 'proprietors', 'proprietorsExtended', 'places', 'parceltypes', 'references'));
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
        $parcel = Parcel::findOrFail($id);

        $this->validate($request, [
            'page_number' => 'required'
        ]);
    
        $input = $request->all();
    
        $parcel->fill($input)->save();
        
        $this->storeRelations($parcel, $input);
        $this->calcValues($parcel, $input);
    
        Session::flash('flash_message', 'Parcelle successfully modified.');
        
        switch ($input['redirect']) {
            case 'edit':
                return redirect()->route('parcels.edit', $id);
                break;
            case 'new_proprietor_page':
                Session::flash('page_number', $input['page_number']);
                Session::flash('front', $input['front']);
                Session::flash('parcel_number', $input['parcel_number']+1);
                return redirect()->route('parcels.create');
                break;
            case 'new_proprietor_page_plus1':
                Session::flash('page_number', $input['front'] == 1 ? $input['page_number'] : $input['page_number']+1);
                Session::flash('front', $input['front'] == 1 ? 0 : 1);
                Session::flash('parcel_number', 1);
                return redirect()->route('parcels.create');
                break;
            case 'copy_proprietor_page':
                Session::flash('proprietor', $input['proprietor']);
                Session::flash('page_number', $input['page_number']);
                Session::flash('front', $input['front']);
                Session::flash('parcel_number', $input['parcel_number']+1);
                return redirect()->route('parcels.create');
                break;
            case 'copy_proprietor_page_plus1':
                Session::flash('proprietor', $input['proprietor']);
                Session::flash('page_number', $input['front'] == 1 ? $input['page_number'] : $input['page_number']+1);
                Session::flash('front', $input['front'] == 1 ? 0 : 1);
                Session::flash('parcel_number', 1);
                return redirect()->route('parcels.create');
                break;
            case 'new':
                return redirect()->route('parcels.create');
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
        $data = Parcel::findOrFail($id);

        $data->delete();
    
        Session::flash('flash_message', 'Parcelle successfully deleted.');
    
        return redirect()->route('parcels.index');
    }
    
    private function storeRelations($parcel, $input)
    {
        if (isset($input['proprietor']))
            $parcel->proprietors()->sync($input['proprietor']);
        else
            $parcel->proprietors()->sync(array());
            
        if (isset($input['place']))
            $parcel->places()->sync($input['place']);
        else
            $parcel->places()->sync(array());
            
        if (isset($input['parceltype']))
            $parcel->parcelTypes()->sync($input['parceltype']);
        else
            $parcel->parcelTypes()->sync(array());
            
        //parcel connections
        $connections = $parcel->parcelConnections()->get();
        
        if ($connections)
            $connectionIds = $connections->lists('id')->toArray();
    
        if (isset($input['connection_orientation'])) {
            
            foreach ($input['connection_orientation'] as $key => $orientation) {
            
                if (isset($input['connection_id'][$key])) {
                    $id = $input['connection_id'][$key];
                    $connection = ParcelConnection::findOrFail($id);
                    if (($i = array_search($id, $connectionIds)) !== false) {
                        unset($connectionIds[$i]);
                    }
                } else {
                    $connection = new ParcelConnection;
                }
                
                $connection->orientation = $orientation;
                $connection->comments = $input['connection_comments'][$key];
                $connection->uncertain = isset($input['connection_uncertain'][$key]) ? 1 : 0;
                
                $parcel->parcelConnections()->save($connection);
                
                $error = false;
                
                //connection with proprietor
                if ($input['connection_type'][$key] == 1) {
                    if (isset($input['connection_proprietors'])) {
                        $connection->proprietors()->sync($input['connection_proprietors'][$key]);
                        $connection->reference()->dissociate();
                    } else {
                        $error = true;
                    }
                } else {
                    $connection->reference()->associate(Reference::findOrFail($input['connection_reference'][$key]));
                    $connection->proprietors()->sync(array());
                }
                
                if ($error) {
                    $connection->delete();
                } else {
                    $connection->save();
                }
                    
            }
            
            if ($connections) {
                foreach ($connectionIds as $connectionId) {
                    ParcelConnection::findOrFail($connectionId)->delete();
                }
            }
            
        } elseif ($connections) {
            foreach ($connections as $connection) {
                $connection->delete();
            }
        }
            
    }
    
    private function calcValues($parcel, $input) {
        $fields = ['canne', 'coup', 'pugnerade', 'arpent', 'seteree', 'denier', 'sous', 'livre'];
        
        $calculator = new Calculator();
        
        foreach ($fields as $field) {
            $value = null;
            
            if (isset($input[$field . '_input']) && strlen($input[$field . '_input']) > 0) {
                $value = $calculator->calculate(str_replace(':','/', str_replace('x','*',$input[$field . '_input'])));
            }
            
            $parcel->{$field} = $value;
        }
        
        $parcel->save();
    }

}