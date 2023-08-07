@extends('backend.user.profile')
@section('inner-content')
    <div class="card border-0 shadow-none">
        <div class="py-2">
        <span class="my-information-header"> My Informations </span>
        </div>
        <div class="card-body">
        <table class="table table-borderless border-0 p-0">
        
        <tbody>
            <tr>
                <td>Username</td>
                <td class="text-black-50">{{$user->username}}</td>
            </tr>
            <tr>
                <td>Phone No</td>
                <td class="text-black-50">{{ $user->phone }}</td>
            </tr>
            <tr>
                <td>Date Of Birth</td>
                <td class="text-black-50">{{ $user->birthday}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td class="text-black-50">{{ $user->address }}</td>
            </tr>
        </tbody>
        </table>
        </div>
    </div>
@endsection