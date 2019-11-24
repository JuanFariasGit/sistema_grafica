function addproduto() {
    let preco = Number(document.getElementById('produtos').value.split("|")[0].split("R$")[1].trim().replace(',','.'));
    let nome = document.getElementById("produtos").value.split("|")[1];
    
    if(document.getElementById("produtos").value.split("|")[2] == "m²") {
        $("#addproduto").append("<tr id='"+nome+"' class='items'><td><input class='border-0 rounded-0 bg-dark text-white text-center' type='text' name='produtospedido[]' value='"+nome+"' readonly='readonly' style='width: 500px'></td><td><input class='al mx-2 rounded border-0 py-2' type='number' name='al[]' step='0.01' value='1' onkeyup='mudouvalor()' style='width: 80px'><input class='la mx-2 rounded border-0 py-2' type='number' name='la[]' step='0.01' value='1' onkeyup='mudouvalor()' style='width: 80px'></td><td><input class='quantidade rounded border-0 py-2' type='number' name='quantidade[]' min='1' value='1' onkeyup='mudouvalor()' style='width: 80px'></td><td><input class='valor_unitario bg-dark text-white border-0' type='text' name='valorunitario[]' value='R$ "+preco.toFixed(2).replace('.', ',')+"' style='width: 80px' readonly='readonly'></td><td><input class='subtotal bg-dark text-white border-0' type='text' name='subtotal[]' value='R$ "+preco.toFixed(2).replace('.', ',')+"' style='width: 80px' readonly='readonly'></td><td><a id='"+nome+"' class='text-danger' href='javascript:void(0)' onclick='delItem(this)'>[x]</a></td></tr>");
    } else {
        $("#addproduto").append("<tr id='"+nome+"' class='items'><td><input class='border-0 rounded-0 bg-dark text-white text-center' type='text' name='produtospedido[]' value='"+nome+"' readonly='readonly' style='width: 500px'></td><td><input class='al mx-2 rounded border-0 py-2' type='number' name='al[]' step='0.01' value='1' onkeyup='mudouvalor()' readonly='readonly' style='width: 80px;background-color: #AAA'><input class='la mx-2 rounded border-0 py-2' type='number' name='la[]' step='0.01' value='1' onkeyup='mudouvalor()' readonly='readonly' style='width: 80px;background-color: #AAA'></td><td><input class='quantidade rounded border-0 py-2' type='number' name='quantidade[]' min='1' value='1' onkeyup='mudouvalor()' style='width: 80px'></td><td><input class='valor_unitario bg-dark text-white border-0' type='text' name='valorunitario[]' value='R$ "+preco.toFixed(2).replace('.',',')+"' style='width: 80px' readonly='readonly'></td><td><input class='subtotal bg-dark text-white border-0' type='text' name='subtotal[]' value='R$ "+preco.toFixed(2).replace('.', ',')+"' style='width: 80px' readonly='readonly'></td><td><a id='"+nome+"' class='text-danger' href='javascript:void(0)' onclick='delItem(this)'>[x]</a></td></tr>");
    }

    soma = 0;
    for(i = 0; i < document.getElementsByClassName('items').length; i++) {
        soma += Number(Number(document.getElementsByClassName("valor_unitario")[i].value.split("R$")[1].trim().replace(',','.'))*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value));
    };
    let valor_frete = Number(document.getElementById('valor_frete').value);
    let taxa_cartao = Number(document.getElementById('taxa_cartao').value)/100;
    let desconto = Number(document.getElementById('desconto').value);
    if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('valor_frete').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(valor_frete + taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
    }    
    else if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('valor_frete').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma + valor_frete).toFixed(2).replace('.',',');
    }
    else if((document.getElementById('valor_frete').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(valor_frete + soma - desconto).toFixed(2).replace('.',',');
    } 
    else if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
    }
    else if(document.getElementById('valor_frete').value.length > 0) {
        document.getElementById('total').value = 'Total: R$ '+(valor_frete + soma).toFixed(2).replace('.',',');
    }
    else if(document.getElementById('taxa_cartao').value.length > 0) {
        document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma).toFixed(2).replace('.',',');
    }
    else if(document.getElementById('desconto').value.length > 0) {
        document.getElementById('total').value = 'Total: R$ '+(soma - desconto).toFixed(2).replace('.',',');
    } 
    else {
        document.getElementById('total').value = 'Total: R$ '+soma.toFixed(2).replace('.',',');
    }    
    document.getElementById('falta_pagar').value = "Falta Pagar: R$ "+Number(Number(document.getElementById('total').value.split('R$')[1].trim().replace(',','.')) - Number(document.getElementById('valor_pago').value)).toFixed(2).replace(".",",");  
}

$(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });

function mudouvalor() {
    for(i = 0; i < document.getElementsByClassName('subtotal').length; i++) {
        document.getElementsByClassName('subtotal')[i].value = "R$ " + Number(Number(document.getElementsByClassName("valor_unitario")[i].value.split("R$")[1].trim().replace(',','.'))*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value)).toFixed(2).replace('.',',');
    };
    soma = 0;    
    for(i = 0; i < document.getElementsByClassName('items').length; i++) {
        soma += Number(Number(document.getElementsByClassName("valor_unitario")[i].value.split("R$")[1].trim().replace(',','.'))*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value));
    };
    let valor_frete = Number(document.getElementById('valor_frete').value);
    let taxa_cartao = Number(document.getElementById('taxa_cartao').value)/100;
    let desconto = Number(document.getElementById('desconto').value);
    if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('valor_frete').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(valor_frete + taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
    }    
    else if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('valor_frete').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma + valor_frete).toFixed(2).replace('.',',');
    }
    else if((document.getElementById('valor_frete').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(valor_frete + soma - desconto).toFixed(2).replace('.',',');
    } 
    else if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
        document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
    }
    else if(document.getElementById('valor_frete').value.length > 0) {
        document.getElementById('total').value = 'Total: R$ '+(valor_frete + soma).toFixed(2).replace('.',',');
    }
    else if(document.getElementById('taxa_cartao').value.length > 0) {
        document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma).toFixed(2).replace('.',',');
    }
    else if(document.getElementById('desconto').value.length > 0) {
        document.getElementById('total').value = 'Total: R$ '+(soma - desconto).toFixed(2).replace('.',',');
    } 
    else {
        document.getElementById('total').value = 'Total: R$ '+soma.toFixed(2).replace('.',',');
    }    
    document.getElementById('falta_pagar').value = "Falta Pagar: R$ "+Number(Number(document.getElementById('total').value.split('R$')[1].trim().replace(',','.')) - Number(document.getElementById('valor_pago').value)).toFixed(2).replace(".",",");    
}

function delItem(e) {
    document.getElementById(e.id).remove();
    soma = 0;    
    for(i = 0; i < document.getElementsByClassName('items').length; i++) {
        soma += Number(Number(document.getElementsByClassName("valor_unitario")[i].value.split("R$")[1].trim().replace(',','.'))*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value));
      }; 
      let valor_frete = Number(document.getElementById('valor_frete').value);
      let taxa_cartao = Number(document.getElementById('taxa_cartao').value)/100;
      let desconto = Number(document.getElementById('desconto').value);
      if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('valor_frete').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
          document.getElementById('total').value = 'Total: R$ '+(valor_frete + taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
      }    
      else if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('valor_frete').value.length > 0)) {
          document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma + valor_frete).toFixed(2).replace('.',',');
      }
      else if((document.getElementById('valor_frete').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
          document.getElementById('total').value = 'Total: R$ '+(valor_frete + soma - desconto).toFixed(2).replace('.',',');
      } 
      else if((document.getElementById('taxa_cartao').value.length > 0) && (document.getElementById('desconto').value.length > 0)) {
          document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
      }
      else if(document.getElementById('valor_frete').value.length > 0) {
          document.getElementById('total').value = 'Total: R$ '+(valor_frete + soma).toFixed(2).replace('.',',');
      }
      else if(document.getElementById('taxa_cartao').value.length > 0) {
          document.getElementById('total').value = 'Total: R$ '+(taxa_cartao*soma + soma).toFixed(2).replace('.',',');
      }
      else if(document.getElementById('desconto').value.length > 0) {
          document.getElementById('total').value = 'Total: R$ '+(soma - desconto).toFixed(2).replace('.',',');
      } 
      else {
          document.getElementById('total').value = 'Total: R$ '+soma.toFixed(2).replace('.',',');
      }    
    document.getElementById('falta_pagar').value = "Falta Pagar: R$ "+Number(Number(document.getElementById('total').value.split('R$')[1].trim().replace(',','.')) - Number(document.getElementById('valor_pago').value)).toFixed(2).replace(".",",");   
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
      if(confirm('O usuário '+usuario.name+' será deletado.') === true) {
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

    if((nomecompleto.value.length > 0) && (fone.value.length == 14)) {
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

function addSituacao() {
    let nomesituacao = prompt("Adicionar situação:");
    if(nomesituacao != null) {
        location = 'add.situacao?nome='+nomesituacao;
    }
}

function upSituacao() {
    let nome = document.getElementById('situacao').value.split("|")[0];
    let  id = document.getElementById('situacao').value.split("|")[1];
    if(nome != "" ) {
        let nomesituacao = prompt("Digite a situação que deseja substituir "+nome+'!');
        if(nomesituacao != "") {
            location = 'up.situacao?nome='+nomesituacao+'?id='+id;
        } else {
            alert("Você deve informar um nome tente novamente!");
        }
    } else {
        alert("Você não selecionou nenhuma situação!");
    }     
}

function upCategoria() {
    let nome = document.getElementById('categoria').value.split("|")[0];
    let  id = document.getElementById('categoria').value.split("|")[1];
    if(nome != "" ) {
        let nomecategoria = prompt("Digite a situação que deseja substituir "+nome+'!');
        if(nomecategoria != "") {
            location = 'up.categoria?nome='+nomecategoria+'?id='+id;
        } else {
            alert("Você deve informar um nome tente novamente!");
        }
    } else {
        alert("Você não selecionou nenhuma situação!");
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
    let nome = document.getElementById('categoria').value.split('|')[0];
    let id   = document.getElementById('categoria').value.split('|')[1];
    
    if(nome != "") {
        if(confirm('A categoria '+nome+' será deletada.') == true) {
            location = 'del.categoria?id='+id;
        }
    } else {
        alert("Você não selecionou nenhuma categoria!");
    }        
}

function delSituacao() {
    let id = document.getElementById('situacao').value.split('|')[1];
    let nome = document.getElementById('situacao').value.split('|')[0];
    
    if(nome != "") {
        if(confirm('A situação '+nome+' será deletada.') == true) {
            location = 'del.situacao?id='+id;
        }
    } else {
        alert("Você não selecionou nenhuma situação!");
    }        
}

function delPedido(pedido) {
    if(confirm('O pedido de '+pedido.name+' será deletado.') == true) {
        location = 'del.pedido?id='+pedido.id;
    } 
}

function delProduto(produto) {
    if(confirm('O produto '+produto.name+' será deletado.') == true) {
        location = 'del.produto?id='+produto.id;
    } 
}

function validar_pedido() {
    if(document.getElementById('situacao').value.length != 0) {
        return true;
    } else {
        alert("Selecione uma situação!");
        return false;
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
