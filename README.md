This project is organised into two separate repositories:

A PHP repo (php-oop-exercise) for implementing the core order-processing domain model using object‑oriented principles.

A Vue 3 repo (vue-order-ui) for building a reactive frontend.

I kept them separated due to their own distinct setup, dependencies, and execution contexts. The Vue repo also has its own JS copy of the domain classes. I decided this was the cleanest and most maintainable approach.