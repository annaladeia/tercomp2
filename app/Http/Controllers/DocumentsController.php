<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Document;
use App\Place;
use App\ParcelConnection;
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
    
    public function generateMap($id) {
        $data = Document::findOrFail($id);
        
        return view('documents.map')->withData($data);
    }
    
    public function generateMapJSON($id, $highlightPlace = 'Sirech', $excludeExceptPlace = false) {
        
        //create response array
        $response = array();
        
        //get document
        $document = Document::findOrFail($id);
        
        //get places
        $places = $document->places()->get();
        $placeColors = array();
        $i = 1;
        $defaultColor = 'black';
        
        foreach ($places as $p) {
            
            if ($p->name == $highlightPlace) {
                $color = 'red';
            } else {
                $color = 'gray';
            }
            
            $placeColors[$p->id] = $color;
        }
        
        //create array with proprietors of each connection
        $proprietorsData = $document->proprietors()->with('parcelConnections')->get();
        
        $connectionProprietors = array();
        
        foreach ($proprietorsData as $p) {
            
            foreach ($p->parcelConnections->pluck('id')->toArray() as $cID) {
                if (! isset($connectionProprietors[$cID])) {
                    $connectionProprietors[$cID] = array();
                }
                $connectionProprietors[$cID][] = $p->id;
            }
        }
        
        //create structured arrays to prevent high number of sql queries
        $proprietorsData = $document->proprietors()->with('parcels')->with('parcels.places')->with('parcels.proprietors')->with('parcels.parcelConnections')->with('parcels.parcelConnections.reference')->get();
        
        $proprietors = array();
        $parcels = array();
        $connections = array();
        
        $connectionCount = 0;
        
        foreach ($proprietorsData as $pr) {
            
            $proprietors[$pr->id] = array('record' => $pr, 'parcels' => array());
            
            foreach ($pr->parcels as $pa) {
                $proprietors[$pr->id]['parcels'][$pa->id] = array('record' => $pa, 'proprietors' => $pa->proprietors->pluck('id')->toArray(), 'connections' => array());
                
                $parcels[$pa->id] =& $proprietors[$pr->id]['parcels'][$pa->id];
                
                $color = $defaultColor;
                $highlight = false;
                $display = $excludeExceptPlace ? false : true;
                
                foreach ($pa->places as $pl) {
                    $color = $placeColors[$pl->id];
                    if ($pl->name == $highlightPlace) {
                        $highlight = true;
                    }
                    
                    if ($pl->name == $excludeExceptPlace) {
                        $display = true;
                    }
                    
                    break;
                }
                
                $proprietors[$pr->id]['parcels'][$pa->id]['color'] = $color;
                $proprietors[$pr->id]['parcels'][$pa->id]['highlight'] = $highlight;
                $proprietors[$pr->id]['parcels'][$pa->id]['display'] = $display;
                
                $numConnections = 0;
                
                foreach ($pa->parcelConnections as $pc) {
                    $proprietors[$pr->id]['parcels'][$pa->id]['connections'][$pc->id] = array('record' => $pc, 'proprietors' => array());
                    
                    if (isset($connectionProprietors[$pc->id])) {
                        $proprietors[$pr->id]['parcels'][$pa->id]['connections'][$pc->id]['proprietors'] =& $connectionProprietors[$pc->id];
                        $numConnections++;
                    }
                    
                    $connections[$pc->id] =& $proprietors[$pr->id]['parcels'][$pa->id]['connections'][$pc->id];
                }
                
                if ($numConnections > $connectionCount) {
                    $connectionCount = $numConnections;
                    $firstParcel = $pa->id;
                }
            }
        }
        
        //create a parcelQueue array
        $parcelQueue = array();
        
        //create array of finished parcels
        $finishedParcels = array();
        
        //
        
        //add first parcel to queue
        $parcelQueue[] = $parcels[$firstParcel];
        
        //set init x, y coordinates
        $parcelQueue[0]['x'] = 0;
        $parcelQueue[0]['y'] = 0;
        
        //init $grid array which holds number of items per coordinate
        $grid = array();
            
        //draw first parcel
        if (! $parcelQueue[0]['display']) {
            $response[] = ['data' => ['id' => $parcelQueue[0]['record']->id, 'zindex' => $parcelQueue[0]['highlight'] ? '9' : '0', 'color' => $parcelQueue[0]['color']], 'position' => ['x' => $parcelQueue[0]['x'], 'y' => $parcelQueue[0]['y']]];
            $grid['0:0'][] = 0;
        }
        
        $errors = 0;
        
        $i = 0;
        $k = 0;
        
        $references = array();
        
        //sirech
        
        //while parcelQueue has parcels...
        while (sizeof($parcelQueue) > 0 && $i < 5000) {
            $i++;
            //get first parcel in Queue
            $p = reset($parcelQueue);
            
            //loop over confronts
            foreach ($p['connections'] as $cID => $c) {
                
                $xyIndex = false;

                if ($c['record']->reference && $p['display']) {
                    
                    $reference = $c['record']->reference;
                    
                    $drawReference = true;
                    
                    //calculate id
                    if (isset($references[$reference->id])) {
                        if ($reference->type == 2) { //reference is a fixed point (type 2) and has already been drawn
                            $drawReference = false;
                        } else {
                            $references[$reference->id]++;
                        }
                    } else {
                        $references[$reference->id] = 1;
                    }
                        
                    $id = 'reference_' . $reference->id . '_' . $references[$reference->id];
                    
                    if ($drawReference) {
                    
                        //set x y 0 by default
                        $x = 0;
                        $y = 0;
                        
                        //draw connection
                        switch ($c['record']->orientation) {
                            case 1:
                                $y = 1;
                                break;
                            case 2:
                                $x = 1;
                                break;
                            case 3:
                                $y = -1;
                                break;
                            case 4:
                                $x = -1;
                                break;
                        }
                        
                        $x = $p['x'] + ($x * 500);
                        $y = $p['y'] + ($y * 500);
                        
                        $response[] = ['data' => ['id' => $id, 'name' => $reference->name, 'zindex' => '10', 'color' => 'orange'], 'position' => ['x' => $x, 'y' => $y]];
                        
                        $xyIndex = $x . ':' . $y;
                        end($response);
                        $responseIndex = key($response);
                    
                    }
                    
                    $response[] = ['data' => ['id' => 'connection_' . $cID, 'style' => 'dotted', 'source' => $p['record']->id, 'color' => 'gray', 'target' => $id]];
                    
                } elseif (sizeof($c['proprietors']) > 0) {

                    $connectedParcel = false;

                    //loop over neighbours (proprietors of connection's parcel)
                    foreach ($c['proprietors'] as $nID) {
                        
                        //loop over neighbour's parcels
                        foreach ($proprietors[$nID]['parcels'] as $npID => $np) {

                            //loop over confronts
                            foreach ($np['connections'] as $npcID => $npc) {

                                $match = false;
                                
                                //skip iteration if confront is not with a proprietor
                                if (! isset($connectionProprietors[$npcID]))
                                    continue;
                                
                                //skip iteration if confront is not opposite to parcel $p's connection's orientation
                                if ($npc['record']->orientation != $c['record']->oppositeOrientation)
                                    continue;
                                    
                                //check if at least one proprietor is one of the proprietors of parcel $p
                                foreach ($npc['proprietors'] as $npcnID) {
                                    if (in_array($npcnID, $p['proprietors'])) {
                                        $connectedParcel = $npID;
                                    }
                                }
                            }
                            
                            //@todo: check if parcels has more than one confront with proprietor of parcel $p
                        }
                        
                    }
                    
                    //check if connection is mutual
                    if ($connectedParcel) {
                        
                        if (! in_array($connectedParcel, $finishedParcels)) {
                            
                            //set x y 0 by default
                            $x = 0;
                            $y = 0;
                            
                            //draw connection
                            switch ($c['record']->orientation) {
                                case 1:
                                    $y = 1;
                                    break;
                                case 2:
                                    $x = 1;
                                    break;
                                case 3:
                                    $y = -1;
                                    break;
                                case 4:
                                    $x = -1;
                                    break;
                            }
                            
                            $parcels[$connectedParcel]['x'] = $p['x'] + ($x * 500);
                            $parcels[$connectedParcel]['y'] = $p['y'] + ($y * 500);
                            
                            if ($parcels[$connectedParcel]['display']) {
                                $response[] = ['data' => ['id' => $connectedParcel, 'zindex' => $parcels[$connectedParcel]['highlight'] ? '9' : '0', 'color' => $parcels[$connectedParcel]['color']], 'position' => ['x' => $parcels[$connectedParcel]['x'], 'y' => $parcels[$connectedParcel]['y']]];
                            
                                $xyIndex = $parcels[$connectedParcel]['x'] . ':' . $parcels[$connectedParcel]['y'];
                                end($response);
                                $responseIndex = key($response);
                            }                            
                            
                            $parcelQueue[] = $parcels[$connectedParcel];
                            $finishedParcels[] = $connectedParcel;
                        }
                        
                        $response[] = ['data' => ['id' => 'connection_' . $cID, 'style' => 'dotted', 'source' => $p['record']->id, 'color' => 'gray', 'target' => $connectedParcel]];
                        
                    } else {
                        
                        //somehow the connection is not mutual
                        $errors++; 
                        
                        //@todo: list this connection somewhere to be able to manually investigate
                    }
                }
                    
                if ($xyIndex) {
                    if (isset($grid[$xyIndex])) {
                        $grid[$xyIndex][] = $responseIndex;
                    } else {
                        $grid[$xyIndex] = array($responseIndex);
                    }
                }
                
                    
                //@todo: get confronts with confronts invariants
            }
                    
            $finishedParcels[] = $p['record']->id;
            
            unset($parcelQueue[key($parcelQueue)]);
                        
        }
        
        $pi = pi();
        
        $tempResponse = array();
        
        foreach($grid as $xy => $position) {
            $items = sizeof($position);
            
            //echo $items . "\n";
            
            if ($items > 1) {

                $xyArray = explode(':', $xy);
                $x = $xyArray[0];
                $y = $xyArray[1];
                $i = 1;
                
                //echo $x . ' - ' . $y . "\n";
                
                foreach ($position as $p) {
                     
                    $theta = (($pi*2) / $items);
                    $angle = ($theta * $i);
                    
                    // echo $p . ': ';
                    // echo $response[$p]['position']['x'] . ' - ' . $response[$p]['position']['y'] . "\n";
                
                    $response[$p]['position']['x'] = (200 * cos($angle) + $x);
                    $response[$p]['position']['y'] = (200 * sin($angle) + $y);
                    
                    $tempResponse[] = $response[$p];
                    
                    // echo $response[$p]['position']['x'];
                    // echo ' - ';
                    // echo $response[$p]['position']['y'];
                    // echo "\n";
                    
                    $i++;
                }
                //die();
                //break;
            }
        }
        
        foreach ($references as $referenceID => $ref) {
            if ($ref > 1) {
                
                $id = false;
                
                for ($i = 1; $i <= $ref; $i++) {
                    
                    $currentID = 'reference_' . $referenceID . '_' . $i; 
                    
                    if ($id) {
                        $response[] = ['data' => ['id' => 'connection_' . $referenceID . '_' . $i, 'style' => 'solid', 'color' => 'orange', 'source' => $id, 'target' => $currentID]];       
                    }
                    
                    $id = $currentID;
                }
            }
        }
        
        return json_encode($response);
    }

}
