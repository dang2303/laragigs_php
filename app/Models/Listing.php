<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    //protected $fillable = ['title', 'description', 'location', 'website', 'email', 'tags', 'company'];

    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags', 'like', '%' .request('tag') . '%');
        }
        if($filters['search'] ?? false){
            $query->where('title', 'like', '%' .request('search') . '%')
                -> orwhere('tags', 'like', '%' .request('search') . '%')
                -> orwhere('description', 'like', '%' .request('search') . '%');

        }
    }

    //Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
