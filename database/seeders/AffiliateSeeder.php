<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AffiliateSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $fh = fopen('public/affiliates.txt','r');
        while ($line = fgets($fh)) {
	    $json_line = json_decode($line);

	    if (is_object($json_line))
            {
                $affilateId = DB::table('affiliates')->insertGetId([
                    'name' => $json_line->name,
		    'affiliate_id' => $json_line->affiliate_id,
		    'latitude' => $json_line->latitude,
                    'longitude' => $json_line->longitude,
	        ]);
	    }
        }
        fclose($fh);
    }
}
