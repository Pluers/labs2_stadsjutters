<a href="/settings">
    <span class="material-symbols-rounded">settings</span>
</a>
{{-- Stadsjutters image --}}
<a href="/">
    <img src="{{ asset('logo-met-witte-achtergrond-stadsjutters-1.webp') }}" alt="Stadsjutters Logo" class="header-logo">
</a>

@php
    $notifications = Auth::user()->notifications;
@endphp

<a href="/notifications">
    @if ($notifications->count() > 0)
        <span class="material-symbols-rounded">notifications_unread</span>
    @else
        <span class="material-symbols-rounded">notifications</span>
    @endif
</a>
