<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Order Manager</h1>

    <form
      @submit.prevent="addProduct"
      class="mb-8 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
    >
      <div class="mb-4">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="productType"
        >
          Product Type
        </label>
        <select
          v-model="productType"
          id="productType"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        >
          <option value="digital">Digital</option>
          <option value="physical">Physical</option>
          <option value="subscription">Subscription</option>
        </select>
      </div>

      <div class="mb-4">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="productName"
        >
          Product Name
        </label>
        <input
          v-model="productName"
          id="productName"
          type="text"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required
        />
      </div>

      <div class="mb-4">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="productPrice"
        >
          Price
        </label>
        <input
          v-model="productPrice"
          id="productPrice"
          type="number"
          step="0.01"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required
        />
      </div>

      <div class="mb-4">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="productQuantity"
        >
          Quantity
        </label>
        <input
          v-model="productQuantity"
          id="productQuantity"
          type="number"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required
        />
      </div>

      <div v-if="productType === 'digital'" class="mb-4">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="downloadLink"
        >
          Download Link
        </label>
        <input
          v-model="downloadLink"
          id="downloadLink"
          type="url"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
      </div>

      <div v-if="productType === 'physical'" class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="weight">
          Weight
        </label>
        <input
          v-model="weight"
          id="weight"
          type="number"
          step="0.01"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
      </div>

      <div v-if="productType === 'subscription'" class="mb-4">
        <label
          class="block text-gray-700 text-sm font-bold mb-2"
          for="subscriptionDuration"
        >
          Subscription Duration (months)
        </label>
        <input
          v-model="subscriptionDuration"
          id="subscriptionDuration"
          type="number"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
      </div>

      <div class="flex items-center justify-between">
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
          Add Product
        </button>
      </div>
    </form>

    <div
      v-if="errorMessage"
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
      role="alert"
    >
      <span class="block sm:inline">{{ errorMessage }}</span>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <h2 class="text-xl font-bold mb-4">Current Order</h2>
        <ul class="mb-4">
          <li
            v-for="(product, index) in order.products"
            :key="index"
            class="border-b py-2"
          >
            {{ product.name }} - ${{ product.calculatePrice().toFixed(2) }}
          </li>
        </ul>

      <div class="text-xl font-bold">Total: ${{ orderTotal }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

import {
  Order,
  DigitalProduct,
  PhysicalProduct,
  SubscriptionProduct,
} from './orderClasses';

const order = ref(new Order());
const productType = ref('digital');
const productName = ref('');
const productPrice = ref('');
const productQuantity = ref('');
const downloadLink = ref('');
const weight = ref('');
const subscriptionDuration = ref('');
const errorMessage = ref('');

const resetForm = () => {
  productName.value = '';
  productPrice.value = '';
  productQuantity.value = '';
  downloadLink.value = '';
  weight.value = '';
  subscriptionDuration.value = '';
};

//if had more time would rewrite without using series of switch statements, maybe using factories??
const addProduct = () => {
  try {
    let product;

    const name = productName.value.trim();
    const price = parseFloat(productPrice.value);
    const quantity = parseInt(productQuantity.value);

    if (!name || isNaN(price) || isNaN(quantity)) {
      errorMessage.value = 'Please fill in all required fields correctly.';
      return;
    }

    switch (productType.value) {
      case 'digital':
        product = new DigitalProduct(name, price, quantity, downloadLink.value);
        break;
      case 'physical':
        const parsedWeight = parseFloat(weight.value);
        if (isNaN(parsedWeight)) {
          errorMessage.value = 'Please enter a valid weight.';
          return;
        }
        product = new PhysicalProduct(name, price, quantity, parsedWeight);
        break;
      case 'subscription':
        const duration = parseInt(subscriptionDuration.value);
        if (isNaN(duration)) {
          errorMessage.value = 'Please enter a valid subscription duration.';
          return;
        }
        product = new SubscriptionProduct(name, price, quantity, duration);
        break;
      default:
        errorMessage.value = 'Invalid product type selected.';
        return;
    }

    order.value.addProduct(product);
    errorMessage.value = '';
    resetForm();
  } catch (e) {
    errorMessage.value = 'An unexpected error occurred.';
    console.error(e);
  }
};

const orderTotal = computed(() => {
  return order.value.calculateTotal().toFixed(2);
});

  
</script>
