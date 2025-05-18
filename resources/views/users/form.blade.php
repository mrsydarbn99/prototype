<div class="mb-3 w-50">
  <label for="inputName" class="form-label">Name</label>
  <input 
    type="text" 
    name="name" 
    id="inputName" 
    value="{{ old('name', $model->name) }}" 
    class="form-control @error('name') is-invalid @enderror"
  >
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3 w-50">
  <label for="inputEmail" class="form-label">Email</label>
  <input 
    type="text" 
    name="email" 
    id="inputEmail" 
    value="{{ old('email', $model->email) }}" 
    class="form-control @error('email') is-invalid @enderror"
  >
  @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3 w-50">
  <label for="inputPassword" class="form-label">Password</label>
  <input 
    type="password" 
    name="password" 
    id="inputPassword" 
    value="{{ old('password') }}" 
    class="form-control @error('password') is-invalid @enderror"
  >
  @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3 w-50">
  <label for="inputPasswordConfirmation" class="form-label">Confirm Password</label>
  <input 
    type="password" 
    name="password_confirmation" 
    id="inputPasswordConfirmation" 
    value="{{ old('password_confirmation') }}" 
    class="form-control @error('password_confirmation') is-invalid @enderror"
  >
  @error('password_confirmation')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3 w-50">
  <label class="form-label">Status</label>
  <div class="form-check">
    <input 
      class="form-check-input" 
      type="radio" 
      name="status" 
      id="statusActive" 
      value="1" 
      {{ old('status', $model->status ?? '1') == '1' ? 'checked' : '' }}
    >
    <label class="form-check-label" for="statusActive">
      Active
    </label>
  </div>
  <div class="form-check">
    <input 
      class="form-check-input" 
      type="radio" 
      name="status" 
      id="statusInactive" 
      value="2" 
      {{ old('status', $model->status ?? '') == '2' ? 'checked' : '' }}
    >
    <label class="form-check-label" for="statusInactive">
      Inactive
    </label>
  </div>
  @error('status')
    <div class="invalid-feedback d-block">{{ $message }}</div>
  @enderror
</div>
