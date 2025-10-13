<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StoredQuestion extends Model
{
    use HasFactory;
    
    
    protected $table = 'stored_questions';

    
    public function users():BelongsToMany
    {
        
        return $this->belongsToMany(User::class, 'user_tried_stored_questions', 'stored_question_id', 'user_id')
                    ->withPivot(['answer_count', 'priority']) 
                    ->withTimestamps(); 
    }

    
    public function updatePriority(int $userId, int $priorityNum): bool
    {
        
        $pivotData = $this->users()->where('user_id', $userId)->first();

        if ($pivotData) {
            
            $this->users()->updateExistingPivot($userId, [
                'priority' => $priorityNum,
                'updated_at' => now(),
            ]);
        } else {
            
            $this->users()->attach($userId, [
                'priority' => $priorityNum,
                'answer_count' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return true;
    }
}
