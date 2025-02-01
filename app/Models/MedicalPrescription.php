<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPrescription extends Model
{
    use HasFactory;

    protected $guarded = ['id_resep'];
    protected $primaryKey = 'id_rekmed';

    public function medical_record()
    {
        return $this->hasMany(MedicalRecord::class, 'id_rekmed');
    }

    public function medicine_recipe()
    {
        return $this->hasMany(MedicineRecipe::class, 'id_resep');
    }
}