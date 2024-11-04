@extends('layouts.main')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Overview
          </div>
          <h2 class="page-title">
            Dashboard
          </h2>
        </div>
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ Session::get('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="row row-deck row-cards">
        <div class="col-12">
          <div class="card card-md">
            <div class="card-stamp card-stamp-lg">
              <div class="card-stamp-icon bg-primary">
                <!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 11a7 7 0 0 1 14 0v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-7" /><path d="M10 10l.01 0" /><path d="M14 10l.01 0" /><path d="M10 14a3.5 3.5 0 0 0 4 0" /></svg>
              </div>
            </div>
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-10">
                  <h3 class="h1">Edit Permission</h3>
                  <div class="markdown text-secondary">
                    <form action="{{route('permissions.update',$permission->id)}}" method="POST">
                        @csrf
                        <div class="form-group pb-2">
                          <label for="name">Permission Name</label>
                          <input type="text" name="name" value="{{$permission->name}}" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Your permission name">
                          @error('name')
                              <p class="text-danger">{{$message}}</p>
                          @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection
