<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios pueden ver la lista de tareas
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can comment on the model.
     */
    public function comment(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can generate a report.
     */
    public function generateReport(User $user): bool
    {
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can attach files to the model.
     */
    public function attach(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete attached files from the model.
     */
    public function deleteAttachment(User $user, Task $task): bool
    {
        return $task->user()->is($user) || $task->attachment->user()->is($user) || $user->is_super_admin;
    }

    /**
     * Determine whether the user can update the status of the model.
     */
    public function updateStatus(User $user, Task $task): bool
    {
        return $task->user()->is($user);
    }
}
