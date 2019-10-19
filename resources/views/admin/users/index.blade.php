@extends('layouts.admin')


@section('content')


<h1>Users </h1>
<table class="table">
   <thead>
     <tr>
        <th>ID</th>
        <th>Photo</th>
        <th>Name</th>
         <th>Email</th>
         <th>Role</th>
         <th>Status</th>
         <th>Created</th>
         <th>Updated</th>
      </tr>
    </thead>
    <tbody>
    <!-- comming from index at AdminUsersController -->
    @if($users)

        @foreach($users as $user)
          <tr>
            <td>{{$user->id}}</td>
            {{--<td><img height="50" src="/images/{{$user->photo ? $user->photo->file: 'no user photo'}}" alt="No Photo found"></td>--}}
            <!-- The below images directory is omitted because it has been publicly declared in Photo.php with getFileAttribute
            <td><img height="50" src="{{$user->photo ? $user->photo->file: 'no user photo'}}" alt="No Photo found"></td>

            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role->name}}</td>
            <td> {{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>
             <td>{{$user->created_at->diffforHumans()}}</td>
            <td>{{$user->updated_at->diffforHumans()}}</td>
          </tr>
        @endforeach

    @endif
   </tbody>
 </table>
@stop