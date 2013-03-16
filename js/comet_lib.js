var comet_lib = function(url,data,form_method,dataType,handler) {
		
		this.url = url;
		this.data = data;
		this.type = form_method;
		this.dataType = dataType;
		this.error_timeout = 5000;
		this.fetch_interval = 1000;
		this.continue_fetch = true;
		this.handler = handler;
		
		this.connect = function(clib) {
			
			$.ajax({
				url: this.url,
				data: this.data,
				type: this.type,
				dataType: this.dataType,
				success: function(data) {
					clib.handler(data,clib);
				},
				complete: function(jqXHR, textStatus) { 
					if (textStatus != 'success') { 
						if (clib.continue_fetch) { 
							setTimeout(function() { clib.connect(clib); }, clib.error_timeout);	
						}
					} else {
						if (clib.continue_fetch) {
							setTimeout(function() { clib.connect(clib); }, clib.fetch_interval);
						}
					}
				}
			});
				
		}
		
};
