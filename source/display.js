const categorySelect = document.getElementById("subcategory-select");
const $productList = $("#product-list");

// Add a change event listener to the category selection dropdown
categorySelect.addEventListener("change", function () {
    const selectedCategory = categorySelect.value;
    category_list = ["fresh-produce", "frozen", "breakfast-cereal", "baking", "pantry"]
    if (category_list.includes(selectedCategory)){
        fetchAndDisplayProductsFromDatabase(selectedCategory, "all", "all");
    }
    else{
        fetchAndDisplayProductsFromDatabase("all", selectedCategory, "all");
    }
});

// Cart functionality
function addToCartAndUpdateInventory(item, q) {
    // Send an AJAX request to update the inventory and transaction on the server
    $.ajax({
        url: 'addToCart.php',
        method: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({ cart: [{ Item_Num: item.Item_Num, quantity: q }] }),
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                console.log('Transaction ID:', response.transactionId);
            } else {
                alert(response.message);
            }
        },
        error: function (error) {
            console.error('Error updating inventory/transaction/cart:', error);
        }
    });
}


function fetchAndDisplayProductsFromDatabase(category, sub_category, name) {
    // Make an AJAX request to fetch product data from the database PHP script
    $.ajax({
        url: 'fetch_db.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Process the fetched data and update the UI
            displayProducts(data, category, sub_category, name);
        },
        error: function (error) {
            console.error('Error fetching products:', error);
        }
    });
}

function displayProducts(products, category, sub_category, name) {
    $productList.empty();

    const productTable = $('div').addClass("product-table")
    products
        .filter(product => (category === "all" || product.Category === category) && (sub_category === "all" || product.Sub_Category === sub_category) && (name === "all" || product.Name.toLowerCase().includes(name)))
        .forEach(product => {
            const $productItem = $("<div>").addClass("product-item");

            // Create elements for name, image, and price
            const $productImage = $("<img>").attr("src", product.ImageSrc).attr("alt", product.Name);
            const $productName = $("<h3>").text(product.Name);
            // const $productPrice = $("<p>").text(`Price: $${product.Unit_Price.toFixed(2)}`);
            const $productPrice = $("<p>").text(`Price: $${product.Unit_Price}`);

            $productItem.append($productImage, $productName, $productPrice);

            let $quantityInput;
            if (["candy", "snacks"].includes(product.Category)) {
                const $qLabel = $("<p>").text("Enter Quantity: ");
                $quantityInput = $("<input>").attr("type", "number").attr("min", "1").val("1"); // Default quantity

                $productItem.append($qLabel, $quantityInput);
            }

            const $addToCartButton = $("<button>").text("Add to Cart").data("productId", product.Item_Num);
            $addToCartButton.on("click", function() {
                const quantity = $quantityInput ? parseInt($quantityInput.val(), 10) : 1;
                addToCartAndUpdateInventory(product, quantity);
            });

            $productItem.append($addToCartButton);
            $productTable.append($productItem);
        });
    $productList.append($productTable);
}

// Initial fetch and display on page load
// fetchAndDisplayProductsFromDatabase("all", "all", "all");
