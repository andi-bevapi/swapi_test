<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    //
    protected $fillable = [
        'next',
        'previous',
        'cargo_capacity',
        'consumables',
        'cost_in_credits',
        'crew',
        'floatlength',
        'manufacturer',
        'max_atmosphering_speed',
        'model',
        'name',
        'passengers',
        'pilots',
        'films',
        'url',
        'vehicle_class'
    ];

    protected $casts = [
        'films'=>'array',
        'pilots'=>'array'
    ];

    public function inventory(){
        return $this->hasMany('App\Inventory','vehicle_id');
    }

    public static function validateVehicleData($data){
        return json_encode(collect($data)->join(', '));
     }
}
