<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./main.css">
    <title>VueJS - Fundamentals</title>
</head>

<body>
    <div id="shopping-list">
        <div class="header">
            <h1>{{ header.toLocaleUpperCase() }}</h1>
            <button v-if="state === 'default'" class="btn btn-primary" @click="changeState('edit')">Add Item</button>
            <button v-else class="btn btn-cancel" @click="changeState('default')">Cancel</button>
        </div>
        <div v-if="state === 'edit'" class="add-item-form">
            <input v-model="newItem" type="text" placeholder="Add a New Item" @keyup.enter="saveItem" />
            <button class="btn btn-primary" v-bind:disabled="newItem.length === 0" @click="saveItem">Save Item</button>
        </div>
        <ul>
            <li v-for="item in reversedItems" :class="{strikeout: item.purchased}" @click="togglePurchased(item)">{{
                item.label }}</li>
        </ul>
        <p v-if="items.length === 0">Nice Job! You have purchased all required items.</p>
    </div>
    <script src="https://unpkg.com/vue"></script>
    <script>
        var shoppingList = new Vue({
            el: '#shopping-list',
            data: {
                state: 'default',
                header: 'Shopping List App',
                newItem: '',
                items: []
            },
            computed: {
                reversedItems() {
                    return this.items.slice(0).reverse();
                }
            },
            methods: {
                saveItem: function () {
                    this.items.push({
                        label: this.newItem,
                        purchased: false,
                    }, );
                    this.newItem = '';
                },
                changeState: function (newState) {
                    this.state = newState;
                    this.newItem = '';
                },
                togglePurchased: function (item) {
                    item.purchased = !item.purchased;
                }
            },
            watch: {
                items: {
                    handler: function () {
                        
                        var remaining = 0;

                        this.items.forEach(item => {
                            if (item.purchased === false) {
                                remaining++;
                            }
                        });

                        if (remaining === 0 && this.items.length > 0) {
                            this.items = [];
                            return this.state = 'default';
                        }
                    },
                    deep: true
                }
            },
        });
    </script>
</body>

</html>