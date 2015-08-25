$(document).ready(function() {
	var rootpath="http://"+location.hostname+"/thedc";
	var modalstate =0; 
	$("[data-toggle='popover']").popover();
	// $("#loginAlert").alert('close');
	$('#fileupload').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        	inputfile: {
                validators: {
                    file: {
                        maxSize: 10 * 1024 * 1024,   // 10 MB
                        message: '文件超过10MB'
                    },
                    notEmpty: {
                        message: '文件不能为空'
                    }
                }
            }
        }
    });
	$("#registersubmit").click(function(){
		values = $("#registerform").serializeArray(); 
			    var values, index; 
			    for (index = 0; index < values.length; ++index) 
			    { 
			    if (values[index].type != "submit") 
			    { 
			    $("#"+values[index].name).blur();
			    	
			    } 
			    } 
			    //alert($('#registerform').bootstrapValidator("isValid"));
			    var bootstrapValidator = $('#registerform').data('bootstrapValidator');
			if (true==bootstrapValidator.isValid())
				{
					$("#registerform").submit();
					$('#registermodal').modal('hide');
				}
	})
	document.onkeydown = function (e) { 
		var theEvent = window.event || e; 
		var code = theEvent.keyCode || theEvent.which; 
		if (code == 13) { 
			if (modalstate==1)
				{
				values = $("#registerform").serializeArray(); 
			    var values, index; 
			    for (index = 0; index < values.length; ++index) 
			    { 
			    if (values[index].type != "submit") 
			    { 
			    $("#"+values[index].name).blur();
			    	
			    } 
			    } 
			    //alert($('#registerform').bootstrapValidator("isValid"));
			    var bootstrapValidator = $('#registerform').data('bootstrapValidator');
			if (true==bootstrapValidator.isValid())
				{
					$("#registerform").submit();
					$('#registermodal').modal('hide');
				}
	       
			return false;
				}else if(modalstate==2)
					{

						$("#login").click();
						return false;

					}else if(modalstate==0){
						
					}
		
		
		} 
		} 
	$("#login").click(function(){
		var bootstrapValidator = $('#loginform').data('bootstrapValidator');
        bootstrapValidator.enableFieldValidators("loginnickname",true)
        			.validateField("loginnickname");
        bootstrapValidator.enableFieldValidators("loginpassword",true)
		.validateField("loginpassword");
        if (false==bootstrapValidator.isValid())
        	{
        	return false;
        	}
		  $.post(rootpath+'/user/login',
		  {
		    nickname:$("#loginnickname").val(),
		    password:$("#loginpassword").val(),
		    rememberme:document.getElementById('rememberme').checked==true?'1':'0'
		  },
		  function(data,status){
		    if (status=='success')
		    {
		    	var obj = JSON.parse(data);
		    	if (obj.status=='success')
		    	{
		    		if (obj.cookie!="")
		    		{
		    			var date=new Date(); 
		    			var expiresDays=60; 
		    			date.setTime(date.getTime()+expiresDays*24*3600*1000); 
		    			document.cookie="autologin="+obj.cookie+";expires="+date.toGMTString(); 
		    		}else{
		    			var date=new Date(); 
		    			date.setTime(date.getTime()-10000); 
		    			document.cookie="autologin="+obj.cookie+";expires="+date.toGMTString(); 
		    		}
		    		$('#loginmodal').modal('hide');
		    		window.location.reload(); 
		    	}else{
		    		var date=new Date(); 
	    			date.setTime(date.getTime()-10000); 
	    			document.cookie="autologin="+obj.cookie+";expires="+date.toGMTString();
	    			
	    			$("#loginAlert").attr("class","alert alert-warning fade in");
		    	}
		    }
		  });
		});
	
	$('#registermodal').on('hide.bs.modal', function () {
		modalstate=0;
		$('#registerform').bootstrapValidator('resetForm','true');});
	
	$('#loginmodal').on('hide.bs.modal', function () {
		modalstate=0;
		window.location.href=window.location.href;});
	
	$('#registermodal').on('shown.bs.modal', function () {
		modalstate=1;$("#nickname").focus();});
	
	$('#loginmodal').on('shown.bs.modal', function () {
		modalstate=2;$("#loginnickname").focus();});
	
	$('#loginform').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        	loginnickname:{
                validators: {
                    notEmpty: {
                        message: '昵称不能为空'
                    },
                    regexp: {
                        regexp: /^[^%'"?*,]+$/,
                        message: '用户名不能出现特殊字符'
                    }
                }
            },
            loginpassword:{
            	validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    }
                }
            }
        }
	});
	
	$('#changeform').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        	oldpass:{
                validators: {
                    notEmpty: {
                        message: '不能为空'
                    },
                    stringLength: {
                        min: 6,
                        message: '长度至少为6'
                    }
                }
            },
            newpass:{
            	validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    stringLength: {
                        min: 6,
                        message: '长度至少为6'
                    }
                }
            },
            renewpass:{
            	validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    identical:{
                    	message:'密码输入不同',
                    	field:'newpass'
                    },
                    stringLength: {
                        min: 6,
                        message: '长度至少为6'
                    }
                }
            }
        }
	});
	
	$('#messageupload').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        	messagedecription:{
                validators: {
                    notEmpty: {
                        message: '标题不能为空'
                    }
                }
            },
            inputtext:{
            	validators: {
                    notEmpty: {
                        message: '内容不能为空'
                    }
                }
            }
        }
	});
	
	
    $('#registerform').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nickname: {
                message: '昵称不符要求',
                validators: {
                    notEmpty: {
                        message: '昵称不能为空'
                    },
                    stringLength: {
                        min: 3,
                        max: 10,
                        message: '昵称长度为3~10之间'
                    },
                    regexp: {
                        regexp: /^[^%'"?*,]+$/,
                        message: '用户名不能出现特殊字符'
                    },
                    remote: {
		                message: '用户名已存在',
		                url: window.location.href+'/user/checkUser'
		            }
                }
            },
            realname: {
                validators: {
                    notEmpty: {
                        message: '姓名不能为空'
                    }
                }
            },
            class: {
                validators: {
                    notEmpty: {
                        message: '班级不能为空'
                    }
                }
            },
            cellphone: {
                validators: {
                    notEmpty: {
                        message: '手机号不能为空'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: '只能为数字'
                    },
                    stringLength: {
                        min: 11,
                        max: 11,
                        message: '长度为11'
                    }
                }
            },
            mailaddress: {
                validators:{
                    notEmpty: {
                        message: '邮箱不能为空'
                    },
                    emailAddress: {
                        message: '邮箱格式错误'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    stringLength: {
                        min: 6,
                        message: '长度至少为6'
                    }
                }
            },
            repassword:{
            	validators:{
            		notEmpty: {
                        message: '密码不能为空'
                    },
                    identical:{
                    	message:'密码输入不同',
                    	field:'password'
                    }
                    
            	}
            },
            vc:{
            	validators:{
            		notEmpty: {
                        message: '验证码不能为空'
                    },
		            remote: {
		                message: '验证码错误',
		                url: window.location.href+'/user/checkVc'
		            }
            	}
            }
        }
    });
    
    // Get plugin instance
    var bootstrapValidator = $('#registerform').data('bootstrapValidator');
    // and then call method
    bootstrapValidator.enableFieldValidators('nickname',false)
    .enableFieldValidators('password',false)
    .enableFieldValidators('repassword',false)
    .enableFieldValidators('realname',false)
    .enableFieldValidators('class',false)
    .enableFieldValidators('cellphone',false)
    .enableFieldValidators('mailaddress',false)
    .enableFieldValidators('vc',false);
    
    
    values = $("#registerform").serializeArray(); 
    var values, index; 
    for (index = 0; index < values.length; ++index) 
    { 
    if (values[index].type != "submit") 
    { 
    $("#"+values[index].name).blur(function(){
    	var bootstrapValidator = $('#registerform').data('bootstrapValidator');
        bootstrapValidator.enableFieldValidators(this.id,true)
        			.validateField(this.id);
        
    	});
    } 
    } 
    
});