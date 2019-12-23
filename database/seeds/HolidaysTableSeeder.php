<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('holidays')->insert([
            'name' => 'Nova godina',
            'name_slug' => Str::slug('Nova godina', '-'),
            'date' => Carbon::createFromDate(2020, 1, 1),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Sveta tri kralja',
            'name_slug' => Str::slug('Sveta tri kralja', '-'),
            'date' => Carbon::createFromDate(2020, 1, 6),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Uskrs',
            'name_slug' => Str::slug('Uskrs', '-'),
            'date' => Carbon::createFromDate(2020, 4, 12),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Uskrsni ponedjeljak',
            'name_slug' => Str::slug('Uskrsni ponedjeljak', '-'),
            'date' => Carbon::createFromDate(2020, 4, 13),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Praznik rada',
            'name_slug' => Str::slug('Praznik rada', '-'),
            'date' => Carbon::createFromDate(2020, 5, 1),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Dan državnosti',
            'name_slug' => Str::slug('Dan državnosti', '-'),
            'date' => Carbon::createFromDate(2020, 5, 30),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Tijelovo',
            'name_slug' => Str::slug('Tijelovo', '-'),
            'date' => Carbon::createFromDate(2020, 6, 11),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Dan antifašističke borbe',
            'name_slug' => Str::slug('Dan antifašističke borbe', '-'),
            'date' => Carbon::createFromDate(2020, 6, 22),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Dan pobjede i domovinske zahvalnosti i Dan hrvatskih branitelja',
            'name_slug' => Str::slug('Dan pobjede i domovinske zahvalnosti i Dan hrvatskih branitelja', '-'),
            'date' => Carbon::createFromDate(2020, 8, 5),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Velika Gospa',
            'name_slug' => Str::slug('Velika Gospa', '-'),
            'date' => Carbon::createFromDate(2020, 8, 15),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Dan svih svetih',
            'name_slug' => Str::slug('Dan svih svetih', '-'),
            'date' => Carbon::createFromDate(2020, 11, 1),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Dan sjećanja na žrtve Domovinskog rata i Dan sjećanja na žrtvu Vukovara i Škabrnje',
            'name_slug' => Str::slug('Dan sjećanja na žrtve Domovinskog rata i Dan sjećanja na žrtvu Vukovara i Škabrnje', '-'),
            'date' => Carbon::createFromDate(2020, 11, 18),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Božić',
            'name_slug' => Str::slug('Božić', '-'),
            'date' => Carbon::createFromDate(2020, 12, 25),
        ]);

        DB::table('holidays')->insert([
            'name' => 'Sveti Stjepan',
            'name_slug' => Str::slug('Sveti Stjepan', '-'),
            'date' => Carbon::createFromDate(2020, 12, 26),
        ]);
    }
}
