@extends('boilerplate::installer.base')

@section('title')
    Email Setup
@endsection

@section('content')
    <div class="d-flex justify-content-center mb-5">

        <form action="{{route('installer.save.mail')}}" method="post" class="d-flex flex-wrap">
            @csrf

            <div class="col-4">
                <h1>Email Setup</h1>

                <p id="logMailerDetails">
                    Having a log mail will not sent out any email to anymore, instate it will store
                    the log inside the system logs, which you will find at <code>storage/logs/laravel.log</code>.
                </p>
                <p id="smtpMailerDetails" style="display: none">
                    Having SMTP mail setup system can send out email to the user. During the setup, system will try to
                    send out an email to ensure that your given SMTP configuration is correct.
                </p>

                <div class="alert alert-primary" role="alert">
                    Please note that you can change it at any time by going to <code>config/mail.php</code> file.
                </div>
            </div>

            <div class="px-5 col-8">

                @error('server_error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Whoops!</h4>
                    <p>{{$message}}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror

                <div class="mb-3">
                    <label class="form-label">Mailer</label>
                    <select class="form-select @error('transport') is-invalid @enderror" name="transport"
                            id="mailerType">
                        <option value="log" {{ old('transport') == 'log' ? 'selected': '' }}>Log</option>
                        <option value="smtp" {{ old('transport') == 'smtp' ? 'selected': '' }}>Simple Mail Transfer
                            Protocol (SMTP)
                        </option>
                    </select>
                    @error('transport')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>

                <div id="smtpMailer" style="display: none">
                    <div class=" mb-3">
                        <label>Host</label>
                        <input type="text" name="host" value="{{ old('host') ?: $mailConfig['host'] }}"
                               placeholder="Host"
                               class="form-control @error('host') is-invalid @enderror">
                        @error('host')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class=" mb-3">
                        <label>Port</label>
                        <input type="text" name="port" value="{{ old('port') ?: $mailConfig['port'] }}"
                               placeholder="Port"
                               class="form-control @error('port') is-invalid @enderror">
                        @error('port')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class=" mb-3">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username') ?: $mailConfig['username'] }}"
                               placeholder="Username"
                               class="form-control @error('username') is-invalid @enderror">
                        @error('username')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="text" name="password" value="{{ old('password') ?: $mailConfig['password'] }}"
                               placeholder="Password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Encryption</label>
                        <select class="form-select @error('mailer') is-invalid @enderror" name="encryption">
                            <option
                                value="ssl" {{ (old('encryption') ?: $mailConfig['encryption'] ) == 'ssl' ? 'selected': '' }}>
                                SSL
                            </option>
                            <option
                                value="tls" {{ (old('encryption') ?: $mailConfig['encryption'] ) == 'tls' ? 'selected': '' }}>
                                TLS
                            </option>
                            <option
                                value="null" {{ (old('encryption') ?: $mailConfig['encryption'] ) == null ? 'selected': '' }}>
                                None
                            </option>
                        </select>
                        @error('encryption')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Mail From</label>
                        <input type="email" name="mail_from_address"
                               value="{{ old('mail_from_address') ?: $mailFromConfig['address'] }}"
                               placeholder="Email from address"
                               class="form-control @error('mail_from_address') is-invalid @enderror">
                        @error('mail_from_address')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Mail From Name</label>
                        <input type="text" name="mail_from_name"
                               value="{{ old('mail_from_name') ?: $mailFromConfig['name'] }}"
                               placeholder="Mail from name"
                               class="form-control @error('mail_from_name') is-invalid @enderror">
                        @error('mail_from_name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between w-100">
                <x-installer-navigation-buttons/>
            </div>
        </form>
    </div>

    <script>
        const mailerType = document.querySelector('#mailerType');
        const smtpMailer = document.querySelector('#smtpMailer');
        const logMailerDetails = document.querySelector('#logMailerDetails');
        const smtpMailerDetails = document.querySelector('#smtpMailerDetails');

        function setMailerType(mailer) {
            const choice = mailerType.value
            if (choice === 'smtp') {
                smtpMailer.style.display = 'block'
                smtpMailerDetails.style.display = 'block'
                logMailerDetails.style.display = 'none'

            } else {
                smtpMailer.style.display = 'none'
                smtpMailerDetails.style.display = 'none'
                logMailerDetails.style.display = 'block'
            }
        }

        mailerType.addEventListener('change', setMailerType);
        window.addEventListener('load', setMailerType)
    </script>

@endsection
