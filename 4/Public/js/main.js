function MyAjax(actions)
{
	var xmlhttp;
	var result;
	$("#main_content").html("<div align=\"center\"><font color=\"#10a0ea\" size=\"6\">正在加载，请稍后</font></div>");
	$.get(actions + '&' + Math.random(),function( response , status , xhr){
		if (status == "success")
		{
			$("#main_content").html(response);
		}else{
			alert("网络错误！请重试");
		}
	});
}
function LoginOff(url){
	$.get(url + '&' + Math.random() , function(result , status){
		if(result == "1"){
			alert("注销成功");
			self.location="./";
		}else{
			alert("未知错误");
		}
	});
}
function DeleteMyRecord(url){
	$('#delete-data').val( url );
	$('#my-confirm').modal({
        relatedTarget: this
      });
}
function ConfirmDeleteMyRecord(){
	var url = $('#delete-data').val();
	$.get( url + "&" + Math.random() ,function(response,status){
			if(response == "1"){
				alert("删除成功");
				MyAjax($('#contents-myrecord').attr('data-value'));
			}else{
				alert(response);
			}
	})
}
function ChangeMyRecord(url){
	$('#delete-data').val( url );
	$('#my-confirm2').modal({
        relatedTarget: this
      });
}
