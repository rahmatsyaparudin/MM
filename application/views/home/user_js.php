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

	$(document).ready(function(){
		$('#modalEditUser').on('show.bs.modal', function (event) 
		{
			var newURL = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;
  			var pathArray = window.location.pathname.split( '/' );
  			var segment_edit = pathArray[5];
  			
			var button = $(event.relatedTarget);
	  		var modalData = button.data('whatever');
	  		
	  		var modal = $(this);
	  		if (modalData != ''){ 
	        	$.get('<?=base_url()?>index.php/home/jsonUserEdit/'+modalData, function(data){
	        		var json = JSON.parse(data);
	        		modal.find('.modal-title').text('Edit User Data - ' + json.name);
	        		modal.find('#username_edit').val(json.username);
	        		modal.find('#username_temp').val(json.username);
	        		modal.find('#password_edit').val(json.password);
	        		modal.find('#name_edit').val(json.name);
	        		modal.find('#email_edit').val(json.email);
	        		if (json.status == 1)
	        		{
	        			modal.find('#statusDisable').removeAttr("checked");
	        			modal.find('#statusEnable').attr("checked", "checked");
	        			modal.find('#statusEnableLbl').removeClass("not-active");
	        			modal.find('#statusDisableLbl').addClass("not-active");
	        		}
	        		else if (json.status == 0)
	        		{
	        			modal.find('#statusEnable').removeAttr("checked");
	        			modal.find('#statusDisable').attr("checked", "checked");
	        			modal.find('#statusDisableLbl').removeClass("not-active");
	        			modal.find('#statusEnableLbl').addClass("not-active");
	        		}

	        		if (json.isAdmin == 1)
	        		{
	        			modal.find('#levelIsUser').removeAttr("checked");
	        			modal.find('#levelIsAdmin').attr("checked", "checked");
	        			modal.find('#levelAdminLbl').removeClass("not-active");
	        			modal.find('#levelUserLbl').addClass("not-active");
	        		}
	        		else if (json.isAdmin == null)
	        		{
	        			modal.find('#levelIsAdmin').removeAttr("checked");
	        			modal.find('#levelIsUser').attr("checked", "checked");
	        			modal.find('#levelUserLbl').removeClass("not-active");
	        			modal.find('#levelAdminLbl').addClass("not-active");
	        		}
	        	});
	  		}
		});
	});
</script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">