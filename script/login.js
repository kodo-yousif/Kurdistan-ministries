function form_log_in_submited(event) {
  event.preventDefault();
  let form = document.forms.login_form;
  let form_data = new FormData(form);
  let error = document.getElementById("login_errors");
  error.innerHTML = "";
  let has_error = false;
  if (!form_data.get("email")) {
    has_error = true;
    error.innerHTML += `<div>Please enter Email</div>`;
  }
  if (!form_data.get("password")) {
    has_error = true;
    error.innerHTML += `<div>Please enter Password.</div>`;
  } else if (form_data.get("password").length < 8) {
    has_error = true;
    error.innerHTML += `<div>Password length must be 8 or more.</div>`;
  }
  if (error.innerHTML == "") {
    let s = {
      email: form_data.get("email"),
      password: form_data.get("password"),
    };
    $.post("loging.php", s, function (r) {
      if (r.error) {
        error.innerHTML = r.m;
      } else {
        location.reload();
      }
    });
  }
}
