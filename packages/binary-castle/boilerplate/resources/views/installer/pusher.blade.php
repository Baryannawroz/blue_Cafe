@extends('boilerplate::installer.base')

@section('title')
    Broadcastr Setup
@endsection

@section('content')
    <div class="d-flex justify-content-center mb-5">

        <form action="{{ route('installer.save.pusher') }}" method="post" class="d-flex flex-wrap">
            @csrf

            <div class="col-4">
                <h1>Broadcastr Setup</h1>

                <p id="pusherDetails">
                    Pusher allows you to add realtime, scalable features to your applications.
                    Setting up Pusher will enable broadcasting events over websockets in your Laravel application.
                </p>
                <p id="redisDetails" style="display: none">
                    Using Redis for broadcasting leverages your Redis server to publish events that can be received
                    by websocket connections. This requires a Redis server to be configured and running.
                </p>
                <p id="logDetails" style="display: none">
                    Log broadcasting will write all broadcast events to your application logs instead of sending
                    them to a real broadcasting service. You will find these at <code>storage/logs/laravel.log</code>.
                </p>
                <p id="nullDetails" style="display: none">
                    Null broadcasting disables broadcasting completely. No events will be broadcast when this driver is selected.
                </p>

                <div class="alert alert-primary" role="alert">
                    Please note that you can change these settings at any time by modifying your <code>.env</code> file
                    or updating <code>config/broadcasting.php</code>.
                </div>
            </div>

            <div class="px-5 col-8">

                @error('server_error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Whoops!</h4>
                    <p>{{ $message }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror

                <div class="mb-3">
                    <label class="form-label">Default Broadcaster</label>
                    <select class="form-select @error('broadcast_driver') is-invalid @enderror" name="broadcast_driver"
                            id="broadcasterType">
                        <option value="pusher" {{ old('broadcast_driver', 'pusher') == 'pusher' ? 'selected': '' }}>Pusher</option>
                        <option value="redis" {{ old('broadcast_driver') == 'redis' ? 'selected': '' }}>Redis</option>
                        <option value="log" {{ old('broadcast_driver') == 'log' ? 'selected': '' }}>Log</option>
                        <option value="null" {{ old('broadcast_driver') == 'null' ? 'selected': '' }}>Null</option>
                    </select>
                    @error('broadcast_driver')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="pusherSettings">
                    <div class="mb-3">
                        <label>Pusher App ID</label>
                        <input type="text" name="pusher_app_id" value="{{ old('pusher_app_id', $broadcastConfig['connections']['pusher']['app_id'] ?? '') }}"
                               placeholder="Pusher App ID"
                               class="form-control @error('pusher_app_id') is-invalid @enderror">
                        @error('pusher_app_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Pusher Key</label>
                        <input type="text" name="pusher_key" value="{{ old('pusher_key', $broadcastConfig['connections']['pusher']['key'] ?? '') }}"
                               placeholder="Pusher Key"
                               class="form-control @error('pusher_key') is-invalid @enderror">
                        @error('pusher_key')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Pusher Secret</label>
                        <input type="text" name="pusher_secret" value="{{ old('pusher_secret', $broadcastConfig['connections']['pusher']['secret'] ?? '') }}"
                               placeholder="Pusher Secret"
                               class="form-control @error('pusher_secret') is-invalid @enderror">
                        @error('pusher_secret')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Pusher Cluster</label>
                        <input type="text" name="pusher_cluster" value="{{ old('pusher_cluster', $broadcastConfig['connections']['pusher']['options']['cluster'] ?? 'ap2') }}"
                               placeholder="Pusher Cluster (e.g., ap2, eu, us, ap1)"
                               class="form-control @error('pusher_cluster') is-invalid @enderror">
                        @error('pusher_cluster')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="pusher_encrypted" name="pusher_encrypted"
                               value="1" {{ old('pusher_encrypted', $broadcastConfig['connections']['pusher']['options']['encrypted'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="pusher_encrypted">Encrypted</label>
                        @error('pusher_encrypted')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="redisSettings" style="display: none">
                    <div class="mb-3">
                        <label>Redis Connection</label>
                        <input type="text" name="redis_connection" value="{{ old('redis_connection', $broadcastConfig['connections']['redis']['connection'] ?? 'default') }}"
                               placeholder="Redis Connection Name"
                               class="form-control @error('redis_connection') is-invalid @enderror">
                        @error('redis_connection')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Uses the connection defined in your <code>config/database.php</code> file.
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between w-100">
                <x-installer-navigation-buttons/>
            </div>
        </form>
    </div>

    <script>
        const broadcasterType = document.querySelector('#broadcasterType');
        const pusherSettings = document.querySelector('#pusherSettings');
        const redisSettings = document.querySelector('#redisSettings');

        const pusherDetails = document.querySelector('#pusherDetails');
        const redisDetails = document.querySelector('#redisDetails');
        const logDetails = document.querySelector('#logDetails');
        const nullDetails = document.querySelector('#nullDetails');

        function setBroadcasterType() {
            const choice = broadcasterType.value;

            // Hide all details sections first
            pusherDetails.style.display = 'none';
            redisDetails.style.display = 'none';
            logDetails.style.display = 'none';
            nullDetails.style.display = 'none';

            // Hide all settings sections
            pusherSettings.style.display = 'none';
            redisSettings.style.display = 'none';

            // Show the appropriate sections based on choice
            if (choice === 'pusher') {
                pusherSettings.style.display = 'block';
                pusherDetails.style.display = 'block';
            } else if (choice === 'redis') {
                redisSettings.style.display = 'block';
                redisDetails.style.display = 'block';
            } else if (choice === 'log') {
                logDetails.style.display = 'block';
            } else if (choice === 'null') {
                nullDetails.style.display = 'block';
            }
        }

        broadcasterType.addEventListener('change', setBroadcasterType);
        window.addEventListener('load', setBroadcasterType);
    </script>
@endsection
