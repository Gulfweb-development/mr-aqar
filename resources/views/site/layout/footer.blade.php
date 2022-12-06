@if( ! isset($hideHeaderAndFooter) or  ( isset($hideHeaderAndFooter) and !$hideHeaderAndFooter) )
    <footer class="mt-4">
        <div class="px-3">
            <div class="theme-container">
                <div class="py-4 content">
                    <div class="row between-xs">
                        <div class="col-xs-12 col-sm-4 sm:mx-auto d-flex align-items-end">
                            <a href="{{ route('Main.index', ['locale' => app()->getLocale()]) }}" class="logo sm:mx-auto">
                                <img src="{{ asset('images/main/logo_footer_' . app()->getLocale() . '.png') }}" style="max-width: 275px;" id="logo_footer" alt="image">
                            </a>
                        </div>
                        <div class="col-sm-4 d-mobile-none text-center">
                            @if(\App\Http\Controllers\site\MessageController::getSettingDetails('ios_link') )
                                <a href="{{ \App\Http\Controllers\site\MessageController::getSettingDetails('ios_link')  }}" target="_blank" style="display: inline-block;    color: inherit;">
                                    <img src="{{ asset('asset/images/App-Store-Button-300x98.png') }}" style="width: 185px;height: 62px;">
                                </a>
                            @endif
                            @if(\App\Http\Controllers\site\MessageController::getSettingDetails('android_link') )
                                <a href="{{ \App\Http\Controllers\site\MessageController::getSettingDetails('android_link')  }}" target="_blank" style="display: inline-block;    color: inherit;">
                                    <img src="{{ asset('asset/images/Google-Play-Store-Button-300x98.png') }}" style="width: 185px;height: 62px;">
                                </a>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-4 sm:mx-auto">
                            @include('site.sections.socials', [
                                'classes' => 'start-xs middle-xs desc sm:justify-content-center end-sm',
                                'icon_classes' => 'mat-icon-md'
                            ])
                        </div>
                    </div>
                </div>
                <div class="between-xs center-lg center-md center-sm center-xs centered copyright middle-xs my-2 row">
                    @if (app()->getLocale()=='en')
                        <p>Copyright {{date('Y')}} | All rights reserved.</p>
                    @else
                        <p> حقوق النشر {{date('Y')}} | كل الحقوق محفوظة.</p>
                    @endif
                    &ensp;
                    <p>
                        <a style="color:#fff" href="/{{ app()->getLocale() }}/terms_and_conditions">{{ __("terms_and_conditions") }}</a>
                    </p>
                    &ensp;
                    <p >
                        <a style="color:#fff" href="/{{ app()->getLocale() }}/privacy_policy">{{ __("privacy_policy") }}</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div id="favorites-snackbar" class="mdc-snackbar">
        <div class="mdc-snackbar__surface">
            <div class="mdc-snackbar__label">The property has been added to favorites.</div>
            <div class="mdc-snackbar__actions">
                <button type="button" class="mdc-button mdc-snackbar__action">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label">
                        <i class="material-icons warn-color">close</i>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div id="back-to-top"><i class="material-icons">arrow_upward</i></div>
@endif
