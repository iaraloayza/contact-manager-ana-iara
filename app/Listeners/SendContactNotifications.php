<?php

namespace App\Listeners;

use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use App\Events\ContactDeleted;
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
                'created_by' => $event->contact->created_by ?? 'null'
            ]);

            // Usar o relacionamento createdBy em vez de user
            $user = $event->contact->createdBy;
            
            if (!$user) {
                \Log::warning('Usuário não encontrado para notificação', [
                    'contact_id' => $event->contact->id,
                    'created_by' => $event->contact->created_by
                ]);
                return;
            }

            $this->notificationService->create(
                user: $user,
                type: 'contact_created',
                title: '✅ Contato criado',
                message: "O contato '{$event->contact->name}' foi criado com sucesso!",
                data: [
                    'contact_id' => $event->contact->id,
                    'contact_name' => $event->contact->name,
                    'contact_email' => $event->contact->email,
                    'action_url' => route('contacts.index')
                ]
            );

            \Log::info('Notificação de contato criado enviada com sucesso');
        } catch (\Exception $e) {
            \Log::error('Erro ao processar evento ContactCreated', [
                'error' => $e->getMessage(),
                'contact_id' => $event->contact->id ?? 'null'
            ]);
        }
    }

    public function handleContactUpdated(ContactUpdated $event): void
    {
        try {
            \Log::info('Processando evento ContactUpdated', [
                'contact_id' => $event->contact->id,
                'contact_name' => $event->contact->name,
                'updated_by' => $event->contact->updated_by ?? 'null'
            ]);

            $user = $event->contact->createdBy ?? auth()->user();

            if (!$user) {
                \Log::warning('Usuário não encontrado para notificação de atualização', [
                    'contact_id' => $event->contact->id
                ]);
                return;
            }

            $this->notificationService->create(
                user: $user,
                type: 'contact_updated',
                title: '✏️ Contato atualizado',
                message: "O contato '{$event->contact->name}' foi atualizado com sucesso.",
                data: [
                    'contact_id' => $event->contact->id,
                    'contact_name' => $event->contact->name,
                    'updated_at' => now()->toISOString(),
                    'action_url' => route('contacts.index')
                ]
            );

            \Log::info('Notificação de contato atualizado enviada com sucesso');
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
                'user_id' => $event->user->id ?? 'null'
            ]);

            if (!$event->user) {
                \Log::warning('Usuário não encontrado para notificação de exclusão', [
                    'contact_name' => $event->contactName
                ]);
                return;
            }

            $this->notificationService->create(
                user: $event->user,
                type: 'contact_deleted',
                title: '🗑️ Contato removido',
                message: "O contato '{$event->contactName}' foi removido do sistema.",
                data: [
                    'contact_name' => $event->contactName,
                    'contact_data' => $event->contactData,
                    'deleted_at' => now()->toISOString()
                ]
            );

            \Log::info('Notificação de contato deletado enviada com sucesso');
        } catch (\Exception $e) {
            \Log::error('Erro ao processar evento ContactDeleted', [
                'error' => $e->getMessage(),
                'contact_name' => $event->contactName ?? 'null'
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(ContactCreated|ContactDeleted $event, \Throwable $exception): void
    {
        \Log::error('Falha no processamento do evento de contato', [
            'event' => get_class($event),
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}