@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Permission</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('permissions.update', ['permission' => $permission->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $permission->role_id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="route">Route</label>
                            <input id="route" type="text" class="form-control" name="route" value="{{ $permission->route->name }}" required readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
