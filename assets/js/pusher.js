if(typeof(pappkey) != 'undefined') {
		
	var pusher = new Pusher(pappkey, {
		encrypted: true,
		cluster: cluster
	});
		
	var channel = pusher.subscribe(chatchan);
	channel.bind('intern_chat', function(data) {
			  
		if(data.message && data.identifier) {
			//send message not to self
			var urlvars = getUrlVars('dashboard', function(response) {
						
				if(response == 1) {
							  
					var urlvars = getUrlVars('chat', function(response){
								  
						if(response == 1) {
							
							$('#chat-window').append('<div class="chat-block"><span class="chat-label" style="background: '+data.colour+'; color: '+data.fontc+'">'+data.username+'</span><span class="chat-message">'+data.message+'</span></div>');
							
							var box = document.getElementById('chat-window');
							box.scrollTop = box.scrollHeight;
						}
					});
				}
			});
		}
	});
}


$(function(){

	$('#form-chat').on('submit', function(event){
		event.preventDefault();
		
		var message = $('#new-message').val();
		$('#new-message').val('');
		
		var request = $.ajax({

    		dataType: 'json',
    		type: 'post',
    		url: '/dashboard/ajax/chatmessage/',
    		data: {
    			message: encodeURIComponent(message)
    		},
		  
		}).done(function(response){
			
			
		}).fail(function(response){
			alert('message failed...');
		});
		
	});
	
});