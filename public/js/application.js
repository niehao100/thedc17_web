$(document).ready(function() {
	
	// $("#loginAlert").alert('close');

	$("#login").click(function(){
		  $.post(window.location.href+'/user/login',
		  {
		    nickname:$("#login-nickname").val(),
		    password:$("#login-password").val(),
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
		    		 window.location.href=window.location.href;
		    	}else{
		    		var date=new Date(); 
	    			date.setTime(date.getTime()-10000); 
	    			document.cookie="autologin="+obj.cookie+";expires="+date.toGMTString();
	    			
	    			$("#loginAlert").attr("class","alert alert-warning fade in");
		    	}
		    }
		  });
		});
	
	$('#registermodal').on('hidden.bs.modal', function () {
		$('#registerform')[0].reset();});
	
	$('#loginmodal').on('hidden.bs.modal', function () {
		window.location.href=window.location.href;});
	
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
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: '用户名只能为英文、数字、下划线'
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
 /*                   stringLength: {
                        min: 11,
                        max: 11,
                        message: '长度为11'
                    }*/
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
                    identical:{
                    	message:'密码输入不同',
                    	field:'repassword'
                    },
                    different:{
                    	message:'密码不能与用户名相同',
                    	field:'nickname'
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
                    },
                    different:{
                    	message:'密码不能与用户名相同',
                    	field:'nickname'
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
});