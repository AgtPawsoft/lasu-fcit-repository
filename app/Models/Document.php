<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title', 'abstract', 'file_path', 'file_type',
        'user_id', 'department_id', 'category_id',
        'keywords', 'publication_year', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }

    public function scopeByDepartment($q, $deptId)
    {
        return $q->where('department_id', $deptId);
    }

    public function scopeByYear($q, $year)
    {
        return $q->where('publication_year', $year);
    }
}