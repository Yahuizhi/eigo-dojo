<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTriedStoredQuestion extends Model
{
    use HasFactory;

    protected $table = 'user_tried_stored_questions';

    
    public $timestamps = false; 

    
    protected $fillable = ['user_id', 'stored_question_id','answer_count', 'priority', 'created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function storedQuestion()
    {
        return $this->belongsTo(StoredQuestion::class);
    }
}
