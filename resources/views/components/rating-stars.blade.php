<style>
    /* use display:inline-flex to prevent whitespace issues. alternatively, you can put all the children of .rating-group on a single line */
    .rating-group {
        display: inline-flex;
    }

    /* make hover effect work properly in IE */
    .rating__icon {
        pointer-events: none;
    }

    /* hide radio inputs */
    .rating__input {
        position: absolute !important;
        left: -9999px !important;
    }

    /* set icon padding and size */
    .rating__label {
        cursor: pointer;
        /* if you change the left/right padding, update the margin-right property of .rating__label--half as well. */
        padding: 0 0.1em;
        font-size: 2rem;
    }

    /* add padding and positioning to half star labels */
    .rating__label--half {
        padding-right: 0;
        margin-right: -0.6em;
        z-index: 2;
    }

    /* set default star color */
    .rating__icon--star {
        color: orange;
    }

    /* set color of none icon when unchecked */
    .rating__icon--none {
        color: #eee;
    }

    /* if none icon is checked, make it red */
    .rating__input--none:checked + .rating__label .rating__icon--none {
        color: red;
    }

    /* if any input is checked, make its following siblings grey */
    .rating__input:checked ~ .rating__label .rating__icon--star {
        color: #ddd;
    }

    /* make all stars orange on rating group hover */
    .rating-group:hover .rating__label .rating__icon--star,
    .rating-group:hover .rating__label--half .rating__icon--star {
        color: orange;
    }

    /* make hovered input's following siblings grey on hover */
    .rating__input:hover ~ .rating__label .rating__icon--star,
    .rating__input:hover ~ .rating__label--half .rating__icon--star {
        color: #ddd;
    }

    /* make none icon grey on rating group hover */
    .rating-group:hover .rating__input--none:not(:hover) + .rating__label .rating__icon--none {
        color: #eee;
    }

    /* make none icon red on hover */
    .rating__input--none:hover + .rating__label .rating__icon--none {
        color: red;
    }

</style>
<div id="half-stars-example">
    <div class="rating-group">
        <input class="rating__input rating__input--none" checked name="rating" id="rating-0" value="0" type="radio">
        <label aria-label="0 stars" class="rating__label" for="rating-0">&nbsp;</label>
        <label aria-label="0.5 stars" class="rating__label rating__label--half" for="rating-05"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
        <input class="rating__input" name="rating" id="rating-05" value="0.5" type="radio">
        <label aria-label="1 star" class="rating__label" for="rating-10"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
        <input class="rating__input" name="rating" id="rating-10" value="1" type="radio">
        <label aria-label="1.5 stars" class="rating__label rating__label--half" for="rating-15"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
        <input class="rating__input" name="rating" id="rating-15" value="1.5" type="radio">
        <label aria-label="2 stars" class="rating__label" for="rating-20"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
        <input class="rating__input" name="rating" id="rating-20" value="2" type="radio">
        <label aria-label="2.5 stars" class="rating__label rating__label--half" for="rating-25"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
        <input class="rating__input" name="rating" id="rating-25" value="2.5" type="radio" checked>
        <label aria-label="3 stars" class="rating__label" for="rating-30"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
        <input class="rating__input" name="rating" id="rating-30" value="3" type="radio">
        <label aria-label="3.5 stars" class="rating__label rating__label--half" for="rating-35"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
        <input class="rating__input" name="rating" id="rating-35" value="3.5" type="radio">
        <label aria-label="4 stars" class="rating__label" for="rating-40"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
        <input class="rating__input" name="rating" id="rating-40" value="4" type="radio">
        <label aria-label="4.5 stars" class="rating__label rating__label--half" for="rating-45"><i class="rating__icon rating__icon--star fa fa-star-half"></i></label>
        <input class="rating__input" name="rating" id="rating-45" value="4.5" type="radio">
        <label aria-label="5 stars" class="rating__label" for="rating-50"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
        <input class="rating__input" name="rating" id="rating-50" value="5" type="radio">
    </div>
</div>
