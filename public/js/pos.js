$(document).ready(function() {
    var addItemToCart = function(item) {
        console.log(item);
    }

    var posCart = new PosCart();
    var posProducts = new PosProducts();
    
    posProducts.init(posCart.addItemToCart);
    posCart.init();
   
    
    
});
