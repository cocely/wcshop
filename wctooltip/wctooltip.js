/*
    www.wowcore.com.br
*/
function http_request(url, type, async, data)
{
    var request = new XMLHttpRequest();
    var _data;
    request.onreadystatechange = function()
    {
        if(request.readyState == 4 && request.status == 200)
        {
            _data = request.responseText;
        }
    }
    request.open(type, url, async);
    if(type.toLowerCase() == "post")
    {
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
    }
    else
    {
        request.send();
    }
    return _data;
}
function set_style()
{
    var style = document.createElement("style");
    style.innerHTML = `
        .wctooltip
        {
            display: inline-block;
            position: relative;
            padding: 3px;
            text-decoration: none;
            cursor: pointer;
        }
        .wctooltip > div > img
        {
            vertical-align: middle;
            margin: 0 8px 4px 0;
            background-color: #111111;
            border-radius: 2px;
        }
        .wctooltip-box
        {
            display: none;
            position: fixed;
            font-family: sans-serif;
            font-size: 0.75em;
            line-height: 180%;
            color: #ffffff;
            z-index: 9999;
        }
        .wctooltip-icon
        {
            float: left;
            height: 36px;
            margin: 0 5px 0 0;
            border-radius: 2px;
        }
        .wctooltip-content
        {
            float: left;
            min-width: 200px;
            background-color: #111111;
            padding: 4px 9px;
            border-radius: 2px;
        }
    `;
    document.getElementsByTagName("head")[0].appendChild(style);

    var wctooltip = document.getElementsByTagName("a");
    for(x = 0; x < wctooltip.length; x++)
    {
        if(wctooltip[x].className == "wctooltip")
        {
            wctooltip[x].onmouseenter = function()
            {
                this.onmousemove = function(e)
                {
                    var y = e.pageY + 30 + "px";
                    var x = e.pageX + 15 + "px";
                    this.childNodes[3].style.display = "block";
                    this.childNodes[3].style.top = y;
                    this.childNodes[3].style.left = x;
                }
            }
            wctooltip[x].onmouseout = function(e)
            {
                this.childNodes[3].style.display = "none";
            }
        }
    }
}
function get_weapon_dps(min_dmg, max_dmg, delay)
{
    return parseFloat(((min_dmg + max_dmg) / 2) / delay).toFixed(2);
}
function get_weapon_delay(delay)
{
    return parseFloat((delay/1000)).toFixed(2);
}
function get_dmgtype(dmg_id)
{
    var response = JSON.parse(http_request("wctooltip/json/item_dmgtype.json", "post", false, null));
    return response[dmg_id];
}
function get_stat(stat_id)
{
    var response = JSON.parse(http_request("wctooltip/json/item_stat.json", "post", false, null));
    return response[stat_id];
}
function get_class(class_id)
{
    var response = JSON.parse(http_request("wctooltip/json/item_class.json", "post", false, null));
    return response[class_id];
}
function get_inventorytype(inventory_id)
{
    var response = JSON.parse(http_request("wctooltip/json/item_inventorytype.json", "post", false, null));
    return response[inventory_id];
}
function get_bonding(bonding_id)
{
    var response = JSON.parse(http_request("wctooltip/json/item_bonding.json", "post", false, null));
    return response[bonding_id];
}
function get_quality(quality_id)
{
    var response = JSON.parse(http_request("wctooltip/json/item_quality.json", "post", false, null));
    return response[quality_id];
}
function get_icon(item_id, size, quality)
{
    var response = JSON.parse(http_request("wctooltip/json/item_display.json", "post", false, null));
    var src = "http://wow.zamimg.com/images/wow/icons/" + size + "/" + response[item_id] + ".jpg";
    var data = "<img style='box-shadow:0 0 1px 1px " + quality + "' src='" + src + "'>";
    return data.toLowerCase();
}
function get_item_data(item_id)
{
    var response = JSON.parse(http_request("wctooltip/php/Ajax.php", "post", false, `item_id=${item_id}`));
    return response;
}
window.onload = function()
{
    var anchor = document.getElementsByTagName("a");
    for(i = 0; i < anchor.length; i++)
    {
        if(anchor[i].className == "wctooltip")
        {
            var item_id = anchor[i].getAttribute("data-item");
            var item_data = get_item_data(item_id);
            var item_quality = get_quality(item_data["Quality"]);
            var icon_small = get_icon(item_id, "small", item_quality);
            var icon_medium = get_icon(item_id, "medium", item_quality);
            var item_name = item_data["name"];
            var item_level = item_data["ItemLevel"];
            var item_bonding = get_bonding(item_data["bonding"]);
            var item_containerslots = item_data["ContainerSlots"];
            var item_inventorytype = get_inventorytype(item_data["InventoryType"]);
            var item_class = get_class(item_data["class"] + "-" + item_data["subclass"]);
            var item_dmgtype1 = get_dmgtype(item_data["dmg_type1"]);
            var item_dmgmin1 = item_data["dmg_min1"];
            var item_dmgmax1 = item_data["dmg_max1"];
            var item_delay = get_weapon_delay(item_data["delay"]);
            var item_dps = get_weapon_dps(item_dmgmin1, item_dmgmax1, item_data["delay"]);
            var item_armor = item_data["armor"];
            var item_stats = new Array();
            for(j = 1; j <= 10; j++)
            {
                var type = "stat_type" + j;
                var value = "stat_value" + j;
                var num_type = parseInt(item_data[type]);
                var num_value = parseInt(item_data[value]);

                if(item_data[type] in item_stats)
                    item_stats[num_type] += num_value;
                else
                    item_stats[num_type] = num_value;
            }
            var item_requiredlevel = item_data["RequiredLevel"];
            var item_maxdurability = item_data["MaxDurability"];
            var item_description = item_data["description"];
            var html = ``;
            html += `
            <div style="color:${item_quality};">${icon_small}${item_name}</div>
            <div class="wctooltip-box">
                <div class="wctooltip-icon" style="box-shadow:0 0 1px 1px ${item_quality}">${icon_medium}</div>
                <div class="wctooltip-content" style="box-shadow:0 0 1px 1px ${item_quality}">
                    <div style="color:${item_quality};">${item_name}</div>
                    <div style="color:#ffdd00;">Item Level ${item_level}</div>
                    <div>${item_bonding}</div>
                    <div>
            `;
            var container_inventory = (item_containerslots > 0) ? item_containerslots + " Slots" : item_inventorytype;
            html += `
                    <div style="float:left;">${container_inventory}</div>
                    <div style="float:right;">${item_class}</div>
                    <div style='clear:both'></div>
                </div>
            `;
            if(item_dmgmin1 > 0 || item_dmgmax1 > 0)
            {
                html += `
                    <div>
                        <div style="float:left;">${item_dmgmin1} - ${item_dmgmax1} ${item_dmgtype1} Damage</div>
                        <div style="float:right;">Speed ${item_delay}</div>
                        <div style='clear:both'></div>
                        <div>(${item_dps} damage per second)</div>
                    </div>
                `;
            }
            if(item_armor > 0)
            {
                html += `
                    <div>Armor ${item_armor}</div>
                `;
            }
            for(key in item_stats)
            {
                var value = item_stats[key];
                var type = get_stat(key);
                if(value > 0)
                {
                    if(key < 10)
                        html += `
                            <div>+ ${value} ${type}</div>
                        `;
                    else
                        html += `
                            <div style="color:#00ff00;">${type} ${value}.</div>
                        `;
                }
            }
            if(item_requiredlevel > 0)
            {
                html += `
                    <div>Required Level ${item_requiredlevel}</div>
                `;
            }
            if(item_maxdurability > 0)
            {
                html += `
                    <div>Durability ${item_maxdurability} / ${item_maxdurability}</div>
                `;
            }
            if(item_description)
            {
                html += `
                    <div style="color:#ffdd00;">"${item_description}"</div>
                `;
            }
            html += `
            </div>
            </div>
            `;
            anchor[i].innerHTML = html;
        }
    }
    set_style();
};
