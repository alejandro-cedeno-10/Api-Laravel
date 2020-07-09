<?php

namespace App\Http\Resources;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tabla'=>'Users',
            'id'=>$this->id,
            "atributos"=>[
                'Nombre'=>$this->apellido
            ],
            "data"=>'as',
            "links"=>[
                /* 'self'=>route('user') */
            ]
        ];
    }
}
