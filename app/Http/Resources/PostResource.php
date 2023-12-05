<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    //define properti
    public $status;
    public $message;

      public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }
    public function toArray(Request $request)
    {
         return [
            //key -> $this->namaColumn
            
            'id' => $this->id,
            'kategori_sampah' => $this->kategori_sampah,
            'harga_sampah' => $this->harga_sampah,
        ];
    }
}