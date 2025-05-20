@extends('boilerplate::installer.base')

@section('title')
    Log Management
@endsection

@section('content')
    <div class="d-flex justify-content-center">
        <form method="post" action="{{ route('installer.save.logs') }}" class="d-flex flex-wrap w-100">
            @csrf
            <div class="col-4">
                <h1>Log Management</h1>
                <p>Decide where to place your log.</p>
            </div>

            <div class="col-8 px-5">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Log Type</label>
                    <select name="log_channel" class="form-select" id="logSelector">
                        <option value="single" {{old('log_channel') === 'single' ? 'selected' : ''}}>Single - Will have only one file to contain all log</option>
                        <option value="daily" {{old('log_channel') === 'daily' ? 'selected' : ''}}>Daily - Log will chunk by each day</option>
                        <option value="slack" {{old('log_channel') === 'slack' ? 'selected' : ''}}>Slack - Log will send to the slack channel</option>
                    </select>
                </div>

                <div id="slackLogForm" @if(old('log_channel') === 'slack') style="display: block" @else style="display: none" @endif >
                    <div class="mb-3">
                        <label for="slackWebhook" class="form-label">Slack Webhook</label>
                        <input type="url" name="slack_url" class="form-control  @error('slack_url') is-invalid @enderror" id="slackWebhook"
                               placeholder="Slack Webhook">
                        @error('slack_url')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <x-installer-navigation-buttons/>
        </form>
    </div>

    <script>
        const logSelect = document.querySelector('#logSelector');
        const slackLogForm = document.querySelector('#slackLogForm');

        function setLog() {
            const choice = logSelect.value;
            if (choice === 'slack') {
                slackLogForm.style.display = 'block';
            } else {
                slackLogForm.style.display = 'none';
            }
        }

        logSelect.addEventListener("change", setLog)

    </script>
@endsection
