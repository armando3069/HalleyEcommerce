let selectedColor = "";
let selectedMemory = "";

function selectColor(color, index) {
  // Schimbă stilul pentru culoarea selectată
  document
    .querySelectorAll(".color-circle")
    .forEach((el) => el.classList.remove("selected"));
  document.getElementById(`color-${index}`).classList.add("selected");
  selectedColor = color;
}

function selectMemory(memory, index) {
  // Schimbă stilul pentru memoria selectată
  document
    .querySelectorAll(".memory-item")
    .forEach((el) => el.classList.remove("selected"));
  document.getElementById(`memory-${index}`).classList.add("selected");
  selectedMemory = memory;
}

function addToCart(productId) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let existingProduct = cart.find((p) => p.id === productId);

  if (existingProduct) {
    existingProduct.quantity += 1;
    existingProduct.selectedColor = selectedColor;
    existingProduct.selectedMemory = selectedMemory;
  } else {
    cart.push({
      id: productId,
      quantity: 1,
      selectedColor: selectedColor,
      selectedMemory: selectedMemory,
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  alert(
    "Product added to cart with color: " +
      selectedColor +
      " and memory: " +
      selectedMemory
  );
}

document.getElementById("toggle-btn").addEventListener("click", function () {
  var hiddenSections = document.getElementById("hidden-sections");
  var isHidden =
    hiddenSections.style.display === "none" ||
    hiddenSections.style.display === "";

  if (isHidden) {
    hiddenSections.style.display = "block";
    this.textContent = "View Less";
  } else {
    hiddenSections.style.display = "none";
    this.textContent = "View More";
  }
});

function toggleReviews() {
  const reviews = document.querySelectorAll("#reviews-list .review");
  const viewMoreBtn = document.getElementById("view-more-btn");
  let isExpanded = viewMoreBtn.getAttribute("data-expanded") === "true";

  reviews.forEach((review, index) => {
    if (index >= 3) {
      review.style.display = isExpanded ? "none" : "block";
    }
  });

  viewMoreBtn.textContent = isExpanded ? "View More" : "View Less";
  viewMoreBtn.setAttribute("data-expanded", !isExpanded);
}
