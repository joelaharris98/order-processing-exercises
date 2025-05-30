class Product {
    constructor(name, price, quantity) {
      this.name = name;
      this.price = price;
      this.quantity = quantity;
    }
  
    calculatePrice() {
      return this.price * this.quantity;
    }
  }
  
  class DigitalProduct extends Product {
    constructor(name, price, quantity, downloadLink) {
      super(name, price, quantity);
      this.downloadLink = downloadLink;
    }

  }
  
  class PhysicalProduct extends Product {
    constructor(name, price, quantity, weight) {
      super(name, price, quantity);
      this.weight = weight;
    }
  
    calculatePrice() {
      return this.price * this.quantity * this.weight;
    }
  }
  
  class SubscriptionProduct extends Product {
    constructor(name, price, quantity, subscriptionDuration) {
      super(name, price, quantity);
      this.subscriptionDuration = subscriptionDuration;
    }

    calculatePrice() {
      return this.price * this.quantity * this.subscriptionDuration;
    }
  }
  
  // Order class
  class Order {
    constructor() {
      this.products = [];
    }
  
    addProduct(product) {
      this.products.push(product);
    }
  
    calculateTotal() {
      return this.products.reduce(
        (total, product) => total + product.calculatePrice(),
        0
      );
    }
  }
  
  export { Order, Product, DigitalProduct, PhysicalProduct, SubscriptionProduct };
  