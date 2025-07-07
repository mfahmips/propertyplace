<?php

namespace Config;

use CodeIgniter\Config\BaseCommand;
use CodeIgniter\CLI\Commands as CLICommands;

class Commands extends CLICommands
{
    protected $commands = [
        'shield:publish' => \CodeIgniter\Shield\Commands\ShieldPublish::class,
    ];
}
