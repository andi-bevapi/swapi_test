<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Starships;
use App\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StarshipController extends Controller
{
    //
    public function importStarship(){
        $data = Http::get('http://swapi.dev/api/starships/?page=4')->json();
        $starships = $data['results'];

        // var_dump($data);
        $starship_data = [];
        foreach($starships as $starship){
            if(! empty($starship)){
                $now = Carbon::now();
                $starship_data[]= [
                    'next' => $data['next'],
                    'previous' => $data['previous'],
                    'name' =>  $starship['name'],
                    'model' => $starship['model'],
                    'starship_class' => $starship['starship_class'],
                    'manufacturer' => $starship['manufacturer'],
                    'cost_in_credits' => $starship['cost_in_credits'],
                    'length' => $starship['length'],
                    'crew' => $starship['crew'],
                    'passengers' => $starship['passengers'],
                    'max_atmosphering_speed' => $starship['max_atmosphering_speed'],
                    'hyperdrive_rating' => $starship['hyperdrive_rating'],
                    'mglt' => $starship['MGLT'],
                    'cargo_capacity' => $starship['cargo_capacity'],
                    'films' => Starships::validateStarshipData($starship['films']),
                    'pilots' => Starships::validateStarshipData($starship['pilots']),
                    'consumables'=> $starship['consumables'],
                    'url' => $starship['url'],
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
        }
        // var_dump($starship_data);
        Starships::insert($starship_data);
        return response()->json(
            ['message' => 'The request succeeded.','status',200],
            200
        );
    }

    public function getStarship($id){
        $starship = Starships::findOrFail($id);
        $starship_quantity = Starships::findOrFail($id)->inventory;
        
        $starship_data = [
            'count' => $starship_quantity[0]->quantity,
            'next' => $starship['next'],
            'previous' => null,
            'results' => [
                'name' =>  $starship['name'],
                'model' => $starship['model'],
                'starship_class' => $starship['starship_class'],
                'manufacturer' => $starship['manufacturer'],
                'cost_in_credits' => $starship['cost_in_credits'],
                'length' => $starship['length'],
                'crew' => $starship['crew'],
                'passengers' => $starship['passengers'],
                'max_atmosphering_speed' => $starship['max_atmosphering_speed'],
                'hyperdrive_rating' => $starship['hyperdrive_rating'],
                'mglt' => $starship['MGLT'],
                'cargo_capacity' => $starship['cargo_capacity'],
                'films' => $starship['films'],
                'pilots' => $starship['pilots'],
                'consumables'=> $starship['consumables'],
                'url' => $starship['url'],
                'created_at' => $starship['created_at'],
                'updated_at' => $starship['updated_at']
            ]
        ];
        return $starship_data;
    }

    public function setQuantity($id,$number){
        $starship = DB::table('starships')->where('id','=',$id)->get();
        if(!$starship->isEmpty()){
            DB::table('inventories')->where('starship_id', $id)->update(['quantity' => $number]);
            return response()->json(
                ['message' => 'Quantity have updated with success ' , 'status',200],
                200);
        }
        return response()->json(
            ['message' => 'Starship with id ' .$id. ' was not found'.' status',404],
            200);
    }


    public function increment($id){
        $starship_inventory = DB::table('inventories')->where('starship_id','=',$id)->get();
        if(!$starship_inventory->isEmpty()){
           $quantity = $starship_inventory[0]->quantity + 1;

           DB::table('inventories')->where('starship_id', $id)->update(['quantity' => $quantity]);
           return response()->json(
            ['message' => 'Quantity incremented with success ' , 'status',200],
            200);
        }
        return response()->json(
            ['message' => 'Starship with id ' .$id. ' was not found'.' status',404],
            404);
    }


    public function decrement($id){
        $starship_inventory = DB::table('inventories')->where('starship_id','=',$id)->get();
        if(!$starship_inventory->isEmpty()){
           $quantity = $starship_inventory[0]->quantity - 1;

           DB::table('inventories')->where('starship_id', $id)->update(['quantity' => $quantity]);
           return response()->json(
            ['message' => 'Quantity decremented with success ' , 'status',200],
            200);
        }
        return response()->json(
            ['message' => 'Starship with id ' .$id. ' was not found'.' status',404],
            404);
    }
    
}
