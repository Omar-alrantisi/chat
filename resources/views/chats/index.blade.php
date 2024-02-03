@extends('layouts.app')
@section('content')
<div class="container">
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
            <div class="container">
            <div class="row">
                @if(Session::has('success'))
                <div class="col-6 alert alert-success justify-content-center d-flex">
                    {{Session::get('success')}}
                </div>
            @endif
            <example-component></example-component>

            @foreach ($users as $item )
                <div class="col-8">
                    <div class="col-4">
                        <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" width="100" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="Image Description">                    </div>
                    <div class="card-body">
                        <h4 class="card-title" style="">{{$item->name}}</h4>
                        <a  href="{{route('chats.show',$item->id)}}">{{$item->email}}</a>
                    </div>
                </div>
            @endforeach

            </div>
            </div>
</div>

@endsection
