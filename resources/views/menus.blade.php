@php
$categories = \App\Models\DishCategory::where('status',1)->get();
$dishes = \App\Models\Dish::where('status', 1)->where('available', 1)->get();
@endphp

<!-- Menu Section -->
<section class="py-5" id="menu">
    <div class="container">
        <h2 class="text-center section-title">Our Delicious Menu</h2>

        <!-- Menu Categories -->
        <div class="d-flex flex-wrap justify-content-center mb-4">
            <button class="btn category-tab active" data-category-id="all" onclick="filterDishes('all')">
                All Dishes
            </button>
            @foreach($categories as $category)
            <button class="btn category-tab" data-category-id="{{ $category->id }}"
                onclick="filterDishes({{ $category->id }})">
                {{ $category->name }}
            </button>
            @endforeach
        </div>

        <!-- Menu Items -->
        <div class="row" id="menu-items-container">
            @foreach($dishes as $dish)
            <div class="col-lg-4 col-md-6 col-6 mb-4 menu-item"
                data-category="{{ $dish->category_id ?? 'uncategorized' }}" data-dish-id="{{ $dish->id }}">
                <div class="menu-item-simple text-center">
                    <a href="{{ $dish->thumbnail }}" class="glightbox">
                        <img src="{{ $dish->thumbnail }}"
                            style="width: 100%; height: 180px; object-fit: cover; border-radius: 8px;" loading="lazy"
                            class="menu-img img-fluid" alt="{{ $dish->dish }}">
                    </a>
                    <h5 class="mt-2 mb-1">{{ $dish->dish }}</h5>
                    @if($dish->dishPrices->count() > 0)
                    @php
                    $Price = $dish->dishPrices->min('price');
                    @endphp
                    <p class="price mb-0">
                        {{ number_format($Price, 0) }}
                    </p>
                    @endif

                    <!-- Hidden div to store dish images for modal -->
                    <div class="dish-images-data" style="display: none;">
                        @foreach($dish->dishImages as $image)
                        <div class="dish-image-item" data-image="{{ $image->image }}" data-title="{{ $image->title }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="no-results-message" class="text-center py-5" style="display: none;">
            <div style="font-size: 64px;">🍽️</div>
            <h3 class="mt-3 mb-2">No dishes found in this category</h3>
            <p class="text-muted">Try selecting a different category or check back later for new additions.</p>
        </div>
    </div>
</section>

<!-- Add this modal structure to the end of your body tag but before the script tags -->
<div class="modal fade" id="dishModal" tabindex="-1" aria-labelledby="dishModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"
                style="background-color: #FF6B6B; color: #fff; position: relative; padding: 15px 20px;">
                <h5 class="modal-title" id="dishModalLabel" style="font-weight: 600; font-size: 22px;">Dish
                    Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Main dish image -->
                        <img src="" id="dishMainImage" class="img-fluid rounded mb-4 w-100" alt="Dish Image"
                            style="height: 300px; object-fit: cover;">

                        <!-- Dish options with clear styling -->
                        <div class="dish-options-container mb-4">
                            <h5
                                style="color: #333; font-weight: 600; margin-bottom: 12px; border-left: 4px solid #FF6B6B; padding-left: 10px;">
                                Portion Options</h5>
                            <div class="dish-options"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- More photos -->
                        <h5
                            style="color: #333; font-weight: 600; margin-bottom: 12px; border-left: 4px solid #FF6B6B; padding-left: 10px;">
                            More Photos</h5>
                        <div class="dish-gallery row g-2"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #eee; padding: 15px;">
                <button type="button" class="btn" data-bs-dismiss="modal"
                    style="background-color: #4ECDC4; color: white; padding: 8px 24px; border-radius: 30px; font-weight: 500;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add this JavaScript code before the closing body tag -->
<script>
    function filterDishes(categoryId) {
        const menuItems = document.querySelectorAll('.menu-item');
        const categoryTabs = document.querySelectorAll('.category-tab');
        const noResultsMessage = document.getElementById('no-results-message');

        // Remove active class from all tabs
        categoryTabs.forEach(tab => tab.classList.remove('active'));

        // Add active class to clicked tab
        document.querySelector(`[data-category-id="${categoryId}"]`).classList.add('active');

        let visibleCount = 0;

        // Show/hide menu items based on category
        menuItems.forEach(item => {
            if (categoryId === 'all' || item.dataset.category === categoryId.toString()) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide "no results" message
        if (visibleCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
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

<!-- Add these CSS styles to your existing style tag -->
<style>
    .menu-item-simple {
        cursor: pointer;
        transition: transform 0.3s ease;
        padding: 5px;
        border-radius: 8px;
        background: transparent;
    }

    .menu-item-simple:hover {
        transform: translateY(-3px);
    }

    .menu-item-simple img {
        transition: transform 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .menu-item-simple:hover img {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .menu-item-simple h5 {
        color: #333;
        font-weight: 600;
        margin-top: 8px;
        margin-bottom: 4px;
        font-size: 0.9rem;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .menu-item-simple .price {
        color: #007bff;
        font-weight: 700;
        font-size: 1rem;
        margin-top: 4px;
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .menu-item-simple h5 {
            font-size: 0.8rem;
        }

        .menu-item-simple .price {
            font-size: 0.9rem;
            color: #007bff;
        }

        .menu-item-simple {
            padding: 3px;
        }
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border: none;
    }

    .btn-close {
        opacity: 1;
    }

    /* Animation for modal */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: scale(0.9);
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }

    /* GLightbox customization */
    .glightbox-container .gslide-description {
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 15px;
        border-radius: 8px;
    }

    /* Category tabs styling */
 

    .category-tab:hover {
        background: #007bff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .category-tab.active {
        background: #007bff;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    /* Blue Cafe text color */
    .navbar-brand .text-custom-primary {
        color: #007bff !important;
    }

    .text-custom-primary {
        color: #007bff !important;
    }
</style>
