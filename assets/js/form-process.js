    $(document).ready(function(){
		
		
		var text_boxes = "";
		$("#amount-transfer-div :text").each(function(){
		//alert($(this).attr('id'));
		text_boxes += '#'+$(this).attr('id')+',';
		});	
		text_boxes = text_boxes.slice(0,-10);
		text_boxes = text_boxes+',';
		
		//alert(text_boxes);
		
		var result = text_boxes.split(',');
		//alert( 'Len = '+result.length+ ' : '+result[0]+' , '+result[1]+' , '+result[2] );
		
		text_boxes = text_boxes.slice(0,-1);
		
		//alert(text_boxes);		
		
		var tot, deposit, sumup;		
		
		$( text_boxes ).keyup(function() {
		  //console.log( "Handler for .keypress() called." );	  
		  
		  //case1 = 0;
		  //case2 = 0;
		  tot = 0;
		  deposit = 0;		  
		  sumup = 0;
		  
		  $.each( result, function( key, value ) {	  
			if (key == 0 || $.trim(value)  === "") { //  key = 0 : Skip first iteration as it processes total_transfer
				return;			  
			}
			sumup = sumup + Number($($.trim(value)).val());		  
		  
		});
		
		//alert('Sum = '+sumup);

		
		
		
		  
		  
		  //case1 = Number($('#case1').val());
		  //case2 = Number($('#case2').val());
		  
		  tot = Number($('#total_transfer').val());
		  
		  if( sumup > tot ) {
			  alert("Invalid Split-up: Total transfer and respective split-up doesn't match! ");
			  text_boxes_clear = text_boxes.substring(16, text_boxes.length);
			  //alert(text_boxes_clear);
			  $(text_boxes_clear).val("");
			  
			  //$('#case1').val("");
			  //$('#case2').val("");
			  //$('#deposit').val("");			  
		  } else {	  
		  
			deposit = Number(tot - sumup);
		  
			$('#deposit').val(deposit);
		  }
		});


        $('#whatsapp_phone').click(function(){

            if($(this).prop("checked") == true){

                //alert("Checkbox is checked. "+$("#phone").val().length);
				
				if ($("#phone").val().length >= 10) {
					
					$("#whatsapp").val($("#phone").val());
				} else {
					
					alert("Invalid Phone");
					$('#whatsapp_phone').attr('checked', false);
				}
            }
            else if($(this).prop("checked") == false){

                $("#whatsapp").val("");

            }

        });
		
		var total_amount = 0;
		var text_boxes = "";
		var current_balance = Number($("#current_balance").val());
		
		$("#amount-transfer-div :text").each(function(){
			//alert($(this).attr('id'));
			text_boxes += '#'+$(this).attr('id')+',';
		});	
		text_boxes = text_boxes.slice(0,-1);
		
		//alert(text_boxes);
			
		/*$( text_boxes ).keyup(function() {			  
			$("#amount-transfer-div :text").each(function(){
				total_amount = total_amount + Number($(this).val());
			});		  
		  $('#total_amount').html( total_amount );
		  
		  $('#total_deposit').html( current_balance+total_amount );
		  total_amount = 0;
		});*/
		

    });
	
	function processPayments(member_id, transaction_id, payment_action) {
		//alert('Action = '+payment_action);
		
		
		var paymentDetails = {
		  admin_action_message: $("#admin_action_text").val(),
		  admin_action: payment_action
		};

        $('#target').html('<b>Processing...</b>');
		$('#target').show();
		
		if(payment_action == 'approve') {
			payment_action_response = 'Approved';
		}
		if(payment_action == 'reject') {
			payment_action_response = 'Rejected';
		}		
		
		$.ajax({
            url: 'processPayments.php',
            type: 'post',
            dataType: 'text',
            success: function (data) {
				$('#target').hide();
                $('#admin-action-div').html(payment_action_response+' <br />'+$("#admin_action_text").val());
				//alert('Returned from AJAX = '+data);
            },
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				if (textStatus == 'Unauthorized') {
					alert('custom message. Error: ' + errorThrown);
				} else {
					alert('custom message. Error: ' + errorThrown);
				}
			},			
            data: paymentDetails
        });
		
		
	}
	
	
	function hideAndShowDiv(act, divname) {
		
		if (act == 'hide') {
			$('#'+divname).hide();
			$('#div-show-'+divname).hide();
			$('#div-hide-'+divname).hide();
			$('#div-show-'+divname).show();
		}
		if (act == 'show') {
			$('#'+divname).show();
			$('#div-show-'+divname).hide();
			$('#div-hide-'+divname).hide();
			$('#div-hide-'+divname).show();
		}		
			
			
		
	}
	
	function updateBalance() {

		var leftBalance , totalTransfer, splitup1, splitup2, deposit, splitup;
		splitup = 0;
		splitup1 = 0;
		splitup2 = 0;
		deposit = 0;
		leftBalance = 0;
		totalTransfer = 0;
		//$('#left_balance_span').html(rs+'');
		
		totalTransfer = Number($('#total_transfer').val());
		
		/* Total Split ups */
		splitup1 = Number($('#case1').val());		
		splitup2 = Number($('#case2').val());		
		deposit = Number($('#deposit').val());
		
		//alert('Total split up = '+splitup);
		splitup = Number(splitup1+splitup2+deposit);
		totalTransfer = Number(totalTransfer);
		
		//alert(totalTransfer+' '+splitup);
		
		leftBalance = Number(totalTransfer - splitup);
		$('#deposit').val(leftBalance);
		
		
		
		
		
		
	}
	
	
	
	