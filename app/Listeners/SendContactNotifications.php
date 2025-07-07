<?php

namespace App\Listeners;

use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use App\Events\ContactDeleted;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendContactNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the ContactCreated event.
     */
    public function handleContactCreated(ContactCreated $event): void
    {
        try {
            \Log::info('Processando evento ContactCreated', [
                'contact_id' => $event->contact->id,
                'contact_name' => $event->contact->name,
                'action_by' => $event->actionBy->name
            ]);

            // Notificar TODOS os usuários do sistema
            $this->notifyAllUsers(
                type: 'contact_created',
                title: '✅ Novo contato criado',
                message: "O contato '{$event->contact->name}' foi criado com sucesso!",
                data: [
                    'contact_id' => $event->contact->id,
                    'contact_name' => $event->contact->name,
                    'contact_email' => $event->contact->email,
                    'action_by' => $event->actionBy->name,
                    'action_by_id' => $event->actionBy->id,
                    'action_url' => route('contacts.index')
                ],
                excludeUser: $event->actionBy->id // Opcional: excluir o usuário que fez a ação
            );

            \Log::info('Notificações de contato criado enviadas para todos os usuários');
        } catch (\Exception $e) {
            \Log::error('Erro ao processar evento ContactCreated', [
                'error' => $e->getMessage(),
                'contact_id' => $event->contact->id ?? 'null'
            ]);
        }
    }

    /**
     * Handle the ContactUpdated event.
     */
    public function handleContactUpdated(ContactUpdated $event): void
    {
        try {
            \Log::info('Processando evento ContactUpdated', [
                'contact_id' => $event->contact->id,
                'contact_name' => $event->contact->name,
                'action_by' => $event->actionBy->name
            ]);

            // Notificar TODOS os usuários do sistema
            $this->notifyAllUsers(
                type: 'contact_updated',
                title: '✏️ Contato atualizado',
                message: "O contato '{$event->contact->name}' foi atualizado com sucesso!",
                data: [
                    'contact_id' => $event->contact->id,
                    'contact_name' => $event->contact->name,
                    'contact_email' => $event->contact->email,
                    'updated_at' => now()->toISOString(),
                    'action_by' => $event->actionBy->name,
                    'action_by_id' => $event->actionBy->id,
                    'action_url' => route('contacts.index')
                ],
                excludeUser: $event->actionBy->id // Opcional: excluir o usuário que fez a ação
            );

            \Log::info('Notificações de contato atualizado enviadas para todos os usuários');
        } catch (\Exception $e) {
            \Log::error('Erro ao processar evento ContactUpdated', [
                'error' => $e->getMessage(),
                'contact_id' => $event->contact->id ?? 'null'
            ]);
        }
    }

    /**
     * Handle the ContactDeleted event.
     */
    public function handleContactDeleted(ContactDeleted $event): void
    {
        try {
            \Log::info('Processando evento ContactDeleted', [
                'contact_name' => $event->contactName,
                'action_by' => $event->actionBy->name
            ]);

            // Notificar TODOS os usuários do sistema
            $this->notifyAllUsers(
                type: 'contact_deleted',
                title: '🗑️ Contato removido',
                message: "O contato '{$event->contactName}' foi removido com sucesso!",
                data: [
                    'contact_name' => $event->contactName,
                    'contact_data' => $event->contactData,
                    'deleted_at' => now()->toISOString(),
                    'action_by' => $event->actionBy->name,
                    'action_by_id' => $event->actionBy->id
                ],
                excludeUser: $event->actionBy->id // Opcional: excluir o usuário que fez a ação
            );

            \Log::info('Notificações de contato deletado enviadas para todos os usuários');
        } catch (\Exception $e) {
            \Log::error('Erro ao processar evento ContactDeleted', [
                'error' => $e->getMessage(),
                'contact_name' => $event->contactName ?? 'null'
            ]);
        }
    }

    /**
     * Notifica todos os usuários do sistema
     */
    private function notifyAllUsers(string $type, string $title, string $message, array $data = [], ?int $excludeUser = null): void
    {
        try {
            // Buscar todos os usuários do sistema
            $usersQuery = User::query();

            $excludeUser = null;
            
            // Opcional: excluir o usuário que fez a ação para não notificar ele mesmo
            // if ($excludeUser) {
            //     $usersQuery->where('id', '!=', $excludeUser);
            // }
            
            $users = $usersQuery->get();

            foreach ($users as $user) {
                $this->notificationService->create(
                    user: $user,
                    type: $type,
                    title: $title,
                    message: $message,
                    data: $data
                );
            }

            \Log::info("Notificações enviadas para {$users->count()} usuários", [
                'type' => $type,
                'excluded_user' => $excludeUser
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao notificar todos os usuários', [
                'error' => $e->getMessage(),
                'type' => $type
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(ContactCreated|ContactUpdated|ContactDeleted $event, \Throwable $exception): void
    {
        \Log::error('Falha no processamento do evento de contato', [
            'event' => get_class($event),
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}