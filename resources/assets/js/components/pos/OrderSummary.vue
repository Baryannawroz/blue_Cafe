<template>
    <!-- Order Summary (Desktop Only) -->
    <div class="order-summary" id="order-summary">
        <div class="order-header">
            <div class="current-table">
                <span id="current-table-display"
                    >Table:
                    <span v-if="selectedTable">{{
                        selectedTable.table_no
                    }}</span>
                    <span v-else><i>No table selected</i></span>
                </span>
                <span
                    class="change-table-btn"
                    role="button"
                    @click="tableList = !tableList"
                    >Change</span
                >
            </div>
        </div>

        <!-- Table Selection Section (Initially Hidden) -->
        <div class="table-selection" v-if="tableList">
            <h3>Select Table</h3>
            <div class="table-grid">
                <div
                    class="table-item"
                    v-for="(table, index) in tables"
                    :key="`table-${index}`"
                    :class="{ selected: table?.id === selectedTable?.id }"
                    @click="
                        selectedTable = table;
                        tableList = !tableList;
                    "
                >
                    <span class="status-indicator available"></span>
                    {{ table.table_no }}
                </div>
                <div
                    class="table-item"
                    @click="selectedTable = null"
                    :class="{ selected: selectedTable === null }"
                >
                    <span class="status-indicator available"></span>
                    No table
                </div>
            </div>
        </div>

        <div class="cart-header">
            <h3>Items</h3>
            <button
                class="clear-cart-btn"
                @click="clearCart(true)"
                v-if="carts.length > 0"
            >
                Clear All
            </button>
        </div>

        <div class="cart-items" ref="cartItemsRef">
            <div class="cart-empty" v-if="carts.length === 0">
                <p>Your cart is empty</p>
                <p style="font-size: 12px; margin-top: 8px">
                    Add items from the menu to get started
                </p>
            </div>

            <div
                class="cart-item"
                v-for="(cart, index) in carts"
                :key="index"
                :class="{ 'cart-item-new': animatingItems[cart.cartItemId] }"
            >
                <div class="cart-item-header">
                    <div class="cart-item-info">
                        <div class="cart-item-name-row">
                            <h4 class="cart-item-name">{{ cart.name }}</h4>
                            <span class="cart-item-price">
                                {{ config.currency.symbol }}{{ cart.price }}
                            </span>
                        </div>
                    </div>
                    <button
                        class="remove-btn"
                        @click="deleteProductFromCart(cart.cartItemId)"
                    >
                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="cart-item-controls">
                    <div class="quantity-controls">
                        <button
                            class="quantity-btn decrease"
                            @click="
                                updateCartItemQuantity(
                                    cart.cartItemId,
                                    cart.quantity - 1
                                )
                            "
                        >
                            <svg
                                width="12"
                                height="12"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                        <span class="item-quantity">{{ cart.quantity }}</span>
                        <button
                            class="quantity-btn increase"
                            @click="
                                updateCartItemQuantity(
                                    cart.cartItemId,
                                    cart.quantity + 1
                                )
                            "
                        >
                            <svg
                                width="12"
                                height="12"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                    </div>

                    <div class="discount-controls">
                        <label class="discount-label">Discount</label>
                        <input
                            type="number"
                            v-model="cart.discount"
                            placeholder="0"
                            class="discount-input"
                            min="0"
                            max="100"
                        />
                        <span class="discount-percent">%</span>
                    </div>

                    <div class="item-total">
                        {{ config.currency.symbol
                        }}{{ (parseFloat(cart.price || 0) * parseFloat(cart.quantity || 0)).toFixed(0) }}
                    </div>
                </div>

                <div class="cart-item-options">
                    <div class="note-section">
                        <input
                            type="text"
                            v-model="cart.note"
                            placeholder="Add note (optional)"
                            class="note-input"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Discount Section -->
        <div class="discount-section">
            <div class="discount-header">
                <label>Discount</label>
            </div>
            <div class="discount-input-group">
                <input
                    type="number"
                    v-model="discountValue"
                    placeholder="Enter discount value"
                    min="0"
                    :max="discountType === 'percentage' ? 100 : null"
                />
                <div class="discount-toggle">
                    <span
                        :class="{ active: discountType === 'percentage' }"
                        @click="discountType = 'percentage'"
                        >%</span
                    >
                    <span
                        :class="{ active: discountType === 'fixed' }"
                        @click="discountType = 'fixed'"
                        >{{ config.currency.symbol }}</span
                    >
                </div>
                <button class="apply-btn" @click="applyDiscount">Apply</button>
            </div>
        </div>

        <div class="order-totals">
            <div class="total-row">
                <span>Subtotal</span>
                <span
                    >{{ config.currency.symbol
                    }}{{ parseFloat(subTotal || 0).toFixed(2) }}</span
                >
            </div>
            <div class="total-row" v-if="discountAmount > 0">
                <span>Discount</span>
                <span
                    >-{{ config.currency.symbol
                    }}{{ parseFloat(discountAmount || 0).toFixed(2) }}</span
                >
            </div>
            <div class="total-row hidden">
                <span>Tax ({{ config.vat.vat_percentage }}%)</span>
                <span
                    >{{ config.currency.symbol
                    }}{{ parseFloat(taxAmount || 0).toFixed(2) }}</span
                >
            </div>
            <div class="total-row final">
                <span>Total</span>
                <span :class="{ 'animate-balance': isBalanceAnimating }">
                    {{ config.currency.symbol }}{{ parseFloat(finalTotal || 0).toFixed(0) }}
                </span>
            </div>
        </div>

        <div class="order-actions">
            <div class="actions-grid">
                <div class="btn btn-outline" role="button" @click="saveOrder()">
                    Save
                    <span class="shortcut-badge">F7</span>
                </div>
                <div
                    class="btn btn-outline hidden"
                    role="button"
                    @click="saveOrder(1)"
                >
                    print
                    <span class="shortcut-badge">F7</span>
                </div>
                <div
                    class="btn btn-outline"
                    role="button"
                    @click="saveOrder(2)"
                >
                    staff
                    <span class="shortcut-badge">F7</span>
                </div>
                <div
                    role="button"
                    class="btn btn-primary"
                    @click="handleOrderAction"
                >
                    <span>✓</span> Save & Pay
                    <span class="shortcut-badge">F6</span>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div class="payment-modal" v-if="isOrderModalVisible">
            <div
                class="modal-overlay"
                @click="isOrderModalVisible = false"
            ></div>
            <div class="modal-content">
                <div
                    class=""
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 5px 15px;
                        border-bottom: 1px solid #e4e4e4;
                    "
                >
                    <h3>Payment</h3>
                    <button
                        class="close-btn"
                        @click="isOrderModalVisible = false"
                    >
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <div class="payment-summary">
                        <div class="summary-row">
                            <div class="summary-label">
                                <strong>Total amount:</strong>
                            </div>
                            <div class="summary-value">
                                <strong>
                                    {{ config.currency.symbol }}
                                    {{ parseFloat(subTotal || 0).toFixed(0) }}
                                </strong>
                            </div>
                        </div>
                        <div class="summary-row" v-if="discountAmount > 0">
                            <div class="summary-label">Total discount:</div>
                            <div class="summary-value">
                                {{ config.currency.symbol
                                }}{{ parseFloat(discountAmount || 0).toFixed(2) }}
                            </div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Total tax amount:</div>
                            <div class="summary-value">
                                {{ config.currency.symbol
                                }}{{ parseFloat(taxAmount || 0).toFixed(0) }}
                            </div>
                        </div>
                        <div class="summary-row total">
                            <div class="summary-label">
                                <strong>Total payable:</strong>
                            </div>
                            <div class="summary-value">
                                <strong>
                                    {{ config.currency.symbol }}
                                    {{ parseFloat(finalTotal || 0).toFixed(0) }}
                                </strong>
                            </div>
                        </div>
                        <div
                            class="summary-row balance"
                            :class="{
                                positive: remainingBalance > 0,
                                negative: remainingBalance < 0,
                            }"
                        >
                            <div class="summary-label">
                                <strong>Due / Change: </strong>
                            </div>
                            <div class="summary-value">
                                <strong>
                                    {{ config.currency.symbol }}
                                    {{
                                        parseFloat(
                                            (finalTotal || 0) - (currentPaymentAmount || 0)
                                        ).toFixed(2)
                                    }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <!-- Add Payment -->
                    <div class="add-payment hidden">
                        <h4>Add Payment</h4>
                        <div class="payment-input">
                            <div class="input-group">
                                <span class="currency-symbol"
                                    >{{ config.currency.symbol }}
                                </span>
                                <input
                                    autofocus
                                    @keydown.enter="saveOrder(1)"
                                    type="number"
                                    v-model.number="currentPaymentAmount"
                                    placeholder="Enter amount"
                                    :max="remainingBalance"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Complete Order Button -->
                    <div class="model-footer">
                        <div style="display: flex; gap: 15px; width: 100%">
                            <button
                                class="btn btn-outline"
                                @click="saveOrder(false, true)"
                                role="button"
                            >
                                Complete Order
                            </button>
                            <button
                                class="btn btn-success btn-block"
                                @click="saveOrder(1, true)"
                                role="button"
                            >
                                Complete & Print Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import useStore from "./useStore";
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from "vue";

// Initialize store
const {
    tables,
    carts,
    discountAmount,
    currentPaymentAmount,
    subTotal,
    taxAmount,
    finalTotal,
    selectedTable,
    isOrderModalVisible,
    deleteProductFromCart,
    updateCartItemQuantity,
    config,
    clearCart,
    saveOrder,
} = useStore();

const tableList = ref(false);
const discountType = ref("percentage"); // 'percentage' or 'fixed'
const discountValue = ref(0);
const appliedDiscount = ref(0);
const isSaved = ref(false);
const cartItemsRef = ref(null);
const animatingItems = ref({}); // Track animating items by ID
const isBalanceAnimating = ref(false);
const showClearConfirm = ref(false);
const remainingBalance = ref(0);

const payments = ref([]);

// Compute the action button text
const orderActionText = computed(() => {
    return isSaved.value ? "Pay Now" : "Save & Pay";
});

// Apply discount function
const applyDiscount = () => {
    const previousTotal = finalTotal.value;

    if (discountType.value === "percentage") {
        const percentage = Math.min(parseFloat(discountValue.value) || 0, 100);
        discountAmount.value =
            Math.floor((subTotal.value * percentage) / 100 / 250) * 250;
        appliedDiscount.value = percentage;
    } else {
        const amount = Math.min(
            parseFloat(discountValue.value) || 0,
            subTotal.value
        );
        discountAmount.value = amount;
        appliedDiscount.value = amount;
    }

    // Animate balance if it changed
    if (previousTotal !== finalTotal.value) {
        animateBalance();
    }
};

// Handle order action (Save & Pay or Pay Now)
const handleOrderAction = async () => {
    try {
        if (!isSaved.value) {
            // Save order logic here
            isSaved.value = true;
            // Additional save logic...
        }

        // Show payment modal
        isOrderModalVisible.value = true;
    } catch (error) {
        console.error("Error handling order action:", error);
        // Show error toast or handle gracefully
    }
};

// Function to handle keyboard shortcuts
const handleKeyboardShortcut = (event) => {
    // F2 key for payment (F1 is usually help, so we avoid that)
    if (event.key === "F6") {
        handleOrderAction();
        event.preventDefault(); // Prevent default browser action
    }

    if (event.key === "F7") {
        saveOrder();
        event.preventDefault();
    }
};

// Set up keyboard event listeners when component is mounted
onMounted(() => {
    window.addEventListener("keydown", handleKeyboardShortcut);
});

// Clean up event listeners when component is unmounted
onUnmounted(() => {
    window.removeEventListener("keydown", handleKeyboardShortcut);
});

// Auto-scroll cart items to bottom when items are added or modified
const scrollToBottom = () => {
    if (cartItemsRef.value && cartItemsRef.value.scrollHeight !== undefined) {
        nextTick(() => {
            if (cartItemsRef.value && cartItemsRef.value.scrollHeight !== undefined) {
                cartItemsRef.value.scrollTop = cartItemsRef.value.scrollHeight;
            }
        });
    }
};

// Function to add animation class to new cart items
const animateNewCartItem = (cartItemId) => {
    animatingItems.value[cartItemId] = true;
    setTimeout(() => {
        animatingItems.value[cartItemId] = false;
    }, 500); // Match animation duration
};

// Function to animate balance changes
const animateBalance = () => {
    isBalanceAnimating.value = true;
    setTimeout(() => {
        isBalanceAnimating.value = false;
    }, 700); // Match animation duration
};

// Watch for changes in the cart and handle animations and scrolling
const previousCartLength = ref(carts.value.length);
watch(
    () => carts.value.length,
    (newLength, oldLength) => {
        // Check if cart length increased (new item added)
        if (newLength > previousCartLength.value) {
            // Get the last item (newly added)
            const newItem = carts.value[carts.value.length - 1];
            animateNewCartItem(newItem.cartItemId);
            animateBalance();
        } else if (newLength !== previousCartLength.value) {
            // Cart item was removed
            animateBalance();
        }

        previousCartLength.value = newLength;
        scrollToBottom();
    }
);

// Watch for cart content changes (quantities, prices, etc.)
watch(
    () =>
        carts.value.map((item) => ({
            id: item.cartItemId,
            quantity: item.quantity,
            price: item.price,
            discount: item.discount,
        })),
    () => {
        animateBalance();
    },
    { deep: true }
);
</script>

<style scoped>
/* Order Summary */
.order-summary {
    width: 100% !important;
    max-width: 500px;
    background-color: white;
    border-left: 1px solid #e0e0e0;
    display: flex;
    flex-direction: column;
}

.order-header {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.current-table {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.change-table-btn {
    font-size: 14px;
    font-weight: normal;
    color: #3498db;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 4px;
}

.change-table-btn:hover {
    background-color: #f0f7fc;
}

.table-selection {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
    display: block;
}

.table-selection h3 {
    margin-bottom: 10px;
    font-size: 16px;
}

.table-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.table-item {
    padding: 8px;
    border: 1px solid #eee;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    font-size: 14px;
}

.table-item.selected {
    background-color: #e8f4fd;
    border-color: #3498db;
}

.table-item .status-indicator {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 4px;
}

.status-indicator.available {
    background-color: #2ecc71;
}

.status-indicator.occupied {
    background-color: #e74c3c;
}

.status-indicator.reserved {
    background-color: #f39c12;
}

.order-header p {
    font-size: 14px;
    color: #666;
}

.cart-items {
    overflow-y: auto;
    flex-grow: 1;
    height: calc(100vh - 600px); /* Adjusted for discount section */
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    border-bottom: 1px solid #e0e0e0;
    background-color: #f9f9f9;
}

.cart-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}

.clear-cart-btn {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px 8px;
    font-size: 12px;
    color: #e74c3c;
    cursor: pointer;
    transition: all 0.2s;
}

.clear-cart-btn:hover {
    background-color: #fee;
    border-color: #e74c3c;
}

.cart-empty {
    padding: 30px;
    text-align: center;
    color: #888;
}

.cart-item {
    background: #ffffff;
    border: 1px solid #e1e5e9;
    border-radius: 8px;
    margin-bottom: 8px;
    padding: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    animation-duration: 0.5s;
}

.cart-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.cart-item-new {
    animation-name: highlight-new-item;
}

@keyframes highlight-new-item {
    0% {
        background-color: rgba(52, 152, 219, 0.2);
        transform: translateX(-5px);
    }
    50% {
        background-color: rgba(52, 152, 219, 0.1);
    }
    100% {
        background-color: transparent;
        transform: translateX(0);
    }
}

.cart-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
}

.cart-item-info {
    flex: 1;
}

.cart-item-name-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.cart-item-name {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    line-height: 1.2;
    flex: 1;
}

.cart-item-price {
    font-size: 12px;
    color: #718096;
    font-weight: 500;
    background: #f7fafc;
    padding: 2px 6px;
    border-radius: 4px;
    white-space: nowrap;
    margin-right: 10px;
}

.cart-item-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    padding: 6px 0;
    border-top: 1px solid #f7fafc;
    border-bottom: 1px solid #f7fafc;
    gap: 12px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 6px;
}

.quantity-btn {
    width: 28px;
    height: 28px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    color: #4a5568;
}

.quantity-btn:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: scale(1.05);
}

.quantity-btn.decrease:hover {
    background: #fed7d7;
    border-color: #feb2b2;
    color: #e53e3e;
}

.quantity-btn.increase:hover {
    background: #c6f6d5;
    border-color: #9ae6b4;
    color: #38a169;
}

.item-quantity {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    min-width: 20px;
    text-align: center;
}

.item-total {
    font-size: 14px;
    font-weight: 700;
    color: #2d3748;
    background: #f7fafc;
    padding: 4px 8px;
    border-radius: 4px;
}

.remove-btn {
    width: 28px;
    height: 28px;
    border: none;
    background: #fed7d7;
    border-radius: 6px;
    cursor: pointer;
    color: #e53e3e;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.remove-btn:hover {
    background: #feb2b2;
    transform: scale(1.1);
}

.cart-item-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.note-section {
    width: 100%;
}

.note-input {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    background: #f7fafc;
    transition: all 0.2s ease;
}

.note-input:focus {
    outline: none;
    border-color: #4299e1;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.discount-section {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.discount-label {
    font-size: 10px;
    font-weight: 600;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.discount-controls {
    display: flex;
    align-items: center;
    gap: 4px;
    flex: 1;
    justify-content: center;
}

.discount-input {
    width: 50px;
    padding: 4px 6px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    font-size: 12px;
    text-align: center;
    background: #f7fafc;
    transition: all 0.2s ease;
}

.discount-input:focus {
    outline: none;
    border-color: #4299e1;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.discount-percent {
    font-size: 12px;
    font-weight: 600;
    color: #4a5568;
}

.discount-preview {
    font-size: 12px;
    font-weight: 600;
    color: #38a169;
    background: #c6f6d5;
    padding: 3px 6px;
    border-radius: 3px;
    margin-left: auto;
}

/* Discount Section */
.discount-section {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
}

.discount-header {
    margin-bottom: 10px;
}

.discount-header label {
    font-weight: 500;
    font-size: 15px;
    color: #333;
}

.discount-input-group {
    display: flex;
    align-items: center;
    gap: 5px;
}

.discount-input-group input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    outline: none;
}

.discount-toggle {
    display: flex;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
}

.discount-toggle span {
    padding: 8px 12px;
    background-color: #f9f9f9;
    cursor: pointer;
    font-size: 14px;
}

.discount-toggle span.active {
    background-color: #e8f4fd;
    color: #3498db;
}

.apply-btn {
    padding: 8px 12px;
    background-color: #3498db;
    color: white;
    border: none;
    cursor: pointer;
}

.order-totals {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.total-row.final {
    margin-top: 12px;
    font-weight: 600;
    font-size: 16px;
}

.animate-balance {
    animation: balance-change 0.7s ease;
}

@keyframes balance-change {
    0% {
        color: #2ecc71;
        transform: scale(1.1);
    }
    100% {
        color: inherit;
        transform: scale(1);
    }
}

.order-actions {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
}

.actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 10px;
}

.btn {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
}

.btn-outline {
    background-color: white;
    color: #333;
}

.btn-primary {
    background-color: #3498db;
    color: white;
    border-color: #3498db;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-primary span {
    margin-right: 6px;
}

.shortcut-badge {
    background-color: rgba(255, 255, 255, 0.2);
    padding: 2px 5px;
    border-radius: 3px;
    font-size: 11px;
    margin-left: 8px;
}

/* Payment Modal Styles */
.payment-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    border-radius: 8px;
    width: 450px;
    max-width: 90%;
    max-height: 90vh;
    position: relative;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    z-index: 1001;
    overflow-y: auto;
}

.modal-header {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    /* top: 0; */
    background-color: white;
    z-index: 2;
}

.modal-header h3 {
    margin: 0;
    font-size: 18px;
}

.close-btn {
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    color: #666;
}

.modal-body {
    padding: 20px;
}

/* Payment Summary */
.payment-summary {
    margin-bottom: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 15px;
    background-color: #f9f9f9;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.summary-row.total {
    border-top: 1px solid #e0e0e0;
    margin-top: 10px;
    padding-top: 10px;
}

.summary-row.balance {
    margin-top: 10px;
    font-size: 18px;
}

.summary-row.positive .summary-value {
    color: #e74c3c; /* Red for due amount */
}

.summary-row.negative .summary-value {
    color: #2ecc71; /* Green for change/excess payment */
}

/* Payments Made */
.payments-made {
    margin-bottom: 20px;
}

.payments-made h4 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 16px;
}

.payment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f5f5f5;
    border-radius: 4px;
    margin-bottom: 8px;
}

.payment-info {
    display: flex;
    justify-content: space-between;
    flex-grow: 1;
    margin-right: 10px;
}

.remove-payment-btn {
    background: none;
    border: none;
    color: #e74c3c;
    font-size: 18px;
    cursor: pointer;
    padding: 0 5px;
}

/* Add Payment */
.add-payment {
    margin-bottom: 20px;
}

.add-payment h4 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 16px;
}

.payment-input {
    margin-bottom: 15px;
}

.input-group {
    display: flex;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
}

.currency-symbol {
    background-color: #f9f9f9;
    padding: 8px 12px;
    border-right: 1px solid #ddd;
    font-weight: 500;
}

.input-group input {
    flex-grow: 1;
    padding: 8px;
    border: none;
    outline: none;
    font-size: 16px;
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.payment-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 10px;
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.payment-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.payment-btn:not(:disabled):hover {
    transform: translateY(-2px);
}

.method-icon {
    font-size: 20px;
    margin-bottom: 5px;
}

/* Complete Order */
.complete-order {
    margin-top: 20px;
}

.complete-btn {
    width: 100%;
    padding: 12px;
    background-color: #2ecc71;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.complete-btn:hover {
    background-color: #27ae60;
}

.modal-footer {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
    text-align: right;
    position: sticky;
    bottom: 0;
    background-color: white;
    z-index: 2;
}
.w-90 {
    width: 90%;
}
</style>
