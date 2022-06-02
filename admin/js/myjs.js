var boxUser = document.getElementById("box-user");
var dropUser = document.getElementById("drop-user");
boxUser.addEventListener("click", function () {
    if (dropUser.style.display == "none") {
        dropUser.style.display = "block";
    } else {
        dropUser.style.display = "none";
    }
});
function confirmlogout() {
    return confirm("Bạn có chắc muốn đăng xuất !")
}
function confirmpass() {
    return confirm("Bạn có chắc refresh password thành viên này không !")
}