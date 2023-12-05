<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
   
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id, 
        'berat_sampah' => $this->berat_sampah,
        'alamat_jemput' => $this->kategori_sampah,
        'status'=> $this->status,
        'poin'=> $this->poin,
        'total_berat'=> $this->poin,
        'tanggal_jemput'=> $this->tanggal_jemput,
        'user_id'=> $this->user_id,
        'kategori_id'=> $this->kategori_id,
        ];
    }
}