<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

final class  XmlParserService
{
    /**
     * @param $path
     * @param $filename
     * @return void
     */

    // это, конечно, лучше доработать
    //
    // - по методам загрузку файла и upsert, но уж больно простой показалась задача
    // -  возвращать лучше булевое значение, выкидывать exception, если файла нет и т. п.
    // консольная утилита - через ларавельный artisan

    static public function parser(string $path = '/xml/' , string $filename = 'data.xml'): void
    {
        $xml = simplexml_load_file($path.$filename)->offers->offer;

        DB::table('data')->update(['in_xml' => 0]);

        foreach ($xml as $offer) {

            DB::table('data')->upsert(
                [
                    'id' => $offer->id,
                    'mark' => $offer->mark,
                    'model' => $offer->model,
                    'generation' => $offer->generation,
                    'year' => $offer->year,
                    'run' => $offer->run,
                    'color' => $offer->color,
                    'body_type' => $offer->{'body-type'},
                    'engine_type' => $offer->{'engine-type'},
                    'transmission' => $offer->transmission,
                    'gear_type' => $offer->{'gear-type'},
                    'generation_id' => (int)($offer->generation_id),
                ],
                ['id'],
                [
                    'mark',
                    'model',
                    'generation',
                    'year',
                    'run',
                    'color',
                    'body_type',
                    'engine_type',
                    'transmission',
                    'gear_type',
                    'in_xml'
                ]
            );


            DB::table('data')->where('id', '=', $offer->id)->update(['in_xml' => 1]);
        }

        DB::table('data')->where('in_xml', '=', 0)->delete();
    }

}
