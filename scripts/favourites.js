

function fetchGames(){
    fetch("./assets/fetch_games.php")
    .then ((res) => {
        return res.json();
    })
    .then((json) => {
        console.log(json);
        if(!json.length) {
            noResults();
            return;
        }

        const container = document.querySelector(".cards");
        container.innerHTML = '';

        for(let game in json){
            const card = document.createElement("div");
            card.classList.add('card');

            card.dataset.id = json[game].content.id;

            const image = document.createElement("img");
            image.classList.add('image');
            image.src = json[game].content.image;
            card.appendChild(image);

            const info_box = document.createElement("div");
            info_box.classList.add('info');
            card.appendChild(info_box);

            const name = document.createElement("div");
            name.classList.add('name');
            name.innerText = json[game].content.name;
            info_box.appendChild(name);

            const score = document.createElement("div");
            score.classList.add("score");
            score.innerText = json[game].content.score;
            info_box.appendChild(score);

            if(score.innerText >= 80) score.classList.add('high_score');
            else if(score.innerText < 80 && score.innerText >= 40) score.classList.add('mid_score');
            else score.classList.add('low_score');


            container.appendChild(card);
        }
    });
}

function noResults() {
    // Definisce il comportamento nel caso in cui non ci siano contenuti da mostrare
    const container = document.querySelector(".cards");
    container.innerHTML = '';
    const nores = document.createElement('div');
    nores.className = "nores";
    nores.textContent = "Nessun risultato.";
    container.appendChild(nores);
}

fetchGames();

