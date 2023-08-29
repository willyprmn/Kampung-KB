<?php

use Illuminate\Database\Seeder;
use App\Models\Kampung;
use App\Scopes\KampungActiveScope;

class KampungUpdateMergerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #fix merger wilayan not completed
        #DST Janji Matogu
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 20714)->update(['is_active' => null]);
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 20555)->update([
            'is_active' => true,
            'kabupaten_id' => '1211',
            'kecamatan_id' => '122102',
            'desa_id' => '1221022024'
        ]);

        #PRAMPELAN 1
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 20760)->update(['is_active' => null]);
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 11421)->update([
            'is_active' => true,
            'kecamatan_id' => '330813',
            'desa_id' => '3308132020'
        ]);

        #NGUDI KARAHAYON
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 13021)->update([
            'is_active' => true,
            'kecamatan_id' => '330222',
            'desa_id' => '3302222009'
        ]);

        #Rantau Tijang
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 37267)->update(['is_active' => null]);
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 2210)->update([
            'is_active' => true,
            'kabupaten_id' => '1810',
            'kecamatan_id' => '181004',
            'desa_id' => '1810042009'
        ]);

        #PANCUR MAS
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 1715)->update([
            'desa_id' => '1611042032',
        ]);

        #Desa Kamuh
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 37385)->update(['is_active' => null]);
        Kampung::withoutGlobalScope(KampungActiveScope::class)->where('id', 3593)->update([
            'is_active' => true,
            'kabupaten_id' => '6107',
            'kecamatan_id' => '610717',
            'desa_id' => '6107172002',
        ]);

    }
}
