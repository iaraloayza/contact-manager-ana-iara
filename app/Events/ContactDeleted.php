<?php

namespace App\Events;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
        public string $contactName,
        public array $contactData = []
    ) {}
}