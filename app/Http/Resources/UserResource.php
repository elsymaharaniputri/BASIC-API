<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            //key -> $this->namaColumn
            
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'alamat' => $this->alamat,
            'hp' => $this->hp,
            'role_id'     => $this->role_id,
        ];
    }
}