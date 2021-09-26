<?php

namespace BlueSea\Cms\Console\Commands;

use Illuminate\Console\Command;

class InstallBlueSeaCms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bluesea:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs new BlueSeaCms CMS Instance';

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
     * @return int
     */
    public function handle()
    {
        return $this->error('We\'re Working on this feature');
    }
}
