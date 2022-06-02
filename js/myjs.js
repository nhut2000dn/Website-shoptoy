var a = '<?php echo "hello" ?>';

var mainToyHightlights = document.getElementsByClassName("box-toy-hightlights")[0];
// var mainBoxLatest = document.getElementsByClassName("main-toy-latest")[0];
var mainBoxConsectetur = document.getElementsByClassName("main-toy-latest")[1];
var mainBoxSpeacial = document.getElementsByClassName("main-toy-speacial")[0];
var mainBoxNew = document.getElementsByClassName("main-toy-new")[0];

function listProducts() {
  var listToys = [
    { "id": 1, "img": "images/slides4.jpg", "name": "Bumble-Bee Transformer Robot Toy", "information": "Bumble-Bee Transformer Robot Ride-On Car MP3 Player + USB Battery Powered Suitable for Boys or Girls 3-6 Years Old 2.4Ghz Parental Remote Control", "price": 899.21 },
    { "id": 2, "img": "images/slides3.jpg", "name": "Robot Mainan Lucu", "information": "Indoor Luar Permainan Mainan Model Mainan multi-fungsi RC Pert empuran Robot Cerdas Menari Xmas hadiah Suitable for Boys or Girls 3-6 Years Old Busch made seven starts in the car that year", "price": 219.46 },
    { "id": 3, "img": "images/slides7.jpg", "name": "Ricky Stenhouse", "information": "NASCAR’s managing director for technical inspection and officiating. Below are each of Stenhouse He is now NASCAR’s managing director for technical The last three trips to Darlington.", "price": 489.51 },

    { "id": 6, "img": "images/car2.jpeg", "name": "Think Gizmos", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 236.64 },
    { "id": 7, "img": "images/toy3.jpg", "name": "Imagin Jurassic", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 250.74 },
    { "id": 8, "img": "images/car1.jpeg", "name": "Rideoncarstore", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 290.52 },
    { "id": 9, "img": "images/robot.png", "name": "Robo Explorer", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 336.61 },
    { "id": 10, "img": "images/robot2.jpeg", "name": "Fingerlings", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 256.76 },

    { "id": 11, "img": "images/toy-secture4.jpg", "name": "Think Gizmos", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 136.99 },
    { "id": 12, "img": "images/toy-secture5.jpg", "name": "Imagin Jurassic", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 200.34 },
    { "id": 13, "img": "images/toy-consecture1.jpeg", "name": "Rideoncarstore", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 211.29 },
    { "id": 14, "img": "images/toy-consecture3.jpeg", "name": "Robo Explorer", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 246.12 },
    { "id": 15, "img": "images/toy-consecture2.jpeg", "name": "Fingerlings", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 285.14 },

    { "id": 16, "img": "images/toy3.jpg", "name": "Fingerlings", "oldPrice": 326.86, "price": 285.14 },

    { "id": 17, "img": "images/toy-secture5.jpg", "name": "Fingerlings", "price": 285.14 },
    { "id": 18, "img": "images/toy3.jpg", "name": "Think Gizmos", "price": 285.14 },
    { "id": 19, "img": "images/toy-consecture1.jpeg", "name": "Robo Explorer", "price": 285.14 },

    { "id": 20, "img": "images/img-details1.webp", "name": "Monster Jam Official Grave Digger RC Truck Scale 2.4GHz", "price": 285.14 },
  ]
  return listToys;
}
console.log(listProducts());

function loadToyHighlights() {
  var html = '';
  for (var i = 0; i < 3; i++) {
    html += '<div class="main-toy-highlights">';
    html += '<div class="img-toy-highlights">';
    html += '<a href="product-details.php"><img src="' + listProducts()[i].img + '" alt="" class="toy-highlights"></a>';
    html += '</div>';
    html += '<div class="information-toy-highlights">';
    html += '<a href="product-details.php">';
    html += '<p class="name-toy-highlights">' + listProducts()[i].name + '</p>';
    html += '<p class="information-toy-highlights">' + listProducts()[i].information + '</p>';
    html += '<p class="price-toy-highlights">$' + listProducts()[i].price + '</p>';
    html += '</a>';
    html += '<div class="add-cart-btn-highlights">';
    html += '<p class="add-to-cart-highlights" data-id =' + listProducts()[i].id + '>ADD TO CART</p>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
  }
  // mainToyHightlights.insertAdjacentHTML('beforeend', html);
}



var indexSlidesShow = 1;

function btnSLides() {
  var btnLeft = document.getElementById("btn-left-slides");
  btnLeft.addEventListener("click", function() {
    showSlides(indexSlidesShow += 1);
  });
  var btnRight = document.getElementById("btn-right-slides");
  btnRight.addEventListener("click", function() {
    showSlides(indexSlidesShow -= 1);
  });
}

function showSlides(n) {
  var i;
  var x = document.getElementsByClassName("main-toy-highlights");
  if (n > x.length) {
    indexSlidesShow = 1;
  }
  if (n < 1) {
    indexSlidesShow = x.length;
  }
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  x[indexSlidesShow - 1].style.display = "block";
}

var index = 0;

function showSlidesTime() {
  var i;
  var x = document.getElementsByClassName("main-toy-highlights");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  index += 1;
  if (index > x.length) {
    index = 1;
  }
  x[index - 1].style.display = "block";
  setTimeout(showSlidesTime, 4000);
}

function btnActionMenu() {
  var btnSearch = document.getElementsByClassName("box-action")[0];
  var pageMain = document.getElementsByClassName("page-main")[0];
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



(function() {
  loadToyHighlights();


  btnSLides();
  showSlides(indexSlidesShow);
  showSlidesTime();
  btnActionMenu();

})();