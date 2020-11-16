(function( $ ) {
	'use strict';
	// console.log(partnersdiscountOptions);

	var Global_Response_Handler = {
	  response : null,
	  init : function( response ) {
	    this.response = response;
	    return this;
	  },
	  is_success : function() {
	    return this.response.status == 'success';
	  },
	  is_error : function() {
	    return this.response.status == 'error';
	  },
	  message : function() {
	    return this.response.message;
	  },
	  status : function() {
	    return this.response.status;
	  },
	  data : function() {
	    return ( this.response.data !== undefined ) 
	      ? this.response.data
	      : {};
	  },
	  get_data : function(key, default_value) {
	    return ( this.response.data[ key ] !== undefined ) 
	      ? this.response.data[ key ]
	      : default_value;
	  },
	  get_request : function(key, default_value) {
	    return ( this.response.request[ key ] !== undefined ) 
	      ? this.response.request[ key ]
	      : default_value;
	  }
	};

	var PartnersDiscountPlugin = {
		init: function() {
			var _this = this;

			$(document).on('click', '.partner-redeem-btn', function(e){
				e.preventDefault();

				var partner_id = $(this).attr('data-id');
				_this.redeemDiscount(partner_id, this);
			});
		},
		redeemDiscount: function(partner_id, button) {
			var _this = this;

			$.ajax({
				type : "post",
				dataType : "json",
				url : partnersdiscountOptions.ajax_url,
				data : {
                    action: 'partnersdiscount_ajax',
                    request_type: 'redeem_discount',
                    partner_id: partner_id,
                },
				success: function(response) {
					var res = Global_Response_Handler.init(response);
					if( res.is_success() ) {
						$(button).attr('disabled', true).addClass('partner-redeemed');
					} else {
						alert(res.message());
					}
				},
				error: function(jqXhr, textStatus, errorMessage) {
					alert("Error processing request. Please contact support. ERROR: " + errorMessage);
				}
			}) 
		}
	};

	PartnersDiscountPlugin.init();
})( jQuery );
