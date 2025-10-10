<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $Q
 * @property string $A
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion whereA($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion whereQ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoredQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StoredQuestion extends Model
{
    use HasFactory;
    // Just having Questions and Answers made by Gene AI.
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
}
