@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('employee.clients', 'recruitment') }}" class="list-group-item">Recruitment</a>
                <a href="{{ route('employee.clients', 'accounting') }}" class="list-group-item">Accounting</a>
            </div>
        </div>
        <div class="col-md-9">
            <h3>Welcome, {{ Auth::user()->name }}</h3>
            <p>Select a package from the sidebar to view your clients.</p>
        </div>
    </div>
</div>
@endsection 