@extends('permissions.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Permission</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('permissions.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role_id" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Select Route</label><br>
                                <select name="route_id[]" class="form-select" multiple size="20">
                                    @foreach($Routes as $Route)
                                        <option value="{{$Route->id}}">{{$Route->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            

                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
