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
        users: ref([]),
        discountAmount: ref(0),
        currentPaymentAmount: ref(''),
        updateOrder: ref(null),
        selectedTable: ref(null),
        selectedUser: ref(null),
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
            const total = state.carts.value.reduce((total, item) => {
                const price = parseFloat(item.price || 0);
                const discount = parseFloat(item.discount || 0);
                const quantity = parseFloat(item.quantity || 0);
                return total + (Math.ceil((price - price * discount / 100) / 250) * 250 * quantity);
            }, 0);
            return isNaN(total) ? 0 : total;
        }),

        taxAmount: computed(() => {
            const subTotal = getters.subTotal.value || 0;
            const discount = parseFloat(state.discountAmount.value || 0);
            const afterDiscountAmount = subTotal - discount;
            const vatPercentage = parseFloat(state.config.value.vat?.vat_percentage || 0);
            const tax = afterDiscountAmount * (vatPercentage / 100);
            return isNaN(tax) ? 0 : tax;
        }),

        finalTotal: computed(() => {
            const subTotal = getters.subTotal.value || 0;
            const discount = parseFloat(state.discountAmount.value || 0);
            const tax = getters.taxAmount.value || 0;
            const total = subTotal - discount + tax;
            return isNaN(total) ? 0 : total;
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

        async fetchUsers() {
            try {
                console.log('Starting to fetch users...');
                state.isLoading.value = true;
                const response = await axios.get('/web-api/users');
                console.log('Users API response:', response);
                console.log('Users data:', response.data);
                state.users.value = response.data;
                console.log('Users state updated:', state.users.value);
            } catch (err) {
                console.error('Error fetching users:', err);
                console.error('Error details:', err.response);
                actions.showToast("Failed to load users", 3000);
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
                    note: item.note,
                    discount: item.discount,
                    image: item.dish?.thumbnail,
                    is_printed: Boolean(item.is_printed)
                }));

                state.carts.value = order;
                if (response.data?.table_id && state.tables.value.length > 0) {
                    state.selectedTable.value = state.tables.value.find(el => el.id == response.data.table_id) || null;
                }

                // Set the selected user based on served_by information
                if (response.data?.served_by && state.users.value.length > 0) {
                    console.log('Setting user from order record:', response.data.served_by);
                    // Handle both cases: served_by as object or as integer ID
                    const servedById = response.data.served_by.id || response.data.served_by;
                    const user = state.users.value.find(el => el.id == servedById);
                    if (user) {
                        state.selectedUser.value = user;
                        console.log('User set to:', user);
                    } else {
                        console.warn('User not found in available users:', servedById);
                    }
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

        setSelectedUserById(userId) {
            console.log('setSelectedUserById called with userId:', userId);
            console.log('Available users:', state.users.value);
            console.log('Users length:', state.users.value.length);

            if (!state.users.value.length) {
                console.warn('Users not loaded yet');
                return false;
            }

            const user = state.users.value.find(u => u.id === userId);
            console.log('Found user:', user);
            if (user) {
                state.selectedUser.value = user;
                console.log('Selected user set to:', state.selectedUser.value);
                return true;
            }

            console.warn(`User with ID ${userId} not found`);
            return false;
        },

        clearSelectedUser() {
            state.selectedUser.value = null;
        },

        addProductToCart(product, selectedVariant = null) {
            const variant = selectedVariant || product.dish_prices[0];
            const existingIndex = state.carts.value.findIndex(item =>
                item.productId === product.id && item.variantId === variant.id && item.is_printed === false
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
                    image: product.thumbnail,
                    note: ``,
                    discount:0,
                    is_printed: false,

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

        clearCart(clear=false) {

if (clear) {

    fetch(`/table/deleteOrderId/${state.selectedTable.value.id}`, {
        method: 'GET',
    })
    .then(response => {
    if (!response.ok) throw new Error('Failed to delete order');
    return response.json();
})
.then(data => {
    if (data.status === 'success') {
        actions.showToast("Order deleted successfully");
        // Optional: refresh table or update UI here
    } else {
        actions.showToast("Failed to delete order");
    }
})
.catch(error => {
    console.error(error);
    actions.showToast("Error deleting table order");
});
}

    state.carts.value = [];
    state.discountAmount.value = 0;
    state.currentPaymentAmount.value = '';
    actions.showToast("Table order deleted");
}
,

        async saveOrder(shouldPrint = false, orderComplete = false) {

const total = state.carts.value.reduce((sum, item) => {
  return sum + (item.price * item.quantity);
}, 0);


            const orderData = {
                table_id: state.selectedTable.value?.id || null,
                served_by: state.selectedUser.value?.id || null,
                payment:orderComplete ? total : state.currentPaymentAmount.value || null,
                vat: getters.taxAmount.value || 0,
                change_amount: state.currentPaymentAmount.value ?
                    (getters.finalTotal.value - state.currentPaymentAmount.value) : 0,
                discount_amount: state.discountAmount.value || 0,
                items: state.carts.value.map(item => ({
                    dish_id: item.productId,
                    dish_type_id: item.variantId,
                    quantity: item.quantity,
                    net_price: item.price,
                    note: item.note,
                    discount: item.discount,
                    gross_price: item.price * item.quantity,
                    is_printed: item.is_printed,
                }))
            };
            console.log('Order data being sent:', orderData);
            console.log('Selected user:', state.selectedUser.value);
            console.log('Served by ID:', state.selectedUser.value?.id);


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
                    // For staff button, start printing and redirect after a short delay
                    if (shouldPrint === 2) {
                        actions.printInvoice(response.data.id, shouldPrint);
                        // Redirect after a short delay to allow printing to start
                        setTimeout(() => {
                            window.location.href = '/order';
                        }, 2000);
                    } else if (orderComplete) {
                        // For complete & print order, start printing and redirect after a short delay
                        actions.printInvoice(response.data.id, shouldPrint);
                        setTimeout(() => {
                            window.location.href = '/order';
                        }, 2000);
                    } else {
                        await actions.printInvoice(response.data.id, shouldPrint);
                    }
                }

                // Redirect to order page for complete order actions (without printing)
                if (orderComplete && !shouldPrint) {
                    setTimeout(() => {
                        window.location.href = '/order';
                    }, 1000);
                }

                // Redirect to order page for regular save button as well
                if (!shouldPrint && !orderComplete) {
                    setTimeout(() => {
                        window.location.href = '/order';
                    }, 1000);
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

        async printInvoice(orderId, shouldPrint) {
                        console.log(shouldPrint);

            if (!orderId) {
                actions.showToast("Cannot print receipt: Order ID is missing", 3000);
                return;
            }

            try {
                state.isPrinting.value = true;
                const response = await axios.get(`/print-order${shouldPrint == 2 ? '-staff':''}/${orderId}`, {
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
                    actions.fetchProducts(),
                    actions.fetchTables(),
                    actions.fetchConfig(),
                    actions.fetchDishCategories(),
                    actions.fetchUsers()
                ]);

                // Set initial table from URL parameter or default
                const urlParams = new URLSearchParams(window.location.search);
                const tableIdParam = urlParams.get('table_id') || window.initialSelectedTableId || window.table_id;

                if (tableIdParam) {
                    actions.setSelectedTableById(Number(tableIdParam));
                }

                // Set authenticated user as default selected user
                console.log('Setting authenticated user as default:', window.authUser);
                if (window.authUser && window.authUser.id) {
                    console.log('Auth user ID:', window.authUser.id);
                    console.log('Available users:', state.users.value);
                    const userSet = actions.setSelectedUserById(window.authUser.id);
                    if (!userSet) {
                        console.warn('Failed to set authenticated user, retrying...');
                        // Retry after a short delay
                        setTimeout(() => {
                            console.log('Retrying to set authenticated user...');
                            actions.setSelectedUserById(window.authUser.id);
                        }, 100);
                    } else {
                        console.log('Successfully set authenticated user as default');
                    }
                } else {
                    console.warn('No authenticated user found in window.authUser:', window.authUser);
                }

                if (window.editOrderId) {
                    await actions.fetchOrderById();
                }

                state.initialized.value = true;
            } catch (error) {
                console.error('Store initialization failed:', error);
                actions.showToast("Failed to initialize application", 3000);
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
