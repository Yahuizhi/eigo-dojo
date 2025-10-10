<?php
// app/Models/UserTriedStoredQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $stored_question_id
 * @property int $question_id
 * @property int $answer_count
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\StoredQuestion $storedQuestion
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereAnswerCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereStoredQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTriedStoredQuestion whereUserId($value)
 * @mixin \Eloquent
 */
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
