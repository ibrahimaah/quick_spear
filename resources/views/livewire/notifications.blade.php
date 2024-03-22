<ul class="notification-dropdown onhover-show-div" wire:poll>
    <li>
        <i data-feather="bell"></i>
        <h6 class="f-18 mb-0">التنبيهات</h6>
    </li>

    @foreach (auth()->user()->notifications->take(3) as $notiy)
    @if($notiy->type == "App\Notifications\OrderNotification")
    <li class="mb-3 py-3">
        <a onclick="{{ auth()->user()->notifications->where('id', $notiy->id)->markAsRead() }};" href="{{ route('admin.shipments.show', $notiy->data['shipment_id'] ?? '') }}?notification_id={{ $notiy->id }}">
            <p>
                <i class="fa fa-circle-o me-3 font-success"> </i>
                {{ $notiy->data['body'] ?? '' }}
                <span class="pull-right">{{ $notiy->created_at }}</span>
            </p>
        </a>
    </li>
    @elseif ($notiy->type == "App\Notifications\NewUserNotification")
    <li class="mb-3 py-3">
        <a onclick="{{ auth()->user()->notifications->where('id', $notiy->id)->markAsRead() }};" href="{{ route('admin.users.show', $notiy->data['user_id'] ?? '') }}?notification_id={{ $notiy->id }}">
            <p>
                <i class="fa fa-circle-o me-3 font-success"> </i>
                {{ $notiy->data['body'] ?? '' }}
                <span class="pull-right">{{ $notiy->created_at }}</span>
            </p>
        </a>
    </li>
    @endif
    @endforeach
    {{-- <li>
        <a class="btn btn-primary mt-3" onclick="{{ auth()->user()->unreadNotifications->markAsRead() }};" href="#">جعل كل الاشعارات مقروءة</a>
    </li> --}}
</ul>
