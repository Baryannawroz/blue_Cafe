@extends('boilerplate::installer.base')

@section('title')
    Requirements
@endsection

@section('content')
    @php
        $server_requirement_satisfy = true;
    @endphp

    <div class="d-flex justify-content-center mb-5">
        <div class="col-4">
            <h1>Server Requirements</h1>
            <p>These modules are essential for the proper functioning of our application. If any of them are missing or
                disabled, the installation may not proceed smoothly.</p>

            @error('server_requirement_satisfy')
            <div class="p-4">
                <div class="alert alert-danger" role="alert">
                    {{$message}}
                </div>
            </div>
            @enderror

        </div>

        <div class="col-8">
            <ul class="list-group mb-2">
                @foreach($requirements as $requirement)
                    <li class="list-group-item">
                        @if(extension_loaded($requirement))
                            <i class="text-success bi bi-circle-fill"></i>
                        @else
                            @php
                                $server_requirement_satisfy = false;
                            @endphp
                            <i class="bi bi-circle text-danger"></i>
                        @endif
                        {{$requirement}}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>





    <form class="d-flex justify-content-between mb-2" method="post" action="{{ route('installer.save.requirements') }}">
        @csrf
        <input type="hidden" name="server_requirement_satisfy" value="{{$server_requirement_satisfy}}">
        <x-installer-navigation-buttons/>

    </form>

@endsection
