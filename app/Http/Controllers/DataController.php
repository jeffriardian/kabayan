<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        $data = json_decode(file_get_contents(storage_path() . "/backend-titanic-test.json"), true);
        
        return $data;
    }

    public function show_most_occuring()
    {
        $data = json_decode(file_get_contents(storage_path() . "/backend-titanic-test.json"), true);

        $ages = [];
        
        foreach ($data as $row) {
            $ages[] = $row['age'];
        }

        $c = array_count_values($ages); 
        $most_age = array_search(max($c), $c);

        $collection = collect($data);
        $filtered = $collection->whereIn('age', $most_age);
        
        $result = [];
        
        foreach ($filtered as $row) {
            $result[] = $row['name'];
        }

        return array_values($result);
    }

    public function show_group()
    {
        $data = json_decode(file_get_contents(storage_path() . "/backend-titanic-test.json"), true);

        $collection = collect($data);

        $group = $collection->groupBy('age')->values();

        $result =  $group->map(function($items, $key){
                        return $items->map(function ($item){
                            return $item['name'];
                        });
                    });

        return $result;
    }
}
