<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlayerHand;
use App\Services\PokerAnalyzer;

class PokerAnalyzer2Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        
        // $hand = [
        //     ['5H', '6H', '7H', '8H', '9H'], 
        //     ['4C', '5C', '6C', '7C', '8C']
        // ];

        $hand = [
            ['8C', 'TS', 'KC', '9H', '4S'], 
            ['7D', '2S', '5D', '3S', 'AC']
        ];

        $analyzer = new PokerAnalyzer;
        dd($analyzer->analyze($hand));
    }
}
