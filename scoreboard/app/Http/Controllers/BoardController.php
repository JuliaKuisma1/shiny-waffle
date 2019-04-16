<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // for database connection


class BoardController extends Controller {
    
    public function Board ()
    {
        return view('Board');
    }
    
    public function Test()
    {
        $datas = DB::select('select data, result from test_datas');
        
        // show the view
        return view('test', ["team" => $datas[1]->data], ["result" => $datas[1]->result]);
    }
    
    public function Past()
    {
        $past = DB::select('select data, result from past_games');
        $games = [];
        for ($i = 0; $i < 3; $i++)
        {
            array_push($games, $past[$i]->data, $past[$i]->result);
            //$games = ["{$past[$i]->data} | {$past[$i]->result}"];
        }
        return view('past', compact('games'));
    }
    
    public function Add()
    {
        return view('add');
    }
}
