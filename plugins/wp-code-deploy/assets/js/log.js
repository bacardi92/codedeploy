(function($){

    _this = {

        logSelector: $("#getLogFile"),
        logView: $("#wpcd_logs"),

        requestFile: function(){
            $(document).on('change', _this.logSelector, function(e){
                e.preventDefault();
                console.log(_this.logSelector.val());
                var data = {
                    action: "request_log_file",
                    logFile: _this.logSelector.val()
                };
                _this.sendPostRequest(ajaxurl, data, function(json){
                    if(json.hasOwnProperty('logs')) {
                        _this.logView.val(json.logs);
                    }else{
                        $("#logsWrapper").before(json.message);
                    }
                });
            })
        },

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

        init:function(){
            _this.requestFile();
        }

    };
    _this.init();

})(jQuery);