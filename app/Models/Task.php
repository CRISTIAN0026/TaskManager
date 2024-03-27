<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'user_id', 'completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function task()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsCompleted($status)
    {
        if ($status == 'Completado' || $status == 'Bloqueado') {
            $this->status = $status;
            $this->completed_at = now();
            $this->save();
        }
    }
}
