<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model {
    protected $table = 'vehicle__types';
    protected $fillable = ['jenis','perjam_pertama','perjam_berikutnya','max_perhari'];
    public function transactions() { return $this->hasMany(Transaction::class, 'id_jenis'); }
}
