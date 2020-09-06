<?php

namespace App\Http\Controllers;

use App\Hand;
use Illuminate\Http\Request;
use App\Services\PokerAnalyzer;

class PokerAnalyzerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the analyzer page.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // retrieving all hands
        $hands = Hand::paginate(10);

        // calculating winners
        $players = Hand::selectRaw('winner as i, count(winner) as wins')->groupBy('winner')->get();

        return view('analyzer', compact('hands', 'players'));
    }

    /**
     * Upload and store hands on database
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Htttp\RedirectResponse
     */
    public function analyze(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:txt']
        ]);

        // truncating hands table
        Hand::truncate();

        $file = $request->file('file');

        $this->parse($file->getRealPath());

        return redirect()->route('analyzer');
    }

    /**
     * parse file line by line, analyze and store on DB
     *
     * @param string $file
     *
     * @return null
     */
    protected function parse(string $file)
    {
        $analyzer = new PokerAnalyzer;

        $fd = fopen($file, 'r');

        while(!feof($fd)){
            $line = trim(fgets($fd));
            if(!empty($line)){
                $cards = array_chunk(explode(' ', $line), 5);
                Hand::create($analyzer->analyze($cards));
            }
        }

        fclose($fd);
    }
}
