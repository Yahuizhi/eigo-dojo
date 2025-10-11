<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class StoredQuestion extends Model
{
    use HasFactory;
    
    protected $fillable=['Q','A'];
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }       

   
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tried_stored_questions')
                    ->withPivot('answer_count', 'priority')
                    ->withTimestamps();
    }

    // App/Models/StoredQuestion.php

    public function triedUsers()
    {
        return $this->belongsToMany(User::class, 'user_tried_stored_questions')
            ->withPivot('answer_count', 'priority')
            ->withTimestamps();
    }

    public function userPivot()
    {
        // belongsToMany を使用し、wherePivot でユーザーを絞り込む
        return $this->belongsToMany(User::class, 'user_tried_stored_questions', 'stored_question_id', 'user_id')
            ->as('pivotData') // pivot としてアクセスできるように別名を付ける
            ->withPivot('priority', 'answer_count', 'created_at', 'updated_at') // 必要なカラムを取得
            ->wherePivot('user_id', auth()->id());
    }
}
