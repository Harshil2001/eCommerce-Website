
const categorySelect = document.getElementById("subcategory-select");
const $productList = $("#product-list");


// Add a change event listener to the category selection dropdown
categorySelect.addEventListener("change", function () {
    const selectedCategory = categorySelect.value;
    category_list = ["breakfast-cereal", "baking", "pantry"]
    if (category_list.includes(selectedCategory)){
        fetchAndDisplayProductsFromJson(selectedCategory, "all", "all");
    }
    else{
        fetchAndDisplayProductsFromJson("all", selectedCategory, "all");
    }
});

// Cart functionality
function addToCartAndUpdateInventoryJson(item) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    json_inventory = JSON.parse(localStorage.getItem('json_inventory'))
    const existingProduct = json_inventory.find(product => product.id === item.id);
    
    if (existingProduct && existingProduct.quantity > 0) {
        // Decrement the inventory
        existingProduct.quantity--;

        const existingItem = cart.find(cartItem => cartItem.id === item.id);
        if (existingItem) {
            // If the item already exists in the cart, increase the quantity
            existingItem.quantity++;
        } else {
            // If the item doesn't exist in the cart, add it
            cart.push({ ...item, quantity: 1 });
        }
    }
    else {
        alert("This item is Out of Stock :(")
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    localStorage.setItem("json_inventory", JSON.stringify(json_inventory));
}


async function fetchAndDisplayProductsFromJson(category, sub_category, name){
    let json_inventory = JSON.parse(localStorage.getItem('json_inventory'))
    if (!json_inventory){
        await fetch('inventory.json')
        .then(response => response.json())
        .then(data => {
            json_inventory = data;
            localStorage.setItem('json_inventory', JSON.stringify(json_inventory))
        })
        .catch(error => console.error('Error:', error));
    }

    $productList.empty();

    json_inventory
        .filter(product => (category === "all" || product.category === category) && (sub_category === "all" || product.sub_category === sub_category) && (name === "all" || product.name.toLowerCase().includes(name)))
        .forEach(product => {
            const $productItem = $("<div>").addClass("product");

            // Create elements for name, image, and price
            const $productImage = $("<img>").attr("src", product.imageSrc).attr("alt", product.name);
            const $productName = $("<h3>").text(product.name);
            const $productPrice = $("<p>").text(`Price: $${product.price.toFixed(2)}`);

            $productItem.append($productImage, $productName, $productPrice);
        

            const $addToCartButton = $("<button>").text("Add to Cart").data("productId", product.id);
            $addToCartButton.on("click", function() {
                addToCartAndUpdateInventoryJson(product);
            });
    
            $productItem.append($addToCartButton);
            $productList.append($productItem);
        });
}