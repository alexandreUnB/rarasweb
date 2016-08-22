$(document).ready(function(){
	Carregar();
});

var id=null;
var next_page = null;
var current_page = null;
var prev_page = null;

//Função lista todos synonyms
function Carregar(){
	var tableSinonimos = $("#dados-synonyms"); //id definido em admin/synonyms/index
	var arrow = $("#arrow");

	if(current_page == null) {
		route = "http://localhost/rarasweb/public/admin/sinonimo";//rota para listar todos synonyms()
	}else{
		route = current_page;
	}
	$("#dados-synonyms").empty(); //limpa a tele antes de atualizar novamente
	$("#arrow").empty();

	$.get(route, function(res){
		//estacia dados dos synonyms no form

		$(res).each(function(key,value){//each-> digamos que é um foreach otimizado

			current_page=value.current_page;
			next_page=value.next_page_url;
			prev_page=value.prev_page_url;

		});

		$(res.data).each(function(key,value){//each-> digamos que é um foreach otimizado

				//console.log(value.id);
			tableSinonimos.append("<tr><td>"+value.id+"</td><td class='text-td'>"+value.sinonimo+"</td><td class='text-center'><button  class='btn btn-default btn-acoes '><i class='fa fa-eye' title='Visualizar'></i></button></td><td class='text-center'><button value="+value.id+
				" OnClick='Editar(this);'class='btn btn-success btn-acoes'data-toggle='modal' data-target='#myModal'><i class='glyphicon glyphicon-pencil' title='Editar'></i></button></td><td class='text-center'><button value="+value.id+
				" OnClick='Delete(this);'class='btn btn-danger' data-toggle='modal' data-target='#delete'><i class='fa fa-trash' title='Deletar'></i></button></td></tr>")
		});
	});


	//Cria butões de navegação
	if(prev_page==null){
		arrow.append("<ul class='pager'><li class='disabled'><span>«</span></li> <li value="+current_page+" Onclick='Next(this)'><a>»</a></li></ul>")
	}else if(next_page == null){
		arrow.append("<ul class='pager'><li value="+current_page+" Onclick='Prev(this)'><a>«</a></li> <li class='disabled'><span>»</span></li></ul>")
	}else if(next_page == null && prev_page==null) {
		arrow.append("<ul class='disabled'><span>«</span></li> <li class='disabled'><span>»</span></li></ul>")
	}else{
		arrow.append("<ul class='pager'><li value="+current_page+" Onclick='Prev(this)'><a>«</a></li> <li  value="+current_page+" Onclick='Next(this)'><a>»</a></li></ul>")
		}
}


function Next() {
	current_page = next_page;
	Carregar();
}

function Prev() {
	current_page = prev_page;
	Carregar();
}

//se clicar em button edit, abre a modal com os dados od sinonimo
function Editar(btn) {
	//btn.value é passado os valores do sinonimo vindo no ao clicar
	var route = "http://localhost/rarasweb/public/admin/synonyms/"+btn.value+"/edit";
	$.get(route, function (res) {
		$("#sinonimo").val(res.sinonimo);// #sinonimo é o id definido para um label
		$("#id").val(res.id);

	});
}

//se clicar em button Delete, abre a modal com os dados od sinonimo
function Delete(btn) {
	id=btn.value;
}

//Se clicar no button Atualizar na modal tem ID="atualizar" abre a modal
$("#atualizar").click(function() {
	var value = $("#id").val();
	var dado = $("#sinonimo").val();
	var route = "http://localhost/rarasweb/public/admin/synonyms/"+value+"";
	var token = $("#token").val();// token indica ao laravel que a requisição não é mal intencionada

	$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': token},
			type: 'PUT',
			dataType: 'json',
			data: {sinonimo: dado},
			success: function(){
				current_page = "http://localhost/rarasweb/public/admin/sinonimo?page="+current_page+"";
				Carregar();

				$("#myModal").modal('toggle');//oculta modal
				$("#msg-delete-success").hide();
				$("#msg-success").fadeIn();// messagem de sucesso definida no form
			}
	});
});


//Se clicar no button Delete na modal tem ID="delete" exclui o item
$("#del").click(function() {

	var route = "http://localhost/rarasweb/public/admin/synonyms/"+id+"";
	var token = $("#token").val();// token indica ao laravel que a requisição não é mal intencionada
	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'DELETE',
		dataType: 'json',
		success: function(){
			current_page = "http://localhost/rarasweb/public/admin/sinonimo?page="+current_page+"";

			Carregar();
			$("#msg-success").hide();
			$("#delete").modal('toggle');//oculta modal
			$("#msg-delete-success").fadeIn();// messagem de sucesso definida no form
		}
	});
});

