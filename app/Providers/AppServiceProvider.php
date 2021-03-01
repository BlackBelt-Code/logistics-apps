<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot() {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            // die("Could not connect to the database.  Please check your configuration. error:" . $e );
            // dd($e);
            if($e->code == 1049) {
                return response()->json(['status' => 'Could not connect to the database.  Please check your configuration', $e->message], 500);
            }
        }
    }
}
