<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name', 
    'email', 
    'phone', 
    'created_by', 
    'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o usuário que criou o contato
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relacionamento com o usuário que atualizou o contato
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
