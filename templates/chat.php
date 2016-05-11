<!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
	<!-- Search for small screen -->
	<div class="header-search-wrapper grey hide-on-large-only">
		<i class="mdi-action-search active"></i>
			<input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col s12 m12 l12">
				
				<h5 class="breadcrumbs-title"><?php echo $this->Lang->write('dashboard_module_forum_headline');?></h5>
				<ol class="breadcrumbs">
					<li>
						<a href="/">
							<?php echo $this->Lang->write('app_breadcrumbs_home');?>
						</a>
						 <i class="mdi-hardware-keyboard-arrow-right" style="line-height: 15px;"></i>
						<?php echo $this->Lang->write('dashboard_module_forum_headline');?>
						</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!--breadcrumbs end-->
        
<!--start container-->
<div class="container content-wrapper">
	<div class="section">

		<div class="action-wrapper">
			<div class="table-datatables">
				
				<div class="row">
			      
					<div class="col s12 m6">
			        
						<div id="chat-wrapper">
						
							<div id="chat-window"></div>
						
							<form id="form-chat">
								<input type="text" value="" id="new-message" />
								<button class="btn waves-effect waves-light right submit">Send</button>
							</form>
						
						</div>
						
			        </div>
				</div>
			</div>
		</div>
	</div>
</div>
