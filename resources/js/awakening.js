import Vue from 'vue'
import axios from 'axios'
import Masonry from 'masonry-layout'
import LazyLoad from 'vanilla-lazyload'
import cozyHouse from './cozy';

new Vue({
    el: '#vue-menu',
    data: {show: false},
    methods: {
        menuToggle() {
            this.show = !this.show
        }
    },
    computed: {
        showClass() {
            return {show: this.show}
        }
    }
})

export default new Vue({
    el: '#vue-files',
    data: {
        blocks: [],
    },
    methods: {
        sendEvent(category, name, label, props) {
            cozyHouse.push(category, name, label, props)
        }
    },
    mounted() {
        new LazyLoad({
            elements_selector: '[data-src]',
        });

        if (localStorage.getItem('blocks') !== null) {
            this.blocks = JSON.parse(localStorage.getItem('blocks'))
        }

        (async () => {
            await axios.get('/internal/v1/file/blocks', {withCredentials: true}).then(({data: res}) => {
                this.blocks = res.data;
                localStorage.setItem('blocks', JSON.stringify(res.data))
            });

            new Masonry(document.querySelector('.grid'), {
                itemSelector: '.grid-item',
            });
        })();
    },
})
