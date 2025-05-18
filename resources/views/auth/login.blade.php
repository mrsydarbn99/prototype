<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
      width: 350px;
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
      width: 85%;
      padding: 0.6rem;
      padding-right: 40px;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 34px;
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
    <h2>Login</h2>
    <form id="loginForm" method="POST" action="{{ route('login') }}">
      @csrf

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" />
        <div class="error" id="emailError"></div>
        @error('email')
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
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    loginForm.addEventListener("submit", function (e) {
      // Optional client-side validation
      emailError.textContent = "";
      passwordError.textContent = "";

      let valid = true;

      if (emailInput.value.trim() === "") {
        emailError.textContent = "email is required.";
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
