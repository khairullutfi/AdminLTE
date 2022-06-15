<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
     use SoftDeletes;

     protected $table = "karyawan";

     protected $fillable = [
      'companies_id', 'name', 'tanggal',  'pos_code', 'pos_name', 'organisasi_code', 'organisasi_name'
  ];

    protected $hidden = [

    ];

     public function company(){
        return $this->hasOne(Company::class, 'id', 'companies_id');
    }
}
