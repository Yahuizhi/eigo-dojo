<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $stored_question_id
 * @property string $user_answer
 * @property int|null $tried_stored_question_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereStoredQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereTriedStoredQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUserAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUserId($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'stored_question_id','user_answer', 'tried_stored_question_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'question_user','question_id', 'user_id')
    //         ->withPivot('answer_count', 'priority')
    //         ->withTimestamps();
    //     // return $this->belongsTo(User::class);
    // }
    //     public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'user_tried_stored_questions', 'question_id', 'user_id')
    //                 ->withPivot('answer_count', 'priority')
    //                 ->withTimestamps();
    // }
    //     public function usertriedStoredQuestions()
    // {
    //     return $this->hasMany(UserTriedStoredQuestion::class);
    // }

    // public function questionUser(): HasMany
    // {
    //     return $this->hasMany(QuestionUser::class);
    // }
}

