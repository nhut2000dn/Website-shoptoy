(function() {
  var zoomBoxes = document.querySelectorAll('.detail-view');

  // Extract the URL
  zoomBoxes.forEach(function(image) {
    var imageCss = window.getComputedStyle(image, false),
      imageUrl = imageCss.backgroundImage
      .slice(4, -1).replace(/['"]/g, '');

    // Get the original source image
    var imageSrc = new Image();
    imageSrc.onload = function() {
      var imageWidth = imageSrc.naturalWidth,
        imageHeight = imageSrc.naturalHeight,
        ratio = imageHeight / imageWidth;

      // Adjust the box to fit the image and to adapt responsively
      var percentage = ratio * 100 + '%';
      image.style.paddingBottom = percentage;

      // Zoom and scan on mousemove
      image.onmousemove = function(e) {
        // Get the width of the thumbnail
        var boxWidth = image.clientWidth,
          // Get the cursor position, minus element offset
          x = e.pageX - this.offsetLeft,
          y = e.pageY - this.offsetTop,
          // Convert coordinates to % of elem. width & height
          xPercent = x / (boxWidth / 100) + '%',
          yPercent = y / (boxWidth * ratio / 100) + '%';

        // Update styles w/actual size
        Object.assign(image.style, {
          backgroundPosition: xPercent + ' ' + yPercent,
          backgroundSize: imageWidth + 'px'
        });
      };

      // Reset when mouse leaves
      image.onmouseleave = function(e) {
        Object.assign(image.style, {
          backgroundPosition: 'center',
          backgroundSize: 'cover'
        });
      };
    }
    imageSrc.src = imageUrl;
  });
})();



function btnActionMenu() {
  var btnSearch = document.getElementsByClassName("box-action")[0];
  var pageMain = document.getElementsByClassName("page-main-details")[0];
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

currentDiv(1);

function loadSlides() {
  var btnSlide = document.getElementsByClassName("mySlides-click");
  btnSlide[0].style.border = "1px solid black";
  for (var i = 0; i < btnSlide.length; i++) {
    var self = btnSlide[i];
    self.addEventListener("mouseover", function(event) {
      for (var i = 0; i < btnSlide.length; i++) {
        btnSlide[i].style.border = "1px solid #e6ecf2";
      };
      var id = event.target.getAttribute("data-id");
      currentDiv(id);
      var self1 = event.target;
      self1.style.border = "1px solid black";
    });
  }
}
loadSlides();

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("mySlides-click");
  if (n > x.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = x.length }
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " w3-opacity-off";
}


function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

function btnTab() {
  var btnActionTab = document.getElementsByClassName("tablinks");
  var x = btnActionTab[0];
  for (var i = 0; i < btnActionTab.length; i++) {
    self = btnActionTab[i];
    self.addEventListener("click", function(event) {
      var data = event.target.getAttribute("data");
      openCity(event, data);
    });
  }
}
btnTab();

// function listProducts() {
//   var listToys = [
//     { "id": 1, "img": "images/slides4.jpg", "name": "Bumble-Bee Transformer Robot Toy", "information": "Bumble-Bee Transformer Robot Ride-On Car MP3 Player + USB Battery Powered Suitable for Boys or Girls 3-6 Years Old 2.4Ghz Parental Remote Control", "price": 899.21 },
//     { "id": 2, "img": "images/slides3.jpg", "name": "Robot Mainan Lucu", "information": "Indoor Luar Permainan Mainan Model Mainan multi-fungsi RC Pert empuran Robot Cerdas Menari Xmas hadiah Suitable for Boys or Girls 3-6 Years Old Busch made seven starts in the car that year", "price": 219.46 },
//     { "id": 3, "img": "images/slides7.jpg", "name": "Ricky Stenhouse", "information": "NASCAR’s managing director for technical inspection and officiating. Below are each of Stenhouse He is now NASCAR’s managing director for technical The last three trips to Darlington.", "price": 489.51 },

//     { "id": 6, "img": "images/car2.jpeg", "name": "Think Gizmos", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 236.64 },
//     { "id": 7, "img": "images/toy3.jpg", "name": "Imagin Jurassic", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 250.74 },
//     { "id": 8, "img": "images/car1.jpeg", "name": "Rideoncarstore", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 290.52 },
//     { "id": 9, "img": "images/robot.png", "name": "Robo Explorer", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 336.61 },
//     { "id": 10, "img": "images/robot2.jpeg", "name": "Fingerlings", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 256.76 },

//     { "id": 11, "img": "images/toy-secture4.jpg", "name": "Think Gizmos", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 136.99 },
//     { "id": 12, "img": "images/toy-secture5.jpg", "name": "Imagin Jurassic", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 200.34 },
//     { "id": 13, "img": "images/toy-consecture1.jpeg", "name": "Rideoncarstore", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 211.29 },
//     { "id": 14, "img": "images/toy-consecture3.jpeg", "name": "Robo Explorer", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 246.12 },
//     { "id": 15, "img": "images/toy-consecture2.jpeg", "name": "Fingerlings", "information": "Battery Operated Ride on Licensed Key for start, with leather seat", "price": 285.14 },

//     { "id": 16, "img": "images/toy3.jpg", "name": "Fingerlings", "oldPrice": 326.86, "price": 285.14 },

//     { "id": 17, "img": "images/toy-secture5.jpg", "name": "Fingerlings", "price": 285.14 },
//     { "id": 18, "img": "images/toy3.jpg", "name": "Think Gizmos", "price": 285.14 },
//     { "id": 19, "img": "images/toy-consecture1.jpeg", "name": "Robo Explorer", "price": 285.14 },

//     { "id": 20, "img": "images/img-details1.webp", "name": "Monster Jam Official Grave Digger RC Truck Scale 2.4GHz", "price": 285.14 },
//   ]
//   return listToys;
// }
// function filterDetails() {
//   var products = listProducts();
//   var cart = JSON.parse(localStorage.getItem('Toys') || "[]");
//   var details = cart.map((obj) => {
//     var id = +obj.id;
//     return products.find(x => x.id === id);
//   });
//   return details;
// }
// function ActionAddCart() {
//   // var btnAddCart = document.querySelectorAll('.add-to-cart-highlights');
//   var btnAddCart = document.getElementsByClassName('add-cart');
//   for (var i = 0; i < btnAddCart.length; i++) {
//     var self = btnAddCart[i];
//     self.addEventListener('click', function (event) {
//       var self = this;
//       var id = event.target.getAttribute("data-id");
//       var products = JSON.parse(localStorage.getItem('Toys') || "[]");
//       products.push({ id: id });
//       if (typeof (Storage) !== "undefined") {
//         localStorage.setItem('Toys', JSON.stringify(products));

//         var boxToyCart = document.getElementsByClassName('box-item-cart')[0];
//         boxToyCart.innerHTML = "";
//         getTotalPrice();
//         disableBtnAddCart();
//         getDetailsCart();
//         removeDetailsCart();
//         amountCart();
//         ActionboxDeleteAll();
//         removeAllCart();
//       } else {
//         alert('Your web browser does not support local storage');
//       }
//       var x = self.parentNode;
//       self.style.pointerEvents = 'none';
//       self.style.color = "white";
//       x.style.backgroundColor = "#264e56";
//     });
//   }
// }
// function disableBtnAddCart() {
//   var localProducts = JSON.parse(localStorage.getItem("Toys") || "[]");
//   var products = listProducts();
//   localProducts.map((obj) => {
//     var id = +obj.id;
//     return products.find(x => x.id === id);
//   });
//   var btn = document.getElementsByClassName('add-cart');
//   [].forEach.call(btn, function (el) {
//     var id = el.getAttribute('data-id');
//     var product = localProducts.find(x => x.id === id);
//     if (product) {
//       var x = el.parentNode;
//       el.style.pointerEvents = 'none';
//       el.style.color = 'white';
//       el.style.backgroundColor = "#264e56";
//       x.style.backgroundColor = "#264e56";
//       x.style.cursor = "auto";
//     }
//     else {
//       var x = el.parentNode;
//       el.style.pointerEvents = 'auto';
//       el.style.color = '#e8f7fe';
//       el.style.backgroundColor = "#5acfe7";
//       x.style.backgroundColor = "#5acfe7";
//       x.style.cursor = "auto";
//     }
//   });
// }
// disableBtnAddCart();
// ActionAddCart();
// function getDetailsCart() {
//   var html = '';
//   var details = filterDetails();
//   details.forEach((obj) => {
//     html += '<div class="item-toy-cart">';
//     html += '<div class="box-img">';
//     html += '<img src="' + obj.img + '" alt="" class="img-toy">';
//     html += '</div>';
//     html += '<div class="item-price-cart">';
//     html += '<div class="box-price-cart">';
//     html += '<span>Cart Item</span><br>';
//     html += '<span class="price-add-cart">$' + obj.price + '</span>';
//     html += '</div>';
//     html += '</div>';
//     html += '<div class="box-btn-cart">';
//     html += '<div class="box-delete">';
//     html += '<i class="fas fa-trash btn-delete" data-id="' + obj.id + '"></i>';
//     html += '</div>';
//     html += '</div>';
//     html += '</div>';
//   });
// var boxToyCart = document.getElementsByClassName('box-item-cart')[0];
// boxToyCart.insertAdjacentHTML('beforeend', html);
// }
// getDetailsCart();
// function removeDetailsCart() {
//   var btn = document.getElementsByClassName("btn-delete");
//   [].forEach.call(btn, function (el) {
//     el.addEventListener('click', function () {
//       var self = this;
//       var id = self.getAttribute('data-id');
//       var element = self.parentNode.parentNode.parentNode;
//       var tbody = document.querySelector('.box-item-cart');
//       tbody.removeChild(element);
//       var localCarts = JSON.parse(localStorage.getItem("Toys") || "[]");
//       var johnRemoved = localCarts.findIndex(x => x.id === id);
//       console.log(johnRemoved);
//       localCarts.splice(johnRemoved, 1);
//       if (typeof (Storage) !== "undefined") {
//         localStorage.setItem('Toys', JSON.stringify(localCarts));
//         amountCart();
//         getTotalPrice();
//       } else {
//         alert('Your web browser does not support local storage');
//       }
//       ActionboxDeleteAll();
//       disableBtnAddCart();
//     });
//   });
// }
// removeDetailsCart();
// function removeAllCart() {
//   var btnDeleteAllCart = document.getElementsByClassName("delete-all-cart")[0];
//   btnDeleteAllCart.addEventListener("click", function () {
//     localStorage.setItem('Toys', "");
//     var boxToyCart = document.getElementsByClassName('box-item-cart')[0];
//     boxToyCart.innerHTML = "";
//     ActionboxDeleteAll();
//     amountCart();
//     getTotalPrice();
//     disableBtnAddCart();
//   });
// }
// removeAllCart();
// function getTotalPrice(el) {
//   var details = filterDetails();
//   var total = details.reduce((total, current) => {
//     return total += current.price
//   }, 0)
//   var totalPrice = document.getElementsByClassName('price-cart')[0];
//   var mathTotal = Math.round(total * 1000)/1000;
//   if (mathTotal != 0) {
//     totalPrice.innerHTML = mathTotal;
//   } else {
//     totalPrice.innerHTML = "0.00";
//   }
// }
// getTotalPrice();
// function amountCart() {
//   var amountCart = document.getElementsByClassName("amount-cart")[0];
//   var amountCart2 = document.getElementsByClassName("count-product")[0];
//   var products = JSON.parse(localStorage.getItem('Toys') || "[]");;
//   var length = products.length;
//   if (length > 0) {
//     amountCart.innerHTML = length;
//     amountCart2.innerHTML = length;
//   } else {
//     amountCart.innerHTML = 0;
//   }
// };
// amountCart();
// function ActionboxDeleteAll() {
//   var boxItemCart = document.getElementsByClassName("box-item-cart")[0];
//   var boxActionCart = document.getElementsByClassName("box-action-cart")[0];
//   var boxIconCart = document.getElementsByClassName("box-icon-cart")[0];
//   if (boxItemCart.innerHTML == "") {
//     boxActionCart.style.display = 'none';
//     boxIconCart.style.display = 'none';
//   } else {
//     boxActionCart.style.display = 'block';
//     boxIconCart.style.display = 'block';
//   }
// }
// ActionboxDeleteAll();

var boxSuggestion = document.getElementsByClassName("box-suggest-products")[0];
var btnSeeMore = document.getElementsByClassName("btn-see-more")[0];
var btnHidden = document.getElementsByClassName("btn-hidden")[0];
btnSeeMore.addEventListener("click", function() {
  boxSuggestion.style.maxHeight = '1287px';
  btnSeeMore.style.display = 'none';
  btnHidden.style.display = 'block';
});
btnHidden.addEventListener("click", function() {
  boxSuggestion.style.maxHeight = '782px';
  btnSeeMore.style.display = 'block';
  btnHidden.style.display = 'none';
});
///////////////////////////////////////////////////////
var countDisplay = 0;
var checkLeft = 0;

var countLeft = 0;
var barDisplayProduct = document.getElementsByClassName("bar-display-product")[0];
var btnLeftDisplay = document.getElementsByClassName("btn-left-view")[0];
btnLeftDisplay.addEventListener("click", function() {
  if (checkLeft > 0) {
    countRight = countDisplay * -1365;
    countLeft = countRight + 1365;
    barDisplayProduct.style.marginLeft = countLeft + 'px';
    countDisplay--;
    checkLeft--;
  }
});
var countRight = 0;
var btnRightDisplay = document.getElementsByClassName("btn-right-view")[0];
btnRightDisplay.addEventListener("click", function() {
  if (countRight < -4000) {
    countDisplay = 0;
    countRight = 0;
    barDisplayProduct.style.marginLeft = countRight + 'px';
    checkLeft = 0;
  } else {
    countDisplay++;
    countRight = countDisplay * -1365;
    barDisplayProduct.style.marginLeft = countRight + 'px';
    checkLeft++;
  }
});

function disPlayProduct() {
  if (countRight < -4000) {
    countDisplay = 0;
    countRight = 0;
    barDisplayProduct.style.marginLeft = countRight + 'px';
    checkLeft = 0;
  } else {
    countDisplay++;
    countRight = countDisplay * -1365;
    barDisplayProduct.style.marginLeft = countRight + 'px';
    checkLeft++;
  }
  timeOut = setTimeout(disPlayProduct, 4000);
}
barDisplayProduct.addEventListener("mouseover", function() {
  clearTimeout(timeOut);
});
barDisplayProduct.addEventListener("mouseout", function() {
  barDisplayProduct.style.backgroundColor = '#ffffff';
  timeOut = setTimeout(disPlayProduct, 4000);
});
document.getElementsByClassName("box-btn-view")[0].addEventListener("mouseover", function() {
  clearTimeout(timeOut);
});
document.getElementsByClassName("box-btn-view")[0].addEventListener("mouseout", function() {
  barDisplayProduct.style.backgroundColor = '#ffffff';
  timeOut = setTimeout(disPlayProduct, 4000);
});
document.getElementsByClassName("box-btn-view")[1].addEventListener("mouseover", function() {
  clearTimeout(timeOut);
});
document.getElementsByClassName("box-btn-view")[1].addEventListener("mouseout", function() {
  barDisplayProduct.style.backgroundColor = '#ffffff';
  timeOut = setTimeout(disPlayProduct, 4000);
});
disPlayProduct();


// var boxDisplayProduct = document.getElementsByClassName("box-img-left");
// $countBoxProduct = ROUND(boxDisplayProduct.length);
// abstractalert(boxDisplayProduct.length);
// alert($countBoxProduct);