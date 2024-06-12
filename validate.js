//provjeri dal su popunjeni elementi sa bilocim
function validateLogin() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    if (username == "" || password == "") {
        alert("All fields are required!");
        return false;
    }
    return true;
}
//provjeri dal su popunjeni elementi i dal se matchaju passwordi
function validateRegister() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (username == "" || password == "" || confirm_password == "") {
        alert("All fields are required!");
        return false;
    }

    if (password !== confirm_password) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
//isto ali sa newsovima
function validateNews() {
    var title = document.getElementById("title").value;
    var content = document.getElementById("content").value;

    if (title == "" || content == "") {
        alert("All fields are required!");
        return false;
    }
    return true;
}