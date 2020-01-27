$(document).ready(function() {
    var addItemToCart = function(item) {
        console.log(item);
    }

    var posCart = PosCart();
     
    var posProducts = new PosProducts();
    posProducts.init(addItemToCart);
    
});
