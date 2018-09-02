@extends('layouts.app')

@section('content')

        <Chat :user="{{auth()->user()}}"></Chat>
@endsection
