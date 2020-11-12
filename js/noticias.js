 function obtenerDatos(num){

    var url =  `https://newsapi.org/v2/top-headlines?country=us&category=general&apikey=cebd0330d8dd41208bcf09710d677bb6`;
    const request = new XMLHttpRequest();
    request.open('GET',url, true);
    request.send();
    request.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
           let datos = JSON.parse(this.responseText);
      //    console.log(datos.articles[num].title); // muestra en consola
 let noticias = datos.articles;
 noticias.map(noticia=>{
  const{urlToImage,url,title,description,source} = noticia;

});
           $("#txttitle").val(datos.articles[num].title);
           $("#txtcity").val(datos.articles[1].title);
           $("#txtdes").val(datos.actividades[0].descripcion);
           // console.log(datos.articles[num].title);


    }
}

}
