$("#cadastro").click(function(){
	var dado = $("#sinonimo").val();//id definido em form/sinonimo
	var route = "http://localhost/rarasweb/public/admin/sinonimos";
	var token = $("#token").val();

$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data:{sinonimo: dado},

		success:function(){
			$("#msg-error").hide(); //esconde
			$("#msg-success").fadeIn();
		},

		error:function (msg) {

			$("#msg-success").hide();
			console.log(msg.responseJSON.sinonimo);
			$("#msg").html(msg.responseJSON.sinonimo);
			$("#msg-error").fadeIn();

		}

		

		
	});
});