<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\PokerAnalyzer as Analyzer;
use App\Hand;

use Symfony\Component\Console\Helper\Table;

class PokerAnalyzer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poker:analyze {file : the file to be imported}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze hands by txt file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $analyzer = new Analyzer;

        $file = $this->argument('file');

        if(!file_exists($file))
        {
            $this->error("File $file does not exists!");
            return;
        }

        // truncating hands table
        Hand::truncate();

        $this->parse($file);
        $this->line('');

        // retrieving all hands
        $headers = ['Player 1 Cards', 'Player 1 Rank', 'Player 2 Cards', 'Player 2 Rank', 'Winner'];
        $this->table($headers, Hand::all());        

        // calculating winners
        $players = Hand::selectRaw('winner as i, count(winner) as wins')->groupBy('winner')->get();

        $players->each(function($player){
            $this->info('Player ' . $player->i . ' wins ' . $player->wins . ' times');
        });
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
        $analyzer = new Analyzer;
        $bar = $this->output->createProgressBar();

        $fd = fopen($file, 'r');

        while(!feof($fd))
        {
            $line = trim(fgets($fd));
            if(!empty($line))
            {
                $cards = array_chunk(explode(' ', $line), 5);
                Hand::create($analyzer->analyze($cards[0], $cards[1]));

                $bar->advance();
            }
        }

        $bar->finish();
    }

    /**
     * Format input to textual table.
     *
     * @param  array   $headers
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $rows
     * @param  string  $tableStyle
     * @param  array   $columnStyles
     * @return void
     */
    public function table($headers, $rows, $tableStyle = 'default', array $columnStyles = [])
    {
        $table = new Table($this->output);

        $table->setHeaders((array) $headers)->setStyle($tableStyle);

        $rows->each(function($hand) use($table)
        {
            $table->addRows([[
                $hand->p1_cards->implode(' '),
                $hand->p1_rank,
                $hand->p2_cards->implode(' '),
                $hand->p2_rank,
                $hand->winner
            ]]);
        });

        foreach ($columnStyles as $columnIndex => $columnStyle) {
            $table->setColumnStyle($columnIndex, $columnStyle);
        }

        $table->render();
    }
}
