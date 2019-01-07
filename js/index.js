window.mobileAndTabletcheck = function() {
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};
window.inMobile = window.mobileAndTabletcheck();

var tooltip = document.getElementById("minetip-tooltip");
function handleTooltip(e){
    tooltip.style.left = ((window.inMobile ? e.screenX : e.clientX)+5)+"px";
    tooltip.style.top = ((window.inMobile ? e.screenY : e.clientY)+5)+"px";
}

function find_image(namespace, durability = 0){
    var rs = items_map[namespace];
    if(rs){
        if(rs.hasOwnProperty("reference")){
            var kv = rs.reference.split(":");
            return find_image(kv[0], kv.length>1 ? kv[1] : 0);
        }else{
            if(rs[durability]){
                return {
                    icon: rs.id+"-"+durability,
                    data: rs[durability],
                    max_durability: rs.hasOwnProperty("max_durability") ? rs["max_durability"] : null
                };
            }else{
                return find_image(namespace, 0);
            }
        }
    }else{
        console.log("invalid")
    }
}

document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".colorize").forEach((element)=>{
        var text = element.innerText;
        parse_color(text, element);
    });

    document.querySelectorAll(".bukkit2name").forEach((element)=>{
        element.innerText = find_image(element.innerText).data.name;
    });

    {
        var details_lore = document.querySelector(".details > .lore");
        var item = document.querySelector(".inv-sprite");

        if(details_lore!=null){
            if(item.dataset.lore>0){
                for (let i = 0; i < item.dataset.lore; i++) {
                    var line = document.createElement("SPAN");
                    parse_color(item.dataset["lore-"+i], line);
                    details_lore.append(line);
                }
            }else{
                var line = document.createElement("SPAN");
                line.innerText = "No lore";
                details_lore.append(line);
            }
        }
    }

    for(var date of document.querySelectorAll(".date-moment")){
        date.innerHTML = moment(date.innerHTML, "YYYY-MM-DD hh-mm-ss").fromNow();
    }

    var invslots = document.querySelectorAll(".invslot");
    invslots.forEach((element)=>{
        var sprite = element.querySelector(".inv-sprite");
        var data = find_image(sprite.dataset.bukkit, sprite.dataset.durability);

        if(data.max_durability!=null && sprite.dataset.durability!=0){
            var bar = document.createElement("SPAN");
            var durability = document.createElement("SPAN");
            durability.append(sprite.firstChild);
            durability.classList.add("durability");
            var display = parseInt(sprite.dataset.durability)/data.max_durability;
            durability.style.backgroundColor = "rgb("+(display*255)+", "+(255-display*255)+", 0)";
            durability.style.width = (display*100)+"%";
            bar.classList.add("durability-bar");
            bar.append(durability);
            sprite.append(bar);
        }else if(sprite.dataset.amount>1){
            var amount = document.createElement("SPAN");
            amount.classList.add("amount");
            amount.innerText = sprite.dataset.amount;
            sprite.firstChild.remove();
            sprite.append(amount);
        }

        if(sprite.dataset.head!=""){
            sprite.style.backgroundImage = "url('"+sprite.dataset.head+"')";
            sprite.classList.add("image-skull");
        }else{
            sprite.style.backgroundImage = "url('items/images/"+data.icon+".png')";
        }


        if(sprite.dataset.name==""){
            sprite.dataset.name = data.data.name
        }
    });
});

function hideTooltip(e){
    tooltip.style.display = "none";
}

function showTooltip(e){
    tooltip.style.display = "inline";

    var string = e.target.querySelector(".inv-sprite").dataset.name;
    var lore_el = tooltip.querySelector(".lore");

    var price = tooltip.querySelector(".price");
    if(price){
        price.innerText = e.target.querySelector(".inv-sprite").dataset.total;
    }

    var seller = tooltip.querySelector(".seller");
    if(seller){
        seller.innerText = e.target.querySelector(".inv-sprite").dataset.seller;
    }

    parse_color(string, tooltip.querySelector(".name"));
    while(lore_el.firstChild){
        lore_el.removeChild(lore_el.firstChild);
    }
    var lore_count = parseInt(e.target.querySelector(".inv-sprite").dataset.lore);
    if(lore_count>0){
        for (let i = 0; i < lore_count; i++) {
            var line = document.createElement("SPAN");
            parse_color(e.target.querySelector(".inv-sprite").dataset["lore-"+i], line);
            lore_el.append(line);
        }
        // tooltip.querySelector(".lore").innerText = e.target.querySelector(".inv-sprite").dataset.lore;
    }
}

function parse_color(string = "", element){
    while(element.firstChild){
        element.removeChild(element.firstChild);
    }

    var current = document.createElement("SPAN");
    current.classList.add("color-f");
    
    for (let i = 0; i < string.length; i++) {
        var char = string.charAt(i);
        if(char=="§" && i<string.length-1){
            var code = string.charAt(i+1);
            if(code.match("[a-f,0-9,k-o,r]")==null){
                current.innerText += char;
                continue;
            }
            i++;

            // final_string += "<b>";
            if(code=="r"){
                element.append(current);
                current = document.createElement("SPAN");
                current.classList.add("color-f");
            }else if(current.innerText.length==0 && code.match("[k-o]")!=null){
                current.classList.add("color-"+code)
            }else{
                element.append(current);
                current = document.createElement("SPAN");
                current.classList.add("color-"+code);
            }

            // element.append(current);
        }else{
            current.innerText += char;
        }
    }

    element.append(current);

    // return final_string;
}