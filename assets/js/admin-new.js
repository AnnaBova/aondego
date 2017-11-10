jQuery(document).ready(function() {
	

		getCommissionTotal();

		getMerchantBalance();

	
}); /*end docu*/

function getCommissionTotal()
{
	$(".commission_loader").html('<i class="fa fa-spinner fa-spin"></i>');
	var params="action=getCommissionTotal";
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){   
        	$(".commission_loader").html('');          	
        	$(".commission_total_3").html(data.details.total_com);
        	$(".commission_total_2").html(data.details.total_today);
        	$(".commission_total_1").html(data.details.total_last);
        }, 
        error: function(){        
        	$(".commission_loader").html('error');
        }		
    });
}

function getMerchantBalance()
{
	$(".commission_loader").html('<i class="fa fa-spinner fa-spin"></i>');
	var params="action=getMerchantBalance";
	 $.ajax({    
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',       
        success: function(data){   
        	$(".commission_loader").html('');          	
        	$(".merchant_total_balance").html(data.details);        	
        }, 
        error: function(){        
        	$(".commission_loader").html('error');
        }		
    });
}

function bankRequired(is_required)
{
	if ( is_required ){
		$("#account_name").attr("data-validation","required");
		$("#bank_account_number").attr("data-validation","required");
		$("#swift_code").attr("data-validation","required");
		$("#bank_name").attr("data-validation","required");
		$("#bank_country").attr("data-validation","required");		
	} else {
		$("#account_name").removeAttr("data-validation");
		$("#bank_account_number").removeAttr("data-validation");
		$("#swift_code").removeAttr("data-validation");
		$("#bank_name").removeAttr("data-validation");
		$("#bank_country").removeAttr("data-validation");
	}
}

