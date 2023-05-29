
function getArticles(){
    fetch("./assets/get_news.php")
    .then((res) => {
        return res.json();
    })
    .then((json) => {
        console.log(json);
        const container = document.querySelector(".articles");
        for(let index in json){
            const article = document.createElement('div');
            article.classList.add('article');

            const url = document.createElement('a');
            url.href = json[index].link;
            article.appendChild(url);

            const title = document.createElement('h4');
            title.innerHTML = json[index].title;
            url.appendChild(title);

            const description = document.createElement('div');
            description.innerHTML = json[index].description;
            url.appendChild(description);

            const image = document.createElement('img');
            image.src = json[index].image;
            url.appendChild(image);

            const date = document.createElement('div');
            date.innerHTML = json[index].date;
            url.appendChild(date);

            

            container.appendChild(article);
        }


    })
}

getArticles();