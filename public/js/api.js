let vm = new Vue({
    el: '#vue-files',
    data: {
        api: '/api/v1/file/blocks',
        storage: [],
        id: null
    },
    mounted() {
        this.fetchData()
    },
    computed: {
        blocks: function () {

            if (this.id !== null) {
                clearTimeout(this.id);
                this.id = null;
            }

            this.id = setTimeout(function () {
                new Masonry(document.querySelector('.grid'), {
                    itemSelector: '.grid-item'
                });
            }, 100);

            return this.storage;
        }
    },
    methods: {
        fetchData: function () {
            if (this.api !== null) {
                fetch(this.api)
                    .then(res => res.json())
                    .then(json => {
                        this.storage.push(...json.data);
                        this.api = json.links.next;
                        this.fetchData();
                    });
            }
        }
    }
});
