@extends('boilerplate::installer.base')

@section('title')
    Finish
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-7">
            <h1> 🎉 Installation Complete! Thank You! 🚀</h1> <br>
            <b>BinaryCastle</b> appreciates your trust in our products. Need assistance? We're here for you! <br> <br>

            ✨ <b>BinaryCastle</b> - Your Partner in Innovation <br> <br>

            Your success is our mission! If you loved our setup, consider leaving us a 5-star rating. <br> <br>

            ⭐⭐⭐⭐⭐ Rate Us Now! <br> <br>

            Your feedback matters. Thanks for choosing <b>BinaryCastle</b>! <br> <br>

            Happy exploring!

            <form class="py-5" action="{{config('boilerplate.installation_finish_url')}}" method="post">
                @csrf
                <button class="btn btn-lg btn-primary">Start Using App</button>
            </form>
        </div>
    </div>





@endsection
