<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $data = Parcel::orderBy('page_number', 'asc')->orderBy('front', 'asc')->orderBy('parcel_number', 'asc')->get();

        return view('parcels.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proprietors = Proprietor::orderBy('name', 'asc')->orderBy('first_name', 'asc')->orderBy('nickname', 'asc')->get()->lists('field_display', 'id');
        $places = Place::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        $parceltypes = ParcelType::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        $references = Reference::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        
        return view('parcels.create', compact('proprietors', 'places', 'parceltypes', 'references'));
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
        
        $parcel = Parcel::create($input);
        
        $this->storeRelations($parcel, $input);
        $this->calcValues($parcel, $input);
        
        Session::flash('flash_message', 'Parcelle successfully added.');
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('parcels.edit', $parcel);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('parcels.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Parcel::findOrFail($id);
        
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
        $data = Parcel::findOrFail($id);
        $proprietors = Proprietor::orderBy('name', 'asc')->orderBy('first_name', 'asc')->orderBy('nickname', 'asc')->get()->lists('field_display', 'id');
        $places = Place::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        $parceltypes = ParcelType::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        $references = Reference::orderBy('name', 'asc')->get()->lists('field_display', 'id');
        
        return view('parcels.edit', compact('data', 'proprietors', 'places', 'parceltypes', 'references'));
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
    
        if ($input['redirect'] == 'edit')
            
            return redirect()->route('parcels.edit', $id);
    
        elseif ($input['redirect'] == 'new')
            
            return redirect()->route('parcels.create');
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
                }
                else
                    $connection = new ParcelConnection;
                
                $connection->orientation = $orientation;
                $connection->comments = $input['connection_comments'][$key];
                
                //connection with proprietor
                if ($input['connection_type'][$key] == 1) {
                    $connection->proprietor()->associate(Proprietor::findOrFail($input['connection_proprietor'][$key]));
                    $connection->reference()->dissociate();
                } else {
                    $connection->reference()->associate(Reference::findOrFail($input['connection_reference'][$key]));
                    $connection->proprietor()->dissociate();
                }
                
                $parcel->parcelConnections()->save($connection);
                    
            }
            
            if ($connections)
                foreach ($connectionIds as $connectionId) {
                    ParcelConnection::findOrFail($connectionId)->delete();
                }
            
        } elseif ($connections) {
            foreach ($connections as $connection) {
                $connection->delete();
            }
        }
            
    }
    
    private function calcValues($parcel, $input) {
        $fields = ['canne', 'coup', 'pugnerade', 'seteree', 'denier', 'sous', 'livre'];
        
        foreach ($fields as $field) {
            $value = null;
            
            if (isset($input[$field . '_input']) && strlen($input[$field . '_input']) > 0 && preg_match('/(\d+)(?:\s*)([\+\-\*\/])(?:\s*)(\d+)/', $input[$field . '_input'], $matches) !== FALSE){
                
                if (isset($matches[2])) {
                    $operator = $matches[2];
                
                    switch($operator){
                        case '+':
                            $value = $matches[1] + $matches[3];
                            break;
                        case '-':
                            $value = $matches[1] - $matches[3];
                            break;
                        case '*':
                            $value = $matches[1] * $matches[3];
                            break;
                        case '/':
                            $value = $matches[1] / $matches[3];
                            break;
                    }
                } else {
                    $value = str_replace(',', '.', $input[$field . '_input']);
                }
            }
            
            $parcel->{$field} = $value;
        }
        
        $parcel->save();
    }

}
