<?php

namespace App\Console\Commands;

use App\Imports\OfficesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfficesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'launch:import_data {filename=LISTADO_CENTROS_SERVIFORM.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Imports data from file 'LISTADO_CENTROS_SERVIFORM.xlsx' located in public/files/import";

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
        if(DB::table('offices')->count() == 0 || true){

            try {
                $filename = $this->argument('filename');
                Excel::import(new OfficesImport, public_path("files/import/$filename"));
            } catch (\Exception $e) {
                $this->error($e->getMessage());
                return;
            }

            $this->info('El fichero se ha importado con éxito');
        }else{
            $this->error('Base datos ya tiene registros insertados, limpie las tablas de offices para importar los registros iniciales');
        }
    }
}
