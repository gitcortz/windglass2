var PosProducts = (function ($) {
    return function () {
        var _producttypes_tab = $("#pos_producttype_tabs");
        var _pos_product_list = $("#pos_product_list");
        var _pos_product_search = $("#pos_product_search");
        var _pos_product_search_button = $("#pos_product_search_button");
        
        var _pos_product_list_item = "<a href='#' data-id='{id}' class='pos_product_item list-group-item d-flex justify-content-between align-items-center'>{name}</a>";
                               
        var _producttypes_tab_li="<li><a class='tab_producttype' href='#product_selection' data-toggle='tab' data-id='{id}'>{name}</a></li>";
        var _producttypes_other = "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>more..<span class='caret'></span></a><ul class='dropdown-menu' role='menu'></ul></li>";
        var _producttypes_other_li="<li><a class='tab_producttype' href='#product_selection'  data-toggle='tab' data-id='{id}'>{name}</a></li>";
        var _products;
        var _producttypes;
        var _itemClickCallBack;
      
        var search_products = function(keyword) {
            show_products('', keyword);
        }

        var show_products = function(id ,keyword) {
            _pos_product_list.empty();
            
            var list = _products;
            if (keyword && keyword != '') {
                list = _products.filter(function (entry) {
                    return entry.product.name.toLowerCase().indexOf(keyword) > -1;
                });
            }
            else if (id != '') {
                list = _products.filter(function (entry) {
                    return entry.product.producttype_id===id;
                });
            }

            $.each(list, function(i, item){
                _pos_product_list.append($(_pos_product_list_item.replace('{id}', item.id).replace('{name}', 
                (item.product.brand ? "[" + item.product.brand.name + "]<br/>" : "") + item.product.name)));
            });

            $('.pos_product_item').on('click', function() {
                
                if (_itemClickCallBack) {
                    var item = _products.find(item => item.id === $(this).data("id"));
                    _itemClickCallBack(item);
                }
            })
        }


        var init_tabs = function(){
            _producttypes_tab.empty();
            _producttypes_tab.append($(_producttypes_tab_li.replace('{id}', '').replace('{name}', 'All')));
        
            var other;
            var list = _producttypes.filter(function (entry) {
                return entry.name.toLowerCase().indexOf('empty') == -1;
            });

            $.each(list, function(i, item){
                if (i < 2) {
                    var $li = _producttypes_tab.append($(_producttypes_tab_li.replace('{id}', item.id).replace('{name}', item.name)));
                    _producttypes_tab.append($li);
                } else {
                    if (!other) {
                        other = $(_producttypes_other);
                        _producttypes_tab.append(other);
                    }
                    other.find(".dropdown-menu").append($(_producttypes_other_li.replace('{id}', item.id).replace('{name}', item.name)));                    
                }
            });
            $('.tab_producttype').first().parent().addClass("active");
            $('.tab_producttype').on('click', function(e){
                show_products($(this).data("id"));
            });
        }
          
        var init = function(itemClickCallBack) {
            _itemClickCallBack = itemClickCallBack;
            ajaxcall("GET", "/producttypes/all", null, 
                function(data) {
                    _producttypes = data.data;
                    init_tabs();
                }, function(data) {
                    console.log(data);
            });

            ajaxcall("GET", "/branches/1/products", null, 
                function(data) {
                    _products = data;
                    show_products('');
                }, function(data) {
                    console.log(data);
                });

            _pos_product_search_button.on('click', function() {
                search_products(_pos_product_search.val());
            })

            _pos_product_search.on('keypress', function (e) {
                if(e.which === 13){
                    search_products(_pos_product_search.val());
                }
            });

        };

        return {
            init: init,        
        }
    }
})(jQuery);
