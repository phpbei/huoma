/*! 16expoPc1.0.0 2016-05-06 author:feng */function placeholderSupport(){return"placeholder"in document.createElement("input")}function verify(){$($("[verify]").attr("verify")).attr("src","/index.php?magic-verify&_"+Math.random())}function ajaxSubmit(a){var b=$("#loginLoading");b.modal("show");var c=document.getElementById(a),d=new FormData(c);$.ajax({url:c.action,type:"POST",async:!0,data:d,cache:!1,contentType:!1,processData:!1,success:function(a){try{var c=$.parseJSON(a)}catch(d){b.find(".modal-body").html("\u672a\u77e5\u9519\u8bef"),setTimeout(function(){b.modal("hide").find(".modal-body").html("\u6b63\u5728\u767b\u5f55\uff0c\u8bf7\u7a0d\u540e...")},3e3)}var e=c.error,f=c.message,g=3,h=c.forward,i=c.appendjs;""!=i&&null!=i?b.find(".modal-body").html(f+i):b.find(".modal-body").html(f),0==e&&(b.find(".modal-body").append("\r\n"+g+"\u79d2\u540e\u8df3\u8f6c\uff01"),b.find(".modal-footer").html('<a href="'+h+'" class="btn btn-success">\u7acb\u5373\u8df3\u8f6c</a>'),h&&setTimeout(function(){window.location.href=h},g)),0!=e&&(verify(),setTimeout(function(){b.modal("hide").find(".modal-body").html("\u6b63\u5728\u767b\u5f55\uff0c\u8bf7\u7a0d\u540e...")},3e3))},error:function(a){}})}$(function(){$("#loginSubmit").click(function(){ajaxSubmit("loginForm")}),$("[verify]").click(verify()),placeholderSupport()||$("[placeholder]").focus(function(){var a=$(this);a.val()==a.attr("placeholder")&&(a.val(""),"loginPwd"===a.attr("id")&&a.attr("type","password"),a.removeClass("placeholder"))}).blur(function(){var a=$(this);""!=a.val()&&a.val()!=a.attr("placeholder")||(a.addClass("placeholder"),a.val(a.attr("placeholder")),"loginPwd"===a.attr("id")&&a.attr("type","text"))}).blur()});