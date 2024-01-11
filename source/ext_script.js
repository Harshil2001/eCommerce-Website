const products =[
    {id: 1, name: 'Apples', price: 1.99, quantity: 5, sub_category: 'fruit', imageSrc:'images/apples.jpeg', category: 'fresh-produce'},
    {id: 2, name: 'Bananas', price: 0.99, quantity: 8, sub_category: 'fruit', imageSrc:'images/banana.jpeg', category: 'fresh-produce'},
    {id: 3, name: 'Oranges', price: 2.99, quantity: 5, sub_category: 'fruit', imageSrc:'images/orange.jpeg', category: 'fresh-produce'},
    {id: 4, name: 'Lettuce', price: 1.99, quantity: 5, sub_category: 'vegetable', imageSrc:'images/lettuce.jpeg', category: 'fresh-produce'},
    {id: 5, name: 'Tomatoes', price: 1.99, quantity: 5, sub_category: 'vegetable', imageSrc:'images/tomato.jpeg ', category: 'fresh-produce'},
    {id: 6, name: 'Onions', price: 1.99, quantity: 5, sub_category: 'vegetable', imageSrc:'images/onions.jpeg', category: 'fresh-produce'},
    {id: 10, name: 'Fruit Bowl', price: 3.99, quantity: 5, sub_category: 'pre-cut', imageSrc:'images/fruitbowl.jpeg', category: 'fresh-produce'},
    {id: 11, name: 'Red rose', price: 1.99, quantity: 5, sub_category: 'flower', imageSrc:'images/flowers.jpeg', category: 'fresh-produce'},
    {id: 12, name: 'salsa', price: 1.99, quantity: 5, sub_category: 'salsa', imageSrc:'images/salsa.jpeg', category: 'fresh-produce'},
    {id: 13, name: 'Fresh carrots', price: 1.99, quantity: 5, sub_category: 'new-item', imageSrc:'images/carrots.jpeg', category: 'fresh-produce'},
    {id: 7, name: 'Ice Cream', price: 1.99, quantity: 5, sub_category: 'frozen-dessert', imageSrc:'images/ice cream.jpeg', category: 'frozen'},
    {id: 14, name: 'frozen muffin', price: 1.99, quantity: 5, sub_category: 'frozen-bf', imageSrc:'images/frozen muffin.jpeg', category: 'frozen'},
    {id: 15, name: 'frozen steak', price: 1.99, quantity: 5, sub_category: 'frozen-meal', imageSrc:'images/frozen steak.jpeg', category: 'frozen'},
    {id: 16, name: 'pizza', price: 1.99, quantity: 5, sub_category: 'frozen-pizza', imageSrc:'images/pizza.jpeg', category: 'frozen'},
    {id: 17, name: 'meat', price: 1.99, quantity: 5, sub_category: 'frozen-meat', imageSrc:'images/meat.jpeg', category: 'frozen'},
    {id: 18, name: 'pizza rolls', price: 1.99, quantity: 5, sub_category: 'frozen-snacks', imageSrc:'images/pizza rolls.jpeg', category: 'frozen'},
    {id: 8, name: 'Bounty', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/bounty.jpeg', category: 'candy'},
    {id: 9, name: 'Snickers', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/Snickers.jpeg', category: 'candy'},
    {id: 19, name: 'Mayo mustard', price: 1.99, quantity: 5, sub_category: 'condiments', imageSrc:'images/mayomustard.jpeg', category: 'pantry'},
    {id: 20, name: 'Peas', price: 1.99, quantity: 5, sub_category: 'canned-goods', imageSrc:'images/canned-peas.jpeg', category: 'pantry'},
    {id: 21, name: 'Beans', price: 1.99, quantity: 5, sub_category: 'canned-vegetable', imageSrc:'images/canned-beans.jpeg', category: 'pantry'},
    {id: 22, name: 'Peanut butter spread', price: 1.99, quantity: 5, sub_category: 'butter-spread', imageSrc:'images/butter spread.jpeg', category: 'pantry'},
    {id: 23, name: 'Pasta', price: 1.99, quantity: 5, sub_category: 'pasta-pizza', imageSrc:'images/pasta.jpeg', category: 'pantry'},
    {id: 24, name: 'Ranch', price: 1.99, quantity: 5, sub_category: 'rollbacks', imageSrc:'images/ranch.jpeg', category: 'pantry'},
    {id: 25, name: 'Raisin Bran', price: 1.99, quantity: 5, sub_category: 'cereals', imageSrc:'images/raisin bran.jpeg', category: 'breakfast-cereal'},
    {id: 26, name: 'Chocolate Pancake', price: 1.99, quantity: 5, sub_category: 'pancakes', imageSrc:'images/choco pancake.jpeg', category: 'breakfast-cereal'},
    {id: 27, name: 'Baked breakfast bread', price: 1.99, quantity: 5, sub_category: 'breads', imageSrc:'images/baked bf bread.jpeg', category: 'breakfast-cereal'},
    {id: 28, name: 'Oatmeal', price: 1.99, quantity: 5, sub_category: 'oatmeal', imageSrc:'images/oatmeal.jpeg', category: 'breakfast-cereal'},
    {id: 29, name: 'White bread', price: 1.99, quantity: 5, sub_category: 'bf-rollback', imageSrc:'images/white bread.jpeg', category: 'breakfast-cereal'},
    {id: 30, name: 'Apple filling', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/apple filling.jpeg', category: 'baking'},
    {id: 31, name: 'Pie Crust', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/pie crust.jpeg', category: 'baking'},
    {id: 32, name: 'Chocolate pudding mix', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/choco pudding.jpeg', category: 'baking'},
    {id: 33, name: 'Pie Pans', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/pie pans.jpeg', category: 'baking'},
    {id: 34, name: 'Rind Chips', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/rind.jpeg', category: 'snacks'},
    {id: 35, name: 'Little Bites', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/little bites.jpeg', category: 'snacks'},
    {id: 35, name: 'Bold Chips', price: 1.99, quantity: 5, sub_category: '', imageSrc:'images/chips.jpeg', category: 'snacks'},
];

// pie fillings, crusts, pudding mixes and pie pans

const categorySelect = document.getElementById("subcategory-select");
const productList = document.getElementById("product-list");

function populateProductList(category, sub_category, prod_name) {
    // Clear the product list
    productList.innerHTML = "";

    products
        .filter(product => (category === "all" || product.category === category) && (sub_category === "all" || product.sub_category === sub_category) && (prod_name === "all" || product.name.toLowerCase().includes(prod_name)))
        .forEach(product => {
            const productItem = document.createElement("div");
            productItem.classList.add("product");

            // Create elements for name, image, and price
            const productImage = document.createElement("img");
            productImage.src = product.imageSrc;
            productImage.alt = product.name;
        
            const productName = document.createElement("h3");
            productName.textContent = product.name;
        
            const productPrice = document.createElement("p");
            productPrice.textContent = `Price: $${product.price.toFixed(2)}`;
        
            const addToCartButton = document.createElement("button");
            addToCartButton.textContent = "Add to Cart";
            addToCartButton.dataset.productId = product.id;

            addToCartButton.addEventListener("click", function(){
                addToCartAndUpdateInventory(product)
            });

            productItem.appendChild(productImage)
            productItem.appendChild(productName)
            productItem.appendChild(productPrice)
            productItem.appendChild(addToCartButton)

            productList.appendChild(productItem);
        });
}

categorySelect.addEventListener("change", function() {
    const selectedCategory = categorySelect.value;
    category_list = ["fresh-produce", "frozen", "pantry", "breakfast-cereal", "candy", "snacks"];
    if (category_list.includes(selectedCategory)) {
        populateProductList(selectedCategory, "all", "all");
    }
    else {
        populateProductList("all", selectedCategory, "all");
    }
});

function addToCartAndUpdateInventory(item) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existingProduct = products.find(product => product.id == item.id);

    if (existingProduct.quantity > 0) {
        existingProduct.quantity--;
        
        const existingItem = cart.find(cartItem => cartItem.id == item.id);
        if (existingItem) {
            existingItem.quantity++;
        }
        else {
            cart.push({ ...item, quantity: 1});
        }
    }
    else {
        alert("This item is out of stock");
    }
    localStorage.setItem("cart", JSON.stringify(cart));
}

// function displayCart() {
//     console.log(JSON.parse(localStorage.getItem("cart")))
//     const cart = JSON.parse(localStorage.getItem("cart")) || [];
//     const cartItemsElement = document.getElementById("cart-items");
//     cartItemsElement.innerHTML = "";
//     var total_price = 0

//     cart.forEach(item => {
//         const cartItem = document.createElement("li");
//         cartItem.textContent = `${item.name} - Price: $${item.price.toFixed(2)} - Quantity: ${item.quantity}`;
//         total_price += parseFloat(item.price.toFixed(2) * item.quantity)
//         cartItemsElement.appendChild(cartItem);
//     });

//     const cartItem = document.createElement("li");
//     cartItem.textContent = `Cart Total - Price: $${total_price.toFixed(2)}`;
//     cartItemsElement.appendChild(cartItem)
// }

function searchCandy() {
    const candyNameInput = document.getElementById("candyName");
    const userInput = candyNameInput.value.trim();

    // Validate user input (allow only letters)
    if (!/^[a-zA-Z]+$/.test(userInput)) {
        showError("Invalid input. Please enter a valid candy name.");
        return;
    }

    const candy = products.find(item => item.name.toLowerCase() === userInput.toLowerCase());

    if (candy) {
        const candyDetails = document.getElementById("candyDetails");
        candyDetails.innerHTML = `
            <h3>${candy.name}</h3>
            <img src="${candy.image}" alt="${candy.name}">
            <p>Price: $${candy.price}</p>
            <label for="candyAmount">Enter Amount:</label>
            <input type="number" id="candyAmount" min="1" max="${candy.quantity}">
            <button onclick="addToCartAndUpdateInventory(${candy})">Add to Cart</button>
        `;
    } else {
        showError("Candy not found in inventory.");
    }
}

function showError(message) {
    const candyDetails = document.getElementById("candyDetails");
    candyDetails.innerHTML = `<p style="color: red;">${message}</p>`;
}