
const categorySelect = document.getElementById("subcategory-select");
// const productList = document.getElementById("product-list");
const $productList = $("#product-list");

// Add a change event listener to the category selection dropdown
categorySelect.addEventListener("change", function () {
    const selectedCategory = categorySelect.value;
    category_list = ["fresh-produce", "frozen"]
    if (category_list.includes(selectedCategory)){
        fetchAndDisplayProductsFromXml(selectedCategory, "all", "all");
    }
    else{
        fetchAndDisplayProductsFromXml("all", selectedCategory, "all");
    }
});

// Cart functionality
function addToCartAndUpdateInventoryXml(item, q) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    xml_inventory = JSON.parse(localStorage.getItem('xml_inventory'))
    const existingProduct = xml_inventory.find(product => product.id === item.id);
    
    if (existingProduct && existingProduct.quantity - q >= 0) {
        // Decrement the inventory
        existingProduct.quantity -= q;

        const existingItem = cart.find(cartItem => cartItem.id === item.id);
        if (existingItem) {
            // If the item already exists in the cart, increase the quantity
            existingItem.quantity += q;
        } else {
            // If the item doesn't exist in the cart, add it
            cart.push({ ...item, quantity: q });
        }
    }
    else {
        if (existingProduct.quantity){
            alert(`We do not have enough quantity! Only ${existingProduct.quantity} left.`)
        }
        else{
            alert("This item is Out of Stock :(")
        }
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    localStorage.setItem("xml_inventory", JSON.stringify(xml_inventory));
}


function convertXmlToArray(xmlData){
    const items = xmlData.getElementsByTagName('Product');
    const inventory = [];

    for (let i = 0; i < items.length; i++) {
        const item = items[i];
        const id = item.getElementsByTagName('id')[0].textContent;
        const name = item.getElementsByTagName('name')[0].textContent;
        const price = item.getElementsByTagName('price')[0].textContent;
        const quantity = item.getElementsByTagName('quantity')[0].textContent;
        const subCategory = item.getElementsByTagName('sub_category')[0].textContent;
        const imageSrc = item.getElementsByTagName('imageSrc')[0].textContent;
        const category = item.getElementsByTagName('category')[0].textContent;

        inventory.push({
            id: parseInt(id, 10),
            name: name,
            price: parseFloat(price), 
            quantity: parseInt(quantity, 10),
            sub_category: subCategory,
            imageSrc: imageSrc,
            category: category
        });
    }

    return inventory;
}

async function fetchAndDisplayProductsFromXml(category, sub_category, name){
    let xml_inventory = JSON.parse(localStorage.getItem('xml_inventory'))
    if (!xml_inventory){
        await fetch('inventory.xml')
        .then(response => response.text())
        .then(str => (new window.DOMParser()).parseFromString(str, "text/xml"))
        .then(data => {
            xml_inventory = convertXmlToArray(data);
            localStorage.setItem('xml_inventory', JSON.stringify(xml_inventory))
        })
        .catch(error => console.error('Error:', error));
    }

    // productList.innerHTML = "";
    $productList.empty();

    xml_inventory
        .filter(product => (category === "all" || product.category === category) && (sub_category === "all" || product.sub_category === sub_category) && (name === "all" || product.name.toLowerCase().includes(name)))
        .forEach(product => {
        const $productItem = $("<div>").addClass("product");

        // Create elements for name, image, and price
        const $productImage = $("<img>").attr("src", product.imageSrc).attr("alt", product.name);
        const $productName = $("<h3>").text(product.name);
        const $productPrice = $("<p>").text(`Price: $${product.price.toFixed(2)}`);

        $productItem.append($productImage, $productName, $productPrice);

        let $quantityInput;
        if (["candy", "snacks"].includes(product.category)) {
            const $qLabel = $("<p>").text("Enter Quantity: ");
            $quantityInput = $("<input>").attr("type", "number").attr("min", "1").val("1"); // Default quantity

            $productItem.append($qLabel, $quantityInput);
        }

        const $addToCartButton = $("<button>").text("Add to Cart").data("productId", product.id);
        $addToCartButton.on("click", function() {
            const quantity = $quantityInput ? parseInt($quantityInput.val(), 10) : 1;
            addToCartAndUpdateInventoryXml(product, quantity);
        });

        $productItem.append($addToCartButton);
        $productList.append($productItem);
    });
}