@extends('admin.layouts.app')
@section('title',' Create Roles')
@section('content')
    <div class="card">
        <h1>Create Role</h1>
        <div>
            <form action="{{route('roles.store')}}" method="post">
            @csrf
            <div class="input-group input-group-static mb-4">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name')}}" class="form-control">

                @error('name')
                    <span class="text-danger">{{ $message}}</span>
                @enderror
              </div>

              <div class="input-group input-group-static mb-4">
                <label>Display Name</label>
                <input type="text" name="display_name" value="{{ old('display_name')}}" class="form-control">

                @error('display_name')
                <span class="text-danger">{{ $message}}</span>
                @enderror
              </div>

              <div class="input-group input-group-static mb-4">
                <label for="exampleFormControlSelect1"  class="ms-0">Group</label>
                <select class="form-control" name="group">
                  <option value="system">system</option>
                  <option value="user">user</option>
                </select>

                @error('group')
                <span class="text-danger">{{ $message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label>Permission</label>
                <div class="row">
                    @foreach ($permissions as $groupName => $permission)
                    <div class="col-4">
                        <h4>{{ $groupName }}</h4>
                        <div>
                            @foreach ($permission as $item)
                            <div class="form-check">
                                <input class="form-check-input" name="permission_ids[]" type="checkbox" value="{{$item->id}}">
                                <label class="custom-control-label" for="customCheck1">{{$item->display_name}}</label>
                              </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
              </div>

              <button type="submit" class="btn btn-submit btn btn-primary"> Submit</button>
            </form>
        </div>
    </div>
@endsection