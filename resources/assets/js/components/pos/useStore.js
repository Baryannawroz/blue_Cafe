import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

// Default configuration constants
const DEFAULT_CONFIG = {
    hasInstall: "1",
    currency: {
        symbol: "IQD",
        currency: "IQD"
    },
    vat: {
        vat_number: "123456",
        vat_percentage: "5"
    },
    contact: {
        phone: "01738070062",
        address: "Address"
    }
};

// Create the store instance
const createStore = () => {
    // Reactive state
    const state = {
        config: ref(DEFAULT_CONFIG),
        carts: ref([]),
        tables: ref([]),
        products: ref([]),
        productCategories: ref([]),
        discountAmount: ref(0),
        currentPaymentAmount: ref(''),
        updateOrder: ref(null),
        selectedTable: ref(null),
        searchString: ref(''),
        isOrderModalVisible: ref(false),
        toastMessage: ref(''),
        isToastVisible: ref(false),
        isLoading: ref(false),
        isPrinting: ref(false),
        initialized: ref(false),
        toastTimer: ref(null)
    };

    // Computed properties
    const getters = {
        subTotal: computed(() => {
            return state.carts.value.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        }),

        taxAmount: computed(() => {
            const afterDiscountAmount = getters.subTotal.value - state.discountAmount.value;
            return afterDiscountAmount * (parseInt(state.config.value.vat.vat_percentage) / 100);
        }),

        finalTotal: computed(() => {
            return getters.subTotal.value - state.discountAmount.value + getters.taxAmount.value;
        }),

        filteredProducts: computed(() => {
            if (!state.searchString.value) return state.products.value;
            return state.products.value.filter(product =>
                product.dish.toLowerCase().includes(state.searchString.value.toLowerCase())
            );
        }),

        cartItemCount: computed(() => {
            return state.carts.value.reduce((count, item) => count + item.quantity, 0);
        }),

        availableTables: computed(() => {
            return state.tables.value.filter(table => table.status === 'available');
        }),

        occupiedTables: computed(() => {
            return state.tables.value.filter(table => table.status === 'occupied');
        })
    };

    // Actions
    const actions = {
        async fetchProducts() {
            try {
                state.isLoading.value = true;
                const response = await axios.get('/web-api/dishes');
                state.products.value = response.data;
            } catch (err) {
                console.error('Error fetching products:', err);
                actions.showToast("Failed to load products", 3000);
            } finally {
                state.isLoading.value = false;
            }
        },

        async fetchTables() {
            try {
                state.isLoading.value = true;
                const response = await axios.get('/web-api/tables');
                state.tables.value = response.data;
            } catch (err) {
                console.error('Error fetching tables:', err);
                actions.showToast("Failed to load tables", 3000);
            } finally {
                state.isLoading.value = false;
            }
        },

        async fetchDishCategories() {
            try {
                state.isLoading.value = true;
                const response = await axios.get('/web-api/dish-categories');
                state.productCategories.value = response.data;
            } catch (err) {
                console.error('Error fetching product categories:', err);
            } finally {
                state.isLoading.value = false;
            }
        },

        async fetchConfig() {
            try {
                const response = await axios.get('/web-api/config');
                state.config.value = response.data;
            } catch (err) {
                console.error('Error fetching config:', err);
                state.config.value = DEFAULT_CONFIG;
            }
        },

        async fetchOrderById() {
            if (!window.editOrderId) return;

            try {
                state.isLoading.value = true;
                const response = await axios.get(`/get-order-details/${window.editOrderId}`);
                state.updateOrder.value = response.data;

                const order = response.data.order_details.map((item) => ({
                    cartItemId: item.id,
                    productId: item.dish_id,
                    variantId: item.dish_type_id,
                    name: item.dish?.dish,
                    variantName: item.dish_type?.dish_type,
                    price: item.dish_type?.price,
                    quantity: item.quantity,
                    image: item.dish?.thumbnail
                }));

                state.carts.value = order;

                if (response.data?.table_id && state.tables.value.length > 0) {
                    state.selectedTable.value = state.tables.value.find(el => el.id === response.data.table_id) || null;
                }

                state.discountAmount.value = response.data.discount || 0;
            } catch (err) {
                console.error('Error fetching order details:', err);
                actions.showToast("Failed to load order details", 3000);
            } finally {
                state.isLoading.value = false;
            }
        },

        setSelectedTableById(tableId) {
            if (!state.tables.value.length) {
                console.warn('Tables not loaded yet');
                return false;
            }

            const table = state.tables.value.find(t => t.id === tableId);
            if (table) {
                state.selectedTable.value = table;
                return true;
            }

            console.warn(`Table with ID ${tableId} not found`);
            return false;
        },

        clearSelectedTable() {
            state.selectedTable.value = null;
        },

        addProductToCart(product, selectedVariant = null) {
            const variant = selectedVariant || product.dish_prices[0];
            const existingIndex = state.carts.value.findIndex(item =>
                item.productId === product.id && item.variantId === variant.id
            );

            if (existingIndex !== -1) {
                state.carts.value[existingIndex].quantity += 1;
            } else {
                state.carts.value.push({
                    cartItemId: Date.now(),
                    productId: product.id,
                    variantId: variant.id,
                    name: product.dish,
                    variantName: variant.dish_type,
                    price: variant.price,
                    quantity: 1,
                    image: product.thumbnail
                });
            }
            actions.showToast(`${product.dish} added to cart`);
        },

        updateCartItemQuantity(cartItemId, newQuantity) {
            const index = state.carts.value.findIndex(item => item.cartItemId === cartItemId);
            if (index !== -1) {
                if (newQuantity <= 0) {
                    state.carts.value.splice(index, 1);
                } else {
                    state.carts.value[index].quantity = newQuantity;
                }
            }
        },

        deleteProductFromCart(cartItemId) {
            const index = state.carts.value.findIndex(item => item.cartItemId === cartItemId);
            if (index !== -1) {
                const [deletedItem] = state.carts.value.splice(index, 1);
                actions.showToast(`${deletedItem.name} removed from cart`);
            }
        },

        clearCart() {
            state.carts.value = [];
            state.discountAmount.value = 0;
            state.currentPaymentAmount.value = '';
            actions.showToast("Cart cleared");
        },

        async saveOrder(shouldPrint = false) {
            if (state.carts.value.length === 0) {
                actions.showToast("Cannot save empty order", 3000);
                return;
            }

            const orderData = {
                table_id: state.selectedTable.value?.id || null,
                payment: state.currentPaymentAmount.value || null,
                vat: getters.taxAmount.value || 0,
                change_amount: state.currentPaymentAmount.value ?
                    (getters.finalTotal.value - state.currentPaymentAmount.value) : 0,
                discount_amount: state.discountAmount.value || 0,
                items: state.carts.value.map(item => ({
                    dish_id: item.productId,
                    dish_type_id: item.variantId,
                    quantity: item.quantity,
                    net_price: item.price,
                    gross_price: item.price * item.quantity,
                }))
            };

            try {
                state.isLoading.value = true;
                let response;

                if (window.editOrderId) {
                    response = await axios.put(`/update-order/${window.editOrderId}`, orderData);
                    actions.showToast("Order updated successfully");
                } else {
                    response = await axios.post('/save-order', orderData);
                    actions.clearCart();
                    actions.showToast("Order saved successfully");
                }

                state.isOrderModalVisible.value = false;

                if (shouldPrint && response.data.id) {
                    await actions.printInvoice(response.data.id);
                }

                return response.data;
            } catch (err) {
                console.error('Error saving order:', err);
                actions.showToast("Error saving order. Please try again.", 3000);
                throw err;
            } finally {
                state.isLoading.value = false;
            }
        },

        async printInvoice(orderId) {
            if (!orderId) {
                actions.showToast("Cannot print receipt: Order ID is missing", 3000);
                return;
            }

            try {
                state.isPrinting.value = true;
                const response = await axios.get(`/print-order/${orderId}`, {
                    responseType: 'text'
                });

                const printWindow = window.open('', '_blank', 'width=800,height=600');
                if (!printWindow) {
                    actions.showToast("Please allow pop-ups to print receipt", 3000);
                    return;
                }

                printWindow.document.write(response.data);
                printWindow.document.close();

                await new Promise(resolve => {
                    printWindow.onload = () => {
                        printWindow.focus();
                        setTimeout(() => {
                            printWindow.print();
                            if ('onafterprint' in printWindow) {
                                printWindow.onafterprint = () => {
                                    printWindow.close();
                                    resolve();
                                };
                            } else {
                                setTimeout(() => {
                                    printWindow.close();
                                    resolve();
                                }, 1000);
                            }
                        }, 500);
                    };
                });
            } catch (error) {
                console.error('Error printing invoice:', error);
                actions.showToast("Error printing receipt", 3000);
            } finally {
                state.isPrinting.value = false;
            }
        },

        showToast(message, duration = 3000) {
            state.toastMessage.value = message;
            state.isToastVisible.value = true;

            if (state.toastTimer) clearTimeout(state.toastTimer);
            state.toastTimer = setTimeout(() => {
                state.isToastVisible.value = false;
            }, duration);
        },

        async initializeStore() {
            if (state.initialized.value) return;

            try {
                state.isLoading.value = true;
                await Promise.all([
                    this.fetchProducts(),
                    this.fetchTables(),
                    this.fetchConfig(),
                    this.fetchDishCategories()
                ]);

                // Set initial table from URL parameter or default
                const urlParams = new URLSearchParams(window.location.search);
                const tableIdParam = urlParams.get('table_id') || window.initialSelectedTableId || window.table_id;

                if (tableIdParam) {
                    this.setSelectedTableById(Number(tableIdParam));
                }

                if (window.editOrderId) {
                    await this.fetchOrderById();
                }

                state.initialized.value = true;
            } catch (error) {
                console.error('Store initialization failed:', error);
                this.showToast("Failed to initialize application", 3000);
            } finally {
                state.isLoading.value = false;
            }
        }
    };

    return {
        // State
        ...state,
        // Getters
        ...getters,
        // Actions
        ...actions
    };
};

// Singleton pattern
let storeInstance;

export default function useStore() {
    if (!storeInstance) {
        storeInstance = createStore();
    }

    // Initialize on first use
    onMounted(() => {
        storeInstance.initializeStore();
    });

    return storeInstance;
}
