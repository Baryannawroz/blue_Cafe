@php
$categories = \App\Models\DishCategory::where('status',1)->get();
$dishes = \App\Models\Dish::where('status', 1)->where('available', 1)->get();
@endphp

<!-- Ultra Modern Menu Section -->
<section class="py-5" id="menu"
    style="background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%); position: relative; overflow: hidden;">
    <!-- Background Pattern -->
    <div class="menu-bg-pattern"></div>

    <div class="container position-relative">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <div class="menu-header-badge mb-3">
                <span class="badge-text">✨ CULINARY EXCELLENCE</span>
            </div>
            <h2 class="display-3 fw-bold text-white mb-3" style="text-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                Our Signature Menu
            </h2>
            <p class="lead text-light opacity-75" style="max-width: 600px; margin: 0 auto;">
                Experience the perfect harmony of flavors, crafted with passion and served with love
            </p>
        </div>

        <!-- Modern Search and Filter Section -->
        <div class="row mb-5">
            <div class="col-lg-10 mx-auto">
                <!-- Premium Search Bar -->
                <div class="premium-search-container mb-4">
                    <div class="search-wrapper">
                        <div class="search-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <input type="text" class="premium-search-input" id="dishSearch"
                            placeholder="Discover your perfect dish...">
                        <button class="search-clear-btn" type="button" id="clearSearch">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Modern Category Pills -->
                <div class="modern-category-nav">
                    <div class="category-pills-container">
                        <button class="category-pill active" data-category-id="all" onclick="filterDishes('all')">
                            <span class="pill-icon">🍽️</span>
                            <span class="pill-text">All Dishes</span>
                        </button>
                        @foreach($categories as $category)
                        <button class="category-pill" data-category-id="{{ $category->id }}"
                            onclick="filterDishes({{ $category->id }})">
                            <span class="pill-icon">🍴</span>
                            <span class="pill-text">{{ $category->name }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Items Grid -->
        <div class="row g-4" id="menu-items-container">
            @foreach($dishes as $dish)
            <div class="col-xl-3 col-lg-4 col-md-6 col-6 menu-item"
                data-category="{{ $dish->category_id ?? 'uncategorized' }}" data-dish-id="{{ $dish->id }}"
                data-dish-name="{{ strtolower($dish->dish) }}">

                <div class="premium-menu-card h-100">
                    <div class="card-image-wrapper">
                        <a href="{{ $dish->thumbnail }}" class="glightbox">
                            <img 
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='533'%3E%3Crect fill='%231a1a2e' width='400' height='533'/%3E%3C/svg%3E" 
                                data-src="{{ $dish->thumbnail }}" 
                                class="premium-card-img lazy-load" 
                                alt="{{ $dish->dish }}"
                                loading="lazy"
                                decoding="async">
                        </a>
                        <div class="image-overlay-gradient"></div>
                        @if($dish->dishPrices->count() > 0)
                        @php
                        $minPrice = $dish->dishPrices->min('price');
                        $maxPrice = $dish->dishPrices->max('price');
                        @endphp
                        <div class="premium-price-tag">
                            <span class="price-currency">IQD</span>
                            <span class="price-amount">
                                @if($minPrice == $maxPrice)
                                {{ number_format($minPrice, 0) }}
                                @else
                                {{ number_format($minPrice, 0) }}-{{ number_format($maxPrice, 0) }}
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="premium-card-content">
                        <div class="dish-header">
                            <h5 class="dish-title">{{ $dish->dish }}</h5>
                        </div>

                        @if($dish->dishPrices->count() > 1)
                        <div class="portion-tags">
                            @foreach($dish->dishPrices->take(2) as $price)
                            <span class="portion-tag">
                                {{ $price->dish_type }}
                            </span>
                            @endforeach
                            @if($dish->dishPrices->count() > 2)
                            <span class="portion-tag more">+{{ $dish->dishPrices->count() - 2 }}</span>
                            @endif
                        </div>
                        @endif

                    </div>

                    <!-- Hidden data for modal -->
                    <div class="dish-data" style="display: none;">
                        <div class="dish-images-data">
                            @foreach($dish->dishImages as $image)
                            <div class="dish-image-item" data-image="{{ $image->image }}"
                                data-title="{{ $image->title }}">
                            </div>
                            @endforeach
                        </div>
                        <div class="dish-prices-data">
                            @foreach($dish->dishPrices as $price)
                            <div class="dish-price-item" data-type="{{ $price->dish_type }}"
                                data-price="{{ $price->price }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="no-results-message" class="text-center py-5" style="display: none;">
            <div class="no-results-icon">
                <i class="bi bi-search" style="font-size: 4rem; color: #6c757d;"></i>
            </div>
            <h3 class="mt-3 mb-2 text-muted">No dishes found</h3>
            <p class="text-muted">Try adjusting your search or selecting a different category.</p>
            <button class="btn btn-primary" onclick="filterDishes('all')">
                <i class="bi bi-arrow-clockwise me-2"></i>
                Show All Dishes
            </button>
        </div>
    </div>
</section>

<!-- Modern Dish Modal -->
<div class="modal fade" id="dishModal" tabindex="-1" aria-labelledby="dishModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="dishModalLabel">
                    <i class="bi bi-egg-fried me-2"></i>
                    <span id="modalDishName">Dish Details</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <!-- Main Image -->
                        <div class="main-image-container">
                            <img src="" id="dishMainImage" class="img-fluid rounded-3" alt="Dish Image">
                            <div class="image-overlay">
                                <button class="btn btn-light btn-sm" onclick="openLightbox()">
                                    <i class="bi bi-zoom-in me-1"></i>
                                    View Full Size
                                </button>
                            </div>
                        </div>

                        <!-- Portion Options -->
                        <div class="portion-options-section mt-4">
                            <h6 class="section-title">
                                <i class="bi bi-list-ul me-2"></i>
                                Available Portions
                            </h6>
                            <div class="portion-options-grid" id="portionOptions">
                                <!-- Portion options will be populated here -->
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- Dish Gallery -->
                        <div class="gallery-section">
                            <h6 class="section-title">
                                <i class="bi bi-images me-2"></i>
                                More Photos
                            </h6>
                            <div class="gallery-grid" id="dishGallery">
                                <!-- Gallery images will be populated here -->
                            </div>
                        </div>

                        <!-- Dish Information -->
                        <div class="dish-info-section mt-4">
                            <h6 class="section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Dish Information
                            </h6>
                            <div class="info-card">
                                <div class="info-item">
                                    <i class="bi bi-clock me-2"></i>
                                    <span>Freshly prepared daily</span>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-heart me-2"></i>
                                    <span>Made with love and care</span>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-shield-check me-2"></i>
                                    <span>Quality guaranteed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>
                    Close
                </button>
                <button type="button" class="btn btn-primary" onclick="contactForOrder()">
                    <i class="bi bi-telephone me-1"></i>
                    Contact for Order
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modern JavaScript Functionality -->
<script>
    // Global variables
    let currentLightboxImage = '';
    let allDishes = [];
    let imageObserver = null;

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeMenu();
        setupSearch();
        setupCategoryFilter();
        initializeLazyLoading();
    });

    // Advanced Lazy Loading with Intersection Observer
    function initializeLazyLoading() {
        // Check if IntersectionObserver is supported
        if ('IntersectionObserver' in window) {
            // Create observer only once
            if (!imageObserver) {
                imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                // Load the image
                                const imageSrc = img.dataset.src;
                                img.src = imageSrc;
                                img.classList.remove('lazy-load');
                                
                                // Fade in once loaded
                                img.onload = () => {
                                    img.style.opacity = '1';
                                };
                                
                                // Handle loading errors
                                img.onerror = () => {
                                    img.style.opacity = '0.5';
                                };
                                
                                observer.unobserve(img);
                            }
                        }
                    });
                }, {
                    rootMargin: '100px' // Start loading 100px before image enters viewport
                });
            }

            // Observe all lazy images that aren't already being observed
            document.querySelectorAll('.lazy-load[data-src]').forEach(img => {
                // Only observe if image is visible or will be visible soon
                const rect = img.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight + 200;
                
                if (isVisible || img.closest('.menu-item').style.display !== 'none') {
                    imageObserver.observe(img);
                }
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            document.querySelectorAll('.lazy-load[data-src]').forEach(img => {
                img.src = img.dataset.src;
                img.classList.remove('lazy-load');
            });
        }
    }

    function initializeMenu() {
        // Store all dishes for search functionality
        allDishes = Array.from(document.querySelectorAll('.menu-item'));

        // Add animation to menu items
        animateMenuItems();
    }

    function setupSearch() {
        const searchInput = document.getElementById('dishSearch');
        const clearBtn = document.getElementById('clearSearch');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            filterBySearch(searchTerm);
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterBySearch('');
        });
    }

    function setupCategoryFilter() {
        // Category filter is handled by the existing filterDishes function
    }

    function filterBySearch(searchTerm) {
        const menuItems = document.querySelectorAll('.menu-item');
        const noResultsMessage = document.getElementById('no-results-message');
        let visibleCount = 0;

        menuItems.forEach(item => {
            const dishName = item.dataset.dishName || '';
            const isVisible = dishName.includes(searchTerm);

            if (isVisible) {
                item.style.display = 'block';
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                
                // Re-initialize lazy loading for visible items
                setTimeout(() => {
                    const lazyImages = item.querySelectorAll('.lazy-load[data-src]');
                    if (imageObserver && lazyImages.length > 0) {
                        lazyImages.forEach(img => {
                            imageObserver.observe(img);
                        });
                    }
                }, 100);
                
                setTimeout(() => {
                    item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 50 * visibleCount);
                
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0 && searchTerm) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    function filterDishes(categoryId) {
        const menuItems = document.querySelectorAll('.menu-item');
        const categoryTabs = document.querySelectorAll('.category-pill');
        const noResultsMessage = document.getElementById('no-results-message');
        const searchInput = document.getElementById('dishSearch');

        // Clear search when filtering by category
        searchInput.value = '';

        // Update active tab
        categoryTabs.forEach(tab => tab.classList.remove('active'));
        document.querySelector(`[data-category-id="${categoryId}"]`).classList.add('active');

        let visibleCount = 0;

        // Filter and animate items
        menuItems.forEach((item, index) => {
            const itemCategory = item.dataset.category;
            const isVisible = categoryId === 'all' || itemCategory === categoryId.toString();
            
            if (isVisible) {
                item.style.display = 'block';
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                
                // Re-initialize lazy loading for visible items
                setTimeout(() => {
                    const lazyImages = item.querySelectorAll('.lazy-load[data-src]');
                    if (imageObserver && lazyImages.length > 0) {
                        lazyImages.forEach(img => {
                            imageObserver.observe(img);
                        });
                    }
                }, 100);
                
                setTimeout(() => {
                    item.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 50 * visibleCount);
                
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    function animateMenuItems() {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';

            setTimeout(() => {
                item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    }

    function showDishModal(dishId) {
        const menuItem = document.querySelector(`[data-dish-id="${dishId}"]`);
        if (!menuItem) return;

        const dishName = menuItem.querySelector('.dish-title').textContent;
        const dishImage = menuItem.querySelector('.premium-card-img').src;
        const dishData = menuItem.querySelector('.dish-data');

        // Update modal content
        document.getElementById('modalDishName').textContent = dishName;
        document.getElementById('dishMainImage').src = dishImage;
        currentLightboxImage = dishImage;

        // Populate portion options
        populatePortionOptions(dishData);

        // Populate gallery
        populateGallery(dishData, dishImage, dishName);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('dishModal'));
        modal.show();
    }

    function populatePortionOptions(dishData) {
        const portionOptionsContainer = document.getElementById('portionOptions');
        const priceItems = dishData.querySelectorAll('.dish-price-item');

        portionOptionsContainer.innerHTML = '';

        priceItems.forEach(item => {
            const type = item.dataset.type;
            const price = item.dataset.price;

            const optionDiv = document.createElement('div');
            optionDiv.className = 'portion-option-card';
            optionDiv.innerHTML = `
                <div class="portion-info">
                    <h6 class="portion-type">${type}</h6>
                    <span class="portion-price">${parseInt(price).toLocaleString()} IQD</span>
                </div>
            `;

            portionOptionsContainer.appendChild(optionDiv);
        });
    }

    function populateGallery(dishData, mainImage, dishName) {
        const galleryContainer = document.getElementById('dishGallery');
        const imageItems = dishData.querySelectorAll('.dish-image-item');

        galleryContainer.innerHTML = '';

        // Add main image as first gallery item
        if (mainImage) {
            addGalleryImage(mainImage, dishName, galleryContainer);
        }

        // Add additional images
        imageItems.forEach(item => {
            const imageSrc = item.dataset.image;
            const imageTitle = item.dataset.title || dishName;
            addGalleryImage(imageSrc, imageTitle, galleryContainer);
        });
    }

    function addGalleryImage(imageSrc, imageTitle, container) {
        const galleryItem = document.createElement('div');
        galleryItem.className = 'gallery-item';
        galleryItem.innerHTML = `
            <img src="${imageSrc}" alt="${imageTitle}" class="img-fluid">
            <div class="gallery-overlay">
                <i class="bi bi-zoom-in"></i>
            </div>
        `;

        galleryItem.addEventListener('click', function() {
            document.getElementById('dishMainImage').src = imageSrc;
            currentLightboxImage = imageSrc;
        });

        container.appendChild(galleryItem);
    }

    function openLightbox() {
        if (currentLightboxImage) {
            // Create a temporary link for GLightbox
            const tempLink = document.createElement('a');
            tempLink.href = currentLightboxImage;
            tempLink.className = 'glightbox';
            tempLink.click();
        }
    }

    function contactForOrder() {
        // You can customize this function to redirect to contact page or show contact info
        alert('Please contact us to place your order!');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true
        });

        // Get all menu items
        const menuItems = document.querySelectorAll('.menu-item-simple');

        // Add click event to each menu item
        menuItems.forEach(item => {
            item.addEventListener('click', function (e) {
                // Don't trigger modal if clicking on the image (let GLightbox handle it)
                if (e.target.closest('.glightbox')) {
                    return;
                }

                // Get parent container with dish ID
                const menuItemContainer = this.closest('[data-dish-id]');
                const dishId = menuItemContainer ? menuItemContainer.dataset.dishId : null;

                // Get dish information from the clicked item
                const dishName = this.querySelector('h5').textContent;
                const dishImage = this.querySelector('.menu-img')?.src || this.querySelector('img')?.src;

                // Get dish price options (we'll need to fetch this from the server or store it differently)
                const dishOptions = this.querySelectorAll('.portion-option') || [];

                // Find the modal elements
                const modal = document.getElementById('dishModal');
                const modalTitle = modal.querySelector('.modal-title');
                const modalImage = document.getElementById('dishMainImage');
                const modalOptions = modal.querySelector('.dish-options');
                const modalGallery = modal.querySelector('.dish-gallery');

                // Set the modal content
                modalTitle.textContent = dishName;
                modalImage.src = dishImage;
                modalImage.alt = dishName;

                // Clear previous options and gallery
                modalOptions.innerHTML = '';
                modalGallery.innerHTML = '';

                // Since we simplified the display, we'll show a simple message about pricing
                const optionsList = document.createElement('div');
                optionsList.className = 'd-flex flex-column gap-2';

                const infoDiv = document.createElement('div');
                infoDiv.className = 'p-3 bg-light rounded';
                infoDiv.style.border = '1px solid #dee2e6';
                infoDiv.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-info-circle text-primary mb-2" style="font-size: 2rem;"></i>
                        <h6 class="mb-2">Dish Information</h6>
                        <p class="mb-0 text-muted">Click on the image to view larger version. Contact us for detailed pricing options.</p>
                    </div>
                `;

                modalOptions.appendChild(infoDiv);

                // Get dish images from the hidden data div
                let dishImages = [];
                const dishImagesData = this.querySelector('.dish-images-data');

                if (dishImagesData) {
                    const imageItems = dishImagesData.querySelectorAll('.dish-image-item');
                    imageItems.forEach(item => {
                        dishImages.push({
                            image: item.dataset.image,
                            title: item.dataset.title
                        });
                    });
                }

                // If no images found in the hidden div, check for dish images elsewhere
                if (dishImages.length === 0) {
                    // Try to find dish images by dish ID
                    if (dishId) {
                        // Find the dish images container for this dish
                        const imagesContainer = document.querySelector(`[data-dish-id="${dishId}"] .dish-images-data`);
                        if (imagesContainer) {
                            const imageItems = imagesContainer.querySelectorAll('.dish-image-item');
                            imageItems.forEach(item => {
                                dishImages.push({
                                    image: item.dataset.image,
                                    title: item.dataset.title
                                });
                            });
                        }
                    }
                }

                // If still no images found, use the main image as fallback
                if (dishImages.length === 0) {
                    dishImages = [
                        { image: dishImage, title: dishName },
                        { image: dishImage, title: dishName },
                        { image: dishImage, title: dishName }
                    ];
                }

                // Add gallery images to modal with improved styling
                dishImages.forEach(img => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-6 mb-3';

                    const imgContainer = document.createElement('div');
                    imgContainer.style.overflow = 'hidden';
                    imgContainer.style.borderRadius = '10px';
                    imgContainer.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                    imgContainer.style.cursor = 'pointer';
                    imgContainer.title = img.title || dishName;

                    const imgElement = document.createElement('img');
                    imgElement.src = img.image;
                    imgElement.className = 'img-fluid w-100';
                    imgElement.style.height = '140px';
                    imgElement.style.objectFit = 'cover';
                    imgElement.style.transition = 'transform 0.3s ease';
                    imgElement.alt = img.title || dishName;

                    // Add hover effect to gallery images
                    imgContainer.addEventListener('mouseover', function () {
                        imgElement.style.transform = 'scale(1.1)';
                    });

                    imgContainer.addEventListener('mouseout', function () {
                        imgElement.style.transform = 'scale(1)';
                    });

                    // Make gallery image clickable to show as main image
                    imgContainer.addEventListener('click', function() {
                        modalImage.src = img.image;
                        modalImage.alt = img.title || dishName;
                    });

                    imgContainer.appendChild(imgElement);
                    colDiv.appendChild(imgContainer);
                    modalGallery.appendChild(colDiv);
                });

                // Open the modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });
    });
</script>

<!-- GLightbox CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

<!-- Ultra Modern Premium CSS Styles -->
<style>
    /* Background Pattern */
    .menu-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Header Badge */
    .menu-header-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 8px 20px;
        border-radius: 25px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .badge-text {
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    /* Premium Search */
    .premium-search-container {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-wrapper {
        position: relative;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
        z-index: 2;
    }

    .premium-search-input {
        width: 100%;
        padding: 18px 60px 18px 60px;
        background: transparent;
        border: none;
        color: white;
        font-size: 1rem;
        outline: none;
    }

    .premium-search-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .search-clear-btn {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .search-clear-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    /* Modern Category Pills */
    .modern-category-nav {
        margin-top: 30px;
    }

    .category-pills-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
    }

    .category-pill {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 12px 20px;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-pill:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .category-pill.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .pill-icon {
        font-size: 1.1rem;
    }

    .pill-text {
        font-size: 0.9rem;
    }

    /* Premium Menu Cards */
    .premium-menu-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
    }

    .premium-menu-card:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .card-image-wrapper {
        position: relative;
        overflow: hidden;
        aspect-ratio: 3 / 4;
        width: 100%;
    }

    .premium-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
        transition: transform 0.6s ease, opacity 0.3s ease;
    }

    .lazy-load {
        opacity: 0.5;
        background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    .premium-menu-card:hover .premium-card-img {
        transform: scale(1.15);
    }

    .image-overlay-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .premium-menu-card:hover .image-overlay-gradient {
        opacity: 1;
    }

    /* Premium Price Tag */
    .premium-price-tag {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        display: flex;
        flex-direction: column;
        align-items: center;
        line-height: 1.2;
    }

    .price-currency {
        font-size: 0.7rem;
        opacity: 0.9;
    }

    .price-amount {
        font-size: 1rem;
        font-weight: 800;
    }


    /* Premium Card Content */
    .premium-card-content {
        padding: 24px;
        background: rgba(255, 255, 255, 0.02);
    }

    .dish-header {
        margin-bottom: 12px;
    }

    .dish-title {
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.3;
    }

    .portion-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }

    .portion-tag {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .portion-tag.more {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
    }


    /* No Results Styling */
    .no-results-icon {
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .premium-menu-card {
            margin-bottom: 20px;
        }

        .card-image-wrapper {
            aspect-ratio: 2 / 3;
        }

        .category-pill {
            padding: 10px 16px;
            font-size: 0.85rem;
        }

        .premium-card-content {
            padding: 20px;
        }

        .dish-title {
            font-size: 1.1rem;
        }

        .premium-search-input {
            padding: 16px 50px 16px 50px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .premium-search-input {
            padding: 14px 45px 14px 45px;
            font-size: 0.85rem;
        }

        .dish-title {
            font-size: 1rem;
            line-height: 1.2;
        }

        .premium-price-tag {
            padding: 4px 8px;
            font-size: 0.7rem;
        }

        .price-currency {
            font-size: 0.6rem;
        }

        .price-amount {
            font-size: 0.8rem;
        }

        .card-image-wrapper {
            aspect-ratio: 3 / 4;
        }

        .premium-card-content {
            padding: 16px;
        }

        .category-pill {
            padding: 8px 14px;
            font-size: 0.8rem;
        }

        .portion-tags {
            gap: 4px;
        }

        .portion-tag {
            font-size: 0.7rem;
            padding: 3px 8px;
        }
    }

    /* Modal Styles */
    .modern-modal {
        border-radius: 20px;
        border: none;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    .modern-modal .modal-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 20px 30px;
        border: none;
    }

    .modern-modal .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .modern-modal .modal-body {
        padding: 30px;
    }

    .modern-modal .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 20px 30px;
        border-radius: 0 0 20px 20px;
    }

    .main-image-container {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .main-image-container img {
        width: 100%;
        height: 100%;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        object-position: center center;
        display: block;
    }

    .image-overlay {
        position: absolute;
        top: 15px;
        right: 15px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .main-image-container:hover .image-overlay {
        opacity: 1;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #007bff;
        display: inline-block;
    }

    .portion-options-grid {
        display: grid;
        gap: 10px;
    }

    .portion-option-card {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .portion-option-card:hover {
        border-color: #007bff;
        background: #f0f8ff;
        transform: translateX(5px);
    }

    .portion-type {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .portion-price {
        font-weight: 700;
        color: #007bff;
        font-size: 1.1rem;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
    }

    .gallery-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        object-position: center center;
        display: block;
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay i {
        color: white;
        font-size: 1.5rem;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #6c757d;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-item i {
        color: #007bff;
        margin-right: 10px;
    }

    /* No Results Styling */
    .no-results-icon {
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .menu-card {
            margin-bottom: 20px;
        }

        .card-image-container {
            aspect-ratio: 2 / 3;
        }

        .category-btn {
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .modern-modal .modal-body {
            padding: 20px;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .main-image-container img {
            aspect-ratio: 4 / 3;
        }
    }

    @media (max-width: 576px) {
        .search-container .form-control {
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .price-badge {
            font-size: 0.8rem;
            padding: 6px 10px;
        }

        .card-image-container {
            aspect-ratio: 3 / 4;
        }

        .main-image-container img {
            aspect-ratio: 1 / 1;
        }
    }

    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading Animation */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #007bff;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #0056b3;
    }
</style>
