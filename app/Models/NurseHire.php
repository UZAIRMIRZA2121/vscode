<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseHire extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'nurse_id', 'hire_date', 'start_time', 'end_time','charge','status', 'rating', 'comment'];

    protected $casts = [
        'hire_date' => 'date', // Assuming 'hire_date' is the attribute representing the hire date
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
