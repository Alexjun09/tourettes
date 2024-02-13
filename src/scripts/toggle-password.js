function togglePassword() {
  var input = document.getElementById("passwordInput");
  if (input.type === "password") {
    input.type = "text";
  } else {
    input.type = "password";
  }
}
