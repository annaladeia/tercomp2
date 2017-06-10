<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use App\Document;
use Session;

class DocumentSession {

    public static function get() {
        
        $id = Session::get('document');
        
        if (! $id) {
            $id = DocumentSession::setDocument();
        }
        
        return Document::findOrFail($id);
    }
    
    public static function getID() {
        
        $document = DocumentSession::get();
        
        if ($document) {
            return $document->id;    
        } else {
            return false;
        }
    }
    
    public static function setDocument($id = false) {
        
        if (! $id || ! Document::findOrFail($id)) {
            
            if ($document = Document::first()) {
                $id = $document->id;
            }
            
        }
        
        if ($id) {
            Session::set('document', $id);
            return $id;
        } else {
            return false;
        }
    }
    
    public static function checkActiveDocument($document) {
        
        if ($document->id != Session::get('document')) {
            DocumentSession::setDocument($document->id);
            return redirect()->refresh();
        } else {
            return $document->id;
        }
    }
   
}