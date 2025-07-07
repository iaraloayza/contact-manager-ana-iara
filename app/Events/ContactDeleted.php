<?php
// App/Events/ContactDeleted.php
namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $actionBy, // Usuário que fez a ação
        public string $contactName,
        public array $contactData = []
    ) {}
}