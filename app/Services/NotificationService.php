<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Cria uma nova notificação para o usuário
     */
    public function create(User $user, string $type, string $title, string $message, array $data = []): void
    {
        try {
            // Preparar os dados da notificação
            $notificationData = [
                'title' => $title,
                'message' => $message,
                'type' => $type,
                ...$data // Mescla dados adicionais
            ];

            // Criar a notificação usando o sistema nativo do Laravel
            $user->notify(new \App\Notifications\CustomNotification(
                type: $type,
                title: $title,
                message: $message,
                data: $notificationData
            ));

        } catch (\Exception $e) {
            // Log do erro para debugging
            \Log::error('Erro ao criar notificação', [
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
            
            // Não relançar a exceção para não quebrar o fluxo principal
            // mas você pode ajustar conforme necessário
        }
    }

    /**
     * Marca uma notificação como lida
     */
    public function markAsRead(User $user, string $notificationId): bool
    {
        try {
            $notification = $user->notifications()->find($notificationId);
            
            if ($notification) {
                $notification->markAsRead();
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::error('Erro ao marcar notificação como lida', [
                'user_id' => $user->id,
                'notification_id' => $notificationId,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Marca todas as notificações do usuário como lidas
     */
    public function markAllAsRead(User $user): bool
    {
        try {
            $user->unreadNotifications->markAsRead();
            return true;
        } catch (\Exception $e) {
            \Log::error('Erro ao marcar todas notificações como lidas', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Obtém todas as notificações do usuário
     */
    public function getUserNotifications(User $user, int $limit = null, bool $unreadOnly = false)
    {
        try {
            $query = $user->notifications()->orderBy('created_at', 'desc');
            
            if ($unreadOnly) {
                $query->whereNull('read_at');
            }
            
            if ($limit) {
                $query->limit($limit);
            }
            
            return $query->get();
        } catch (\Exception $e) {
            \Log::error('Erro ao obter notificações do usuário', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return collect(); // Retorna coleção vazia em caso de erro
        }
    }

    /**
     * Conta notificações não lidas do usuário
     */
    public function getUnreadCount(User $user): int
    {
        try {
            return $user->unreadNotifications()->count();
        } catch (\Exception $e) {
            \Log::error('Erro ao contar notificações não lidas', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return 0;
        }
    }

    /**
     * Remove todas as notificações do usuário
     */
    public function clearAllNotifications(User $user): bool
    {
        try {
            $user->notifications()->delete();
            return true;
        } catch (\Exception $e) {
            \Log::error('Erro ao limpar todas as notificações', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Remove uma notificação específica
     */
    public function deleteNotification(User $user, string $notificationId): bool
    {
        try {
            $notification = $user->notifications()->find($notificationId);
            
            if ($notification) {
                $notification->delete();
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar notificação', [
                'user_id' => $user->id,
                'notification_id' => $notificationId,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}