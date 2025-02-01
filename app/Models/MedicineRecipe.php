<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineRecipe extends Model
{
    use HasFactory;

    protected $table = 'medicine_recipes';

    protected $guarded = ['id'];

    public function medicalPrescription()
    {
        return $this->belongsTo(MedicalPrescription::class, 'id_resep', 'id_resep');
    }
}
