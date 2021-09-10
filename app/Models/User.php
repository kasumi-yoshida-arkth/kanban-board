<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Task;
use App\Models\Status;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class)->orderBy('order');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $user->statuses()->createdMany([
                [
                    'title' => '未処理',
                    'slug' => 'backlog',
                    'order' => 1
                ],
                [
                    'title' => '着手',
                    'slug' => 'up_next',
                    'order' => 1
                ],
                [
                    'title' => '進行中',
                    'slug' => 'progress',
                    'order' => 1
                ],
                [
                    'title' => '完了',
                    'slug' => 'done',
                    'order' => 1
                ],
                [
                    'title' => '保留',
                    'slug' => 'on_hold',
                    'order' => 1
                ],
            ]);
        });
    }
}
