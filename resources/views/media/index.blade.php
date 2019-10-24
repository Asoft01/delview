@extends('layouts.admin')

@section('content')

    <h1>Media</h1>
    @if($photo)

        <table class="table">
           <thead>
             <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created </th>
                <th>Email</th>
              </tr>
            </thead>

            <tbody>
            @foreach($photos as $photo)
              <tr>
                <td>{{$photo->id}}</td>
                <td>{{$photo->file}}</td>
                <td>{{$photo->created_at ? $photo->created_at: 'No Date'}}</td>
              </tr>
            @endforeach
           </tbody>
        </table>
    @endif

@stop