<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){		
		$.fn.DataTable.ext.pager.numbers_length = 5;
        var oTable = $('#uploadList').DataTable({
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
			iDisplayLength	: 5,
			searching		: true,
			sPaginationType	: 'simple_numbers',
	     	stateSave		: true,
			sAjaxSource		: "<?=base_url()?>index.php/home/jsonUpload",
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
	
        setInterval( function () {
		    oTable.ajax.reload(null, false);
		}, 5000);

		$('#uploadList tbody').on( 'click', 'tr', function () {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        }
	        else {
	            oTable.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });

	    $('#uploadList tbody').on( 'load', 'tr', function () {
	        if ($(this).hasClass('selected')) {
	            $(this).removeClass('selected');
	        }
	        else {
	            oTable.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });
	});

	function fileDelete(id) {
		swal({
  			title: "Are you sure want to delete file id "+id+"?",
  			text: "Once deleted, you will not be able to recover this file?",
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
					url: "<?=base_url()?>index.php/home/jsonUploadDelete/"+id,
					type: 'POST',
					dataType: 'JSON',
					data: {id : id,},
					success: function(data) {
						if(data.status == 'success'){
							swal({
								title: "Oh, Poof!",
  								text: "Your file with id "+id+" has been deleted!",
      							icon: "success",
      							button: "I'm Fine!",
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
  					text: "Your file with id "+id+" is safe!",
      				icon: "info",
      				button: "Thanks God!",
      				className: "btn-info",
    			});
  			}
		});
	}
</script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">