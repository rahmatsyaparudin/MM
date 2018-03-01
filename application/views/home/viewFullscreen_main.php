<script>
	var options = {
    	pdfOpenParams: { pagemode: 'none', scrollbar: '1', toolbar: '0', statusbar: '1', messages: '0', navpanes: '1', view: 'FitH' },
		fallbackLink: '<div class="row"><div class="col-md-3"></div><div class="col-md-6"><div class="alert alert-warning alert-dismissible"><i class="icon fa fa-warning"></i>This browser does not support inline PDFs. Please use Google Chrome or Opera.</div><br><center><a href="<?=base_url()?>index.php/home/timeline" class="btn btn-primary btn-lg" data-toggle="modal" data-placement="top" title="Back To Timeline"><i class="fa  fa-arrow-circle-left "></i> Back To Timeline</a></center></div></div>'
	};

	window.onload = function (){
		var pdf = document.querySelector("#pdf");
		pdf.innerHtml = PDFObject.embed("<?=base_url().$data->location?>", "#pdf", options);
	}
</script>

<section class="content">
	<div class="row">	
		<div class="alert alert-success alert-dismissible"><i class="icon fa fa-file"></i>File Name : <?=$data->file_tittle?> (<?=$data->file_name?>)</div>
		<p><strong></strong></p>	
		<div class="embed-responsive" style="padding-bottom:41%">
			<div id="pdf"></div>
		</div>			
	</div>
</section>
