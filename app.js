// Sample product data
const products = [
    // Stationery
    {
        id: 1,
        name: "Pilot G2 Gel Pen",
        category: "stationery",
        price: 3.50,
        description: "Smooth writing gel pen with comfortable grip",
        image: "./images/pen.jpeg",
        stock: 25,
        bestseller: true
    },
    {
        id: 2,
        name: "A4 Exercise Book",
        category: "stationery",
        price: 2.80,
        description: "80 pages lined exercise book for notes",
        image: "./images/A4book.jpg",
        stock: 50,
        bestseller: false
    },
    {
        id: 3,
        name: "Stadtler Ruler 30cm",
        category: "stationery",
        price: 4.20,
        description: "Transparent plastic ruler with clear markings",
        image: "./images/ruler.jpeg",
        stock: 15,
        bestseller: false
    },
    {
        id: 4,
        name: "Faber-Castell Eraser",
        category: "stationery",
        price: 1.50,
        description: "High quality eraser for pencil marks",
        image: "./images/eraser.jpeg",
        stock: 30,
        bestseller: false
    },
    {
        id: 5,
        name: "Highlighter Set (4 colors)",
        category: "stationery",
        price: 8.90,
        description: "Set of 4 fluorescent highlighters",
        image: "./images/Highlighter.jpeg",
        stock: 20,
        bestseller: true
    },

    // Food & Snacks
    {
        id: 6,
        name: "Maggi Curry Instant Noodles(CUP)",
        category: "food",
        price: 1.20,
        description: "Spicy curry flavored instant noodles",
        image: "./images/maggi.jpeg",
        stock: 40,
        bestseller: true
    },
    {
        id: 7,
        name: "Gardenia Chocolate Bread",
        category: "food",
        price: 2.70,
        description: "Fresh white bread loaf",
        image: "./images/roti.png",
        stock: 12,
        bestseller: false
    },
    {
        id: 8,
        name: "Kit Kat Chocolate Bar",
        category: "food",
        price: 3.80,
        description: "Crispy wafer chocolate bar",
        image: "./images/kitkat.jpeg",
        stock: 35,
        bestseller: true
    },
    {
        id: 9,
        name: "Pringles Original",
        category: "food",
        price: 6.50,
        description: "Crispy potato chips in tube",
        image: "./images/pringles.jpeg",
        stock: 18,
        bestseller: false
    },
    {
        id: 10,
        name: "Oreo Cookies",
        category: "food",
        price: 4.20,
        description: "Chocolate sandwich cookies",
        image: "./images/oreo.jpeg",
        stock: 25,
        bestseller: true
    },

    // Beverages
    {
        id: 11,
        name: "Milo 3-in-1 (10 sachets)",
        category: "beverage",
        price: 8.90,
        description: "Chocolate malt drink mix",
        image: "./images/milo.jpeg",
        stock: 22,
        bestseller: true
    },
    {
        id: 12,
        name: "Spritzer Mineral Water 500ml",
        category: "beverage",
        price: 1.50,
        description: "Natural mineral water",
        image: "./images/mineral.jpeg",
        stock: 60,
        bestseller: false
    },
    {
        id: 13,
        name: "Coca-Cola 325ml",
        category: "beverage",
        price: 2.20,
        description: "Classic cola soft drink",
        image: "./images/coca cola.jpeg",
        stock: 45,
        bestseller: true
    },
    {
        id: 14,
        name: "100Plus Isotonic Drink",
        category: "beverage",
        price: 2.80,
        description: "Lemon lime isotonic sports drink",
        image: "./images/100plus.jpeg",
        stock: 30,
        bestseller: false
    },
    {
        id: 15,
        name: "Nescafe Original Coffee",
        category: "beverage",
        price: 12.50,
        description: "Instant coffee jar 200g",
        image: "./images/Nescafe.jpeg",
        stock: 15,
        bestseller: false
    },

    // Others
    {
        id: 16,
        name: "3-Ply Face Mask (50pcs)",
        category: "others",
        price: 15.90,
        description: "Disposable surgical face masks",
        image: "./images/mask.jpeg",
        stock: 20,
        bestseller: true
    },
    {
        id: 17,
        name: "Kleenex Tissue Box",
        category: "others",
        price: 4.50,
        description: "Soft facial tissues 100 sheets",
        image: "./images/tissue.jpeg",
        stock: 25,
        bestseller: false
    },
    {
        id: 18,
        name: "Hand Sanitizer 50ml",
        category: "others",
        price: 3.20,
        description: "70% alcohol hand sanitizer",
        image: "./images/Handsanitiser.jpeg",
        stock: 40,
        bestseller: true
    },
    {
        id: 19,
        name: "Phone Top-up RM10",
        category: "others",
        price: 10.00,
        description: "Mobile phone credit top-up",
        image: "./images/tng.webp",
        stock: 100,
        bestseller: false
    },
    {
        id: 20,
        name: "Wet Wipes (60 sheets)",
        category: "others",
        price: 5.80,
        description: "Antibacterial wet wipes",
        image: "./images/wettissue.jpg",
        stock: 30,
        bestseller: false
    }
];

// Shopping cart
let cart = JSON.parse(localStorage.getItem('smartmart_cart')) || [];

// Current filter
let currentFilter = 'all';

// Initialize the app
document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    loadBestsellers();
    updateCartUI();
    setupEventListeners();
});

// Setup event listeners
function setupEventListeners() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', handleSearch);

    // Navigation smooth scrolling
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('href');
            if (target.startsWith('#')) {
                document.querySelector(target).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            closeCheckoutModal();
        }
    });
}

// Load and display products
function loadProducts(filter = 'all', searchTerm = '') {
    const productsGrid = document.getElementById('productsGrid');
    productsGrid.innerHTML = '<div class="loading"><div class="spinner"></div></div>';

    setTimeout(() => {
        let filteredProducts = products;

        // Apply category filter
        if (filter !== 'all') {
            filteredProducts = filteredProducts.filter(product => product.category === filter);
        }

        // Apply search filter
        if (searchTerm) {
            filteredProducts = filteredProducts.filter(product =>
                product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.description.toLowerCase().includes(searchTerm.toLowerCase())
            );
        }

        if (filteredProducts.length === 0) {
            productsGrid.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
                    <i class="fas fa-search" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <h3>No products found</h3>
                    <p>Try adjusting your search or filter criteria.</p>
                </div>
            `;
            return;
        }

        productsGrid.innerHTML = filteredProducts.map(product => `
            <div class="product-card" data-category="${product.category}">
                <img src="${product.image}" alt="${product.name}" class="product-image">
                <div class="stock-badge ${getStockClass(product.stock)}">${getStockText(product.stock)}</div>
                <div class="product-info">
                    <span class="product-category">${getCategoryName(product.category)}</span>
                    <h3 class="product-name">${product.name}</h3>
                    <p class="product-description">${product.description}</p>
                    <div class="product-footer">
                        <span class="product-price">RM ${product.price.toFixed(2)}</span>
                        <button class="add-to-cart" onclick="addToCart(${product.id})" ${product.stock === 0 ? 'disabled' : ''}>
                            <i class="fas fa-cart-plus"></i>
                            ${product.stock === 0 ? 'Out of Stock' : 'Add to Cart'}
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }, 500);
}

// Load bestsellers
function loadBestsellers() {
    const bestsellersGrid = document.getElementById('bestsellersGrid');
    const bestsellers = products.filter(product => product.bestseller).slice(0, 4);

    bestsellersGrid.innerHTML = bestsellers.map(product => `
        <div class="product-card">
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <div class="product-info">
                <span class="product-category">${getCategoryName(product.category)}</span>
                <h3 class="product-name">${product.name}</h3>
                <p class="product-description">${product.description}</p>
                <div class="product-footer">
                    <span class="product-price">RM ${product.price.toFixed(2)}</span>
                    <button class="add-to-cart" onclick="addToCart(${product.id})">
                        <i class="fas fa-cart-plus"></i>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Filter products by category
function filterProducts(category) {
    currentFilter = category;
    
    // Update filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');

    // Load filtered products
    loadProducts(category);

    // Scroll to products section
    document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
}

// Handle search
function handleSearch(e) {
    const searchTerm = e.target.value;
    loadProducts(currentFilter, searchTerm);
}

// Get category display name
function getCategoryName(category) {
    const categoryNames = {
        'stationery': 'Stationery',
        'food': 'Food & Snacks',
        'beverage': 'Beverages',
        'others': 'Others'
    };
    return categoryNames[category] || category;
}

// Get stock status class
function getStockClass(stock) {
    if (stock === 0) return 'out';
    if (stock <= 5) return 'low';
    return '';
}

// Get stock status text
function getStockText(stock) {
    if (stock === 0) return 'Out of Stock';
    if (stock <= 5) return `Only ${stock} left`;
    return 'In Stock';
}

// Add product to cart
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product || product.stock === 0) return;

    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        if (existingItem.quantity < product.stock) {
            existingItem.quantity += 1;
        } else {
            alert('Sorry, not enough stock available!');
            return;
        }
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }

    // Update local storage
    localStorage.setItem('smartmart_cart', JSON.stringify(cart));
    
    // Update UI
    updateCartUI();
    showSuccessMessage();
}

// Update cart UI
function updateCartUI() {
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');

    // Update cart count
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;

    // Update cart items
    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #666;">
                <i class="fas fa-shopping-cart" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                <p>Your cart is empty</p>
                <p style="font-size: 0.9rem;">Add some products to get started!</p>
            </div>
        `;
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">RM ${item.price.toFixed(2)}</div>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                        <button class="remove-item" onclick="removeFromCart(${item.id})">Remove</button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Update total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    cartTotal.textContent = total.toFixed(2);
}

// Update item quantity
function updateQuantity(productId, change) {
    const product = products.find(p => p.id === productId);
    const cartItem = cart.find(item => item.id === productId);
    
    if (!cartItem) return;

    const newQuantity = cartItem.quantity + change;
    
    if (newQuantity <= 0) {
        removeFromCart(productId);
        return;
    }
    
    if (newQuantity > product.stock) {
        alert('Sorry, not enough stock available!');
        return;
    }

    cartItem.quantity = newQuantity;
    localStorage.setItem('smartmart_cart', JSON.stringify(cart));
    updateCartUI();
}

// Remove item from cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('smartmart_cart', JSON.stringify(cart));
    updateCartUI();
}

// Toggle cart sidebar
function toggleCart() {
    const cartSidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('overlay');
    
    cartSidebar.classList.toggle('open');
    overlay.classList.toggle('show');
}

// Show success message
function showSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    successMessage.classList.add('show');
    
    setTimeout(() => {
        successMessage.classList.remove('show');
    }, 3000);
}

// Proceed to checkout
function proceedToCheckout() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const checkoutModal = document.getElementById('checkoutModal');
    const checkoutItems = document.getElementById('checkoutItems');
    const checkoutTotal = document.getElementById('checkoutTotal');

    // Populate checkout items
    checkoutItems.innerHTML = cart.map(item => `
        <div class="checkout-item">
            <span>${item.name} x ${item.quantity}</span>
            <span>RM ${(item.price * item.quantity).toFixed(2)}</span>
        </div>
    `).join('');

    // Update total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    checkoutTotal.textContent = total.toFixed(2);

    // Show modal
    checkoutModal.classList.add('show');
    toggleCart(); // Close cart sidebar
}

// Close checkout modal
function closeCheckoutModal() {
    const checkoutModal = document.getElementById('checkoutModal');
    checkoutModal.classList.remove('show');
}

// Checkout via WhatsApp
function checkoutViaWhatsApp() {
    if (!validateCheckoutForm()) return;

    const formData = getCheckoutFormData();
    const orderDetails = cart.map(item => 
        `${item.name} x ${item.quantity} = RM ${(item.price * item.quantity).toFixed(2)}`
    ).join('\n');
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    const message = `🛒 *SmartMart Order*\n\n` +
                   `👤 *Customer Details:*\n` +
                   `Name: ${formData.name}\n` +
                   `Class/Room: ${formData.class}\n` +
                   `Phone: ${formData.phone}\n` +
                   `Delivery Time: ${formData.deliveryTime}\n\n` +
                   `📦 *Order Items:*\n${orderDetails}\n\n` +
                   `💰 *Total: RM ${total.toFixed(2)}*\n\n` +
                   `📝 *Special Instructions:*\n${formData.instructions || 'None'}\n\n` +
                   `Thank you for your order! 😊`;

    const whatsappUrl = `https://wa.me/60123878544?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
    
    // Clear cart and close modal
    clearCartAfterOrder();
}

// Checkout via form submission
function checkoutViaForm() {
    if (!validateCheckoutForm()) return;

    const formData = getCheckoutFormData();
    
    // Create a simple form submission (you can replace this with actual form handling)
    alert('Order submitted successfully! We will contact you soon for confirmation.');
    
    // Clear cart and close modal
    clearCartAfterOrder();
}

// Validate checkout form
function validateCheckoutForm() {
    const name = document.getElementById('customerName').value.trim();
    const classRoom = document.getElementById('customerClass').value.trim();
    const phone = document.getElementById('customerPhone').value.trim();

    if (!name || !classRoom || !phone) {
        alert('Please fill in all required fields!');
        return false;
    }

    return true;
}

// Get checkout form data
function getCheckoutFormData() {
    return {
        name: document.getElementById('customerName').value.trim(),
        class: document.getElementById('customerClass').value.trim(),
        phone: document.getElementById('customerPhone').value.trim(),
        deliveryTime: document.getElementById('deliveryTime').value,
        instructions: document.getElementById('specialInstructions').value.trim()
    };
}

// Clear cart after successful order
function clearCartAfterOrder() {
    cart = [];
    localStorage.setItem('smartmart_cart', JSON.stringify(cart));
    updateCartUI();
    closeCheckoutModal();
    
    // Show success message
    alert('🎉 Order placed successfully! Thank you for shopping with SmartMart!');
    
    // Reset form
    document.getElementById('checkoutForm').reset();
}

// Smooth scrolling for navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Update active navigation link on scroll
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});

// Close cart when clicking outside
document.addEventListener('click', function(e) {
    const cartSidebar = document.getElementById('cartSidebar');
    const cartBtn = document.querySelector('.cart-btn');
    const overlay = document.getElementById('overlay');
    
    if (!cartSidebar.contains(e.target) && !cartBtn.contains(e.target) && cartSidebar.classList.contains('open')) {
        cartSidebar.classList.remove('open');
        overlay.classList.remove('show');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // ESC to close modals/cart
    if (e.key === 'Escape') {
        closeCheckoutModal();
        const cartSidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('overlay');
        if (cartSidebar.classList.contains('open')) {
            cartSidebar.classList.remove('open');
            overlay.classList.remove('show');
        }
    }
    
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('searchInput').focus();
    }
});

// Add loading states for better UX
function showLoading(element) {
    element.innerHTML = '<div class="loading"><div class="spinner"></div></div>';
}

// Initialize tooltips and other interactive elements
function initializeInteractiveElements() {
    // Add hover effects to product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Call initialization functions
document.addEventListener('DOMContentLoaded', function() {
    initializeInteractiveElements();
});