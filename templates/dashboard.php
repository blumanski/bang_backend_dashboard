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
				
				<h5 class="breadcrumbs-title"><?php echo $this->Lang->write('dashboard_module_headline');?></h5>
				<ol class="breadcrumbs">
					<li>
						<a href="/">
							<?php echo $this->Lang->write('app_breadcrumbs_home');?>
						</a>
						 <i class="mdi-hardware-keyboard-arrow-right" style="line-height: 15px;"></i>
						<?php echo $this->Lang->write('dashboard_breadcrumbs_dashboard');?>
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
			      
			      <?php if(isset($this->tplVar['dbMessages']) && is_array($this->tplVar['dbMessages']) && count($this->tplVar['dbMessages'])) { ?>
			        <div class="col s12 m4">
			          <div class="card light-grey">
			            <div class="card-content">
			              <span class="card-title"><?php $this->Lang->write('dashboard_system_db_log_headline');?></span>
			              
			              <ul>
			              	<?php foreach($this->tplVar['dbMessages'] AS $key => $value) { ?>
			              	
			              	
			              	<li title="<?php echo htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8');?>">
			              	
			              		<strong><time data-format="LLL" datetime="<?php echo htmlspecialchars($value['logtime'], ENT_QUOTES, 'UTF-8');?>"></time></strong><br />
			              		<?php echo \Bang\Helper::cutString(htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8'), 35, '...');?>
			              	
			              	</li>
			              	
			              	<?php } ?>
			              </ul>
			              
			            </div>
			          </div>
			        </div>
			        <?php } ?>
			        
			        <?php if(isset($this->tplVar['appMessages']) && is_array($this->tplVar['appMessages']) && count($this->tplVar['appMessages'])) { ?>
			        <div class="col s12 m4">
			          <div class="card light-grey">
			            <div class="card-content">
			              <span class="card-title"><?php $this->Lang->write('dashboard_system_app_log_headline');?></span>
			              
			              <ul>
			              	<?php foreach($this->tplVar['appMessages'] AS $key => $value) { ?>
			              	
			              	
			              	<li title="<?php echo htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8');?>">
			              	
			              		<strong><time data-format="LLL" datetime="<?php echo htmlspecialchars($value['logtime'], ENT_QUOTES, 'UTF-8');?>"></time></strong><br />
			              		<?php echo \Bang\Helper::cutString(htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8'), 35, '...');?>
			              	
			              	</li>
			              	
			              	<?php } ?>
			              </ul>
			              
			            </div>
			          </div>
			        </div>
			      
				<?php } ?>
			        
			      </div>
			      
				
				
				
				
            
			
			</div>
		</div>
	</div>
</div>
       
