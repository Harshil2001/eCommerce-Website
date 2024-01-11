// code to populate the cart
function displayCart(){
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartItemsElement = document.getElementById("cart-items");
    cartItemsElement.innerHTML = "";
    var total_price = 0

    cart.forEach(item => {
        const cartItem = document.createElement("li");
        cartItem.textContent = `${item.name} - Price: $${item.price.toFixed(2)} - Quantity: ${item.quantity}`;
        total_price += parseFloat(item.price.toFixed(2) * item.quantity)
        cartItemsElement.appendChild(cartItem);
    });

    const cartItem = document.createElement("li");
    cartItem.textContent = `Cart Total - Price: $${total_price.toFixed(2)}`;
    cartItemsElement.appendChild(cartItem)
}

function arrayToXml(array){
    if (!array){
        return null;
    }

    let xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
    xml += '<inventory>'

    array.forEach(item => {
        xml += '<Product>'
        for (let key in item){
            xml += `<${key}>${item[key]}</${key}>`;
        }
        xml += '</Product>'
    });

    xml += '</inventory>'
    return xml
}

async function purchaseOrder(){ 
    const json_string = localStorage.getItem("json_inventory");
    const xml_inventory = JSON.parse(localStorage.getItem("xml_inventory"));
    const xml_string = arrayToXml(xml_inventory)

    if (json_string){
        await fetch('update_json.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: json_string
        })
        .then(response => response.json())
        .then(data => console.log('JSON inventory updated:', data))
        .catch(error => console.error('Error:', error));

    }

    if (xml_string){
        await fetch('update_xml.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/xml',
            },
            body: xml_string
        })
        .then(response => response.json())
        .then(data => console.log('XML inventory updated:', data))
        .catch(error => console.error('Error:', error));
    }

    localStorage.removeItem("json_inventory");
    localStorage.removeItem("xml_inventory");
    localStorage.removeItem("cart");
    displayCart()
}