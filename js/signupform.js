function verifyPassword() {
    var pw = document.getElementById("password").value;
    var cpw = document.getElementById("confirmPassword").value;
    // check empty password field
    if (pw == "") {
        document.getElementById("passwordError").innerHTML = "**Fill the password please!";
        return false;
    }

    // minimum password length validation
    if (pw.length < 8) {
        document.getElementById("passwordError").innerHTML = "**Password length must be atleast 8 characters";
        return false;
    }

    // maximum length of password validation
    if (pw.length > 15) {
        document.getElementById("passwordError").innerHTML = "**Password length must not exceed 15 characters";
        return false;
    }

    // check if password and confirm password fields match
    if (pw != cpw) {
        document.getElementById("passwordError").innerHTML = "**Passwords do not match";
        return false;
    }

    // password is correct
    return true;
}

function validateForm() {
    // call the verifyPassword function to check password validation
    return verifyPassword();
}
