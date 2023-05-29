
function saveGame(event){

    event.stopPropagation();
    console.log("Salvataggio");
    const heart = event.currentTarget.querySelector("div");
    heart.classList.remove("save");
    heart.classList.add("saved");
    
    const card = event.currentTarget.parentNode;
    const form_data = new FormData();
    form_data.append('id', card.querySelector('.id').innerText);
    form_data.append('name', card.querySelector('.name').innerText);
    form_data.append('score', card.querySelector('.score').innerText);
    form_data.append('image', card.querySelector('.image').src);
    console.log(form_data.keys());
    fetch("./assets/save_games.php", {method: 'POST', body: form_data}).then(dispatchResponse);
    event.currentTarget.removeEventListener("click",saveGame);
}

function sleep(ms){
    return new Promise((resolve => setTimeout(resolve, 250 * ms) ));
}


async function onJsonResponse(json){
    console.log(json);
    for(let game in json){
        
        var id = json[game].id;
        
        console.log(id);
        fetch("./assets/get_game_info.php?q=" + encodeURIComponent(id))
        .then((res) => {
            return res.json();
        })
        .then((game_json) => {

            console.log(game_json);
            const container = document.querySelector(".cards");
            const box = document.createElement('div');
            box.classList.add('card');

            const image = document.createElement('img');
            image.classList.add('image');

            if (game_json.images.banner.og !== 'undefined') {
                image.src = "https://img.opencritic.com/"+ encodeURIComponent(game_json.images.banner.og);
                }
            else if  (game_json.images.box.og !== 'undefined') { 
                image.src = "https://img.opencritic.com/"+ encodeURIComponent(game_json.images.box.og);
            }
            else image.src = "../assets/missing.jpg";

            box.appendChild(image);

            const id = document.createElement('div');
            id.classList.add('id');
            id.innerText = game_json.id;
            box.appendChild(id);

            const info_box = document.createElement('div');
            info_box.classList.add('info');
            box.appendChild(info_box);

            const name = document.createElement('div');
            name.classList.add("name");
            name.innerText = game_json.name;
            info_box.appendChild(name);

            const score = document.createElement('div');
            score.classList.add('score');
            if(game_json.topCriticScore !== -1) score.innerText = Math.round((game_json.topCriticScore + Number.EPSILON) * 100) / 100;
            else score.innerText = 'x';

            info_box.appendChild(score);

            if(score.innerText >= 80) score.classList.add('high_score');
            else if(score.innerText < 80 && score.innerText >= 40) score.classList.add('mid_score');
            else score.classList.add('low_score');

            const saveForm = document.createElement('div');
            saveForm.classList.add("saveForm");
            box.appendChild(saveForm);
            const save = document.createElement('div');
            save.value='';
            save.classList.add("save");
            saveForm.appendChild(save);
            saveForm.addEventListener('click',saveGame);


            container.appendChild(box);
        });

        await sleep(game);
        
    }
}

function onResponse(response){
    console.log(response);
    return response.json();
}

function search(event){

    event.preventDefault();
    
    const cards = document.querySelector(".cards");
    cards.innerHTML = '';

    const form_data = new FormData(document.querySelector("#search_container form"));

    fetch("./assets/search_content.php?q="+encodeURIComponent(form_data.get('search'))).then(onResponse).then(onJsonResponse)
}

function dispatchResponse(response) {

    console.log(response);
    return response.json().then(databaseResponse); 
}
  
function dispatchError(error) { 
    console.log("Errore");
}
  
function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        return null;
    }
    console.log("Inserito!");
}

document.querySelector("#search_container form").addEventListener("submit", search);