@extends('boilerplate::installer.base')
@section('title')
    Permissions
@endsection

@section('content')
    @php
        $server_requirement_satisfy = true;
    @endphp

    <div class="d-flex justify-content-center mb-5">
        <div class="col-4">
            <h1>Directory Permission</h1>
            <p>Ensure that the following directories on your server have the correct permissions for our application.</p>
            <p>Correct directory permissions are crucial for the application to function properly. Improper permissions may lead to issues with file storage, uploads, and caching.</p>
        </div>

        <div class="col-8 px-5">
            @error('server_error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Whops!</h4>
                <p>{{ $message }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror

            <ul class="list-group mb-3">
                @foreach($directoryPermissions as $key=>$permission)
                    @if(!$permission['isWritable'] || !$permission['hasPermission'])
                        @php
                            $server_requirement_satisfy = false;
                        @endphp
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <div>{{$permission['directory']}}</div>
                        <div>
                            <i class="{{ $permission['isWritable'] && $permission['hasPermission'] ? 'text-success' : 'text-danger'  }} bi bi-circle-fill"></i> {{$permission['permission']}}
                        </div>
                    </li>
                @endforeach
            </ul>
            <p>For cloud setup please make sure the directory have the proper ownership</p>
        </div>
    </div>

    <form class="d-flex justify-content-between mb-2" method="post" action="{{ route('installer.save.permissions') }}">
        @csrf
        <input type="hidden" name="server_requirement_satisfy" value="{{$server_requirement_satisfy}}">
        <x-installer-navigation-buttons/>
    </form>
@endsection
