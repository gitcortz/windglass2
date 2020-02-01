$(document).ready(function() {
    var addItemToCart = function(item) {
        console.log(item);
    }

    var posCart = new PosCart();
    var posProducts = new PosProducts();
    var posCustomer = new PosCustomer();
    posProducts.init(posCart.addItemToCart);
    posCart.init();
    posCustomer.init();
    
    posCustomer.set_saveSucessCallBack(function(data){
        posCart.update_customer_data(data);
    });
    $('#add_customer').on('click', function() { 
        posCustomer.showAddModal();
    });
    $('#info_customer').on('click', function() { 
        posCustomer.showInfoModal($('#customer_id_0').val());
    });
    
    
});
