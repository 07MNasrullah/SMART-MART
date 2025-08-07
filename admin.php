<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMart Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-store"></i>
            <h2>SmartMart Admin</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="#dashboard" class="nav-item active" onclick="showSection('dashboard')">
                <i class="fas fa-chart-line"></i>
                Dashboard
            </a>
            <a href="#products" class="nav-item" onclick="showSection('products')">
                <i class="fas fa-box"></i>
                Products
            </a>
            <a href="#orders" class="nav-item" onclick="showSection('orders')">
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
            <a href="#customers" class="nav-item" onclick="showSection('customers')">
                <i class="fas fa-users"></i>
                Customers
            </a>
            <a href="#reports" class="nav-item" onclick="showSection('reports')">
                <i class="fas fa-chart-bar"></i>
                Reports
            </a>
            <a href="index.html" class="nav-item">
                <i class="fas fa-arrow-left"></i>
                Back to Store
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 id="pageTitle">Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">3</span>
                </div>
                <div class="admin-profile">
                    <img src="https://instagram.fpen1-1.fna.fbcdn.net/v/t51.2885-19/528031866_17846685918538916_3854296623274804997_n.jpg?efg=eyJ2ZW5jb2RlX3RhZyI6InByb2ZpbGVfcGljLmRqYW5nby4xMDgwLmMyIn0&_nc_ht=instagram.fpen1-1.fna.fbcdn.net&_nc_cat=108&_nc_oc=Q6cZ2QGdqM-J3xfH2zXWLZ3sdz_0dJuCmybBErCZjicIlR_2nnE1mHjc-grIljHmavDiMFs&_nc_ohc=r-q-oYfO47UQ7kNvwFMvxoX&_nc_gid=Fu7wFHQyjv3IUJk8YaabDA&edm=AP4sbd4BAAAA&ccb=7-5&oh=00_AfWGs1v0vKJJBimpK_ecSzjfr2iYK6x3M1p3LLjkqjnCeQ&oe=689A3EC1&_nc_sid=7a9f4b" alt="Admin">
                    <span>Admin</span>
                </div>
            </div>
        </header>

        <!-- Dashboard Section -->
        <section id="dashboard" class="content-section active">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="totalProducts">0</h3>
                        <p>Total Products</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="totalOrders">0</h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="pendingOrders">0</h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="totalRevenue">RM 0</h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Recent Orders</h3>
                        <a href="#orders" onclick="showSection('orders')">View All</a>
                    </div>
                    <div class="card-content">
                        <div id="recentOrders">
                            <!-- Recent orders will be loaded here -->
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Top Selling Products</h3>
                        <a href="#products" onclick="showSection('products')">View All</a>
                    </div>
                    <div class="card-content">
                        <div id="topProducts">
                            <!-- Top products will be loaded here -->
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Low Stock Alert</h3>
                        <span class="alert-badge" id="lowStockCount">0</span>
                    </div>
                    <div class="card-content">
                        <div id="lowStockProducts">
                            <!-- Low stock products will be loaded here -->
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="card-content">
                        <div class="quick-actions">
                            <button class="action-btn" onclick="showAddProductModal()">
                                <i class="fas fa-plus"></i>
                                Add Product
                            </button>
                            <button class="action-btn" onclick="showSection('orders')">
                                <i class="fas fa-eye"></i>
                                View Orders
                            </button>
                            <button class="action-btn" onclick="exportData()">
                                <i class="fas fa-download"></i>
                                Export Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="products" class="content-section">
            <div class="section-header">
                <h2>Products Management</h2>
                <button class="btn-primary" onclick="showAddProductModal()">
                    <i class="fas fa-plus"></i>
                    Add New Product
                </button>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <select id="categoryFilter" onchange="filterProducts()">
                        <option value="">All Categories</option>
                        <option value="stationery">Stationery</option>
                        <option value="food">Food & Snacks</option>
                        <option value="beverage">Beverages</option>
                        <option value="others">Others</option>
                    </select>
                </div>
                <div class="filter-group">
                    <input type="text" id="productSearch" placeholder="Search products..." onkeyup="searchProducts()">
                </div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTable">
                        <!-- Products will be loaded here -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Orders Section -->
        <section id="orders" class="content-section">
            <div class="section-header">
                <h2>Orders Management</h2>
                <div class="order-filters">
                    <select id="statusFilter" onchange="filterOrders()">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="preparing">Preparing</option>
                        <option value="ready">Ready</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTable">
                        <!-- Orders will be loaded here -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Customers Section -->
        <section id="customers" class="content-section">
            <div class="section-header">
                <h2>Customers</h2>
            </div>
            <div class="coming-soon">
                <i class="fas fa-users"></i>
                <h3>Customer Management</h3>
                <p>This feature is coming soon! Track customer orders, preferences, and loyalty points.</p>
            </div>
        </section>

        <!-- Reports Section -->
        <section id="reports" class="content-section">
            <div class="section-header">
                <h2>Reports & Analytics</h2>
            </div>
            <div class="coming-soon">
                <i class="fas fa-chart-bar"></i>
                <h3>Advanced Analytics</h3>
                <p>Detailed sales reports, trend analysis, and business insights coming soon!</p>
            </div>
        </section>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New Product</h3>
                <button class="close-modal" onclick="closeProductModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    <input type="hidden" id="productId">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="productName">Product Name *</label>
                            <input type="text" id="productName" required>
                        </div>
                        <div class="form-group">
                            <label for="productCategory">Category *</label>
                            <select id="productCategory" required>
                                <option value="">Select Category</option>
                                <option value="stationery">Stationery</option>
                                <option value="food">Food & Snacks</option>
                                <option value="beverage">Beverages</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="productPrice">Price (RM) *</label>
                            <input type="number" id="productPrice" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="productStock">Stock Quantity *</label>
                            <input type="number" id="productStock" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Description</label>
                        <textarea id="productDescription" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productImage">Image URL</label>
                        <input type="url" id="productImage" placeholder="https://example.com/image.jpg">
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="productBestseller">
                            <span class="checkmark"></span>
                            Mark as Bestseller
                        </label>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="closeProductModal()">Cancel</button>
                        <button type="submit" class="btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Order Details</h3>
                <button class="close-modal" onclick="closeOrderModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="orderDetails">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <script>
        // Sample data for demonstration
        let products = [
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
                name: "Maggi Curry Instant Noodles",
                category: "food",
                price: 1.20,
                description: "Spicy curry flavored instant noodles",
                image: "./images/maggi.jpeg",
                stock: 3,
                bestseller: true
            },
            {
                id: 3,
                name: "Milo 3-in-1",
                category: "beverage",
                price: 8.90,
                description: "Chocolate malt drink mix",
                image: "./images/milo.jpeg",
                stock: 22,
                bestseller: true
            }
        ];

        let orders = [
            {
                id: 1,
                customer_name: "Ahmad Ali",
                customer_class: "5 Bestari",
                customer_phone: "+60 12-345 6789",
                items: "Pilot G2 Gel Pen x2, Maggi Curry x1",
                total_amount: 8.20,
                status: "pending",
                created_at: "2024-01-15 10:30:00"
            },
            {
                id: 2,
                customer_name: "Siti Nurhaliza",
                customer_class: "4 Cemerlang",
                customer_phone: "+60 13-456 7890",
                items: "Milo 3-in-1 x1, Kit Kat x2",
                total_amount: 16.50,
                status: "confirmed",
                created_at: "2024-01-15 11:15:00"
            }
        ];

        // Initialize admin panel
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardStats();
            loadProducts();
            loadOrders();
            setupEventListeners();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Product form submission
            document.getElementById('productForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveProduct();
            });
        }

        // Navigation functions
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // Update navigation
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.classList.add('active');

            // Update page title
            const titles = {
                'dashboard': 'Dashboard',
                'products': 'Products Management',
                'orders': 'Orders Management',
                'customers': 'Customers',
                'reports': 'Reports & Analytics'
            };
            document.getElementById('pageTitle').textContent = titles[sectionId] || 'Dashboard';
        }

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        }

        // Dashboard functions
        function loadDashboardStats() {
            // Calculate stats from sample data
            const totalProducts = products.length;
            const totalOrders = orders.length;
            const pendingOrders = orders.filter(order => order.status === 'pending').length;
            const totalRevenue = orders.reduce((sum, order) => sum + order.total_amount, 0);
            const lowStock = products.filter(product => product.stock <= 5).length;

            // Update dashboard stats
            document.getElementById('totalProducts').textContent = totalProducts;
            document.getElementById('totalOrders').textContent = totalOrders;
            document.getElementById('pendingOrders').textContent = pendingOrders;
            document.getElementById('totalRevenue').textContent = `RM ${totalRevenue.toFixed(2)}`;
            document.getElementById('lowStockCount').textContent = lowStock;

            // Load recent orders
            const recentOrdersHtml = orders.slice(0, 5).map(order => `
                <div class="recent-order">
                    <div class="order-info">
                        <strong>#${order.id} - ${order.customer_name}</strong>
                        <span class="order-status status-${order.status}">${order.status}</span>
                    </div>
                    <div class="order-amount">RM ${order.total_amount.toFixed(2)}</div>
                </div>
            `).join('');
            document.getElementById('recentOrders').innerHTML = recentOrdersHtml;

            // Load top products
            const topProductsHtml = products.filter(p => p.bestseller).slice(0, 5).map(product => `
                <div class="top-product">
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-info">
                        <strong>${product.name}</strong>
                        <span>RM ${product.price.toFixed(2)}</span>
                    </div>
                </div>
            `).join('');
            document.getElementById('topProducts').innerHTML = topProductsHtml;

            // Load low stock products
            const lowStockHtml = products.filter(p => p.stock <= 5).map(product => `
                <div class="low-stock-item">
                    <span>${product.name}</span>
                    <span class="stock-count">${product.stock} left</span>
                </div>
            `).join('');
            document.getElementById('lowStockProducts').innerHTML = lowStockHtml || '<p>All products are well stocked!</p>';
        }

        // Products functions
        function loadProducts() {
            const productsTable = document.getElementById('productsTable');
            
            const productsHtml = products.map(product => `
                <tr>
                    <td>
                        <img src="${product.image}" alt="${product.name}" class="product-thumb">
                    </td>
                    <td>
                        <strong>${product.name}</strong>
                        ${product.bestseller ? '<span class="bestseller-badge">Bestseller</span>' : ''}
                    </td>
                    <td>${getCategoryName(product.category)}</td>
                    <td>RM ${product.price.toFixed(2)}</td>
                    <td>
                        <span class="stock-badge ${getStockClass(product.stock)}">${product.stock}</span>
                    </td>
                    <td>
                        <span class="status-badge ${product.stock > 0 ? 'status-active' : 'status-inactive'}">
                            ${product.stock > 0 ? 'In Stock' : 'Out of Stock'}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="editProduct(${product.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-delete" onclick="deleteProduct(${product.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
            
            productsTable.innerHTML = productsHtml;
        }

        function showAddProductModal() {
            document.getElementById('modalTitle').textContent = 'Add New Product';
            document.getElementById('productForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('productModal').classList.add('show');
            document.getElementById('overlay').classList.add('show');
        }

        function editProduct(id) {
            const product = products.find(p => p.id === id);
            if (!product) return;

            document.getElementById('modalTitle').textContent = 'Edit Product';
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productCategory').value = product.category;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productStock').value = product.stock;
            document.getElementById('productDescription').value = product.description;
            document.getElementById('productImage').value = product.image;
            document.getElementById('productBestseller').checked = product.bestseller;

            document.getElementById('productModal').classList.add('show');
            document.getElementById('overlay').classList.add('show');
        }

        function saveProduct() {
            const formData = {
                id: document.getElementById('productId').value,
                name: document.getElementById('productName').value,
                category: document.getElementById('productCategory').value,
                price: parseFloat(document.getElementById('productPrice').value),
                stock: parseInt(document.getElementById('productStock').value),
                description: document.getElementById('productDescription').value,
                image: document.getElementById('productImage').value,
                bestseller: document.getElementById('productBestseller').checked
            };

            if (formData.id) {
                // Update existing product
                const index = products.findIndex(p => p.id == formData.id);
                if (index !== -1) {
                    products[index] = { ...products[index], ...formData };
                }
            } else {
                // Add new product
                formData.id = Math.max(...products.map(p => p.id)) + 1;
                products.push(formData);
            }

            loadProducts();
            loadDashboardStats();
            closeProductModal();
            
            // Show success message
            alert('Product saved successfully!');
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                products = products.filter(p => p.id !== id);
                loadProducts();
                loadDashboardStats();
                alert('Product deleted successfully!');
            }
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.remove('show');
            document.getElementById('overlay').classList.remove('show');
        }

        // Orders functions
        function loadOrders() {
            const ordersTable = document.getElementById('ordersTable');
            
            const ordersHtml = orders.map(order => `
                <tr>
                    <td><strong>#${order.id}</strong></td>
                    <td>
                        <div class="customer-info">
                            <strong>${order.customer_name}</strong>
                            <small>${order.customer_class}</small>
                        </div>
                    </td>
                    <td class="items-cell">${order.items}</td>
                    <td><strong>RM ${order.total_amount.toFixed(2)}</strong></td>
                    <td>
                        <select class="status-select" onchange="updateOrderStatus(${order.id}, this.value)">
                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="confirmed" ${order.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                            <option value="preparing" ${order.status === 'preparing' ? 'selected' : ''}>Preparing</option>
                            <option value="ready" ${order.status === 'ready' ? 'selected' : ''}>Ready</option>
                            <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                        </select>
                    </td>
                    <td>${new Date(order.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-view" onclick="viewOrder(${order.id})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-delete" onclick="deleteOrder(${order.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
            
            ordersTable.innerHTML = ordersHtml;
        }

        function updateOrderStatus(orderId, newStatus) {
            const order = orders.find(o => o.id === orderId);
            if (order) {
                order.status = newStatus;
                loadDashboardStats();
                alert('Order status updated successfully!');
            }
        }

        function viewOrder(id) {
            const order = orders.find(o => o.id === id);
            if (!order) return;

            const orderDetailsHtml = `
                <div class="order-details">
                    <div class="detail-row">
                        <label>Order ID:</label>
                        <span>#${order.id}</span>
                    </div>
                    <div class="detail-row">
                        <label>Customer Name:</label>
                        <span>${order.customer_name}</span>
                    </div>
                    <div class="detail-row">
                        <label>Class/Room:</label>
                        <span>${order.customer_class}</span>
                    </div>
                    <div class="detail-row">
                        <label>Phone:</label>
                        <span>${order.customer_phone}</span>
                    </div>
                    <div class="detail-row">
                        <label>Items:</label>
                        <span>${order.items}</span>
                    </div>
                    <div class="detail-row">
                        <label>Total Amount:</label>
                        <span><strong>RM ${order.total_amount.toFixed(2)}</strong></span>
                    </div>
                    <div class="detail-row">
                        <label>Status:</label>
                        <span class="status-badge status-${order.status}">${order.status}</span>
                    </div>
                    <div class="detail-row">
                        <label>Order Date:</label>
                        <span>${new Date(order.created_at).toLocaleString()}</span>
                    </div>
                </div>
            `;

            document.getElementById('orderDetails').innerHTML = orderDetailsHtml;
            document.getElementById('orderModal').classList.add('show');
            document.getElementById('overlay').classList.add('show');
        }

        function deleteOrder(id) {
            if (confirm('Are you sure you want to delete this order?')) {
                orders = orders.filter(o => o.id !== id);
                loadOrders();
                loadDashboardStats();
                alert('Order deleted successfully!');
            }
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.remove('show');
            document.getElementById('overlay').classList.remove('show');
        }

        // Utility functions
        function getCategoryName(category) {
            const categoryNames = {
                'stationery': 'Stationery',
                'food': 'Food & Snacks',
                'beverage': 'Beverages',
                'others': 'Others'
            };
            return categoryNames[category] || category;
        }

        function getStockClass(stock) {
            if (stock === 0) return 'stock-out';
            if (stock <= 5) return 'stock-low';
            return 'stock-good';
        }

        function filterProducts() {
            // Implementation for filtering products
            loadProducts();
        }

        function searchProducts() {
            // Implementation for searching products
            loadProducts();
        }

        function filterOrders() {
            // Implementation for filtering orders
            loadOrders();
        }

        function exportData() {
            alert('Export functionality will be implemented soon!');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('overlay')) {
                closeProductModal();
                closeOrderModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeProductModal();
                closeOrderModal();
            }
        });
    </script>
</body>
</html>