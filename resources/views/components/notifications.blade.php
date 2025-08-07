@php
    $notifications = [];
    
    // Check for urgent alerts
    if ($stats['expired_residence_permits'] > 0) {
        $notifications[] = [
            'type' => 'danger',
            'icon' => 'fas fa-exclamation-triangle',
            'title' => 'Urgent Action Required',
            'message' => $stats['expired_residence_permits'] . ' residence permit(s) have expired',
            'action' => ['url' => '/foreigners?filter=expired', 'text' => 'View Expired Permits']
        ];
    }
    
    if (($stats['expiring_soon'] ?? 0) > 5) {
        $notifications[] = [
            'type' => 'warning',
            'icon' => 'fas fa-clock',
            'title' => 'Residence Permit Expiry Warning',
            'message' => $stats['expiring_soon'] . ' residence permit(s) expiring within 30 days',
            'action' => ['url' => '/foreigners?filter=expiring', 'text' => 'Review Expiring']
        ];
    }
    
    // System health notifications
    $notifications[] = [
        'type' => 'success',
        'icon' => 'fas fa-check-circle',
        'title' => 'System Status',
        'message' => 'Immigration database synchronized successfully',
        'timestamp' => now()->format('H:i')
    ];
@endphp

@if(count($notifications) > 0)
<div class="notification-panel mb-4">
    @foreach($notifications as $notification)
    <div class="alert alert-{{ $notification['type'] }} alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <i class="{{ $notification['icon'] }} me-3 mt-1"></i>
            <div class="flex-grow-1">
                <h6 class="alert-heading mb-1">{{ $notification['title'] }}</h6>
                <p class="mb-2">{{ $notification['message'] }}</p>
                @if(isset($notification['action']))
                    <a href="{{ $notification['action']['url'] }}" class="btn btn-sm btn-outline-{{ $notification['type'] }}">
                        {{ $notification['action']['text'] }}
                    </a>
                @endif
                @if(isset($notification['timestamp']))
                    <small class="text-muted d-block mt-2">{{ $notification['timestamp'] }}</small>
                @endif
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endforeach
</div>
@endif
