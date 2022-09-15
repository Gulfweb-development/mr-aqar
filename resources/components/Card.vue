<script>
export default {
    name: 'Card',
    props: {
        lang: null,
        card: null,
        purpose_lang: {}
    },
    methods: {
        isArabic(text) {
            let pattern = /[\u0600-\u06FF\u0750-\u077F]/;
            let result = pattern.test(text);
            return result;
        }
    },
    computed: {
        href() {
            return `/${this.lang}/advertising/${this.card.hash_number}/details`
        }
    }
}
</script>
