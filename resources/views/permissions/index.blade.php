@extends('permissions.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Permissions</div>

                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add Permission</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role</th>
                                <th scope="col">Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Roles as $role)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="role_{{ $role->id }}">
                                        <label class="custom-control-label" for="role_{{ $role->id }}"></label>
                                    </div>
                                </td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if(isset($dataPermissions[$role->name]))
                                        @foreach($dataPermissions[$role->name] as $permission)
                                            <div class="dropdown">
                                                <form action="DeletePermission" method="post">
                                                    @csrf
                                                    <span class="dropdown-toggle" data-toggle="dropdown">
                                                        {{ $permission }}
                                                    </span>
                                                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                                                    <input type="hidden" name="name" value="{{ $permission }}">
                                                    <div class="dropdown-menu">
                                                        <button type="submit" class="dropdown-item"><em class="icon ni ni-trash"></em> Remove</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
