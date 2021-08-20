<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicBillingSheet extends Model
{
    use HasFactory;
	
	protected $table = 'basic_billinig_sheets';
	
	protected $fillable = [
        
        'billing_sheet_file',
        'comments',
		'doctor_id',
		
    ];
}
