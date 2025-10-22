<form action="{{route('register')}}" method="POST">
    @csrf
    <h2>Register</h2>

    <div>
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" value="{{ old('degree') }}">
    </div>

    <div>
        <label for="first_name">First name:</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
    </div>

    <div>
        <label for="last_name">Last name:</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
    </div>

    <div>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">-- select gender --</option>
            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <div>
        <label for="birth_date">Birth date:</label>
        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
    </div>

    <div>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="{{ old('country') }}">
    </div>

    <div>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio">{{ old('bio') }}</textarea>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>

    <button type="submit">Submit</button>
</form>
