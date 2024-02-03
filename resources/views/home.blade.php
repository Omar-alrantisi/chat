@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="container">
                    <form method="get" action="{{route('post.index')}}">
                    <div class="row">
                        <div class="col-12"><br></div>
                        <div class="col-4"><a href="{{route('chats.index')}}" class="btn btn-primary">chats</a></div>
                                    <input name="all_price" value="0" type="hidden" id="all_price_hidden">
                        <div class="col-12"><br></div>
                    <div class="col-12"><br></div>
                                <input name="all_price" value="0" type="hidden" id="all_price_hidden">
                    <div class="col-12"><br></div>
                        </form>
                </div>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
