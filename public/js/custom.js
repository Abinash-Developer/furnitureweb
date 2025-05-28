(function() {
	'use strict';

	var tinyslider = function() {
		var el = document.querySelectorAll('.testimonial-slider');

		if (el.length > 0) {
			var slider = tns({
				container: '.testimonial-slider',
				items: 1,
				axis: "horizontal",
				controlsContainer: "#testimonial-nav",
				swipeAngle: false,
				speed: 700,
				nav: true,
				controls: true,
				autoplay: true,
				autoplayHoverPause: true,
				autoplayTimeout: 3500,
				autoplayButtonOutput: false
			});
		}
	};
	tinyslider();

	


	var sitePlusMinus = function() {

		var value,
    		quantity = document.getElementsByClassName('quantity-container');

		function createBindings(quantityContainer) {
	      var quantityAmount = quantityContainer.getElementsByClassName('quantity-amount')[0];
	      var increase = quantityContainer.getElementsByClassName('increase')[0];
	      var decrease = quantityContainer.getElementsByClassName('decrease')[0];
	      increase.addEventListener('click', function (e) { increaseValue(e, quantityAmount,increase.getAttribute('data-productid')); });
	      decrease.addEventListener('click', function (e) { decreaseValue(e, quantityAmount,decrease.getAttribute('data-productid')); });
	    }

	    function init() {
	        for (var i = 0; i < quantity.length; i++ ) {
						createBindings(quantity[i]);
	        }
	    };

	    function increaseValue(event, quantityAmount,product_id) {
			$.ajax({
				type:"GET",
				url:'/add-to-cart',
				data:{product_id:product_id},
				success:function(response){
					if(response.success){
						value = parseInt(quantityAmount.value, 10);
						console.log(quantityAmount, quantityAmount.value);
						value = isNaN(value) ? 0 : value;
						value++;
						quantityAmount.value = value;
						location.reload();
					}
				}
			})
	    }

	    function decreaseValue(event, quantityAmount,product_id) {
			$.ajax({
				type:"GET",
				url:'/add-to-cart',
				data:{product_id:product_id},
				success:function(response){
					if(response.success){
						value = parseInt(quantityAmount.value, 10);
						value = isNaN(value) ? 0 : value;
						if (value > 0) value--;
						quantityAmount.value = value;
						location.reload();
					}
				}
			})
	    }
	    
	    init();
		
	};
	sitePlusMinus();


})()

$(document).ready(()=>{
	$('#login-form').submit(function(e) {
       e.preventDefault();
	   var url = $(this).attr("action");
       let formData = new FormData(this);
	   $.ajax({
		type:'POST',
		url:url,
		data:formData,
		processData: false,
		contentType: false,
		success:function(response){
          if(response.success){
			location.reload();
		  }else{
			alert("Please enter correct credential");
		  }
		},
		error:function(response){
            console.log(response);
		}
	   })
	})

	//Add to cart functionality

	$('.add_to_cart_class').click(function(e){
		e.preventDefault();
		$.ajax({
			type:"GET",
			url:'/add-to-cart',
			data:{product_id:$(this).data('id')},
			success:function(response){
                if(response.success){
					location.reload();
				}
			},
			error:function(response){
			   alert(response.responseJSON.error);
			}
		})
	})

	//Remove cart functionality

	$('.remove_products').click(function(e){
          e.preventDefault();
		  $.ajax({
			type:"GET",
			url:'/remove-cart-products',
			data:{product_id:$(this).data('productid')},
			success:function(response){
				if(response.success){
					location.reload();
				}
			}
		  })
	})
})