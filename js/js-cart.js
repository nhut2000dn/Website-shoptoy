function btnActionMenu() {
  var btnSearch = document.getElementsByClassName("box-action")[0];
  var pageMain = document.getElementsByClassName("page-main-cart")[0];
  var mainAction = document.getElementsByClassName("main-action")[0];
  btnSearch.addEventListener("click", function() {
    if (pageMain.style.display == "block") {
      pageMain.style.display = "none";
      mainAction.style.display = "block";
    } else {
      pageMain.style.display = "block";
      mainAction.style.display = "none";
    }
  });
}

btnActionMenu();