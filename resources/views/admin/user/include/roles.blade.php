@foreach($user->roles as $key => $role)
    <label for="role {{ $key }}" class="form-label">
        {{ $role->name }}
    </label>
    <br/>
@endforeach