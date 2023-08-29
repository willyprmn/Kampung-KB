<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProfilKampung extends Model implements Transformable
{

    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bulan',
        'tahun',
        'kampung_kb_id',
        'bulan',
        'tahun',
        'pokja_pengurusan_flag',
        'pokja_sk_flag',
        'pokja_pelatihan_flag',
        'pokja_pelatihan_desc',
        'pokja_jumlah',
        'pokja_jumlah_terlatih',
        'plkb_pendamping_flag',
        'plkb_nip',
        'plkb_nama',
        'plkb_kontak',
        'plkb_pengarah_id',
        'plkb_pengarah_lainnya',
        'regulasi_flag',
        'regulasi_id',
        'rencana_kerja_masyarakat_flag',
        'penggunaan_data_flag',
        'is_active',
        'created_at',
    ];

    // TODO need to defined in migration for adding timestamp
    protected $touches = ['kampung'];
    public $table = 'new_profil_kampung';
    protected $dates = ['created_at'];
    protected $casts = [
        'pokja_pengurusan_flag' => 'boolean',
        'regulasi_flag' => 'boolean',
        'penggunaan_data_flag' => 'boolean',
        'plkb_pendamping_flag' => 'boolean',
    ];


    public static function getTableName()
    {
        return (new self())->getTable();
    }


    public function archive()
    {
        return $this->morphOne(Archive::class, 'attachable');
    }

    public function plkb()
    {
        return $this->belongsTo(PlkbPengarah::class, 'plkb_pengarah_id');
    }


    public function kampung()
    {
        return $this->belongsTo(Kampung::class, 'kampung_kb_id');
    }


    public function regulasi()
    {
        return $this->belongsTo(Regulasi::class);
    }


    public function regulasis()
    {
        return $this->belongsToMany(Regulasi::class, 'new_profil_regulasi', 'profil_id')
            ->using(ProfilRegulasi::class)
            ->withTimestamps()
            ;
    }


    public function profil_regulasis()
    {
        return $this->hasMany(ProfilRegulasi::class, 'profil_id');
    }


    public function profil_operasionals()
    {
        return $this->hasMany(ProfilOperasional::class, 'profil_id');
    }


    public function profil_programs()
    {
        return $this->hasMany(ProfilProgram::class, 'profil_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'new_profil_program', 'profil_id')
            ->using(ProfilProgram::class)
            ->withPivot(['program_flag'])
            ->withTimestamps()
            ;
    }

    public function operasionals()
    {
        return $this->belongsToMany(Operasional::class, 'new_profil_operasional', 'profil_id')
            ->using(ProfilOperasional::class)
            ->withPivot(['frekuensi_id', 'profil_id', 'operasional_id', 'operasional_flag', 'frekuensi_lainnya'])
            ->as('pivot')
            ->withTimestamps();
    }

    public function profil_sumber_danas()
    {
        return $this->hasMany(ProfilSumberDana::class, 'profil_id');
    }

    public function sumber_danas()
    {
        return $this->belongsToMany(SumberDana::class, 'new_profil_sumber_dana', 'profil_id')
            ->withTimestamps();
    }


    public function profil_penggunaan_datas()
    {
        return $this->hasMany(ProfilPenggunaanData::class, 'profil_id');
    }

    public function penggunaan_datas()
    {
        return $this->belongsToMany(PenggunaanData::class, 'new_profil_penggunaan_data', 'profil_id')
            ->using(ProfilPenggunaanData::class)
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
