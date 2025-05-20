@extends('boilerplate::installer.base')

@section('title')
    Verification Centre
@endsection

@section('content')

    <div class="d-flex justify-content-center">
        <form action="{{route('installer.save.verify')}}" method="post" class="d-flex flex-wrap">
            @csrf

            <div class="col-4">
                <h1>Verification Centre</h1>

                <p>Please Enter your purchase code here:</p>
            </div>

            <div class="px-5 col-8">
                @error('server_error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Whoops!</h4>
                    <hr>
                    <p>{{$message}}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
                <div class="form-group mb-3">

                    <label>Purchase Code:</label>
                    <input type="text" name="purchase_code" value="{{ old('purchase_code') }}"
                           class="form-control @error('purchase_code') is-invalid @enderror">
                    @error('purchase_code')
                    <div class="invalid-feedback">{!! $message !!}</div>
                    @enderror
                    <span class="help-text">Don't know how to find the purchase code ? <a
                            href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-"
                            target="_blank">Click here</a> to find your purchase code. </span>
                </div>

            </div>

            <div class="d-flex justify-content-between w-100">
                <x-installer-navigation-buttons/>
            </div>
        </form>
    </div>



@endsection
