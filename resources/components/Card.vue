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
    },
    tel() {
      let tel = this.card.phone_number.startsWith("+") ? this.card.phone_number : '+'+this.card.phone_number;
      tel = tel.startsWith("+965") ? tel : tel.replace('+', '+965');
      return tel.replace(' ', '');
    }
}
</script>
