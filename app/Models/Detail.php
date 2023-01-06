<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'details';
    protected $primaryKey = 'detail_id';
    protected $fillable = [
        'project_name',
        'year',
        'first_student_name',
        'second_student_name',
        'third_student_name',
        'supervisor_name',
        'supervisor_mark',
        'president_name',
        'president_mark',
        'examiner_name',
        'examiner_mark',
        'final_mark',
        'user_id',
    ];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
