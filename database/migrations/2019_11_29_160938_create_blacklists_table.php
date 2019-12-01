<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlacklistsTable extends Migration
{

    /**
     * @var array
     */
    protected $blacklist = [
        'applehelp_accessories',
        'elenashop_krasnodar',
        'nail_brow_lash',
        'krasnodar_resnichki',
        'lash_and_brow_krasnodar',
        'beauty_lashes23',
        'alisaiks_krasnodar',
        'titova_resnizy',
        'art_beauty_krd',
        'massage_zet',
        'massage_mix',
        'massage_krd__',
        'slim_massage_krd',
        'massage_stroinoetelo_krasnodar',
        'dr_baselmelhem',
        'orlov_ortho',
        'atelier_dream',
        'defile_krd',
        'dream_discount',
        'fifiona.ru',
        'fifiona_salon',
        'sofia_fifiona.ru',
        'snuslips_krd',
        'moly_krd',
        'malina_show_room',
        'sliffki_krd',
        'pudraroom_krd',
        'zion_nailstudio',
        'na_klavishah',
        'pop_nails_krasnodar',
        'mulenko_nails',
        'nails_panorama_krd',
        'panorama_nails',
        'nail7_krd',
        'nogti_shellac_krasnodar',
        'dr._amira_',
        'nails_by_Darya ',
        'brow_male_krd',
        'nail_brow_lash',
        'whiteskin__',
        'resnichka_viktoria_krd',
        'fashion_centre',
        'fotoshar_kzn',
        'sharynovogodnie',
        'bogatovi.ru',
        'wow_shayrma',
        'love_shop_krd',
        'atelier_dream',
        'manydressru',
        'kati_nailskrd',
        'kati_nailspb',
        'aleykatya',
        'resnichki_krd_innach',
        'irinam_nails_23',
        'bobrow23',
        'hair_control_krd',
        'ybbrows',
        'oksy28101984',
        'esteticmyway',
        'nastyapyanykh',
        'profmassaj',
        'massage_dayanova',
        'flamingooo_spa',
        'slim.bar',
        'massag.t',
        'slim_studio_krd',
        'b.o.accessories ',
        'fetisov_sergey_krd',
        'workoutkuban',
        'zaryadka_krd',
        'turagentstvo',
        'sugaring_krasnodar_buduar',
        'sugar_ushakova',
        'sugaring_master_krasnodar',
        'sugarlav',
        'lady_krd',
        'nasta_skarlet',
        'sugaring_krasnodar1',
        'shugaring_krasnodare',
        'olgasugaring_krd',
        'shugashuga_krasnodar',
        'na_klavishah',
        'nogotohci_krasnodar',
        'vlada_voskresenskaya',
        'nail_krasnodar_shellac',
        'laque_nail_lounge_',
        'krasnodar_manikur',
        'nogotki_krasnodar_',
        'veranails_krd',
        'candy_nails_krd',
        'larisa_chikrizova',
        'go_shopping_krd',
        'elynchew',
        'gutenberg_krr',
        'djuan925',
        'luxeaccesorie',
        'doradojewellery',
        'serebro925_khv',
        '925_925_',
        'muhtasem_',
        '925_925_',
        'djuan925',
        'ksenia_krd',
        'platon_shop_krd',
        'dot_fashion_store',
        'inside_krd',
        'one_love_krd23',
        'starlookdesign',
        'shop_lale_krd',
        'podium_showroom_',
        'vox_alisalanskaja',
        'karamel__krd',
        'etnomir',
        'vector23.ru_kdr',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blacklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        $blacklists = [];
        foreach (array_unique($this->blacklist) as $name) {
            $blacklists[] = compact('name');
        }

        \Illuminate\Support\Facades\DB::table('blacklists')
            ->insert($blacklists);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blacklists');
    }
}
