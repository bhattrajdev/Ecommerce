// /*---------------------------------- Carousel ----------------------------------*/
var $images = $(".imageBox");
var i = 0;
customSlider();

function customSlider() {
  $images.hide();

  if (i >= $images.length) {
    i = 0;
  }

  $images.eq(i).show();
  i++;

  setTimeout(customSlider, 2000);
}

// /*---------------------------------- Responsive Nav ----------------------------------*/
function navResponsive(){
    var x = document.getElementById("burgernav");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
}
// for search
function search(){
    let searchbox = document.querySelector('.searchBox')
   if (searchbox.style.display === "none") {
     searchbox.style.display = "flex";
   } else {
     searchbox.style.display = "none";
    window.location.replace("index.php");
   }
}
// for clear search



// /*---------------------------------- Product detail page start ----------------------------------*/
const allHoverImages = document.querySelectorAll(".hover-container div img");
const imgContainer = document.querySelector('.img-container');

window.addEventListener('DOMContentLoaded',()=>{
  allHoverImages[0].parentElement.classList.add('active')
})

allHoverImages.forEach((image)=>{
  image.addEventListener('mouseover',() =>{
    imgContainer.querySelector('img').src= image.src;
    // image.parentElement.classList.add('active')
  })
  
})
// /*---------------------------------- Product detail page end ----------------------------------*/

// /*---------------------------------- Owl carousel start ----------------------------------*/
$(document).ready(function () {
  $(".owl-carousel").owlCarousel({
    loop: false,
    margin: 10,
    nav: true,
    navText: [
      "<i class='fas fa-caret-left'></i>",
      "<i class='fas fa-caret-right'></i>",
    ],
    autoplay: true,
    dots: false,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 2,
        nav: false,
        navText:false,
        slideBy: 1, // Slide by 1 item
      },
      600: {
        items: 2,
        nav: true,
        slideBy: 2, // Slide by 2 items
      },
      1000: {
        items: 4,
        slideBy: 4, // Slide by 4 items
      },
    },
  });
});

// /*---------------------------------- Owl carousel end ----------------------------------*/

// /*---------------------------------- word limit start ----------------------------------*/
$(document).ready(function () {
  $(".desc").each(function () {
    var text = $(this).text();
    if (text.length > 50) {
      text = text.substring(0, 50) + "...";
      $(this).text(text);
    }
  });
});
// /*---------------------------------- word limit end ----------------------------------*/


/*----------------------------------Add to cart jquery start----------------------------------*/
  $(document).ready(function () {
    var taxRate = 0.13;
    var shippingRate = 200;
    var fadeTime = 300;

    /* Assign actions */
    $(".quantity-btn").click(function () {
      var productRow = $(this).closest(".product");
      var quantityValue = productRow.find(".quantity-value");
      var quantity = parseInt(quantityValue.text());

      if ($(this).hasClass("increase")) {
        quantity++;
      } else {
        if (quantity > 1) {
          quantity--;
        }
      }

      quantityValue.text(quantity);
      updateQuantity(productRow, quantity);
    });

    $(".product-removal button").click(function () {
      removeItem(this);
    });

    /* Recalculate cart */
    function recalculateCart() {
      var subtotal = 0;

      /* Sum up row totals */
      $(".product").each(function () {
        subtotal += parseFloat($(this).children(".product-line-price").text());
      });

      /* Calculate totals */
      var tax = subtotal * taxRate;
      var shipping = subtotal > 0 ? shippingRate : 0;
      var total = subtotal + tax + shipping;

      /* Update totals display */
      $(".totals-value").fadeOut(fadeTime, function () {
        $("#cart-subtotal").html(subtotal.toFixed(2));
        $("#cart-tax").html(tax.toFixed(2));
        $("#cart-shipping").html(shipping.toFixed(2));
        $("#cart-total").html(total.toFixed(2));
        if (total == 0) {
          $(".checkout").fadeOut(fadeTime);
        } else {
          $(".checkout").fadeIn(fadeTime);
        }
        $(".totals-value").fadeIn(fadeTime);
      });
    }

    /* Update quantity */
    function updateQuantity(productRow, quantity) {
      var price = parseFloat(productRow.children(".product-price").text());
      var linePrice = price * quantity;

      productRow.children(".product-line-price").each(function () {
        $(this).fadeOut(fadeTime, function () {
          $(this).text(linePrice.toFixed(2));
          recalculateCart();
          $(this).fadeIn(fadeTime);
        });
      });
    }

    /* Remove item from cart */
    function removeItem(removeButton) {
      var productRow = $(removeButton).parent().parent();
      productRow.slideUp(fadeTime, function () {
        productRow.remove();
        recalculateCart();
      });
    }
  });


  // product description maximum word limit

  $(document).ready(function () {
    var screenWidth = $(window).width();

    if (screenWidth < 575) {
      var maxLength = 20;

      $(".product-title").each(function () {
        var text = $(this).text();
        if (text.length > maxLength) {
          var trimmedText = text.substring(0, maxLength) + "...";
          $(this).text(trimmedText);
        }
      });
    }
  });
/*----------------------------------Add to cart jquery end----------------------------------*/
/*----------------------------------navbar user button toogle start----------------------------------*/

  var dropdownContent = document.getElementById("dropdown-content");

  function showDropdown() {
    dropdownContent.style.display = "block";
  }

  function hideDropdown() {
    dropdownContent.style.display = "none";
  }

/*----------------------------------navbar user button toogle end----------------------------------*/


