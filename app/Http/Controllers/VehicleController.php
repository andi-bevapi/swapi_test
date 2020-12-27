<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Vehicles;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    //

    public function importVehicles(){
        $data = Http::get('https://swapi.dev/api/vehicles?page=4')->json();
        $vehicles = $data['results'];


        $vehicles_data = [];
        foreach($vehicles as $vehicle){
            $now = Carbon::now();
            $vehicles_data[]= [
                'next' => $data['next'],
                'previous' => $data['previous'],
                'name' =>  $vehicle['name'],
                'model' => $vehicle['model'],
                'vehicle_class' => $vehicle['vehicle_class'],
                'manufacturer' => $vehicle['manufacturer'],
                'cost_in_credits' => $vehicle['cost_in_credits'],
                'length' => $vehicle['length'],
                'crew' => $vehicle['crew'],
                'passengers' => $vehicle['passengers'],
                'max_atmosphering_speed' => $vehicle['max_atmosphering_speed'],
                'cargo_capacity' => $vehicle['cargo_capacity'],
                'films' => Vehicles::validateVehicleData($vehicle['films']),
                'pilots' => Vehicles::validateVehicleData($vehicle['pilots']),
                'consumables'=> $vehicle['consumables'],
                'url' => $vehicle['url'],
                'created_at' => $now,
                'updated_at' => $now
            ];
        }
        Vehicles::insert($vehicles_data);
        return response()->json(
            ['message' => 'The request succeeded.','status',200],
            200
        );
    }


    public function getVehicle($id){
        $vehicle = Vehicles::findOrFail($id);
        $vehicle_quantity = Vehicles::findOrFail($id)->inventory;
        
        $vehicle_data = [
            'count' => $vehicle_quantity[0]->quantity,
            'next' => $vehicle['next'],
            'previous' => null,
            'results' => [
                'name' =>  $vehicle['name'],
                'model' => $vehicle['model'],
                'vehicle_class' => $vehicle['vehicle_class'],
                'manufacturer' => $vehicle['manufacturer'],
                'cost_in_credits' => $vehicle['cost_in_credits'],
                'length' => $vehicle['length'],
                'crew' => $vehicle['crew'],
                'passengers' => $vehicle['passengers'],
                'max_atmosphering_speed' => $vehicle['max_atmosphering_speed'],
                'cargo_capacity' => $vehicle['cargo_capacity'],
                'films' => $vehicle['films'],
                'pilots' => $vehicle['pilots'],
                'consumables'=> $vehicle['consumables'],
                'url' => $vehicle['url'],
                'created_at' => $vehicle['created_at'],
                'updated_at' => $vehicle['updated_at']
            ]
        ];
        return $vehicle_data;
    }

    public function setQuantity($id,$number){
        $vehicle = DB::table('vehicles')->where('id','=',$id)->get();
        if(!$vehicle->isEmpty()){
            DB::table('inventories')->where('vehicle_id', $id)->update(['quantity' => $number]);
            return response()->json(
                ['message' => 'Quantity have updated with success ' , 'status',200],
                200);
        }
        return response()->json(
            ['message' => 'Vehicle with id ' .$id. ' was not found'.' status',404],
            200);
    }


    public function increment($id){
        $vehicle_inventory = DB::table('inventories')->where('vehicle_id','=',$id)->get();
        if(!$vehicle_inventory->isEmpty()){
           $quantity = $vehicle_inventory[0]->quantity + 1;

           DB::table('inventories')->where('vehicle_id', $id)->update(['quantity' => $quantity]);
           return response()->json(
            ['message' => 'Quantity incremented with success ' , 'status',200],
            200);
        }
        return response()->json(
            ['message' => 'Vehicle with id ' .$id. ' was not found'.' status',404],
            404);
    }


    public function decrement($id){
        $vehicle_inventory = DB::table('inventories')->where('vehicle_id','=',$id)->get();
        if(!$vehicle_inventory->isEmpty()){
           $quantity = $vehicle_inventory[0]->quantity - 1;

           DB::table('inventories')->where('vehicle_id', $id)->update(['quantity' => $quantity]);
           return response()->json(
            ['message' => 'Quantity decremented with success ' , 'status',200],
            200);
        }
        return response()->json(
            ['message' => 'Vehicle with id ' .$id. ' was not found'.' status',404],
            404);
    }
}
