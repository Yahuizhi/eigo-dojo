<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\Question|null $question
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionUser query()
 * @mixin \Eloquent
 */
class QuestionUser extends Pivot
{
    protected $table = 'question_user';
    protected $fillable = ['user_id','question_id','answer_count','priority'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}


