<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\GrobnoMestoReplaceSeeder;
use Database\Seeders\UplatilacReplaceSeeder;
use Database\Seeders\UplatilacGrobnoMestoPivotSeeder;
use Database\Seeders\UplataReplaceSeeder;

class ImportData extends Command
{
    protected $signature = 'data:import {--force : Force import even if data exists}';
    protected $description = 'Import all data from seeders in correct order';

    public function handle()
    {
        $this->info('Starting data import...');
        
        try {
            // 1. Import grobna mesta
            $this->info('Importing grobna mesta...');
            $this->call('db:seed', ['--class' => GrobnoMestoReplaceSeeder::class, '--force' => true]);
            
            // 2. Import uplatioci
            $this->info('Importing uplatioci...');
            $this->call('db:seed', ['--class' => UplatilacReplaceSeeder::class, '--force' => true]);
            
            // 3. Import pivot relationships
            $this->info('Importing pivot relationships...');
            $this->call('db:seed', ['--class' => UplatilacGrobnoMestoPivotSeeder::class, '--force' => true]);
            
            // 4. Import uplate
            $this->info('Importing uplate...');
            $this->call('db:seed', ['--class' => UplataReplaceSeeder::class, '--force' => true]);
            
            $this->info('Data import completed successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error during import: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
} 