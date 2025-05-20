@extends('boilerplate::installer.base')
@section('title')
    Database Setup
@endsection


@section('content')

    <div class="d-flex justify-content-center mb-5">
        <form action="{{ route('installer.save.database') }}" class="d-flex flex-wrap" method="post">
            @csrf

            <div class="col-4">
                <h1>Database Setup</h1>
                <p>If you want to setup any db cluster you need to modify the config from the source code
                </p>
                <hr>
                <p>Make sure you have give all access privilege to your user to create, modify or drop
                    columns
                    and table. <a
                        href="https://www.eukhost.com/kb/how-to-grant-all-privileges-to-user-in-cpanel/"
                        target="_blank">check this doc for further details</a></p>
            </div>
            <div class="col-md-8 px-5">

                @error('server_error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Whoops!</h4>
                    <p>{{$message}}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror

                <div class="mb-3">
                    <label class="form-label">Database Driver</label>
                    <select class="form-select @error('driver') is-invalid @enderror" name="driver">
                        <option value="mysql">MySQL</option>
                    </select>
                    @error('driver')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-8">
                        <label for="" class="form-label">Host</label>
                        <input type="text" name="host" class="form-control @error('host') is-invalid @enderror"
                               value="{{ old('host') ?: $db_connection['host'] }}"
                               placeholder="Host">
                        @error('host')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="" class="form-label">Port</label>
                        <input type="text" name="port" class="form-control @error('port') is-invalid @enderror"
                               value="{{ old('port') ?: $db_connection['port'] }}" placeholder="Port">
                        @error('port')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label">User</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                           value="{{ old('username') ?: $db_connection['username'] }}"
                           placeholder="User">
                    @error('username')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                           value="{{ old('password') ?: $db_connection['password'] }}"
                           placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Database</label>
                    <input type="text" name="database" class="form-control @error('database') is-invalid @enderror"
                           value="{{ old('database') ?: $db_connection['database'] }}"
                           placeholder="Database">
                    @error('database')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>


            <x-installer-navigation-buttons />
        </form>
    </div>

@endsection
