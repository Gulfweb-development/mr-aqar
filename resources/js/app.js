import Vue from 'vue';
import Card from './../components/Card.vue';
import Search from './../components/Search.vue';
import axios from 'axios';
import VueSnip from 'vue-snip'

window.Vue = require('vue');

window.url = '/api/v1/';
window.axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-localization'] = document.getElementById("app").getAttribute('data-locale');


Vue.use(VueSnip)

var filter = function(text, length, clamp){
    clamp = clamp || '...';
    var node = document.createElement('div');
    node.innerHTML = text;
    var content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
};
Vue.filter('truncate', filter);

var filter = function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
Vue.filter('commaSeparate', filter);

new Vue({
    el: '#app',
    data () {
        return {
            cards: [],
            searchVariables: {},
            page: 1,
            maxPage: null,
            isLoading: null,
            companyId: 0,
            isRequiredPage: 0,
            notFound: false,
            newAds: false,
            count: null,
        }
    },
    components: {
        Card,
        Search
    },
    methods: {
        getAds() {
            this.isLoading = true ;
            var searchData = this.searchVariables;
            searchData.company_id = this.companyId;
            searchData.isRequiredPage = this.isRequiredPage;


            axios
                .post(window.url + `search-advertising?page=${this.page}`, searchData )
                .then(response => {
                    this.maxPage = response.data.data.last_page;
                    this.nothingFound(response);
                    this.count = response.data.data.total;
                    if (this.$refs.search)
                        this.$refs.search.changeSearchTitle()
                    this.cards.push(...response.data.data.data);
                    this.isLoading = false ;
                })
        },
        pageEnd() {
            if ( this.page < this.maxPage && ! this.isLoading ) {
                this.page++;
                if (this.newAds)
                    this.nothingFound('')
                else
                this.getAds();
            }
        },
        nothingFound(response) {
            if (response === '' ||
                (response.data.data.current_page === 1 && response.data.data.data.length === 0)
            ) {
                this.notFound = true;

                if (! this.companyId)
                    this.getLatestAds()
            }
        },
        reset(){
            this.notFound = false;
            this.cards = [];
            this.page = 1;
            this.maxPage = null;
            this.newAds = false;
        },
        getLatestAds() {
            this.isLoading = true ;
            axios
                .post(window.url + `search-advertising?page=${this.page}`, {
                    area_id : [],
                    venue_type: [],
                    purpose: 'all'
                })
                .then(response => {
                    this.maxPage = response.data.data.last_page;
                    this.cards.push(...response.data.data.data);
                    this.newAds = true;
                    this.isLoading = false;
                })
        }
    },
    watch: {
        searchVariables() {
            this.page = 1
            this.maxPage = null
            this.getAds()
        }
    },
    mounted() {
        this.companyId =  document.getElementById("app").getAttribute('data-company');
        this.isRequiredPage = document.getElementById("app").getAttribute('data-requiredPage');
        const observer = new IntersectionObserver(
            this.pageEnd,
    { threshold: 1 }
        );
        observer.observe(document.getElementById("pageEnd"));

        this.getAds();

        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        window.addEventListener('resize', () => {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        });
    },
    computed:{
        noMore() {
            return this.maxPage !== null && this.page === this.maxPage && this.notFound !== true
        }
    }
});

// window.url = 'http://mraqar.test/';
