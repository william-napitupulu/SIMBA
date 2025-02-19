<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $primaryKey = 'username'; // Set primary key
    public $incrementing = false; // Disable auto-increment

    // Define fillable fields
    protected $fillable = ['username'];

    /**
     * Define the inverse relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}