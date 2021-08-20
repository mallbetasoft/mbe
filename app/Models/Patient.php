<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'doctor_id',
        'first_name',
        'last_name',
        'dob',
        'image',
        'hospital_id',
        'specialist_id',
        'admission_date',
        'admission_status',
        'date_of_schedule',
        'refer_doctor_id',
        'referral_date',
		
    ];
}
