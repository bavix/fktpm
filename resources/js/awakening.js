import Vue from 'vue'
import axios from 'axios'
import Masonry from 'masonry-layout'
import LazyLoad from 'vanilla-lazyload'

export default new Vue({
    el: '#vue-files',
    data: {
        blocks: [],
    },
    mounted() {
        new LazyLoad({
            elements_selector: '[data-src]',
        });

        (async () => {
            await axios.get('/api/v1/file/blocks').then(({data: res}) => {
                this.blocks = res.data;
            });

            new Masonry(document.querySelector('.grid'), {
                itemSelector: '.grid-item',
            });
        })();
    },
})
