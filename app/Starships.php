<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Starships extends Model
{
    //

    protected $fillable = [
        'count',
        'next',
        'previous',
        'name',
        'model',
        'starship_class',
        'manufacturer',
        'cost_in_credits',
        'length',
        'crew',
        'passengers',
        'max_atmosphering_speed',
        'hyperdrive_rating',
        'mglt',
        'cargo_capacity',
        'films',
        'pilots',
        'consumables',
        'url',
        'created_at',
        'updated_at'
        ];

    protected $casts = [
        'films'=>'array',
        'pilots'=>'array'
    ];

    public function inventory(){
        return $this->hasMany('App\Inventory','starship_id');
    }

    public static function validateStarshipData($data){
       return json_encode(collect($data)->join(', '));
    }
}
