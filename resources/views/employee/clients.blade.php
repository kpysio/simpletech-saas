@extends('layouts.app')

@section('content')
<div class="container">
    <h4>{{ ucfirst($department) }} Clients</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->department }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
<div class="container">
    <h4>Task List
    </h4>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Due date</th>
                <th>Status</th>
                <th>Client name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->category }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->status }}</td>
                    <td></td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection