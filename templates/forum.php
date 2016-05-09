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
			      
			        <div class="col s12 m12">
			        
			        	<div id="disqus_thread"></div>
							<script>
							
// 							    var disqus_config = function () {
// 							        this.page.url = '/directory/forum/index/';  // Replace PAGE_URL with your page's canonical URL variable
// 							        this.page.identifier = '1' //; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
// 							    };

								var lang = '<?php echo $this->Session->getUserLang();?>';

								if(lang != '') {
									var disqus_config = function () { 
	  									this.language = lang.substr(0,2);
									};
								}
							    
							    (function() {
							        var d = document, s = d.createElement('script');
							        
							        s.src = '//scenedb.disqus.com/embed.js';
							        
							        s.setAttribute('data-timestamp', +new Date());
							        (d.head || d.body).appendChild(s);
							    })();
							</script>
							<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
			        		
			        </div>
			          
			        
			      </div>
			
			</div>
		</div>
	</div>
</div>
       <script id="dsq-count-scr" src="//scenedb.disqus.com/count.js" async></script>
