@extends('layouts.app')

@section('content')
        
        <private-chat :user="{{auth()->user()}}"></private-chat>
        
@endsection

