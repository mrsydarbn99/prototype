<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" name="name" value="{{ old('name',$model->name) }}" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Email</label>
    <input type="text" name="email" value="{{ old('email',$model->email) }}" class="form-control @error('email') is-invalid @enderror" id="exampleInputPassword1">
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1">
    @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror" id="exampleInputPassword2">
    @error('password_confirmation')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInput" class="form-label">Status</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" checked>
      <label class="form-check-label" for="exampleRadios1">
        Active
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="2">
      <label class="form-check-label" for="exampleRadios2">
        Inactive
      </label>
    </div>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  