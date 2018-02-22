var cache = {};
document.addEventListener("DOMContentLoaded", function(){
    var images = document.querySelectorAll(".item-image");

    for (var image of images) {
        // console.log(items[images[i].dataset.item]);
        var dataset = image.dataset;
        var itemId = items[dataset.item].text_id;
        var cacheKey = itemId+"-"+dataset.durability;

        image.classList.add(cacheKey);
        
        if(!cache.hasOwnProperty(cacheKey)){
            var endpoint = "http://api.wurstmineberg.de/v2/minecraft/items";
            
            if(dataset.durability!=0){
                endpoint += "/by-damage/minecraft/"+items[dataset.item].text_id+"/"+dataset.durability+".json";
            }else{
                endpoint += "/by-id/minecraft/"+items[dataset.item].text_id+".json";
            }

            cache[cacheKey] = "Loading...";
            loadItem(cacheKey, endpoint, items[dataset.item].display_name);
        }
    }

    for(var player of document.querySelectorAll(".head-image")){
        player.src = "https://cravatar.eu/helmavatar/" + player.dataset.player + "/32.png";
        player.parentElement.querySelector(".name").innerText = player.dataset.name;
    }

    for(var date of document.querySelectorAll(".date-moment")){
        date.innerHTML = moment(date.innerHTML, "YYYY-MM-DD hh-mm-ss").fromNow();
    }
});

function loadItem(cacheKey, endpoint, displayName){
    fetch(endpoint).then(function(response){
        return response.json();
    }).then(function(json){
        var image = "";
        if(typeof json.image == "string"){
            image = json.image;
        }else{
            image = json.image.prerendered;
        }

        cache[cacheKey] = image;

        for(var item of document.querySelectorAll("."+cacheKey)){
            item.src = "https://assets.wurstmineberg.de/img/grid/"+image;
            item.parentElement.querySelector(".name").innerText = displayName;
        }
    });
}