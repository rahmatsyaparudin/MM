<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){		
		$.fn.DataTable.ext.pager.numbers_length = 5;
        var oTable = $('#userList').DataTable({
        	aLengthMenu		: [[5,10,15,20], [5,10,15,20]],
		    bLengthChange	: true,
	        bAutoWidth		: true,
	        bPaginate		: true,
	        bInfo			: true,
		    bJQueryUI		: true,
	     	bFilter 		: true,
            bProcessing		: false,
			bServerSide		: false,
			bDestroy		: true,
			bRetrieve		: true,
			deferRender		: true,
			deferLoading	: 57, //57
			iDisplayLength	: 5,			
			searching		: true,
			sPaginationType	: 'first_last_numbers',
	     	stateSave		: true,
			sAjaxSource		: "<?=base_url()?>index.php/home/jsonUser",
			fnInitComplete: function()
				{this.parent().applyTemplateSetup();},
			fnServerData 	: function(sSource, aoData, fnCallback, oSettings){
		    	oSettings.jqXHR = $.ajax({
		    		dataType 	: 'JSON',
		    		type 		: "POST",
		    		url 		: sSource,
		    		data 		: aoData,
		    		success		: fnCallback
		    	})
		    }
		});
	
        setInterval(function() {
		    oTable.ajax.reload(null, false);
		}, 5000);

		$('#userList tbody').on('click', 'tr', function() {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        }
	        else {
	            oTable.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });
	});

	$(function() {
		$('.radio-group label').on('click', function(){
		    $(this).removeClass('not-active').siblings().addClass('not-active');
		});
		$('.radio-group input[name = "levelAdd"]').on('click', function(){
		    $(this).removeAttr('checked').siblings().attr('checked', 'checked');
		});
		$('.radio-group input[name = "statusAdd"]').on('click', function(){
		    $(this).removeAttr('checked').siblings().attr('checked', 'checked');
		});
	});

	function userDelete(id) {
		swal({
  			title: "Are you sure want to delete this account '"+id+"'?",
  			text: "Once deleted, you will not be able to recover this account?",
  			icon: "warning",
  			buttons: ["Please No!", "Yes, Delete It!"],
  			dangerMode: true,
  			closeOnClickOutside: false,
  			closeOnEsc: false,
  			className: "btn-warning",
		})
		.then((willDelete) => {
  			if (willDelete) {
  				$.ajax({
					url: "<?=base_url()?>index.php/home/jsonUserDelete/"+id,
					type: 'POST',
					dataType: 'JSON',
					data: {id : id,},
					success: function(data) {
						if(data.status == 'success'){
							swal({
								title: "Oh, Poof!",
  								text: "Your account with username "+id+" has been deleted!",
      							icon: "success",
      							button: "I'm Fine!",
    						});
    					} else if(data.status == 'isLogin'){
    						swal({
								title: "Are you Okay?",
			  					text: "You can't delete your account when signin",
			      				icon: "warning",
			      				button: "Dont Worry about Me!",
			      				className: "btn-warning",
			    			});
						} else {
							swal({
								title: "Oh Snap!",
  								text: "The AJAX request failed! "+data.status,
      							icon: "error",
      							button: "Find Out!",
      							className: "btn-danger",
    						});
						}
					}
				});
				return true;    			
  			} else {
    			swal({
					title: "Proud!",
  					text: "Your account with username "+id+" is safe!",
      				icon: "info",
      				button: "Thanks God!",
      				className: "btn-info",
    			});
  			}
		});
	}
</script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">