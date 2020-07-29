import Vue from 'vue'
import axios from 'axios'
import Masonry from 'masonry-layout'
import LazyLoad from 'vanilla-lazyload'
import cozyHouse from './cozy';

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

        (async () => {
            await axios.get('/api/v1/file/blocks', {withCredentials: true}).then(({data: res}) => {
                this.blocks = res.data;
            });

            new Masonry(document.querySelector('.grid'), {
                itemSelector: '.grid-item',
            });
        })();
    },
})
