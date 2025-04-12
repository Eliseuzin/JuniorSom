async function enviardados(){
  const errordb=document.getElementById("errordb");
  const successdb=document.getElementById("successdb");
  // alert("Dados enviados")
  //acessa o if quando há dados no localstorage para enviar para o banco de dados
  if(localStorage.hasOwnProperty("listaformu")){
    document.getElementById("msg").innerHTML="<p style='color:green'>[Successfully]: Registro encontrado para sincronizar!</p>"
    //recuperar o usuário dp localStorage
    //json.parse=tranfosrmar uma string em um objeto
    const  dadoslocalstorage=JSON.parse(localStorage.getItem("listaformu"));
    // console.log(dadoslocalstorage);
    //usar fetch para fazer requesiçao par aum arquivo/API
    //await para espera o preocessamento
    await fetch('http://127.0.0.1:5500/editar.php',{
      method:"POST",
      body:JSON.stringify(dadoslocalstorage),
      headers:{
        "Content-Type":"application/json"
      }
    }).then((resposta)=>{
      console.log(resposta)
      //ler a mensagem  da resposta arquivo/API, preciso criar uma promise
      resposta.json().then(data=>{
        document.getElementById("msg").innerHTML=data.msg
      });
      //acessa o if quando o arquivo/API retornar sucesso
      if(resposta.status==200){
        localStorage.removeItem("listaformu");
      }else{
      }
    });
  }else{
    document.getElementById("msg").innerHTML="<p style='color:#f00'>[error]:Nenhum registro encontrado para sincronizar!!!</p>"
  }
}

// //other mwthod
// async function enviardados() {
//   const errordb = document.getElementById("errordb");
//   const successdb = document.getElementById("successdb");

//   // Verifica se há dados no localStorage para enviar
//   if (localStorage.hasOwnProperty("listaformu")) {
//     document.getElementById("msg").innerHTML = "<p style='color:green'>[Successfully]: Registro encontrado para sincronizar!</p>";

//     // Recupera os dados do localStorage
//     const dadoslocalstorage = JSON.parse(localStorage.getItem("listaformu"));

//     try {
//       // Realiza a requisição POST utilizando fetch
//       const resposta = await fetch("editar.php", {
//         method: "POST",
//         headers: {
//           "Content-Type": "application/json"
//         },
//         body: JSON.stringify(dadoslocalstorage)
//       });

//       // Verifica se a resposta foi bem-sucedida
//       if (resposta.ok) {
//         const data = await resposta.json();
//         document.getElementById("msg").innerHTML = data.msg;
//         localStorage.removeItem("listaformu");
//       } else {
//         // Lida com erros de resposta
//         const errorData = await resposta.json();
//         document.getElementById("msg").innerHTML = `<p style='color:red'>[Error]: ${errorData.msg}</p>`;
//       }
//     } catch (erro) {
//       // Lida com erros de rede ou outros erros
//       document.getElementById("msg").innerHTML = `<p style='color:red'>[Network Error]: ${erro.message}</p>`;
//     }
//   } else {
//     document.getElementById("msg").innerHTML = "<p style='color:red'>[Error]: Nenhum registro encontrado para sincronizar!</p>";
//   }
// }
