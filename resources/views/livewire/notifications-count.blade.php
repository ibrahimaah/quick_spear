<div wire:poll>
    <span class="badge rounded-pill badge-secondary">{{ auth()->user()->unreadNotifications->count() }}</span>
</div>
