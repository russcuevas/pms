<div class="bg-success text-white py-3" style="background-color: black !important">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-uppercase" style="color: white !important">MY UNIT: {{ $unit->units_name }}</small>
                            <div class="fw-bold">{{ $tenant->fullname ?? 'Tenant Name' }}</div>
                        </div>
                    </div>
                </div>
                    <div class="col-6 text-end position-relative">
                        @php
                            $unreadCount = $notifications->where('is_view', 0)->count();
                        @endphp
                        <span class="position-relative me-3" id="notif-toggle" style="cursor: pointer;">
                            <i class="fas fa-bell fs-5"></i>

                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </span>


                    <!-- Notification Dropdown -->
                    <div id="notif-dropdown" class="notif-dropdown shadow hidden">'


                        <div class="notif-header">
                            <span>Notifications ({{ $unreadCount }})</span>
                        </div>

                        <div class="notif-content">
                            @forelse ($notifications as $notif)
                                @php $extra = json_decode($notif->extra, true); @endphp

                                <div class="notif-item" style="text-align: left;">
                                    <div class="notif-text" style="text-align: left;">
                                        <p><b>{{ $notif->title }}</b> : {!! nl2br(e($notif->message)) !!}</p>

                                        @if(!empty($extra) && is_array($extra))
                                            <ul class="notif-extra" style="margin-top: 5px; font-size: 0.9em; color: #555; text-align: left;">
                                                @foreach ($extra as $key => $value)
                                                    ---> <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                                    <span style="text-transform: capitalize">{{ $value }}</span><br>
                                                @endforeach
                                            </ul>
                                        @endif

                                        @if(!empty($notif->url))
                                            <p style="margin-top: 5px;">
                                                <a href="{{ route('admin.hubert.notification.view', $notif->id) }}" style="color: #007bff; text-decoration: underline;">
                                                    Click here to view details
                                                </a>
                                            </p>
                                        @endif

                                    </div>
                                    <form action="{{ route('admin.hubert.notification.delete', $notif->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; padding: 0;">
                                            <i class="fas fa-trash notif-delete" style="color: red; cursor: pointer;" title="Delete Notification"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-center" style="color: black; font-weight: 900; padding: 10px;">No notifications yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Logout Icon -->
                    <a href="{{ route('tenants.logout.request') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-out-alt fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>