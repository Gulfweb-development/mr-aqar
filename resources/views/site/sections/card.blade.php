<card lang="{{app()->getLocale()}}" :purpose_lang="{rent: '{{ __('rent') }}' ,sell: '{{ __('sell') }}' ,exchange: '{{ __('exchange') }}' ,required_for_rent: '{{ __('required_for_rent') }}' , }" :card="card" v-for="card in cards" inline-template>
    <a :href="href" style="text-decoration: none;" class="text-body">
    <div class="col-xs-12 rounded-sm p-0 mb-3" :class="card.advertising_type === 'premium' ? 'primary-card rounded-sm' : 'b-gray'">
        <div class="border p-2 overflow-hidden card-height">
            <div class="row">
                <div class="p-relative col-sm-2 w-sm1/5 p{{$side}}-image p-0 card-image-width-pc" :class="card.advertising_type === 'premium' ? 'image-box' : ''">
                    <div :style="`background-image: url('` + (card.main_image ? card.main_image : '{{route('image.noimage', '')}}') + `')`" class="card-image">

                    </div>
                </div>
                <div class="col-sm-10 w-sm4/5 p-0 card-desc-pc">
                    <h2 class="text-md mb-2 sm:width-110" v-text="`${purpose_lang[card.purpose]} ${card.venue.title_{{app()->getLocale()}} } {{__('in')}} ${card.area.name_{{app()->getLocale()}} }`"></h2>

                    <div class="flex-container mb-2">
                        <span class="primary-color fw-600 d-inline-block m{{$side}}-2" v-if="card.price">@{{card.price | commaSeparate }} {{__('kd_title')}}</span>
                        <span class="flex flex-container m{{$side}}-2">
                            <i class="material-icons text-sm text-muted m{{$side}}-1 mb-1">calendar_month</i>
                            <span class="text-xs">@{{ card.created_at }}</span>
                        </span>
                        <span class="flex flex-container">
                            <i class="material-icons-outlined text-sm text-muted m{{$side}}-1">visibility</i>
                            <span class="text-xs">@{{card.view_count}}</span>
                        </span>
                    </div>

                    <div :dir="isArabic(card.description) ? 'rtl' : 'ltr'" :class="card.advertising_type === 'premium' ? 'fw-600' : ''" class="d-none d-sm-block d-md-block d-lg-more-block mb-2 text-sm card-description" v-snip:js="1">
                        @{{card.description  | truncate(180, '...')}}
                    </div>

                    <span class="mdc-button mdc-button--outlined small-button d-none sm-show-button text-decoration-none text-sm" style="padding: 10px 15px; background: white;">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__label fw-600">@{{purpose_lang[card.purpose]}}</span>
                    </span>
                </div>
            </div>
            <div class="row">
                <div :dir="isArabic(card.description) ? 'rtl' : 'ltr'" :class="card.advertising_type === 'premium' ? 'fw-600' : ''" class="col-xs-12 p-0 d-sm-none d-md-none d-lg-more-none text-sm card-description" v-snip:css="3">
                    @{{card.description  | truncate(180, '...')}}
                </div>
            </div>
        </div>
    </div>
    </a>
</card>
