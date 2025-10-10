<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoredQuestion> $triedStoredQuestions
 * @property-read int|null $tried_stored_questions_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function triedStoredQuestions()
    {
        return $this->belongsToMany(StoredQuestion::class, 'user_tried_stored_questions')
                    ->withPivot('answer_count', 'priority')
                    ->withTimestamps();
    }
    //     public function questions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Question::class, 'user_tried_stored_questions', 'user_id', 'question_id')
    //                 ->withPivot('answer_count', 'priority')
    //                 ->withTimestamps();
    // }

    // ⑤ ユーザーが試した質問の履歴を取得
    
    // public function usertriedStoredQuestions()
    // {
    //     return $this->hasMany(UserTriedStoredQuestion::class);
    // }


//         public function answerQuestion($questionId)
// {
//     DB::transaction(function() use($questionId) {
//         $question= Question::find($questionId);
//         if($this->questions()->where('question_id', $questionId)->exists()) {
//             $this->questions()->updateExistingPivot($questionId, [
//                 'answer_count'=> DB::raw('answer_count + 1'),
//                 'updated_at'=> now(),
//             ]);
//         } else{
//             $this->questions()->attach($questionId, ['answer_count'=> 1, 'priority'=> 0]);
//                 }
//     });
// }

    // public function questions(): BelongsToMany
    // {
    //     // return $this->hasmany(Question::class);
    //     return $this->belongsToMany(Question::class, 'question_user','user_id', 'question_id')
    //         ->withPivot('answer_count','priority')
    //         ->withTimestamps();
    // }
    // public function questionUser(): HasMany
    // {
    //     return $this->hasMany(QuestionUser::class);
    // }
}
