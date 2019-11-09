function addproduto() {
    let preco = Number(document.getElementById('produtos').value.split("|")[0].split("R$")[1].split(",")[0].split(" ")[1]);
    let nome = document.getElementById("produtos").value.split("|")[1];

    $("#addproduto").append("<tr class='items'><td>"+nome+"</td><td><input class='al mx-2' type='number' step='0.01' min='1' value='1' onchange='mudouvalor()'><input class='la mx-2' type='number' step='0.01' min='1' value='1' onchange='mudouvalor()'></td><td><input class='quantidade' type='number' min='1' value='1' onchange='mudouvalor()'></td><td class='valor_unitario'>R$ "+preco.toFixed(2).replace('.', ',')+"</td><td class='subtotal'>R$ "+preco.toFixed(2).replace('.', ',')+"</td></tr>");

    soma = 0;
    for(i = 0; i < document.getElementsByClassName('items').length; i++) {
        soma += Number(document.getElementsByClassName('items')[i].textContent.split('R$')[1].split(',')[0].trim())*Number(document.getElementsByClassName('quantidade')[i].value);
      };
      document.getElementById('res').innerHTML = 'Total: R$ '+soma.toFixed(2).replace('.', ',');
}

function mudouvalor() {
    for(i = 0; i < document.getElementsByClassName('subtotal').length; i++) {
        document.getElementsByClassName('subtotal')[i].innerHTML = "R$ " + Number(Number(document.getElementsByClassName("valor_unitario")[i].innerHTML.split("R$")[1].trim().split(",")[0])*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value)).toFixed(2).replace('.',',');
    };
    soma = 0;    
    for(i = 0; i < document.getElementsByClassName('items').length; i++) {
        soma += Number(Number(document.getElementsByClassName("valor_unitario")[i].innerHTML.split("R$")[1].trim().split(",")[0])*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value));
      }; 
      document.getElementById('res').innerHTML = 'Total: R$ '+soma.toFixed(2).replace('.', ',');
}

function validar_redefinir_senha_logado() {
    let atual = document.getElementById('atualsenha');
    let nova  = document.getElementById('novasenha');
    let nova_novamente = document.getElementById('novasenhanovamente');

    if(atual.value.length > 0 && nova.value.length > 0 && nova_novamente.value.length > 0) {
        return true;
    } else {
        alert('Preencha todos os campus !');
        return false;
    }
}

function validar_login() {
    let nomeouemail = document.getElementById('nomeouemail');
    let senha = document.getElementById('senha');

    if(nomeouemail.value.length > 0 && senha.value.length > 0) {
        return true;
    } else {
        alert('Preencha todos os campus !');
        return false;
    }
}

function validar_usuario() {
    let nome      = document.getElementById('nome');
    let email     = document.getElementById('email');
    let permissao = document.getElementsByName('checkbox');

    if(email.value.split('@').length > 1 && nome.value.length > 0 && (permissao[0].checked || permissao[1].checked)) {
        return true;
    } else {
        alert('Preencha todos o campos corretamente !');
        return false;
    }
}

function delUsuario(usuario) {
    if((document.getElementsByClassName("ADMINISTRADOR").length > 1) || (usuario.className.indexOf('PADRÃO') != -1)) {
      if(confirm('O usuário '+usuario.name+' será deletado.') == true) {
         location = 'del.usuario?id='+usuario.id;
      } 
    } else if ((document.getElementsByClassName("ADMINISTRADOR").length == 1) && (usuario.className.indexOf('ADMINISTRADOR') != -1)) {
        alert('O usuário '+usuario.name+' é o único Administrador. Não será possível deletá-lo.');
    }
}

$(document).ready(function() {

    function limpa_formulário_cep() {
        
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }
    
    $("#cep").blur(function() {

        let cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {

            let validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {

                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } 
                    else {                        
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            }
            else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } 
        else {
            limpa_formulário_cep();
        }
    });
});

function validar_cadastro_cliente() {
    let nomecompleto = document.getElementById('nomecompleto');
    let fone         = document.getElementById('fone');
    let cep          = document.getElementById('cep');
    let rua          = document.getElementById('rua');
    let bairro       = document.getElementById('bairro');
    let cidade       = document.getElementById('cidade');
    let uf           = document.getElementById('uf');
    
    if(nomecompleto.value.length > 0 && fone.value.length == 14 && cep.value.length == 8 && rua.value.length > 0 && bairro.value.length > 0 && cidade.value.length > 0 && uf.value.length > 0) {
        return true;
    } else {
        alert("Preencha os campos obrigatórios(*) corretamente!");
        return false;
    }
}

function validar_cadastro_produto() {
    let nome          = document.getElementById('nome');
    let unidademedida = document.getElementById('unidademedida');
    let categoria     = document.getElementById('categoria');
    let valor         = document.getElementById('valor');

    if(nome.value.length > 0 && unidademedida.value.length > 0 && categoria.value.length > 0 && valor.value.length > 0) {
        return true;
    } else {
        alert("Preencha todos os campos corretamente!");
        return false;
    }
}

function mascara_fone(form, fieldName, evento)
{
    if (evento != null)
    {
        let code;
        let navegador = navigator.appName;

        if (navegador.indexOf("Netscape") != -1) {
            code = evento.which;
        } else {
            code = evento.keycode;
        }
        if (code == 8)
            return true;
    }
    
    let fone = '';
    fone = fone + form.value;

    if (fone.length == 2) {
        fone = fone + ' 9 ';
        fieldName.value = fone;
    }
    if (fone.length == 9) {
        fone = fone + '-';
        fieldName.value = fone;
    }
}

function delCliente(cliente) {
    if(confirm('O cliente '+cliente.name+' será deletado.') == true) {
        location = 'del.cliente?id='+cliente.id;
    }    
}

function addCategoria() {
    let nomecategoria = prompt("Adicionar categoria:");
    if(nomecategoria != null) {
        location = 'add.categoria?nome='+nomecategoria;
    }
}

function categorias() {
   let x = $('#categorias');

   if(x.css('display') == 'none') {
       x.css('display', 'block');
   } else {
       x.css('display', 'none');
   }
}

function delCategoria() {
    let nome = document.getElementById('categoria').value;
    if(document.getElementById('categoria').value != "") {
        if(confirm('A categoria '+nome+' será deletada.') == true) {
            location = 'del.categoria?nome='+nome;
        }
    } else {
        alert("Você não selecionou nenhuma categoria!");
    }        
}

function delProduto(produto) {
    if(confirm('O produto '+produto.name+' será deletado.') == true) {
        location = 'del.produto?id='+produto.id;
    } 
}

function mascara_datahora(form, fieldName, evento)
{
    if (evento != null)
    {
        let code;
        let navegador = navigator.appName;

        if (navegador.indexOf("Netscape") != -1) {
            code = evento.which;
        } else {
            code = evento.keycode;
        }
        if (code == 8)
            return true;
    }
    
    let datahora = '';
    datahora = datahora + form.value;

    if (datahora.length == 2) {
        datahora = datahora + '/';
        fieldName.value = datahora;
    }
    if (datahora.length == 5) {
        datahora = datahora + '/';
        fieldName.value = datahora;
    }
    if (datahora.length == 10) {
        datahora = datahora + ' ';
        fieldName.value = datahora;
    }
    if (datahora.length == 13) {
        datahora = datahora + ':';
        fieldName.value = datahora;
    }
}

function mascara_valor(form, fieldName, evento)
{
    if (evento != null)
    {
        let code;
        let navegador = navigator.appName;

        if (navegador.indexOf("Netscape") != -1) {
            code = evento.which;
        } else {
            code = evento.keycode;
        }
        if (code == 8)
            return true;
    }
    
    let valor = '';
    valor = valor + form.value;

    if (valor.length == 0) {
        valor = valor + 'R$ ';
        fieldName.value = valor;
    }  
}