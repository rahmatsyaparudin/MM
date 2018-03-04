<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Main Template View
	 * 
	 * @access public
	 * @author Rahmat Syaparudin
	 * @return void
	 * @url http://yoursite.com/
	 */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Morning Meeting</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">		
		<link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=base_url()?>bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=base_url()?>bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables/datatables.min.css">
		<link rel="stylesheet" href="<?=base_url()?>dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?=base_url()?>dist/css/skins/_all-skins.min.css">
  		<link rel="stylesheet" href="<?=base_url()?>plugins/iCheck/all.css">
  		<link rel="stylesheet" href="<?=base_url()?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	   	<style>
			th {
			    text-align: left;
			    width: auto;
			}

			.opsi{
				width: 7%;
			}
			.radio-group label {
			   	overflow: hidden;
			} .radio-group input {
				height: 1px;
			   	width: 1px;
			   	position: absolute;
			  	top: -20px;
			} .radio-group .not-active  {
			   	color: #070707;
			   	background-color: #fff;
			}
			.modal-backdrop {
    			background-color: navy;
   			}
   			.embed-responsive {
			    position: relative;
			    display: block;
			    height: 0;
			    padding: 0;
			}
			.swal-overlay {
  				background-color: rgba(43, 165, 137, 0.45);
			}
			.swal-button {
  				color: black;
			}
   			input[type=text]:valid {color: black;}
   			input[type=text]:invalid {color: red;}
   			input[type=email]:valid {color: black;}
   			input[type=email]:invalid {color: red;}
   			input[type=number]:valid {color: black;}
   			input[type=number]:invalid {color: red;}
		</style>
		<?php 
			if($js!=''){$this->load->view($js);}
			else{$js = '';}
		?>
	</head>
	<?php if($this->uri->segment(3)!='viewFullscreen'){$fixed = 'fixed';} else {$fixed = '';}?>
	<body class="hold-transition skin-blue <?=$fixed?> layout-top-nav">
		<div class="wrapper">
			<header class="main-header">
				<nav class="navbar navbar-static-top">
					<div class="container">
						<div class="navbar-header">
							<a href="<?=base_url()?>index.php/" class="navbar-brand"><b>Morning</b>Meeting</a>
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"><i class="fa fa-bars"></i></button>
						</div>

						<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
							<ul class="nav navbar-nav">
								<li <?php if($this->uri->segment(2)=='timeline'){echo ' class="active"';}?>>
									<a href="<?=base_url()?>index.php/home/timeline/" onClick="killProcess()" title="Timeline">Timeline</a>
								</li>
								<? if ($this->session->userdata('isLogin') == TRUE) : ?>
								<li <?php if($this->uri->segment(2)=='upload'){echo ' class="active"';}?>>
									<a href="<?=base_url()?>index.php/home/upload/" onClick="killProcess()" title="File Upload">File Upload</a>
								</li>
								<? if ($this->session->userdata('isAdmin') == 1) : ?>
								<li <?php if($this->uri->segment(2)=='user'){echo ' class="active"';}?>>
									<a href="<?=base_url()?>index.php/home/user/" onClick="killProcess()" title="User List">User List</a>
								</li>
								<? endif ?>
								<li>
									<a href="<?=base_url()?>index.php/home/signout">Sign Out</a>
								</li>
								<? endif ?>
								<? if ($this->session->userdata('isLogin') != TRUE) : ?>
								<li <?php if($this->uri->segment(2)=='signin'){echo ' class="active"';}?>>
									<a href="<?=base_url()?>index.php/home/signin" onClick="killProcess()" title="Sign in">Sign in</a>
								</li>
								<? endif ?>
							</ul>
						</div>
						<?php if ($this->session->userdata('isLogin') == TRUE){ $nameUser = $this->session->userdata('getName');?>
						<div class="navbar-custom-menu">
							<ul class="nav navbar-nav">
								<li><a href="#">
									<?php 
										if ($this->session->userdata('isAdmin') == 1) 
											echo 'Welcome <i class="fa fa-user-secret"></i> , '.$nameUser; 
										else 
											echo 'Welcome <i class="fa fa-user"></i> , '.$nameUser;
									?>
								</a></li>
							</ul>
						</div>
						<?php }else{} ?>
					</div>
				</nav>
			</header>

			<div class="content-wrapper">
				<?php $this->load->view($content);?>		
			</div>
			
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.5.0
				</div>
				<strong>Copyright &copy; 2018 Morning Meeting.</strong> Template By <a href="https://adminlte.io">Almsaeed Studio</a>
			</footer>

			<div class="control-sidebar-bg"></div>
		</div>
		
		<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>		
		<script src="<?=base_url()?>bower_components/jquery/dist/jquery.js"></script>
		<script src="<?=base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>
		<script src="<?=base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?=base_url()?>bower_components/datatables/datatables.min.js"></script>
		<script src="<?=base_url()?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
		<script src="<?=base_url()?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
		<script src="<?=base_url()?>bower_components/moment/min/moment.min.js"></script>
		<script src="<?=base_url()?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?=base_url()?>plugins/iCheck/icheck.min.js"></script>
		<script src="<?=base_url()?>bower_components/fastclick/lib/fastclick.js"></script>
		<script src="<?=base_url()?>dist/js/adminlte.min.js"></script>
		<script src="<?=base_url()?>dist/js/jquery.timeago.js" type="text/javascript"></script>
		<script src="<?=base_url()?>dist/js/pages/dashboard.js"></script>
		<script src="<?=base_url()?>dist/js/sweetalert.min.js"></script>
		<script src="<?=base_url()?>/dist/js/pdfobject.js"></script>
		<script type="text/javascript">
			$(function() {
            	$(this).bind("contextmenu", function(e) {
                	e.preventDefault();
            	});
        	}); 
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			    $('[data-toggle="modal"]').tooltip();

				jQuery("time.timeago").timeago();

				document.onmousedown=disableclick;
				status="Sorry, right click disabled for security reason";
				function disableclick(event){
					if(event.button==2)	{
						// alert(status);
            			event.preventDefault();
						swal({
  							text: status,
  							icon: "warning",
  							button: "Are you kidding me?",
						});
						return false;    
					}
				} 			    
			});

			$().button('toggle');
			$().button('dispose');	
		</script>
	</body>
</html>