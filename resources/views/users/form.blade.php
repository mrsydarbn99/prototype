<div class="row mb-3 w-100">
  <!-- Name on the left -->
  <div class="col-md-6 d-flex flex-column">
    <label for="inputName" class="form-label">Name:</label>
    <input
      type="text"
      name="name"
      id="inputName"
      value="{{ old('name', $user->name) }}"
      class="form-control @error('name') is-invalid @enderror"
    >
    @error('name')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <!-- Username on the right -->
  <div class="col-md-6 d-flex flex-column">
    <label for="inputUsername" class="form-label">Username:</label>
    <input
      type="text"
      name="username"
      id="inputUsername"
      value="{{ old('username', $user->username) }}"
      class="form-control @error('username') is-invalid @enderror"
    >
    @error('username')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="row mb-3 w-100">
  <!-- Password on the left -->
  <div class="col-md-6 d-flex flex-column">
    <label for="inputPassword" class="form-label">Password:</label>
    <input
      type="password"
      name="password"
      id="inputPassword"
      value="{{ old('password') }}"
      class="form-control @error('password') is-invalid @enderror"
    >
    @error('password')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <!-- Confirm Password on the right -->
  <div class="col-md-6 d-flex flex-column">
    <label for="inputPasswordConfirmation" class="form-label">Confirm Password:</label>
    <input
      type="password"
      name="password_confirmation"
      id="inputPasswordConfirmation"
      value="{{ old('password_confirmation') }}"
      class="form-control @error('password_confirmation') is-invalid @enderror"
    >
    @error('password_confirmation')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

@hasrole('admin')
<div class="d-flex">
  <!-- Role group -->
  <div class="mb-3 w-50">
    <label class="form-label">Role</label>
    <div class="form-check">
      <input 
        class="form-check-input" 
        type="radio" 
        name="role" 
        id="roleAdmin" 
        value="admin" 
        {{ old('role', $modelRole ?? '') == 'admin' ? 'checked' : '' }}
      >
      <label class="form-check-label" for="roleAdmin">Admin</label>
    </div>
    <div class="form-check">
      <input 
        class="form-check-input" 
        type="radio" 
        name="role" 
        id="roleUser" 
        value="user" 
        {{ old('role', $modelRole ?? 'user') == 'user' ? 'checked' : '' }}
      >
      <label class="form-check-label" for="roleUser">User</label>
    </div>
    @error('role')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <!-- Status group -->
  <div class="mb-3 w-50">
    <label class="form-label">Status</label>
    <div class="form-check">
      <input 
        class="form-check-input" 
        type="radio" 
        name="status" 
        id="statusActive" 
        value="1" 
        {{ old('status', $user->status ?? '1') == '1' ? 'checked' : '' }}
      >
      <label class="form-check-label" for="statusActive">Active</label>
    </div>
    <div class="form-check">
      <input 
        class="form-check-input" 
        type="radio" 
        name="status" 
        id="statusInactive" 
        value="2" 
        {{ old('status', $user->status ?? '') == '2' ? 'checked' : '' }}
      >
      <label class="form-check-label" for="statusInactive">Inactive</label>
    </div>
    @error('status')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>
@endhasrole



