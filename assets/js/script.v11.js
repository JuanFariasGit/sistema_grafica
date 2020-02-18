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
    let valor_frete = (document.getElementById('valor_frete').value.length > 0) ? Number(document.getElementById('valor_frete').value) : 0;
    let valor_arte = (document.getElementById('valor_arte').value.length > 0) ? Number(document.getElementById('valor_arte').value) : 0;
    let valor_outros = (document.getElementById('valor_outros').value.length > 0) ? Number(document.getElementById('valor_outros').value) : 0;
    let taxa_cartao = (document.getElementById('taxa_cartao').value.length > 0) ? Number(document.getElementById('taxa_cartao').value)/100 : 0;
    let desconto = (document.getElementById('desconto').value.length > 0) ? Number(document.getElementById('desconto').value) : 0;
    
    document.getElementById('total').value = 'Total: R$ '+(valor_frete + valor_arte + valor_outros + taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
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
    let valor_frete = (document.getElementById('valor_frete').value.length > 0) ? Number(document.getElementById('valor_frete').value) : 0;
    let valor_arte = (document.getElementById('valor_arte').value.length > 0) ? Number(document.getElementById('valor_arte').value) : 0;
    let valor_outros = (document.getElementById('valor_outros').value.length > 0) ? Number(document.getElementById('valor_outros').value) : 0;
    let taxa_cartao = (document.getElementById('taxa_cartao').value.length > 0) ? Number(document.getElementById('taxa_cartao').value)/100 : 0;
    let desconto = (document.getElementById('desconto').value.length > 0) ? Number(document.getElementById('desconto').value) : 0;
    
    document.getElementById('total').value = 'Total: R$ '+(valor_frete + valor_arte + valor_outros + taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
    document.getElementById('falta_pagar').value = "Falta Pagar: R$ "+Number(Number(document.getElementById('total').value.split('R$')[1].trim().replace(',','.')) - Number(document.getElementById('valor_pago').value)).toFixed(2).replace(".",",");
}

function delItem(e) {
    document.getElementById(e.id).remove();
    soma = 0;    
    for(i = 0; i < document.getElementsByClassName('items').length; i++) {
        soma += Number(Number(document.getElementsByClassName("valor_unitario")[i].value.split("R$")[1].trim().replace(',','.'))*Number(document.getElementsByClassName('quantidade')[i].value)*Number(document.getElementsByClassName('al')[i].value)*Number(document.getElementsByClassName('la')[i].value));
      }; 
      let valor_frete = (document.getElementById('valor_frete').value.length > 0) ? Number(document.getElementById('valor_frete').value) : 0;
      let valor_arte = (document.getElementById('valor_arte').value.length > 0) ? Number(document.getElementById('valor_arte').value) : 0;
      let valor_outros = (document.getElementById('valor_outros').value.length > 0) ? Number(document.getElementById('valor_outros').value) : 0;
      let taxa_cartao = (document.getElementById('taxa_cartao').value.length > 0) ? Number(document.getElementById('taxa_cartao').value)/100 : 0;
      let desconto = (document.getElementById('desconto').value.length > 0) ? Number(document.getElementById('desconto').value) : 0;
      
      document.getElementById('total').value = 'Total: R$ '+(valor_frete + valor_arte + valor_outros + taxa_cartao*soma + soma - desconto).toFixed(2).replace('.',',');
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
        let id_usuario = usuario.id;
        let nome_usuario_logado = document.querySelector(".usuariologado").innerHTML;
        let option = 3;

        $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{id_usuario:id_usuario, option:option},
            success: function() {
                if(usuario.name = nome_usuario_logado) {
                    location.reload();
                } else {
                    $("#"+id_usuario).remove();
                }
            }
        })    
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

function delCliente(cliente) {
    if(confirm('O cliente '+cliente.name+' será deletado.') == true) {
        let id_cliente = cliente.id;
        let option = 4;

        $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{id_cliente:id_cliente, option:option},
            success: function() {
                $("#"+id_cliente).remove();
            }
        })
    }    
}

function addCategoria() {
    let nomecategoria = prompt("Adicionar categoria:");
    if((nomecategoria != "") && (nomecategoria != null)) {
        let option = 11;

        $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{add_nome_categoria:nomecategoria, option:option},
            success: function() {
                location.reload();
            }
       });
    }
}

function addSituacao() {
    let nomesituacao = prompt("Adicionar situação:");
    if((nomesituacao != "") && (nomesituacao != null)) {        
       let option = 8;

       $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{add_nome_situacao:nomesituacao, option:option},
            success: function() {
                location.reload();
            }
       })
    }
}

function upSituacao() {
    let nome = document.getElementById('situacao').value.split("|")[0];
    let  id = document.getElementById('situacao').value.split("|")[1];    
    let option = 9;

    if(nome != "") {
        if(nome != "Concluído") {
        const nomesituacao = prompt("Digite a situação que deseja substituir "+nome+'!');
            if(nomesituacao != "") {
                if(nomesituacao != null) {           
                    $.ajax ({
                        type:'POST',
                        url:'http://localhost/sistema_grafica/ajax',
                        data:{up_id_situacao:id, up_nome_situacao:nomesituacao, option:option},
                        success: function() {
                            location.reload();
                        }
                    })
                }
            } else {
                alert("Você deve informa um nome tente novamente!");
            }
        } else {
            alert("Concluído é uma categoria padrão não pôde ser alterada!");
        } 
    } else {
        alert("Você não selecionou nenhuma situação!");
    }
}

function upCategoria() {
    const nome = document.getElementById('categoria').value.split("|")[0];
    const  id = document.getElementById('categoria').value.split("|")[1];
    const option = 12;

    if(nome != "") {
        const nomecategoria = prompt("Digite a situação que deseja substituir "+nome+'!');
        if(nomecategoria != "") {
            if(nomecategoria != null) {           
                $.ajax ({
                    type:'POST',
                    url:'http://localhost/sistema_grafica/ajax',
                    data:{up_id_categoria:id, up_nome_categoria:nomecategoria, option:option},
                    success: function() {
                        location.reload();
                    }
                })
            }
        } else {
            alert("Você deve informa um nome tente novamente");
        }
    } else {
        alert("Você não selecionou nenhuma categoria");
    }
}

function delCategoria() {
    let nome = document.getElementById('categoria').value.split('|')[0];
    let id   = document.getElementById('categoria').value.split('|')[1];
    let option = 13;
    
    if(nome != "") {
        if(confirm('A categoria '+nome+' será deletada.') == true) {
            $.ajax ({
                type:'POST',
                url:'http://localhost/sistema_grafica/ajax',
                data:{del_id_categoria:id, option:option},
                success: function() {
                    location.reload();
                }
            })
        }
    } else {
        alert("Você não selecionou nenhuma categoria!");
    }        
}

function delSituacao() {
    let id = document.getElementById('situacao').value.split('|')[1];
    let nome = document.getElementById('situacao').value.split('|')[0];
    let option = 10;
    
    if(nome != "") {
        if(nome != "Concluído") {
            if(confirm('A situação '+nome+' será deletada.') == true && nome != "Concluído") {
                $.ajax ({
                    type:'POST',
                    url:'http://localhost/sistema_grafica/ajax',
                    data:{del_id_situacao:id, option:option},
                    success: function() {
                        location.reload();
                    }
                })
            } 
        } else {
            alert("Concluído é uma situação padrão não pôde ser deletada!");
        }
    } else {
        alert("Você não selecionou nenhuma situação!");
    }       
}

function delPedido(pedido) {
    if(confirm('O pedido de ID '+pedido.id+' do usuário '+pedido.name+' será deletado.') == true) {
        let id_pedido = pedido.id;
        let option = 6;

        $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{id_pedido:id_pedido, option:option},
            success: function() {
                $("#"+id_pedido).remove();
            }
        })    
    } 
}

function delProduto(produto) {
    if(confirm('O produto '+produto.name+' será deletado.') == true) {
        let id_produto = produto.id;
        let option = 5;

        $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{id_produto:id_produto, option:option},
            success: function() {
                $("#"+id_produto).remove();
            }
        })    
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

function mascara_data(form, fieldName, evento)
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
    
    let data = '';
    data = data + form.value;

    if (data.length == 2) {
        data = data + '/';
        fieldName.value = data;
    }
    if (data.length == 5) {
        data = data + '/';
        fieldName.value = data;
    }
}

$('[name=situacao_ajax]').change(function() {
    const nome_situacao = this.value.split("|")[2];
    const id_pedido = this.value.split("|")[1];
    const id_situacao = this.value.split("|")[0];
    const url = location.href;
    const option = 1;

    $.ajax({
        type:'POST',
        url:'http://localhost/sistema_grafica/ajax',
        data:{id_pedido:id_pedido, id_situacao:id_situacao, option:option},
        success: function() {
            if(nome_situacao == "Concluído") {
                $('#'+id_pedido).remove();
            } 
            else if(url != "http://localhost/sistema_grafica/pedido") {
                location.href = "http://localhost/sistema_grafica/pedido";
            }         
        }
    });
});

$('.pedido_visualizar').click(function() {
    const id_pedido = this.id;
    const option = 2;
    
    $.ajax({
        type:'POST',
        url:'http://localhost/sistema_grafica/ajax',
        data:{id_pedido:id_pedido, option:option},
        success: function(produtos) {
            Swal.fire({ 
               title: "PEDIDO " + id_pedido, 
               html: produtos,
               width: 850,
               confirmButtonText: "FECHAR", 
              }); 
        }
    });
});

function delHistorico(historico) {
    if(confirm('O historico de '+historico.name+' de ID '+historico.id+' será deletado') == true) {

        let id_historico = historico.id;
        let option = 7;

        $.ajax ({
            type:'POST',
            url:'http://localhost/sistema_grafica/ajax',
            data:{id_historico:id_historico, option:option},
            success: function() {
               $("#"+id_historico).remove();
            }
        })
    }    
}

$('[name="categoria"]').change(function() {
    const id_categoria = this.value.split("|")[1];
    const id_produto = this.value.split("|")[2];
    const option = 14;

    $.ajax({
        type:'POST',
        url:'http://localhost/sistema_grafica/ajax',
        data:{id_produto:id_produto, id_categoria:id_categoria, option:option}
    });
});

$('[name="buscarUsuario"]').keyup(function(){
    let usuario = $(this).val();
    let option = 15;
    
    $.ajax ({
        type:'POST',
        url:'http://localhost/sistema_grafica/ajax',
        data:{buscarUsuario:usuario, option:option},
        success: function(retorno) {
            $("#listausuario").html(retorno);
        }
    })
})