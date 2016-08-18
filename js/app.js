$(function(){
    
    var form=$("#newDelivery");
    
    form.on("submit", function(event){
        event.preventDefault();
        var formData = form.serializeArray();
        $.ajax({
            url: "http://192.168.33.22/stockManager/api/orderController.php",
            method: "POST",
            data: formData,
            dataType: "JSON"
        }).done(function(json){
            if(json['status']==="success"){
                form.find("input").eq(0).val("");
                form.find("input").eq(1).val("");
            }
        }).fail(function(xhr, status, error){
            console.log("Ajax faild when submiting new delivery");
        });
    });
    
    var newOrderForm = $("#newOrder");
    var quantityInput = newOrderForm.find("#orderQuantity");
    var showButton = $(".showBtn");

    newOrderForm.on("click", ".showBtn", function(event){
        event.preventDefault();
        var quantity = newOrderForm.serialize();
        var button = $(this);
        $.ajax({
            url: "http://192.168.33.22/stockManager/api/orderController.php",
            method: "GET",
            data: quantity,
            dataType: "JSON"
        }).done(function(price){
            var priceInput = $("<input type='number' readonly>");
            button.text("Sell");
            button.removeClass("showBtn");
            button.addClass("sellBtn");
            priceInput.val(price);
            quantityInput.parent().append(priceInput);
            quantityInput.attr("readonly", true);
        }).fail(function(xhr, status, error){
            console.log("Ajax faild when showing price");
        });
    });
    
    
   newOrderForm.on("click", ".sellBtn", function(event){
        event.preventDefault();
        var quantity = quantityInput.serialize();
        var button = $(this);
        $.ajax({
            url: "http://192.168.33.22/stockManager/api/orderController.php",
            method: "PUT",
            data: quantity,
            dataType: "JSON"
        }).done(function(json){
            if(json['status']==="success"){
                button.text("Show price");
                button.removeClass("sellBtn");
                button.addClass("showBtn");
                quantityInput.next().remove();
                quantityInput.val("");
            }
        }).fail(function(xhr, status, error){
            console.log("Ajax faild when selling");
        });
    });

});

