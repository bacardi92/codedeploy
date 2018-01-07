(function($){

	if( !$("#wpcd_settings_form").length )
	{
		return;
	}

	var _this = {

		form: $("#wpcd_settings_form"),
		username: $("#wpcd_user_name"),
		userEmail: $("#wpcd_user_email"),
		credsName: $('#git_user_name'),
		credsPass: $('#git_user_password'),
		repository: $("#wpcd_repository_path"),
		connectionType: $(".connection_type"),
		saveBtn: $("#save_user_data"),
		saveCreds: $("#save_credentials"),
		testBtn: $("#wpcd_test_connection"),

		sendPostRequest: function(url, data, callback){
			$.ajax({
	            url: url,
	            type: 'POST',
	            data: data,
	            dataType: "json",
	            success: callback,
	            error: callback
	        });
		},

		saveUserData: function(){
			$(_this.saveBtn).on("click", function(e){
				e.preventDefault();
				$("[id^=message-].notice").remove();
				var data = {
					action: 'save_git_user_data',
					username: '',
					userEmail: '',
					repository: '',
					connectionType: ''
				};
				if( _this.validateText(_this.username) && _this.validateText(_this.repository) && _this.validateEmail(_this.userEmail) )
				{
					data.username = _this.username.val();
					data.userEmail = _this.userEmail.val();
                    data.repository = _this.repository.val();
					data.connectionType =_this.defineConnectionType();

					_this.sendPostRequest(ajaxurl, data, function(json){
						if( json.hasOwnProperty('message') )
						{
							_this.form.before(json.message);
                            _this.scrollToTopAnimate();
                        }
					});
				}
			});
		},

		saveCredentials: function(){
			_this.saveCreds.on('click', function (e){
                e.preventDefault();
                $("[id^=message-].notice").remove();
                var data = {
                    action: 'save_git_creds',
                    username: '',
                    password: ''
                };
                if( _this.validateText(_this.credsName) && _this.validateText(_this.credsPass) ){
                    data.username = _this.credsName.val();
                    data.password = _this.credsPass.val();
                    _this.sendPostRequest(ajaxurl, data, function(json){
                        if( json.hasOwnProperty('message') )
                        {
                            _this.form.before(json.message);
                            _this.scrollToTopAnimate();
                        }
                    });
				}
            });
		},

		defineConnectionType: function(){
			type = 'https';
			if(_this.connectionType.length){
				$.each(_this.connectionType, function(){
					if($(this).prop("checked")){
						type = $(this).val();
					}
				})
			}
			return type;
		},


		testConnection: function(){
			_this.testBtn.on('click', function(e){
                e.preventDefault();
                $("[id^=message-].notice").remove();
				data = {
					action: "test_connection",
				};
				_this.sendPostRequest(ajaxurl, data, function(json){
                    if( json.hasOwnProperty('message') )
                    {
                        _this.form.before(json.message);
						_this.scrollToTopAnimate();
                    }
                });
			});
		},

		validateText: function(obj){
			obj.removeClass('error');
			if( !obj.val().length ){
				obj.addClass('error');
				return false;
			}
			return true;
		},

		validateEmail: function(obj) {
			obj.removeClass('error');
		  	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		  	if (emailReg.test( obj.val() ) == false || !obj.val().length ){
		  		obj.addClass('error');
		  		return false;
			}
			return true;
		},

		scrollToTopAnimate:function(delay){
			if(!delay){
				delay = 500;
			}
            $('body').animate({ scrollTop: 0 }, delay);
		},

		init: function(){
			_this.saveUserData();
			_this.saveCredentials();
			_this.testConnection();
		}

	}
	_this.init();

})(jQuery)