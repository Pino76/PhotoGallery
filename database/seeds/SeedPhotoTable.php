<?php

use Illuminate\Database\Seeder;
use App\Models\Photo;
class SeedPhotoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::statement("SET FOREIGN_KEY_CHECKS=0;"); // disabilitare momentaneamente la FK e svuotare la tabella
         Photo::truncate();
        factory(Photo::class, 200)->create();
    }
}
