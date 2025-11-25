<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function scopeName($query, $name)
    {
        if (!empty($name)) {
            $query->where(function($q) use ($name) {
                $q->where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%")
                ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%$name%"])
                ->orWhere('email', 'like', "%$name%");
            });
        }
    }
    public function scopeGender($query, $gender)
    {
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }
    }

    public function scopeCategory($query, $detail)
    {
        if (!empty($detail)) {
            $query->where('detail', 'like', $detail);
        }
    }

    public function scopeDate($query, $date)
    {
        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }
    }

    public function scopeEmail($query, $email)
    {
        if (!empty($email)) {
            $query->where('email', 'like', "%$email%");
        }
    }
}
