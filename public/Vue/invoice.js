const {
    createApp,
    ref
} = Vue

createApp({
    setup() {
        const products = ref([]);

        function addProduct() {
            products.value.push({
                name:'posi'
            });
            
        }

        function removeProduct(product){
            console.log(product);
        }


        return {
            products,
            addProduct,
            removeProduct
        }
    }
}).mount('#app')