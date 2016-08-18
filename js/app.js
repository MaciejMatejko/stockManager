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
                form.find("input").eq(0).prop("value", "");
                form.find("input").eq(1).prop("value", "");
            }
        }).fail(function(xhr, status, error){
            console.log("Ajax faild when submiting new book");
        });
    });
    
    

});

