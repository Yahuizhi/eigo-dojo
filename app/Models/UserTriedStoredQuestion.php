<?php
// app/Models/UserTriedStoredQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTriedStoredQuestion extends Model
{
    use HasFactory;

    protected $table = 'user_tried_stored_questions';

    protected $fillable = ['user_id', 'question_id', 'stored_question_id','answer_count', 'priority'];

    // ④ 試した質問の履歴情報を取得
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ③ 試した元の質問情報を取得
    public function storedQuestion()
    {
        return $this->belongsTo(StoredQuestion::class);
    }
}
