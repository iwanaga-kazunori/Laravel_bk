@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                <h2>プロフィール</h2>
                <hr color="#c0c0c0">
                @foreach($profiles as $profile)
                    <div class="form-group row">
                        <p class="col-md-2">氏名</p>
                        <p class="col-md-4">{{ $profile->name }}</p>
                        
                    </div>
                    <div class="form-group row">
                        <p class="col-md-2">性別</p>
                        <p class="col-md-4">{{ $profile->gender }}</p>
                    </div>
                    <div class="form-group row">
                        <p class="col-md-2">趣味</p>
                        <p class="col-md-4">{{ $profile->hobby }}</p>
                    </div>
                    <div class="form-group row">
                        <p class="col-md-2">自己紹介欄</p>
                        <p class="col-md-10">{{ $profile->introduction }}</p>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach   
            </div>
        </div>
    </div>
@endsection