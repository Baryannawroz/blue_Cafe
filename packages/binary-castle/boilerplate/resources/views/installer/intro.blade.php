@extends('boilerplate::installer.base')

@section('title')
    End User License Agreement (EULA)
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @php
        $timezones = DateTimeZone::listIdentifiers();
        $selectedTimeZone = config('app.timezone');
    @endphp

    <form method="post" action="{{ route('installer.save.intro') }}">
        <div class="mb-3">
            <label for="">Timezone</label>
            <select class="form-select timezoneSelect" name="timezone">
                <option value="">Null</option>
                @foreach($timezones as $timezone)
                    <option @if($timezone == $selectedTimeZone) selected
                            @endif value="{{$timezone}}">{{$timezone}}</option>
                @endforeach
            </select>
            @error('timezone')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2 border p-2 rounded-2" style="max-height: 50vh; overflow-y: scroll;">
            @include('boilerplate::installer.legal.licence-agreement')
        </div>

        <div class="d-flex justify-content-between">
            @csrf
            <div class="form-check">
                <input class="form-check-input" required name="agreement" type="checkbox" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    I Agree & Accept
                </label>
                @error('agreement')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>


            <div>
                <x-installer-navigation-buttons/>
            </div>
        </div>


    </form>

    <script>
        $(document).ready(function() {
            $('.timezoneSelect').select2();
        });
    </script>
@endsection
