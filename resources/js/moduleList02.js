$(document).ready(function(){
    //alert("JS LOADED");

    //getNews();
});

function getNews(){
    $.getJSON('https://newsapi.org/v2/top-headlines?country=id&pageSize=100&apiKey=e9995dac5f594ce28bede25ee190eb12', function(data) {
        //console.log(data);
        let articles = data.articles;

        for(let article of articles)
        {
            let author = article.author;
            let content = article.content;
            let description = article.description;
            let publishedAt = article.publishedAt;
            let source = article.source;
                let sourceId = source.id;
                let sourceName = source.name;
            let title = article.title;
            let url = article.url;
            let urlToImage = article.urlToImage;

            $("#articles").append("<article>");
                $("#articles").append("<h6>"+title+"</h6>");
                $("#articles").append("<p>"+description+"</p>");
                //$("#articles").append("<p>"+content+"</p>");
            $("#articles").append("</article>");
        }


    });
}
