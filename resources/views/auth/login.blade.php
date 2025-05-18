<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <title>Interactive Login Page</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #74ebd5, #9face6);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      width: 600px;
      animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      text-align: center;
      margin-bottom: 1rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1rem;
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 0.3rem;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 0.6rem;
      padding-right: 40px;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 40px;
      cursor: pointer;
      color: #888;
    }

    .error {
      color: red;
      font-size: 0.8rem;
      margin-top: 0.2rem;
    }

    button {
      width: 100%;
      padding: 0.7rem;
      background: #5c6bc0;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #3949ab;
    }
  </style>
</head>
<body>

  <div class="login-container">
    @if ($errors->has('status'))
        <div class="alert alert-danger">
            {{ $errors->first('status') }}
        </div>
    @endif

    <div class="logo mb-5 d-flex justify-content-center">
      <img src="{{ asset('assets/dist/img/ProCabT.png') }}" alt="" width="500">
    </div>
    <form id="loginForm" method="POST" action="{{ route('login') }}">
      @csrf

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" />
        <div class="error" id="usernameError"></div>
        @error('username')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" />
        <span class="toggle-password" onclick="togglePassword()"><i class="fas fa-eye"></i></span>
        <div class="error" id="passwordError"></div>
        @error('password')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit">Login</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script>
    function togglePassword() {
      const password = document.getElementById("password");
      const icon = document.querySelector(".toggle-password i");
      if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }

    const loginForm = document.getElementById("loginForm");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const usernameError = document.getElementById("usernameError");
    const passwordError = document.getElementById("passwordError");

    loginForm.addEventListener("submit", function (e) {
      // Optional client-side validation
      usernameError.textContent = "";
      passwordError.textContent = "";

      let valid = true;

      if (usernameInput.value.trim() === "") {
        usernameError.textContent = "Username is required.";
        valid = false;
      }

      if (passwordInput.value.trim() === "") {
        passwordError.textContent = "Password is required.";
        valid = false;
      }

      if (!valid) {
        e.preventDefault
      }
    });
  </script>

</body>
</html>
