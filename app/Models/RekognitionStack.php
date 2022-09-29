<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekognitionStack extends Model
{
    protected $fillable = ['source', 'target', 'users_year_book_id'];

    public function user()
    {
        return $this->belongsTo(UsersYearBook::class, 'users_year_book_id');
    }
}
