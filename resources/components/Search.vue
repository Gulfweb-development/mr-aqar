<script>
import Multiselect from 'vue-multiselect'

export default {
    name: 'Search',
    components: { Multiselect },
    props: {
        purpose_lang: null,
        lang: null,
        trans: null,
        areas_count: null
    },
    data () {
        return {
            options: [],
            areas: [],
            venue_types: [],
            venue_type: null,
            purpose: 'all',
            addSpanTimes: 0,
            searchTitle: '',
        }
    },
    methods: {
        search() {
            var area_ids = this.areas ? this.areas.map(item => item.id) : [] ;

            this.$root.reset()
            this.$root.searchVariables = {
                area_id : area_ids,
                venue_type: this.venue_type ? this.venue_type.id : null ,
                purpose: this.purpose
            }
        },
        onSelect(selected) {
            this.addSpan()
            setTimeout(() => {
                let tagsVh = document.querySelector('.multiselect__tags-wrap').offsetHeight * 0.01
                tagsVh = tagsVh > 1.3 ? 1.3 : tagsVh
                document.documentElement.style.setProperty('--tags-vh', `${tagsVh}px`)
            }, 500)
        },
        addSpan() {
            if (this.addSpanTimes++ < 1) {
                let placeholder = `<span class="multiselect__placeholder d-block pb-3 pt-1 helper_placeholder">${this.filter_areas_title}</span>`
                document.querySelector('#select_areas .multiselect .multiselect__tags').insertAdjacentHTML("afterbegin", placeholder);
            }
        },
        changeSearchTitle() {
            if (this.areas_count == 0)
                return this.searchTitle = ''

            let type = this.venue_type === null || this.venue_type.id == null ? '' : this.venue_type['title_' + this.lang];

            let to = ''

            let purpose = ''
            if (this.purpose !== 'all') {
                purpose = this.purpose_lang[this.purpose]
                to = this.lang == 'en' ? this.trans.to : ''
            }

            let areas = ''
            let i = 1
            this.areas.forEach(area => {
                if ( i  <=  this.areas_count - 1 || ( i === this.areas_count && this.areas.length <= this.areas_count ) ) {
                    if (i < this.areas_count - 1) {
                        areas += area['name_' + this.lang]
                        if ( this.areas.length === i + 1  && this.areas.length > 1 )
                            areas +=  " " + this.trans.and + " "
                        else if ( this.areas.length > i  && this.areas.length > 1 )
                            areas +=  ', '
                    }else if (i === this.areas_count - 1) {
                        areas += area['name_' + this.lang]
                        if ( this.areas.length === i + 1  && this.areas.length > 1 )
                            areas +=  " " + this.trans.and + " "
                        else if ( this.areas.length > i  && this.areas.length > 1 )
                            areas +=  ', '
                    } else
                        areas += area['name_' + this.lang]

                }
                i++;
            });
            if (areas === '')
                areas = this.trans.kuwait
            if (this.areas.length > this.areas_count) {
                areas = areas.slice(0, -2);
                areas += ' ' + this.trans.search_and_more.replace(':count', (this.areas.length - this.areas_count) + 1)
            }

            let fee = this.trans.in

            let count = this.$root.count !== null ? this.$root.count : ''

            let ad = this.trans.ad

            if (purpose == '' && type == '' && this.areas.length < 1) {
                this.searchTitle = ''
                return
            }

            this.searchTitle = `${purpose} ${type} ${fee}${areas} (${count} ${ad})`
        },
        selectOpened () {
            document.querySelector('#select_header').classList.remove('d-none')
            document.querySelector('#select_areas').classList.add('select_in_header')
            document.body.classList.add('overflow-hidden-safe')
            this.showHelper = false
            if (this.areas.length)
                document.querySelector('#select_areas .multiselect__content-wrapper').classList.add('areas_are_selected')
        },
        closeSelect () {
            document.querySelector('#select_header').classList.add('d-none')
            document.querySelector('#select_areas').classList.remove('select_in_header')
            document.body.classList.remove('overflow-hidden-safe')
            this.showHelper = true
        }
    },
    mounted () {
        axios.get(window.url + 'cities')
            .then(response => {
                this.options  = response.data.data;

                // this.options = [{areas: [{}], id: 200, name_en: 'remove all', name_ar: 'الحذف'}, ...this.options]

                // let item = `<li class="multiselect__element"><!----> <span data-select="حدد كل المجالات!" data-deselect="انقر لإلغاء التحديد" class="multiselect__option multiselect__option--group multiselect__option--highlight"><span>الحذف</span></span></li>`
                // document.querySelector('.multiselect__content').insertAdjacentHTML("afterbegin", item);
            })

        axios.get(window.url + 'get-search-property')
            .then(response => {
                this.venue_types = [{
                    id: null,
                    title_en: "All",
                    title_ar: "كل",
                }];
                this.venue_types.push(...response.data.data.type);
            })

        if (document.querySelector('.multiselect__placeholder')) {
            this.filter_areas_title = document.querySelector('.multiselect__placeholder').innerText
        }
    },
    watch: {
        areas() {
            if (this.areas.length === 0) {
                document.querySelector('.helper_placeholder').remove()
                this.addSpanTimes = 0
                console.log('here i am ')
                document.querySelector('#select_areas .multiselect__content-wrapper').classList.remove('areas_are_selected')
            } else
                document.querySelector('#select_areas .multiselect__content-wrapper').classList.add('areas_are_selected')
        }
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.multiselect__tag {
    position: relative;
    display: inline-block;
    padding: 4px 26px 4px 10px;
    border-radius: 5px;
    margin-right: 10px;
    color: #fff;
    line-height: 1;
    background: var(--mdc-theme-primary) !important;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    max-width: 100%;
    text-overflow: ellipsis;
}
.multiselect__tags {
    max-height: 180px;
    overflow-y: auto;
    overflow-x: hidden;
}
.multiselect__option--highlight {
    background: var(--mdc-theme-primary) !important;
    outline: none;
    color: #fff
}
.multiselect__option--highlight:after {
    content: attr(data-select);
    background: var(--mdc-theme-primary);
    color: #fff
}
/* multiselect__option multiselect__option--highlight multiselect__option--selected */
.multiselect__option.multiselect__option--highlight.multiselect__option--selected{
    background: var(--mdc-theme-error) !important;
}
.multiselect__tag-icon:focus, .multiselect__tag-icon:hover {
    background: var(--mdc-theme-error) !important;
}
.multiselect__spinner:after, .multiselect__spinner:before {
    position: absolute;
    content: "";
    top: 50%;
    left: 50%;
    margin: -8px 0 0 -8px;
    width: 16px;
    height: 16px;
    border-radius: 100%;
    border: 2px solid transparent;
    border-top-color: var(--mdc-theme-primary) !important;
    box-shadow: 0 0 0 1px transparent
}

.multiselect__option--group {
    background: white;
    font-weight: 900;
    /* color: white; */
}
.multiselect__option--group:before {
    content: "--- ";
}
.multiselect__select::before {
    top: 85%;
}
.multiselect__placeholder{
    margin-bottom: 0;
}
.multiselect__tags {
    padding-top: 6px !important;
    padding-bottom: 6px !important;
}
</style>
