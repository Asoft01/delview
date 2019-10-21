@extends('layouts.admin')


@section('content')

    @if(Session::has('deleted_user'))
        <p class="bg-danger">{{session('deleted_user')}}</p>
    @endif

    @if(Session::has('created_user'))
        <p class="bg-success">{{session('created_user')}}</p>
    @endif

    @if(Session::has('updated_user'))
        <p class="bg-success">{{session('updated_user')}}</p>
    @endif

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
            <!-- The below images directory is omitted because it has been publicly declared in Photo.php with getFileAttribute-->
            {{--<td><img height="50" src="{{$user->photo ? $user->photo->file: 'no user photo'}}" alt="No Photo found"></td>--}}
             <td><img src="{{$user->photo? $user->photo->file: '/images/no-image1.jpg'}}" class="img-responsive img-rounded" alt="No Image" width="50" height="50"/></td>

              <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
            <td>{{$user->email}}</td>
            <td>{{$user->role ? $user->role->name : 'User has no role'}}</td>
            <td> {{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>
             <td>{{$user->created_at->diffforHumans()}}</td>
            <td>{{$user->updated_at->diffforHumans()}}</td>
          </tr>
        @endforeach

    @endif
   </tbody>
 </table>
@stop